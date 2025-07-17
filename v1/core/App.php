<?php
namespace Core;

class App {
    public static $config = [];
    public static $request;
    public static $response;

    public static function init() {
        self::$config = require __DIR__ . '/../config/config.php';
        self::$request = new Request();
        self::$response = new Response();

        // Register global assets
        if (file_exists(__DIR__ . '/../config/assets.php')) {
            $assets = require __DIR__ . '/../config/assets.php';
            foreach (($assets['css'] ?? []) as $css) {
                \Core\AssetManager::addCss($css);
            }
            foreach (($assets['js'] ?? []) as $js) {
                \Core\AssetManager::addJs($js);
            }
        }
    }

    public static function run() {
        $url = self::$request->getUrl();
        $router = new Router();
        $router->dispatch($url);
    }
} 