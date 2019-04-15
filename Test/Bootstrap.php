<?php

declare(strict_types=1);

if (isset($_SERVER['PROJECT_ROOT']) && file_exists($_SERVER['PROJECT_ROOT'])) {
    return $_SERVER['PROJECT_ROOT'];
}
if (isset($_ENV['PROJECT_ROOT']) && file_exists($_ENV['PROJECT_ROOT'])) {
    return $_ENV['PROJECT_ROOT'];
}

$dir = $rootDir = __DIR__;
while (!file_exists($dir . '/.env')) {
    if ($dir === \dirname($dir)) {
        return $rootDir;
    }

    $dir = \dirname($dir);
}

define('TEST_PROJECT_DIR', $dir);

require_once TEST_PROJECT_DIR . '/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

if (!class_exists(Dotenv::class)) {
    throw new \RuntimeException('APP_ENV environment variable is not defined. You need to define environment variables for configuration or add "symfony/dotenv" as a Composer dependency to load variables from a .env file.');
}

(new Dotenv())->load(TEST_PROJECT_DIR . '/.env');
