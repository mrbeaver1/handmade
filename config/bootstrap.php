<?php
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Dotenv\Exception\PathException;

require dirname(__DIR__) . './vendor/autoload.php';

$rootDir = dirname(__DIR__);

if (class_exists(Dotenv::class)) {
    $env = new Dotenv();
    if (method_exists($env, 'usePutenv')) {
        $env->usePutenv();  // Symfony >= 5.1
    } else {
        $env = new Dotenv(true);  // Symfony < 5.1
    }
    try {
        $env->load($rootDir . '/.env.dist', $rootDir . '/.env.test');
    } catch (PathException $exception) {
        // Ничего страшного, если не получилось загрузить файлы.
    }
}

if (!array_key_exists('APP_ENV', $_SERVER)) {
    $_SERVER['APP_ENV'] = $_ENV['APP_ENV'] ?? 'prod';
}

$_SERVER['APP_DEBUG'] = (int) ($_SERVER['APP_DEBUG'] ?? ($_ENV['APP_DEBUG'] ?? 'prod' !== $_SERVER['APP_ENV']));
if ($_SERVER['APP_ENV'] === 'test') {
    $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
}
