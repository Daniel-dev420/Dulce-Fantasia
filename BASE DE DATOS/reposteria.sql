CREATE DATABASE IF NOT EXISTS reposteria
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE reposteria;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS factura_detalle;
DROP TABLE IF EXISTS facturas;
DROP TABLE IF EXISTS ventas;
DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS empleados;
DROP TABLE IF EXISTS clientes;
DROP TABLE IF EXISTS login;

SET FOREIGN_KEY_CHECKS = 1;


-- =========================================================
-- CLIENTES
-- =========================================================

CREATE TABLE clientes (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY email (email),
    UNIQUE KEY usuario (usuario)

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


-- =========================================================
-- EMPLEADOS
-- =========================================================

CREATE TABLE empleados (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    cargo VARCHAR(100) NOT NULL,
    salario DECIMAL(10,2) NOT NULL,

    PRIMARY KEY (id)

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;


INSERT INTO empleados
(id, nombre, cargo, salario)
VALUES
(5, 'ce', 'ewew', 1212.00);


-- =========================================================
-- LOGIN
-- =========================================================

CREATE TABLE login (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) NOT NULL,
    pass VARCHAR(255) NOT NULL,
    rol ENUM('Admin','Usuario') DEFAULT 'Usuario',

    PRIMARY KEY (id),
    UNIQUE KEY email (email),
    UNIQUE KEY usuario (usuario)

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


INSERT INTO login
(id, nombre, email, usuario, pass, rol)
VALUES
(
    2,
    'qwww',
    'iewf|@5g4h45h',
    'qwww',
    '$2y$10$n2ZPSJvvYsgfYsCs5mZL/ugoyfxB2tnbdCv7WgzcDBbeb8G1yYyFi',
    'Usuario'
),
(
    3,
    'vdvsd',
    'qwewq@fw',
    'qwwww',
    '$2y$10$KVuIhQlRirWlxxHqL3IUhOPqXZUMaSgsKyKW4sFDsixZSZGAb/jbG',
    'Usuario'
),
(
    4,
    'qqqq',
    'qqqq@svbfdb',
    'qwerty',
    '$2y$10$1tU/ktAhj9ffc6jTkkypL.vsVu1JfRc6iIxCFzkcNUBXKhD8H7IgS',
    'Usuario'
),
(
    5,
    'Administrador',
    'admin@dulcefantasia.com',
    'admin',
    '$2y$10$PGLZIYHaMXcShesV5q/tJuv2cNyZST41VDuOKBaZUmnhQ64LSiXlC',
    'Admin'
);


-- =========================================================
-- PRODUCTOS
-- =========================================================

CREATE TABLE productos (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    imagen VARCHAR(255) DEFAULT NULL,
    categoria VARCHAR(100) NOT NULL,

    PRIMARY KEY (id)

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


INSERT INTO productos
(id, nombre, precio, imagen, categoria)
VALUES
(2, 'Tarta de Fresas conn Chocolate', 8200.00, 'uploads/descarga (6).jpeg', 'Postres'),
(3, 'Pastel de Chocolate y Fresas', 8500.00, 'uploads/descarga (7).jpeg', 'Postres'),
(4, 'Tarta de Arándanos', 8000.00, 'uploads/descarga (8).jpeg', 'Postres'),
(5, 'Cupcake Rosa', 3500.00, 'uploads/descarga (9).jpeg', 'Postres'),
(6, 'Cupcake de Chocolate', 3600.00, 'uploads/descarga (10).jpeg', 'Postres'),
(7, 'Helado de Vainilla con Chocolate', 6200.00, 'uploads/descarga (11).jpeg', 'Postres'),
(8, 'Mini Cupcakes Decorados', 4500.00, 'uploads/descarga (12).jpeg', 'Postres'),
(9, 'Galletas de Flor Morada', 3800.00, 'uploads/descarga (13).jpeg', 'Postres'),
(10, 'Galletas de Mariposa', 3900.00, 'uploads/descarga (14).jpeg', 'Postres'),
(11, 'Galleta en forma de Perro', 4000.00, 'uploads/descarga (15).jpeg', 'Postres'),
(12, 'Tarta Variada de Sabores', 9200.00, 'uploads/descarga.jfif', 'Postres'),
(13, 'Pastel con Fresas', 7800.00, 'uploads/descarga.jpeg', 'Postres'),
(14, 'Cheesecake de Uvas Verdes', 9700.00, 'uploads/Green Grape Cheesecake.jpeg', 'Postres');


-- =========================================================
-- VENTAS
-- =========================================================

CREATE TABLE ventas (
    id INT(11) NOT NULL AUTO_INCREMENT,
    fecha DATE NOT NULL,
    cliente VARCHAR(100) NOT NULL,
    monto DECIMAL(10,2) NOT NULL,

    PRIMARY KEY (id)

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


INSERT INTO ventas
(id, fecha, cliente, monto)
VALUES
(1, '2025-09-01', 'Juan Pérez', 15000.50),
(2, '2025-09-05', 'María Gómez', 7800.00),
(3, '2025-09-10', 'Carlos López', 22000.75),
(4, '2025-09-13', 'Cliente de prueba', 35600.00),
(5, '2025-09-13', 'Cliente de prueba', 47600.00),
(6, '2025-09-13', 'rerre', 17800.00),
(7, '2025-09-13', '4tert', 17800.00);


-- =========================================================
-- FACTURAS
-- =========================================================

CREATE TABLE facturas (
    id INT(11) NOT NULL AUTO_INCREMENT,
    cliente_id INT(11) NOT NULL,
    fecha TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,

    PRIMARY KEY (id),
    KEY cliente_id (cliente_id),

    CONSTRAINT facturas_ibfk_1
        FOREIGN KEY (cliente_id)
        REFERENCES login(id)
        ON DELETE CASCADE

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


-- =========================================================
-- FACTURA DETALLE
-- =========================================================

CREATE TABLE factura_detalle (
    id INT(11) NOT NULL AUTO_INCREMENT,
    factura_id INT(11) NOT NULL,
    producto_id INT(11) NOT NULL,
    cantidad INT(11) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,

    PRIMARY KEY (id),
    KEY factura_id (factura_id),
    KEY producto_id (producto_id),

    CONSTRAINT factura_detalle_ibfk_1
        FOREIGN KEY (factura_id)
        REFERENCES facturas(id)
        ON DELETE CASCADE,

    CONSTRAINT factura_detalle_ibfk_2
        FOREIGN KEY (producto_id)
        REFERENCES productos(id)
        ON DELETE CASCADE

) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;