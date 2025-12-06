<?php
include 'conexion.php';

// 1. KPIs del día
$sql_total = "SELECT SUM(total) as total_dia, COUNT(*) as cantidad_pedidos FROM pedidos WHERE DATE(fecha) = CURDATE()";
$res_total = $pdo->query($sql_total)->fetch(PDO::FETCH_ASSOC);
$venta_hoy = $res_total['total_dia'] ?? 0;
$pedidos_hoy = $res_total['cantidad_pedidos'];

// 2. Ranking
$sql_top = "SELECT prod.nombre, SUM(d.cantidad) as total_vendido 
            FROM detalle_pedidos d JOIN productos prod ON d.producto_id = prod.id 
            JOIN pedidos p ON d.pedido_id = p.id WHERE DATE(p.fecha) = CURDATE() 
            GROUP BY prod.nombre ORDER BY total_vendido DESC LIMIT 3";
$top_productos = $pdo->query($sql_top)->fetchAll(PDO::FETCH_ASSOC);

// 3. Últimos movimientos
$sql_lista = "SELECT p.id, p.fecha, c.nombre as cliente, p.total, p.estado 
              FROM pedidos p JOIN clientes c ON p.cliente_id = c.id 
              ORDER BY p.fecha DESC LIMIT 10";
$ultimos_pedidos = $pdo->query($sql_lista)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin - Happy Chicken</title>
    <style>
        /* TEMA HAPPY CHICKEN */
        body { 
            font-family: 'Segoe UI', sans-serif; 
            background-color: #fff8e1; /* Fondo Crema */
            margin: 0; padding: 20px; 
            color: #333;
        }
        
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .titulo { font-size: 2rem; color: #5c3a21; font-weight: 900; text-transform: uppercase; }
        
        .btn-volver { 
            text-decoration: none; background: #5c3a21; color: white; 
            padding: 10px 20px; border-radius: 20px; font-weight: bold; 
        }
        .btn-volver:hover { background: #3e2614; }

        /* TARJETAS DE DINERO */
        .kpi-container { display: flex; gap: 20px; margin-bottom: 30px; flex-wrap: wrap; }
        
        .card { 
            flex: 1; min-width: 250px;
            background: white; padding: 25px; border-radius: 15px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); text-align: center; 
            border-bottom: 5px solid #ff6600; /* Borde Naranja */
        }
        
        .card h3 { margin: 0; color: #888; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; }
        .card .numero { font-size: 2.8rem; font-weight: 900; color: #5c3a21; margin: 10px 0; }
        .card .numero.verde { color: #28a745; }

        /* TABLAS */
        .panel { 
            background: white; padding: 25px; border-radius: 15px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 20px; 
        }
        
        .panel h2 { 
            margin-top: 0; color: #ff6600; 
            border-bottom: 2px solid #fff8e1; padding-bottom: 10px; 
        }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #f0f0f0; }
        th { color: #888; font-size: 0.8rem; text-transform: uppercase; }
        
        .badge { padding: 5px 10px; border-radius: 10px; font-size: 0.8rem; font-weight: bold; }
        .pendiente { background: #fff3cd; color: #856404; }
        .completado { background: #d4edda; color: #155724; }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .kpi-container { flex-direction: column; }
            .contenedor-tablas { flex-direction: column; }
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="titulo">🐔 Reporte Diario</div>
        <a href="index.php" class="btn-volver">Ir al Menú</a>
    </div>

    <div class="kpi-container">
        <div class="card">
            <h3>Venta Total (Hoy)</h3>
            <div class="numero verde">S/ <?php echo number_format($venta_hoy, 2); ?></div>
            <small><?php echo date('d/m/Y'); ?></small>
        </div>
        <div class="card">
            <h3>Pedidos Atendidos</h3>
            <div class="numero"><?php echo $pedidos_hoy; ?></div>
            <small>Transacciones</small>
        </div>
        <div class="card">
            <h3>Producto Estrella 🌟</h3>
            <div style="font-size: 1.4rem; font-weight:bold; margin-top:20px; color:#ff6600;">
                <?php echo !empty($top_productos) ? $top_productos[0]['nombre'] : '---'; ?>
            </div>
        </div>
    </div>

    <div style="display: flex; gap: 20px;" class="contenedor-tablas">
        
        <div class="panel" style="flex: 2;">
            <h2>📝 Últimos Movimientos</h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha/Hora</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ultimos_pedidos as $p): ?>
                    <tr>
                        <td><strong>#<?php echo $p['id']; ?></strong></td>
                        <td>
                            <div><?php echo date('d/m/Y', strtotime($p['fecha'])); ?></div>
                            <small style="color: #888;"><?php echo date('H:i', strtotime($p['fecha'])); ?></small>
                        </td>
                        <td><?php echo $p['cliente']; ?></td>
                        <td>S/ <?php echo number_format($p['total'], 2); ?></td>
                        <td>
                            <span class="badge <?php echo $p['estado']; ?>">
                                <?php echo ucfirst($p['estado']); ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="panel" style="flex: 1;">
            <h2>🏆 Top 3 Hoy</h2>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cant.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($top_productos as $top): ?>
                    <tr>
                        <td><?php echo $top['nombre']; ?></td>
                        <td style="font-weight:bold; font-size:1.1rem;"><?php echo $top['total_vendido']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>