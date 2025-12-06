<?php
$host = 'localhost';
$port = '3308'; // IMPORTANTE: Aquí ponemos tu puerto personalizado
$db   = 'sistema_pedidos';
$user = 'root';
$pass = ''; // Por defecto en XAMPP está vacía
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    // Si quieres probar que conecta, descomenta la linea de abajo:
    // echo "¡Conexión exitosa a la base de datos!";
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>