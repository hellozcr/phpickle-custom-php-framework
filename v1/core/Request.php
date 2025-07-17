<?php
namespace Core;

class Request {
    public function getUrl() {
        $url = $_GET['url'] ?? '';
        return trim($url, '/');
    }
    public function method() {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }
    public function all() {
        return $_REQUEST;
    }
    public function input($key, $default = null) {
        return $_REQUEST[$key] ?? $default;
    }
} 