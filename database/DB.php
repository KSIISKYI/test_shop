<?php 

require_once __DIR__ . '/../vendor/autoload.php';

// Looing for .env at the root directory
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

Class DB
{
    static public function get_connection($db_name = null)
    {
        if ($db_name) {
            return new PDO("{$_ENV['DRIVER']}:host={$_ENV['HOST']};dbname={$_ENV['DATABASE']}", $_ENV['USERNAME'], $_ENV['PASSWORD']);
        }

        return new PDO($_ENV['DRIVER'] . ':' . $_ENV['HOST'], $_ENV['USERNAME'], $_ENV['PASSWORD']);
    }
}
