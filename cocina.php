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
    <meta http-equiv="refresh" content="5"> <title>Cocina - Happy Chicken</title>
    <style>
        /* TEMA HAPPY CHICKEN: Marrón (#5c3a21) y Naranja (#ff6600) */
        body { 
            font-family: 'Segoe UI', Tahoma, monospace; 
            background-color: #5c3a21; /* Fondo Marrón Corporativo */
            margin: 0; padding: 20px; 
            color: white; 
        }

        h1 { 
            text-align: center; 
            color: #ffcc00; /* Amarillo */
            text-transform: uppercase;
            font-size: 2.5rem;
            margin-bottom: 30px;
            text-shadow: 2px 2px 0px #000;
        }
        
        .grid-tickets { 
            display: flex; 
            flex-wrap: wrap; 
            gap: 20px; 
            justify-content: center; 
        }
        
        /* EL TICKET DE COCINA */
        .ticket { 
            background: #fff; 
            color: #333; 
            width: 300px; 
            padding: 0; 
            border-radius: 10px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.3); 
            overflow: hidden;
            animation: popIn 0.3s ease-out;
        }

        /* CABECERA DEL TICKET */
        .ticket-header { 
            background: #ff6600; /* Naranja */
            color: white;
            padding: 15px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center;
        }
        
        .cliente { font-weight: bold; font-size: 1.1rem; }
        .hora { font-size: 1.2rem; background: rgba(0,0,0,0.2); padding: 5px 10px; border-radius: 5px; }
        
        /* CUERPO DEL TICKET */
        .ticket-body { padding: 15px; }

        .item { 
            font-size: 1.1rem; 
            margin-bottom: 12px; 
            line-height: 1.3; 
            border-bottom: 1px dashed #eee;
            padding-bottom: 5px;
        }
        
        .cantidad { 
            display: inline-block;
            background: #333; 
            color: #fff; 
            width: 25px; height: 25px; 
            text-align: center; line-height: 25px;
            border-radius: 50%; 
            font-size: 0.9rem; margin-right: 5px; 
            font-weight: bold;
        }
        
        .notas { 
            display: block; 
            color: #d35400; /* Texto rojo/naranja oscuro */
            font-weight: bold; 
            font-size: 0.9rem; 
            background: #fff3cd;
            padding: 2px 5px;
            border-radius: 4px;
            margin-top: 2px;
        }

        /* BOTÓN LISTO */
        .btn-listo { 
            width: 100%; padding: 15px; 
            background: #28a745; 
            color: white; 
            border: none; 
            font-weight: bold; font-size: 1.2rem; cursor: pointer; 
            text-transform: uppercase;
        }
        .btn-listo:hover { background: #218838; }

        .vacio { text-align: center; color: #ffcc00; margin-top: 50px; font-size: 1.5rem; opacity: 0.7; }

        @keyframes popIn {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
    </style>
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