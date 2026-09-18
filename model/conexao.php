<?php
// Lê as variáveis geradas pela Railway ou usa o localhost como fallback para o Laragon
$host = $_ENV['MYSQLHOST'] ?? $_ENV['DB_HOST'] ?? 'localhost';
$dbname = $_ENV['MYSQLDATABASE'] ?? $_ENV['DB_DATABASE'] ?? 'db_serious_games';
$username = $_ENV['MYSQLUSER'] ?? $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['MYSQLPASSWORD'] ?? $_ENV['DB_PASSWORD'] ?? '';
$port = $_ENV['MYSQLPORT'] ?? $_ENV['DB_PORT'] ?? '3306';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>