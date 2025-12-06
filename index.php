<?php
include 'conexion.php';
$productos = $pdo->query("SELECT * FROM productos")->fetchAll(PDO::FETCH_ASSOC);
$clientes = $pdo->query("SELECT * FROM clientes")->fetchAll(PDO::FETCH_ASSOC);

$menu = [];
foreach ($productos as $p) {
    $menu[$p['categoria']][] = $p;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Happy Chicken - Pedidos</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

    <div class="menu-container">
        
        <div class="nav-categorias">
            <?php foreach ($menu as $categoria => $items): ?>
                <a href="#<?php echo str_replace(' ', '', $categoria); ?>"><?php echo $categoria; ?></a>
            <?php endforeach; ?>
        </div>

        <div class="scroll-productos">
            <h2 style="color:#5c3a21; margin-top:0;">🐔 Menú Happy Chicken</h2>
            
            <?php foreach ($menu as $categoria => $lista_productos): ?>
                <h3 id="<?php echo str_replace(' ', '', $categoria); ?>" class="categoria-titulo"><?php echo $categoria; ?></h3>
                
                <div class="grid-productos">
                    <?php foreach ($lista_productos as $p): ?>
                    <div class="card-producto" onclick="agregar(<?php echo $p['id']; ?>, '<?php echo $p['nombre']; ?>', <?php echo $p['precio']; ?>)">
                        <span class="emoji"><?php echo $p['imagen']; ?></span>
                        <span class="nombre-prod"><?php echo $p['nombre']; ?></span>
                        <span class="precio">S/ <?php echo number_format($p['precio'], 2); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="carrito-container">
        <div class="carrito-header">
            <h3>🛒 Tu Pedido</h3>
            <select id="cliente">
                <option value="">Seleccionar Cliente...</option>
                <?php foreach ($clientes as $c): ?>
                    <option value="<?php echo $c['id']; ?>"><?php echo $c['nombre']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="carrito-items" id="lista-ticket">
            <p style="text-align:center; color:#999; margin-top:50px;">Selecciona productos...</p>
        </div>

        <div class="carrito-footer">
            <div class="total">Total: S/ <span id="total-monto">0.00</span></div>
            <button class="procesar" onclick="guardarPedido()">✅ ENVIAR A COCINA</button>
        </div>
    </div>
    <div id="modal-notas" class="modal-overlay">
        <div class="modal-caja">
            <h3 style="margin-top:0; color:#5c3a21;">📝 Nota Especial</h3>
            <p style="color:#666; margin-bottom:10px;">Para: <strong id="nombre-prod-modal" style="color:#ff6600;">Producto</strong></p>
            
            <textarea id="texto-nota" placeholder="Ej: Sin mayonesa, bien taipá, sin ensalada..." autofocus></textarea>
            
            <div class="modal-botones">
                <button class="btn-cancelar" onclick="cerrarModal()">Cancelar</button>
                <button class="btn-confirmar-nota" onclick="confirmarAgregar()">✅ AGREGAR AL PEDIDO</button>
            </div>
        </div>
    </div>

    <script src="js/app.js"></script>
</body>
</html>