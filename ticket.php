<?php
include 'conexion.php';

// Verificamos si nos pasaron un ID
if (!isset($_GET['id'])) {
    die("❌ Error: No se especificó ningún ticket.");
}

$id_pedido = $_GET['id'];

// 1. Traer datos del Pedido y Cliente
$stmt = $pdo->prepare("SELECT p.*, c.nombre as cliente_nombre, c.telefono 
                       FROM pedidos p 
                       JOIN clientes c ON p.cliente_id = c.id 
                       WHERE p.id = ?");
$stmt->execute([$id_pedido]);
$pedido = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pedido) {
    die("❌ Error: El pedido no existe.");
}

// 2. Traer los productos de ese pedido
$stmt_det = $pdo->prepare("SELECT d.*, prod.nombre 
                           FROM detalle_pedidos d 
                           JOIN productos prod ON d.producto_id = prod.id 
                           WHERE d.pedido_id = ?");
$stmt_det->execute([$id_pedido]);
$items = $stmt_det->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket #<?php echo $id_pedido; ?></title>
    <style>
        body { background: #555; display: flex; justify-content: center; padding-top: 30px; font-family: 'Courier New', Courier, monospace; }
        
        .ticket {
            background: #fffbe6; /* Color papel amarillento */
            width: 300px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            text-transform: uppercase;
        }
        
        .centro { text-align: center; }
        .titulo { font-size: 1.2rem; font-weight: bold; margin-bottom: 5px; }
        .linea { border-bottom: 2px dashed #000; margin: 10px 0; }
        
        .info-row { display: flex; justify-content: space-between; margin-bottom: 5px; font-size: 0.9rem; }
        
        .item-row { margin-bottom: 8px; }
        .item-nombre { font-weight: bold; }
        .item-nota { font-size: 0.8rem; font-style: italic; display: block; margin-left: 10px; }
        
        .total-row { font-size: 1.3rem; font-weight: bold; margin-top: 10px; text-align: right; }
        
        .btn-volver {
            display: block; width: 100%; text-align: center; padding: 10px; 
            background: #007bff; color: white; text-decoration: none; 
            margin-top: 20px; font-family: sans-serif; font-weight: bold;
        }
        .btn-imprimir {
            display: block; width: 100%; text-align: center; padding: 10px; 
            background: #28a745; color: white; border: none; cursor: pointer;
            margin-top: 10px; font-family: sans-serif; font-weight: bold;
        }

        /* Ocultar botones al imprimir */
        @media print {
            body { background: white; padding: 0; }
            .ticket { box-shadow: none; width: 100%; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="ticket">
        <div class="centro">
            <div class="titulo">🍔 FAST FOOD "EL PATA" 🍔</div>
            <small>Av. Siempre Viva 123 - Piura</small>
        </div>
        
        <div class="linea"></div>
        
        <div class="info-row">
            <span>TICKET:</span>
            <strong>#<?php echo str_pad($pedido['id'], 6, '0', STR_PAD_LEFT); ?></strong>
        </div>
        <div class="info-row">
            <span>FECHA:</span>
            <span><?php echo $pedido['fecha']; ?></span>
        </div>
        <div class="info-row">
            <span>CLIENTE:</span>
            <span><?php echo $pedido['cliente_nombre']; ?></span>
        </div>

        <div class="linea"></div>

        <?php foreach ($items as $item): ?>
        <div class="item-row">
            <div class="info-row">
                <span class="item-nombre"><?php echo $item['cantidad']; ?> x <?php echo $item['nombre']; ?></span>
                <span>S/ <?php echo number_format($item['precio_unitario'], 2); ?></span>
            </div>
            <?php if(!empty($item['notas'])): ?>
                <span class="item-nota">(<?php echo $item['notas']; ?>)</span>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>

        <div class="linea"></div>
        
        <div class="total-row">
            TOTAL: S/ <?php echo number_format($pedido['total'], 2); ?>
        </div>
        
        <div class="centro" style="margin-top:20px;">
            <small>¡Gracias por su preferencia!</small>
        </div>

        <button onclick="window.print()" class="btn-imprimir no-print">🖨️ IMPRIMIR</button>
        <a href="index.php" class="btn-volver no-print">⬅ NUEVO PEDIDO</a>
    </div>

</body>
</html>