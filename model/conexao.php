<?php
$host = getenv('DB_HOST') ?: getenv('MYSQLHOST') ?: '127.0.0.1';
$db   = getenv('DB_NAME') ?: getenv('MYSQL_DATABASE') ?: getenv('MYSQLDATABASE') ?: '';
$user = getenv('DB_USERNAME') ?: getenv('MYSQLUSER') ?: 'root';
$pass = getenv('DB_PASSWORD') ?: getenv('MYSQLPASSWORD') ?: getenv('MYSQL_ROOT_PASSWORD') ?: '';
$port = getenv('DB_PORT') ?: getenv('MYSQLPORT') ?: '3306';

if (empty($db)) {
    throw new RuntimeException('Banco de dados não configurado. Defina DB_NAME ou MYSQL_DATABASE no Railway.');
}

try {
    $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    echo "Erro no Banco de Dados: " . $e->getMessage();
    exit;
}
?>

