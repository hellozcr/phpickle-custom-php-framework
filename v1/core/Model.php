<?php
namespace Core;

class Model {
    protected static $db;

    public function __construct() {
        if (!self::$db) {
            $config = \Core\App::$config['db'] ?? [];
            if (!empty($config)) {
                $dsn = sprintf(
                    '%s:host=%s;dbname=%s;charset=%s',
                    $config['driver'],
                    $config['host'],
                    $config['database'],
                    $config['charset'] ?? 'utf8'
                );
                try {
                    self::$db = new \PDO($dsn, $config['username'], $config['password']);
                    self::$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                } catch (\PDOException $e) {
                    die('Database connection failed: ' . $e->getMessage());
                }
            }
        }
    }

    // Example: Run a query and return all results
    protected function query($sql, $params = []) {
        $stmt = self::$db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    protected function fetchAll($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll(\PDO::FETCH_ASSOC);
    }

    protected function fetch($sql, $params = []) {
        return $this->query($sql, $params)->fetch(\PDO::FETCH_ASSOC);
    }

    protected function execute($sql, $params = []) {
        return $this->query($sql, $params)->rowCount();
    }
} 