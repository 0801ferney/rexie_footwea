// Aquí puedes agregar JS personalizado si lo necesitas
document.addEventListener('DOMContentLoaded', function () {
    // Productos de ejemplo (deben coincidir con los de tu HTML)
    const productos = [
        { nombre: "Ropero de sedro", precio: 500 },
        { nombre: "Colchon Matrimonial", precio: 2000 },
        { nombre: "Mascara", precio: 50 }
    ];

    // Carrito en memoria
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

    // Añadir al carrito
    document.querySelectorAll('.add-cart-btn').forEach((btn, idx) => {
        btn.addEventListener('click', function () {
            const producto = productos[idx];
            const encontrado = carrito.find(p => p.nombre === producto.nombre);
            if (encontrado) {
                encontrado.cantidad += 1;
            } else {
                carrito.push({ ...producto, cantidad: 1 });
            }
            localStorage.setItem('carrito', JSON.stringify(carrito));
            actualizarCarritoUI();
        });
    });

    // Mostrar carrito al abrir el modal
    const carritoModal = document.getElementById('carritoModal');
    carritoModal.addEventListener('show.bs.modal', actualizarCarritoUI);

    // Actualiza la UI del carrito
    function actualizarCarritoUI() {
        const lista = document.getElementById('carrito-lista');
        const totalSpan = document.getElementById('carrito-total');
        lista.innerHTML = '';
        let total = 0;
        carrito = JSON.parse(localStorage.getItem('carrito')) || [];
        carrito.forEach((item, idx) => {
            total += item.precio * item.cantidad;
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `
                <span>${item.nombre} <span class="badge bg-secondary ms-2">${item.cantidad}</span></span>
                <div>
                    <button class="btn btn-sm btn-outline-secondary me-1 restar" data-idx="${idx}">-</button>
                    <button class="btn btn-sm btn-outline-secondary me-2 sumar" data-idx="${idx}">+</button>
                    $${item.precio * item.cantidad}
                    <button class="btn btn-sm btn-danger ms-2 eliminar" data-idx="${idx}">&times;</button>
                </div>
            `;
            lista.appendChild(li);
        });
        totalSpan.textContent = total;
        document.getElementById('comprar-btn').disabled = carrito.length === 0;

        // Botones sumar/restar/eliminar
        lista.querySelectorAll('.sumar').forEach(btn => {
            btn.onclick = () => {
                carrito[btn.dataset.idx].cantidad++;
                localStorage.setItem('carrito', JSON.stringify(carrito));
                actualizarCarritoUI();
            };
        });
        lista.querySelectorAll('.restar').forEach(btn => {
            btn.onclick = () => {
                if (carrito[btn.dataset.idx].cantidad > 1) {
                    carrito[btn.dataset.idx].cantidad--;
                } else {
                    carrito.splice(btn.dataset.idx, 1);
                }
                localStorage.setItem('carrito', JSON.stringify(carrito));
                actualizarCarritoUI();
            };
        });
        lista.querySelectorAll('.eliminar').forEach(btn => {
            btn.onclick = () => {
                carrito.splice(btn.dataset.idx, 1);
                localStorage.setItem('carrito', JSON.stringify(carrito));
                actualizarCarritoUI();
            };
        });
    }

    // Comprar (solo muestra alerta)
    document.getElementById('comprar-btn').onclick = function () {
        alert('Debes iniciar sesión para comprar.');
    };

    // Al iniciar sesión exitosamente
    localStorage.setItem('usuarioLogueado', 'true');

    // Al cerrar sesión
    localStorage.removeItem('usuarioLogueado');
});

