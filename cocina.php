<?php
include 'conexion.php';

// Si recibimos una petición para "Despachar"
if (isset($_POST['completar_id'])) {
    $id = $_POST['completar_id'];
    $pdo->query("UPDATE pedidos SET estado = 'completado' WHERE id = $id");
    header("Location: cocina.php");
    exit;
}

// CONSULTA DE PEDIDOS PENDIENTES
$sql = "SELECT p.id as pedido_id, p.fecha, c.nombre as cliente, 
               d.cantidad, d.notas, prod.nombre as producto 
        FROM pedidos p 
        JOIN clientes c ON p.cliente_id = c.id 
        JOIN detalle_pedidos d ON p.id = d.pedido_id 
        JOIN productos prod ON d.producto_id = prod.id 
        WHERE p.estado = 'pendiente' 
        ORDER BY p.fecha ASC";

$stmt = $pdo->query($sql);
$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// AGRUPAR POR TICKET
$tickets = [];
foreach ($filas as $fila) {
    $id = $fila['pedido_id'];
    if (!isset($tickets[$id])) {
        $tickets[$id] = [
            'cliente' => $fila['cliente'],
            'hora' => date('H:i', strtotime($fila['fecha'])),
            'items' => []
        ];
    }
    $tickets[$id]['items'][] = $fila;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5">
    <title>Cocina - Happy Chicken</title>
    <link rel="stylesheet" href="css/cocina.css">
</head>
<body>

    <h1>🔥 Cocina Happy Chicken 🔥</h1>

    <div class="grid-tickets">
        <?php if (empty($tickets)): ?>
            <div class="vacio">Todo tranquilo por ahora... 👨‍🍳</div>
        <?php else: ?>
            
            <?php foreach ($tickets as $id => $ticket): ?>
            <div class="ticket">
                <div class="ticket-header">
                    <span class="cliente"><?php echo $ticket['cliente']; ?></span>
                    <span class="hora"><?php echo $ticket['hora']; ?></span>
                </div>

                <div class="ticket-body">
                    <?php foreach ($ticket['items'] as $item): ?>
                    <div class="item">
                        <span class="cantidad"><?php echo $item['cantidad']; ?></span> 
                        <strong><?php echo $item['producto']; ?></strong>
                        
                        <?php if (!empty($item['notas'])): ?>
                            <span class="notas">⚠️ <?php echo $item['notas']; ?></span>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>

                <form method="POST">
                    <input type="hidden" name="completar_id" value="<?php echo $id; ?>">
                    <button type="submit" class="btn-listo">✅ Pedido Listo</button>
                </form>
            </div>
            <?php endforeach; ?>

        <?php endif; ?>
    </div>

</body>
</html>