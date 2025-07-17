<?php
namespace Core;

class Response {
    public function setStatus($code) {
        http_response_code($code);
    }
    public function redirect($url) {
        header('Location: ' . $url);
        exit;
    }
    public function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
} 