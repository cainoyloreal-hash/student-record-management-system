<?php
declare(strict_types=1);

/*
 * Update these values to match your MariaDB database and user.
 * Do not use the MariaDB root account for the application.
 */
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'student_records_db');
define('DB_USER', 'student_app');
define('DB_PASS', 'ChangeThis_DB_Password_123!');

function db(): PDO {
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    return $pdo;
}
