<?php
// ===============================
// Database Migration Runner
// ===============================
// USAGE:
//   php migrate.php [command]
//
// COMMANDS:
//   sync           Ensures DB exists, creates missing tables, updates schema file with new tables from DB (default)
//   create         Only creates DB and tables as per schema.php
//   update-schema  Only updates schema.php with tables found in DB but not in schema
//   status         Shows tables in DB and schema for comparison
//   compare        Compares schema.php and DB in detail, showing mismatches in tables, fields, types, nullability, defaults, etc. (no changes made)
//
// HOW IT WORKS:
// - Define your database and tables in migrations/schema.php
// - Run this script with the desired command
// - Keeps your schema file and database in sync automatically
// ===============================

$schema = require __DIR__ . '/schema.php';
$config = require __DIR__ . '/../config/config.php';
$dbConfig = $config['db'];

function pdoConnect($dbConfig, $withDb = false) {
    $dsn = $withDb
        ? sprintf('%s:host=%s;dbname=%s;charset=%s', $dbConfig['driver'], $dbConfig['host'], $dbConfig['database'], $dbConfig['charset'])
        : sprintf('%s:host=%s;charset=%s', $dbConfig['driver'], $dbConfig['host'], $dbConfig['charset']);
    return new PDO($dsn, $dbConfig['username'], $dbConfig['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
}

function createDatabase($dbConfig, $schema) {
    $pdo = pdoConnect($dbConfig, false);
    $dbName = $schema['database']['name'];
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName`");
    echo "Database '$dbName' ensured.\n";
}

function getExistingTables($pdo) {
    $stmt = $pdo->query("SHOW TABLES");
    $tables = [];
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $tables[] = $row[0];
    }
    return $tables;
}

function createTables($pdo, $schema) {
    foreach ($schema['tables'] as $table => $columns) {
        $cols = [];
        foreach ($columns as $name => $type) {
            $cols[] = "`$name` $type";
        }
        $sql = "CREATE TABLE IF NOT EXISTS `$table` (" . implode(", ", $cols) . ") ENGINE=InnoDB;";
        $pdo->exec($sql);
        echo "Table '$table' ensured.\n";
    }
}

function updateSchemaFile($pdo, $schemaFile, $schema) {
    $existingTables = getExistingTables($pdo);
    $current = $schema['tables'];
    $updated = false;
    foreach ($existingTables as $table) {
        if (!isset($current[$table])) {
            // Add table structure to schema
            $desc = $pdo->query("DESCRIBE `$table`")->fetchAll(PDO::FETCH_ASSOC);
            $columns = [];
            foreach ($desc as $col) {
                $colDef = $col['Type'];
                if ($col['Null'] === 'NO') $colDef .= ' NOT NULL';
                if ($col['Key'] === 'PRI') $colDef .= ' PRIMARY KEY';
                if ($col['Extra']) $colDef .= ' ' . $col['Extra'];
                if ($col['Default'] !== null) $colDef .= " DEFAULT '" . $col['Default'] . "'";
                $columns[$col['Field']] = strtoupper($colDef);
            }
            $schema['tables'][$table] = $columns;
            $updated = true;
            echo "Added missing table '$table' to schema file.\n";
        }
    }
    if ($updated) {
        file_put_contents($schemaFile, "<?php\nreturn " . var_export($schema, true) . ";\n");
        echo "Schema file updated.\n";
    } else {
        echo "Schema file is up to date.\n";
    }
}

function status($pdo, $schema) {
    $existingTables = getExistingTables($pdo);
    $schemaTables = array_keys($schema['tables']);
    echo "Tables in DB: " . implode(", ", $existingTables) . "\n";
    echo "Tables in schema: " . implode(", ", $schemaTables) . "\n";
}

/**
 * Compare schema.php and the actual DB in detail.
 * Reports mismatches in tables, fields, data types, nullability, defaults, etc.
 * Does NOT make any changes—just outputs a detailed report.
 */
function compareSchemaAndDb($pdo, $schema) {
    $report = [];
    $existingTables = getExistingTables($pdo);
    $schemaTables = $schema['tables'];
    $dbTables = array_flip($existingTables);

    // Check for missing tables in DB
    foreach ($schemaTables as $table => $fields) {
        if (!isset($dbTables[$table])) {
            $report[] = "[Missing in DB] Table '$table' is defined in schema but not in DB.";
            continue;
        }
        // Compare columns
        $desc = $pdo->query("DESCRIBE `$table`")->fetchAll(PDO::FETCH_ASSOC);
        $dbFields = [];
        foreach ($desc as $col) {
            $dbFields[$col['Field']] = $col;
        }
        foreach ($fields as $field => $type) {
            if (!isset($dbFields[$field])) {
                $report[] = "[Missing in DB] Field '$field' in table '$table' is defined in schema but not in DB.";
            } else {
                // Compare type (basic, not 100% strict)
                $dbType = strtoupper($dbFields[$field]['Type']);
                $schemaType = strtoupper(preg_replace('/\s+/', ' ', $type));
                if (strpos($schemaType, $dbType) === false && strpos($dbType, $schemaType) === false) {
                    $report[] = "[Type Mismatch] Table '$table', Field '$field': Schema type '$schemaType', DB type '{$dbFields[$field]['Type']}'";
                }
                // Compare nullability
                $schemaNotNull = (stripos($schemaType, 'NOT NULL') !== false);
                $dbNotNull = ($dbFields[$field]['Null'] === 'NO');
                if ($schemaNotNull !== $dbNotNull) {
                    $report[] = "[Nullability Mismatch] Table '$table', Field '$field': Schema NOT NULL is " . ($schemaNotNull ? 'set' : 'not set') . ", DB is " . ($dbNotNull ? 'NOT NULL' : 'NULL') . ".";
                }
                // Compare default values
                $schemaDefault = null;
                if (preg_match("/DEFAULT '([^']*)'/i", $schemaType, $m)) {
                    $schemaDefault = $m[1];
                }
                $dbDefault = $dbFields[$field]['Default'];
                if ($schemaDefault !== $dbDefault) {
                    $report[] = "[Default Mismatch] Table '$table', Field '$field': Schema default is '" . var_export($schemaDefault, true) . "', DB default is '" . var_export($dbDefault, true) . "'.";
                }
            }
        }
        // Check for extra fields in DB
        foreach ($dbFields as $field => $col) {
            if (!isset($fields[$field])) {
                $report[] = "[Extra in DB] Field '$field' in table '$table' exists in DB but not in schema.";
            }
        }
    }
    // Check for extra tables in DB
    foreach ($existingTables as $table) {
        if (!isset($schemaTables[$table])) {
            $report[] = "[Extra in DB] Table '$table' exists in DB but not in schema.";
        }
    }
    // Output the report
    if (empty($report)) {
        echo "Schema and DB are fully synchronized.\n";
    } else {
        echo "--- SCHEMA/DB COMPARISON REPORT ---\n";
        foreach ($report as $line) {
            echo $line . "\n";
        }
        echo "--- END OF REPORT ---\n";
    }
}

$cmd = $argv[1] ?? 'sync';
$schemaFile = __DIR__ . '/schema.php';

try {
    if ($cmd === 'create') {
        createDatabase($dbConfig, $schema);
        $pdo = pdoConnect($dbConfig, true);
        createTables($pdo, $schema);
    } elseif ($cmd === 'update-schema') {
        $pdo = pdoConnect($dbConfig, true);
        updateSchemaFile($pdo, $schemaFile, $schema);
    } elseif ($cmd === 'status') {
        $pdo = pdoConnect($dbConfig, true);
        status($pdo, $schema);
    } elseif ($cmd === 'compare') {
        $pdo = pdoConnect($dbConfig, true);
        compareSchemaAndDb($pdo, $schema);
    } else { // sync (default)
        createDatabase($dbConfig, $schema);
        $pdo = pdoConnect($dbConfig, true);
        createTables($pdo, $schema);
        updateSchemaFile($pdo, $schemaFile, $schema);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
} 