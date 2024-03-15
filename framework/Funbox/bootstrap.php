<?php
namespace Funbox\Framework;

define('BASE_PATH', dirname(__DIR__, 2) . DIRECTORY_SEPARATOR);
define('LIB_PATH', __DIR__ . DIRECTORY_SEPARATOR);
define('APP_PATH', BASE_PATH . 'app' . DIRECTORY_SEPARATOR);
define('CONFIG_PATH', BASE_PATH . 'config' . DIRECTORY_SEPARATOR);
define('DATABASE_URL', '' . BASE_PATH . 'var' . DIRECTORY_SEPARATOR . 'migrations.sqlite');

require_once BASE_PATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

