CREATE DATABASE IF NOT EXISTS zapatos_db;
USE zapatos_db;

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    stock INT,
    precio DECIMAL(10,2),
    imagen VARCHAR(255),
    estado VARCHAR(50) DEFAULT 'Disponible',
    categoria VARCHAR(100) DEFAULT 'Sin categoría',
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    precio_anterior DECIMAL(10,2)
);

INSERT INTO productos (nombre, stock, precio, imagen) VALUES
('Ropero de sedro', 9, 500, 'img1.png'),
('Colchon Matrimonial', 20, 2000, 'img2.png'),
('Mascara', 9, 50, 'img3.png');

CREATE TABLE IF NOT EXISTS ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    referencia VARCHAR(100),
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2),
    status VARCHAR(50) DEFAULT 'Pendiente'
);

CREATE TABLE IF NOT EXISTS detalle_ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venta_id INT,
    producto_id INT,
    cantidad INT,
    FOREIGN KEY (venta_id) REFERENCES ventas(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);
ALTER TABLE ventas ADD COLUMN nombre TEXT;
ALTER TABLE ventas ADD COLUMN direccion TEXT;
ALTER TABLE ventas ADD COLUMN localidad TEXT;
ALTER TABLE detalle_ventas
DROP FOREIGN KEY detalle_ventas_ibfk_1;

ALTER TABLE detalle_ventas
ADD CONSTRAINT detalle_ventas_ibfk_1
FOREIGN KEY (venta_id) REFERENCES ventas(id)
ON DELETE CASCADE;
