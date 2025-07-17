<?php
// Master schema file for database and tables
return [
    'database' => [
        'name' => 'mydb',
        // Add more DB-level options if needed
    ],
    'tables' => [
        'users' => [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'name' => 'VARCHAR(100) NOT NULL',
            'email' => 'VARCHAR(100) NOT NULL UNIQUE',
            'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'last_updated' => 'VARCHAR(100) NULL'
        ],
        // Add more tables here
    ],
]; 