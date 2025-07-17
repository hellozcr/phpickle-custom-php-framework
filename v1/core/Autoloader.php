<?php
namespace Core;

class Autoloader {
    public static function register() {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    public static function autoload($class) {
        $prefixes = [
            'Core\\' => __DIR__ . '/',
            'App\\' => __DIR__ . '/../app/',
        ];
        foreach ($prefixes as $prefix => $base_dir) {
            if (strpos($class, $prefix) === 0) {
                $relative_class = substr($class, strlen($prefix));
                $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
                if (file_exists($file)) {
                    require $file;
                }
            }
        }
    }
} 