/* =========================================
   LÓGICA DEL POS - HAPPY CHICKEN (SIN PROMPT)
   ========================================= */

let carrito = [];
let total = 0;
let productoPendiente = null;

// FUNCIÓN 1: ABRIR LA VENTANA BONITA
function agregar(id, nombre, precio) {
  productoPendiente = { id, nombre, precio };

  // Llenar datos en la ventana
  document.getElementById("nombre-prod-modal").innerText = nombre;
  document.getElementById("texto-nota").value = "";

  // MOSTRAR LA VENTANA (Cambiamos el display de none a flex)
  const modal = document.getElementById("modal-notas");
  if (modal) {
    modal.style.display = "flex";
    document.getElementById("texto-nota").focus();
  } else {
    alert("Error: No encuentro la ventana modal en el HTML");
  }
}

// FUNCIÓN 2: CONFIRMAR Y AGREGAR AL CARRITO
function confirmarAgregar() {
  if (!productoPendiente) return;

  const notaUsuario = document.getElementById("texto-nota").value.trim();

  carrito.push({
    id: productoPendiente.id,
    nombre: productoPendiente.nombre,
    precio: productoPendiente.precio,
    nota: notaUsuario,
  });

  cerrarModal();
  actualizarVista();
}

// FUNCIÓN 3: CERRAR VENTANA
function cerrarModal() {
  document.getElementById("modal-notas").style.display = "none";
  productoPendiente = null;
}

// RESTO DE FUNCIONES (VISUALIZAR, BORRAR, GUARDAR)
function actualizarVista() {
  const lista = document.getElementById("lista-ticket");
  const totalDisplay = document.getElementById("total-monto");

  lista.innerHTML = "";
  total = 0;

  if (carrito.length === 0) {
    lista.innerHTML =
      '<p style="text-align:center; color:#999; margin-top:50px;">Selecciona productos...</p>';
  }

  carrito.forEach((prod, index) => {
    total += prod.precio;
    const htmlNota = prod.nota
      ? `<small style="color:#d35400; font-style:italic;">📝 ${prod.nota}</small>`
      : "";

    lista.innerHTML += `
        <div class="item-fila">
            <div>
                <strong>${prod.nombre}</strong> <br>
                ${htmlNota} <br>
                <small>S/ ${prod.precio.toFixed(2)}</small>
            </div>
            <div class="btn-borrar" onclick="eliminar(${index})">✕</div>
        </div>`;
  });

  totalDisplay.innerText = total.toFixed(2);
}

function eliminar(index) {
  carrito.splice(index, 1);
  actualizarVista();
}

async function guardarPedido() {
  let cliente_id = document.getElementById("cliente").value;

  if (cliente_id === "") return alert("⚠️ ¡Selecciona un cliente primero!");
  if (carrito.length === 0) return alert("⚠️ ¡El carrito está vacío!");

  try {
    const respuesta = await fetch("procesar_pedido.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        cliente_id: cliente_id,
        productos: carrito,
        total: total,
      }),
    });
    const resultado = await respuesta.json();
    if (resultado.success) {
      window.location.href = "ticket.php?id=" + resultado.id;
    } else {
      alert("❌ Error: " + resultado.message);
    }
  } catch (error) {
    console.error("Error:", error);
    alert("Error de conexión");
  }
}
