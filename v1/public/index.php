<?php
require_once __DIR__ . '/../core/Autoloader.php';
\Core\Autoloader::register();

require_once __DIR__ . '/../core/App.php';
\Core\App::init();
\Core\App::run(); 