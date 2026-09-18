<?php
/*
$host = getenv('MYSQLHOST') ?: getenv('DB_HOST');
$db   = getenv('MYSQL_DATABASE') ?: getenv('MYSQLDATABASE');
$user = getenv('MYSQLUSER') ?: 'root';
// Aqui capturamos tanto MYSQL_ROOT_PASSWORD quanto MYSQLPASSWORD
$pass = getenv('MYSQL_ROOT_PASSWORD') ?: getenv('MYSQLPASSWORD');
$port = getenv('MYSQLPORT') ?: '3306';

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
    exit;
}*/



$host = getenv('MYSQLHOST') ?: getenv('DB_HOST') ?: 'containers-us-west-xx.railway.app'; // Fallback de segurança
$db   = getenv('MYSQL_DATABASE') ?: getenv('MYSQLDATABASE');
$user = getenv('MYSQLUSER') ?: 'root';
$pass = getenv('MYSQL_ROOT_PASSWORD') ?: getenv('MYSQLPASSWORD');
$port = getenv('MYSQLPORT') ?: '3306';

// Se o host não estiver configurado nas variáveis da aplicação, avisamos claramente
if (!$host || $host == 'containers-us-west-xx.railway.app') {
    // Tenta ler diretamente se houver um serviço linkado
    // Mas o ideal é garantirmos a variável no painel
}

try {
    $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
    exit;
}

?>