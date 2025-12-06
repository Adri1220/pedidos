<?php
require_once 'conexion.php';

$input = file_get_contents("php://input");
$data = json_decode($input, true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "No llegaron datos"]);
    exit;
}

$cliente_id = $data['cliente_id'];
$productos = $data['productos'];
$total = $data['total'];

try {
    $pdo->beginTransaction();

    // 1. Crear Pedido
    $stmt = $pdo->prepare("INSERT INTO pedidos (cliente_id, total, fecha, estado) VALUES (?, ?, NOW(), 'pendiente')");
    $stmt->execute([$cliente_id, $total]);
    $pedido_id = $pdo->lastInsertId(); // <--- OJO: Capturamos el ID del nuevo pedido

    // 2. Crear Detalle
    $stmt_detalle = $pdo->prepare("INSERT INTO detalle_pedidos (pedido_id, producto_id, cantidad, precio_unitario, notas) VALUES (?, ?, 1, ?, ?)");
    $stmt_stock = $pdo->prepare("UPDATE productos SET stock = stock - 1 WHERE id = ?");

    foreach ($productos as $prod) {
        $stmt_detalle->execute([$pedido_id, $prod['id'], $prod['precio'], $prod['nota']]);
        $stmt_stock->execute([$prod['id']]);
    }

    $pdo->commit();
    
    // RESPUESTA FINAL: Enviamos "success" Y TAMBIÉN el ID del pedido
    echo json_encode(["success" => true, "id" => $pedido_id]);

} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
}
?>