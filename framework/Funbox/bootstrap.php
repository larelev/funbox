<?php
namespace Funbox\Framework;

define('BASE_PATH', dirname(__DIR__, 2) . DIRECTORY_SEPARATOR);
define('LIB_PATH', __DIR__ . DIRECTORY_SEPARATOR);
define('APP_PATH', BASE_PATH . 'app' . DIRECTORY_SEPARATOR);
define('SERVICES_PATH', LIB_PATH . 'services.php');
define('DATABASE_URL', '' . BASE_PATH . 'var' . DIRECTORY_SEPARATOR . 'migrations.sqlite');
define( 'MIGRATIONS_PATH', 'migrations' . DIRECTORY_SEPARATOR);

require_once BASE_PATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';


