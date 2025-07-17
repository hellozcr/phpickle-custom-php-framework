<?php
namespace Core;

class AssetManager {
    protected static $css = [];
    protected static $js = [];

    public static function addCss($url) {
        if (!in_array($url, self::$css)) self::$css[] = $url;
    }

    public static function addJs($url) {
        if (!in_array($url, self::$js)) self::$js[] = $url;
    }

    public static function renderCss() {
        foreach (self::$css as $url) {
            echo "<link rel='stylesheet' href='" . htmlspecialchars($url) . "' />\n";
        }
    }

    public static function renderJs() {
        foreach (self::$js as $url) {
            echo "<script src='" . htmlspecialchars($url) . "'></script>\n";
        }
    }

    public static function clear() {
        self::$css = [];
        self::$js = [];
    }
} 