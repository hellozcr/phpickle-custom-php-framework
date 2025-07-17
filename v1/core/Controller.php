<?php
namespace Core;

class Controller {
    protected function render($view, $data = []) {
        extract($data);
        $viewFile = __DIR__ . '/../app/Views/' . $view . '.php';
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            echo "View $view not found.";
        }
    }
} 