-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 12-11-2024 a las 21:31:53
-- Versión del servidor: 8.0.17
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

SET AUTOCOMMIT = 0;

START TRANSACTION;

SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;

--
-- Base de datos: `comercio_electronico`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
    `id` int(11) NOT NULL,
    `nombre` varchar(255) NOT NULL,
    `descripcion` text,
    `imagen` varchar(255) DEFAULT NULL
);

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO
    `categorias` (
        `id`,
        `nombre`,
        `descripcion`,
        `imagen`
    )
VALUES (
        1,
        'Laptops',
        'Portátiles de última generación',
        'imagenes\laptops.jpg'
    ),
    (
        2,
        'Smartphones',
        'Teléfonos inteligentes de diversas marcas',
        'imagenes\smart.jpeg'
    ),
    (
        3,
        'Tablets',
        'Tabletas de distintas marcas y tamaños',
        'imagenes\tab.jpg'
    ),
    (
        4,
        'Accesorios',
        'Accesorios tecnológicos como teclados, ratones, etc.',
        'imagenes\acce.jpg'
    ),
    (
        5,
        'Cámaras',
        'Cámaras fotográficas y de video',
        'imagenes\ca.jpg'
    ),
    (
        6,
        'Audio',
        'Auriculares, altavoces, y otros dispositivos de audio',
        'imagenes\au.jpg'
    ),
    (
        7,
        'Videojuegos',
        'ultimos juegos de multijugador para xbox y playstation',
        'imagenes\videoj.jpg'
    );

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
    `id_cliente` int(11) NOT NULL,
    `nombre` varchar(100) NOT NULL,
    `email` varchar(100) NOT NULL,
    `telefono` varchar(20) DEFAULT NULL,
    `direccion` text,
    `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO
    `clientes` (
        `id_cliente`,
        `nombre`,
        `email`,
        `telefono`,
        `direccion`,
        `fecha_registro`
    )
VALUES (
        1,
        'Sofia Perez',
        'sofia.perez@gmail.com',
        '1234567890',
        '123 Calle Falsa, Ciudad',
        '2024-11-10 03:55:22'
    ),
    (
        2,
        'Javier Gomez',
        'javier.gomez@gmail.com',
        '0987654321',
        '456 Avenida Real, Ciudad',
        '2024-11-10 03:55:22'
    ),
    (
        3,
        'Luis Martinez',
        'luis.martinez@gmail.com',
        '3456789012',
        '789 Calle Nueva, Ciudad',
        '2024-11-10 03:55:22'
    ),
    (
        4,
        'Carla Lopez',
        'carla.lopez@gmail.com',
        '5678901234',
        '1010 Calle Principal, Ciudad',
        '2024-11-10 03:55:22'
    ),
    (
        5,
        'Raul Fernandez',
        'raul.fernandez@gmail.com',
        '6789012345',
        '2020 Avenida Libertad, Ciudad',
        '2024-11-10 03:55:22'
    ),
    (
        6,
        'Ana Maria Torres',
        'ana.torres@gmail.com',
        '7890123456',
        '3030 Calle Independencia, Ciudad',
        '2024-11-10 03:55:22'
    ),
    (
        7,
        'alex mendoza',
        'alexmendoza@gmail.com',
        '64123456',
        'San Valentin',
        '2024-11-10 23:30:34'
    ),
    (
        8,
        'Alonso',
        'alonso11m@gmail.com',
        '43748646895',
        'las huacas',
        '2024-11-10 23:38:51'
    );

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_pedido`
--

CREATE TABLE `detalles_pedido` (
    `id` int(11) NOT NULL,
    `id_pedido` int(11) DEFAULT NULL,
    `id_producto` int(11) DEFAULT NULL,
    `cantidad` int(11) NOT NULL
);

--
-- Volcado de datos para la tabla `detalles_pedido`
--

INSERT INTO
    `detalles_pedido` (
        `id`,
        `id_pedido`,
        `id_producto`,
        `cantidad`
    )
VALUES (1, 1, 1, 1),
    (2, 2, 2, 2),
    (3, 3, 3, 1),
    (4, 4, 4, 3),
    (5, 5, 5, 1),
    (6, 6, 6, 2),
    (7, 7, 4, 1),
    (8, 8, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
    `id` int(11) NOT NULL,
    `nombre` varchar(255) NOT NULL,
    `apellido` varchar(255) NOT NULL,
    `puesto` varchar(255) NOT NULL,
    `usuario_id` int(11) DEFAULT NULL
);

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO
    `empleados` (
        `id`,
        `nombre`,
        `apellido`,
        `puesto`,
        `usuario_id`
    )
VALUES (
        1,
        'Ricardo',
        'Martínez',
        'Gerente General',
        1
    ),
    (
        2,
        'Paola',
        'Hernández',
        'Contadora Auxiliar',
        2
    ),
    (
        3,
        'Fernando',
        'Lopez',
        'Soporte Técnico',
        3
    ),
    (
        4,
        'Gabriela',
        'Sanchez',
        'Vendedora',
        4
    ),
    (
        5,
        'Santiago',
        'Ruiz',
        'Contador',
        5
    ),
    (
        6,
        'Valeria',
        'Gomez',
        'Asistente Administrativa',
        6
    );

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entregas`
--

CREATE TABLE `entregas` (
    `id_entrega` int(11) NOT NULL,
    `id_venta` int(11) NOT NULL,
    `metodo_entrega` varchar(100) NOT NULL,
    `fecha_entrega` date NOT NULL,
    `hora_entrega` time NOT NULL,
    `tipo_envio` varchar(50) NOT NULL
);

--
-- Volcado de datos para la tabla `entregas`
--

INSERT INTO
    `entregas` (
        `id_entrega`,
        `id_venta`,
        `metodo_entrega`,
        `fecha_entrega`,
        `hora_entrega`,
        `tipo_envio`
    )
VALUES (
        1,
        1,
        'Envío a domicilio',
        '2024-11-10',
        '14:30:00',
        'express'
    ),
    (
        2,
        2,
        'Recogida en tienda',
        '2024-11-11',
        '10:00:00',
        'estándar'
    ),
    (
        3,
        3,
        'Envío a domicilio',
        '2024-11-12',
        '16:00:00',
        'express'
    ),
    (
        4,
        4,
        'Recogida en tienda',
        '2024-11-13',
        '09:30:00',
        'estándar'
    ),
    (
        5,
        5,
        'Envío a domicilio',
        '2024-11-14',
        '11:00:00',
        'standard'
    ),
    (
        6,
        6,
        'Recogida en tienda',
        '2024-11-15',
        '13:00:00',
        'express'
    ),
    (
        7,
        7,
        'domicilio',
        '2024-11-04',
        '20:30:00',
        'normal'
    ),
    (
        8,
        8,
        'domicilio',
        '2024-11-03',
        '08:40:00',
        'normal'
    );

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
    `id` int(11) NOT NULL,
    `nombre` varchar(255) NOT NULL,
    `descripcion` text,
    `estado` enum(
        'disponible',
        'en uso',
        'fuera de servicio'
    ) NOT NULL,
    `Empleados_id` int(11) DEFAULT NULL
);

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO
    `equipos` (
        `id`,
        `nombre`,
        `descripcion`,
        `estado`,
        `Empleados_id`
    )
VALUES (
        1,
        'Equipo A',
        'Equipo de soporte técnico',
        'disponible',
        1
    ),
    (
        2,
        'Equipo B',
        'Equipo de ventas',
        'en uso',
        2
    ),
    (
        3,
        'Equipo C',
        'Equipo de marketing',
        'disponible',
        3
    ),
    (
        4,
        'Equipo D',
        'Equipo de administración',
        'fuera de servicio',
        4
    ),
    (
        5,
        'Equipo E',
        'Equipo de desarrollo',
        'en uso',
        5
    ),
    (
        6,
        'Equipo F',
        'Equipo de logística',
        'disponible',
        6
    );

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
    `id_pago` int(11) NOT NULL,
    `id_venta` int(11) NOT NULL,
    `metodo_pago` enum('tarjeta', 'paypal') NOT NULL,
    `tipo_tarjeta` varchar(50) DEFAULT NULL,
    `numero_cuenta` varchar(100) NOT NULL,
    `fecha_pago` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    `monto` decimal(10, 2) NOT NULL,
    `estado_pago` enum(
        'completado',
        'pendiente',
        'fallido'
    ) DEFAULT 'pendiente'
);

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO
    `pagos` (
        `id_pago`,
        `id_venta`,
        `metodo_pago`,
        `tipo_tarjeta`,
        `numero_cuenta`,
        `fecha_pago`,
        `monto`,
        `estado_pago`
    )
VALUES (
        1,
        1,
        'tarjeta',
        'VISA',
        '1234-5678-9101',
        '2024-11-10 03:55:22',
        '1500.00',
        'pendiente'
    ),
    (
        2,
        2,
        'paypal',
        'paypal_usa',
        'e456798787654',
        '2024-11-10 03:55:22',
        '1800.00',
        'completado'
    ),
    (
        3,
        3,
        'tarjeta',
        'MasterCard',
        '2345-6789-1234',
        '2024-11-10 03:55:22',
        '400.00',
        'completado'
    ),
    (
        4,
        4,
        'tarjeta',
        'VISA',
        '3456-7890-2345',
        '2024-11-10 03:55:22',
        '93.35',
        'completado'
    ),
    (
        5,
        5,
        'paypal',
        'paypal_usa',
        '3234567895654',
        '2024-11-10 03:55:22',
        '800.00',
        'pendiente'
    ),
    (
        6,
        6,
        'tarjeta',
        'American Express',
        '4567-8901-3456',
        '2024-11-10 03:55:22',
        '240.00',
        'pendiente'
    ),
    (
        7,
        7,
        'paypal',
        'paypal_america',
        '345435355435322112',
        '2024-11-10 23:30:35',
        '50.00',
        'pendiente'
    ),
    (
        8,
        8,
        'tarjeta',
        'AmericanExpress',
        '2835496790',
        '2024-11-10 23:38:51',
        '400.00',
        'pendiente'
    );

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
    `id_pedido` int(11) NOT NULL,
    `id_cliente` int(11) DEFAULT NULL,
    `venta_id` int(11) DEFAULT NULL,
    `fecha` datetime DEFAULT CURRENT_TIMESTAMP,
    `estado` enum(
        'pendiente',
        'completado',
        'cancelado'
    ) NOT NULL
);

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO
    `pedidos` (
        `id_pedido`,
        `id_cliente`,
        `venta_id`,
        `fecha`,
        `estado`
    )
VALUES (
        1,
        1,
        1,
        '2024-11-09 22:55:22',
        'pendiente'
    ),
    (
        2,
        2,
        2,
        '2024-11-09 22:55:22',
        'completado'
    ),
    (
        3,
        3,
        3,
        '2024-11-09 22:55:22',
        'pendiente'
    ),
    (
        4,
        4,
        4,
        '2024-11-09 22:55:22',
        'completado'
    ),
    (
        5,
        5,
        5,
        '2024-11-09 22:55:22',
        'cancelado'
    ),
    (
        6,
        6,
        6,
        '2024-11-09 22:55:22',
        'pendiente'
    ),
    (
        7,
        7,
        7,
        '2024-11-10 18:30:34',
        'pendiente'
    ),
    (
        8,
        8,
        8,
        '2024-11-10 18:38:51',
        'pendiente'
    );

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
    `id` int(11) NOT NULL,
    `nombre` varchar(255) NOT NULL,
    `descripcion` text,
    `precio` decimal(10, 2) NOT NULL,
    `stock` int(11) NOT NULL,
    `categoria_id` int(11) DEFAULT NULL,
    `imagen` varchar(255) DEFAULT NULL,
    `descripcion_larga` text
);

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO
    `productos` (
        `id`,
        `nombre`,
        `descripcion`,
        `precio`,
        `stock`,
        `categoria_id`,
        `imagen`,
        `descripcion_larga`
    )
VALUES (
        1,
        'Laptop Ultra',
        'Laptop con procesador Intel i7',
        '1500.00',
        10,
        1,
        '/src/images/dell.jpg',
        'Laptop de alta gama con 16GB RAM'
    ),
    (
        2,
        'Smartphone X',
        'Teléfono inteligente con 128GB',
        '900.00',
        20,
        2,
        '/src/images/Smartphone.jpg',
        'Smartphone con excelente cámara'
    ),
    (
        3,
        'Tablet Pro',
        'Tableta de 10 pulgadas con 4GB de RAM',
        '400.00',
        14,
        3,
        '/src/images/tablet.jpg',
        'Tablet ideal para ver contenido multimedia'
    ),
    (
        4,
        'Mouse Inalámbrico',
        'Mouse ergonómico y recargable',
        '50.00',
        50,
        4,
        '/src/images/mouse.jpg',
        'Mouse con conectividad Bluetooth'
    ),
    (
        5,
        'Cámara HD',
        'Cámara digital con capacidad 4K',
        '800.00',
        8,
        5,
        '/src/images/camara.jpg',
        'Cámara con lentes intercambiables y grabación en 4K'
    ),
    (
        6,
        'Auriculares Bluetooth',
        'Auriculares inalámbricos con sonido premium',
        '120.00',
        30,
        6,
        '/src/images/auriculares.jpg',
        'Auriculares con cancelación de ruido'
    ),
    (
        7,
        'Control Inalámbrico para Celulares',
        'Control de juegos compatible con Android e iOS',
        '39.99',
        45,
        7,
        '/src/images/control.png',
        'Control inalámbrico para jugar en dispositivos móviles, compatible con Android e iOS, con soporte para sostener el teléfono.'
    ),
    (
        18,
        'Funda Protectora para Nintendo Switch',
        'Funda rígida para proteger la consola Switch',
        '19.99',
        50,
        7,
        '/src/images/fu.jpg',
        'Funda de alta resistencia para proteger la Nintendo Switch, incluye compartimientos para juegos y accesorios.'
    ),
    (
        19,
        'Auriculares con Micrófono',
        'Auriculares con micrófono ajustable y cancelación de ruido',
        '59.99',
        30,
        6,
        '/src/images/auu.jpg',
        'Auriculares especialmente diseñados  con sonido envolvente y cancelación de ruido, compatibles con consolas y PC.'
    ),
    (
        20,
        'Soporte de Carga para PlayStation 5',
        'Base de carga para dos controles PS5',
        '29.99',
        25,
        7,
        '/src/images/so.jpg',
        'Soporte que permite cargar dos controles de PlayStation 5 simultáneamente, ideal para mantener organizados los controles.'
    ),
    (
        21,
        'Vidrio Templado para iPhone 13',
        'Protector de pantalla de alta resistencia para iPhone',
        '12.99',
        100,
        2,
        '/src/images/templado.jpeg',
        'Protector de pantalla de vidrio templado para iPhone 13, resistente a rayones y caídas, con alta claridad y sensibilidad al tacto.'
    ),
    (
        22,
        'Joystick para Smartphone',
        'Joystick removible para mejorar la experiencia de juego móvil',
        '8.99',
        75,
        7,
        '/src/images/sj.jpg',
        'Joystick portátil que se adhiere a la pantalla de cualquier smartphone, ideal para juegos móviles de acción y aventura.'
    ),
    (
        23,
        'Smartphone Galaxy A52',
        'Celular Samsung de gama media con buena cámara',
        '299.99',
        50,
        2,
        '/src/images/a52.jpeg',
        'Un smartphone con pantalla AMOLED, resistente al agua y con una cámara cuádruple de 64 MP.'
    ),
    (
        24,
        'PlayStation 5',
        'Consola de videojuegos de última generación',
        '499.99',
        10,
        7,
        '/src/images/ps5.jpg',
        'La PS5 ofrece gráficos impresionantes, velocidades de carga rápidas y una experiencia de juego inmersiva con su control DualSense.'
    ),
    (
        25,
        'Laptop Dell Inspiron 15',
        'Laptop con procesador Intel i5 y 8GB de RAM',
        '649.99',
        30,
        1,
        '/src/images/de.jpg',
        'Portátil de alto rendimiento para tareas diarias, equipada con procesador Intel de última generación y almacenamiento SSD.'
    ),
    (
        26,
        'Auriculares Inalámbricos Bluetooth',
        'Auriculares compactos con estuche de carga',
        '59.99',
        40,
        6,
        '/src/images/aau.jpg',
        'Auriculares inalámbricos de alta calidad con tecnología Bluetooth 5.0, batería de larga duración y cancelación de ruido.'
    ),
    (
        27,
        'Cargador Portátil Power Bank 10,000mAh',
        'Batería externa compatible con dispositivos USB',
        '29.99',
        75,
        4,
        '/src/images/carga.jpg',
        'Cargador portátil de alta capacidad, ideal para cargar tu smartphone o tablet cuando estás fuera de casa.'
    ),
    (
        28,
        'Teclado Mecánico RGB',
        'Teclado mecánico con iluminación RGB personalizable',
        '89.99',
        20,
        1,
        '/src/images/tecladomec.jpg',
        'Teclado mecánico de alta durabilidad con retroiluminación RGB y múltiples modos de color, perfecto para juegos y productividad.'
    ),
    (
        29,
        'Funda Protectora para Tablet 10\"',
        'Funda de silicona resistente para tabletas de 10 pulgadas',
        '15.99',
        50,
        3,
        '/src/images/fundatablet.jpeg',
        'Funda protectora diseñada para brindar resistencia contra golpes y rayones, ideal para mantener segura tu tablet.'
    ),
    (
        30,
        'Cargador Rápido USB-C de 20W',
        'Cargador rápido compatible con dispositivos USB-C',
        '24.99',
        60,
        4,
        '/src/images/cargacell.jpg',
        'Cargador compacto de 20W, ideal para una carga rápida y segura de dispositivos USB-C como smartphones y tablets.'
    ),
    (
        31,
        'Ratón Inalámbrico Ergonómico',
        'Ratón inalámbrico con diseño ergonómico',
        '19.99',
        100,
        4,
        '/src/images/ra.jpg',
        'Ratón ergonómico diseñado para uso prolongado sin causar fatiga en la muñeca, con conectividad inalámbrica y alta precisión.'
    ),
    (
        32,
        'Soporte Ajustable para Laptop',
        'Soporte portátil ajustable en altura para laptops',
        '34.99',
        30,
        1,
        '/src/images/sso.jpeg',
        'Soporte ligero y ajustable que mejora la ventilación y la postura al utilizar la laptop. Compatible con modelos de hasta 15 pulgadas.'
    ),
    (
        33,
        'Cable HDMI 4K de 2 metros',
        'Cable HDMI compatible con 4K UHD',
        '14.99',
        120,
        1,
        '/src/images/hdmi.jpg',
        'Cable HDMI de alta velocidad, ideal para conectar dispositivos a pantallas 4K UHD con excelente calidad de imagen y sonido.'
    ),
    (
        35,
        'Lámpara LED con Cargador Inalámbrico',
        'Lámpara de escritorio LED con carga inalámbrica',
        '49.99',
        15,
        4,
        '/src/images/cc.jpg',
        'Lámpara LED multifuncional con carga inalámbrica integrada, brillo ajustable y modo de luz nocturna, ideal para el escritorio.'
    ),
    (
        36,
        'Parlante Bluetooth Portátil',
        'Parlante compacto con sonido de alta calidad',
        '49.99',
        40,
        6,
        '/src/images/par.jpg',
        'Parlante Bluetooth portátil con resistencia al agua, batería de larga duración y conectividad Bluetooth 5.0. Ideal para exteriores.'
    ),
    (
        37,
        'Audífonos Inalámbricos con Cancelación de Ruido',
        'Audífonos premium con cancelación activa de ruido',
        '99.99',
        25,
        6,
        '/src/images/dif.jpg',
        'Audífonos inalámbricos con cancelación de ruido, perfectos para escuchar música sin interrupciones en cualquier lugar. Incluye estuche de carga rápida.'
    ),
    (
        38,
        'Cámara Digital 4K',
        'Cámara digital con grabación en 4K y múltiples funciones',
        '299.99',
        15,
        5,
        '/src/images/4k.jpg',
        'Cámara compacta que captura imágenes y videos en alta resolución 4K, con pantalla táctil y opciones de conectividad Wi-Fi y Bluetooth.'
    ),
    (
        39,
        'Cámara Deportiva a Prueba de Agua',
        'Cámara de acción resistente al agua, ideal para deportes',
        '89.99',
        35,
        5,
        '/src/images/cde.jpg',
        'Cámara de acción para deportes extremos, con resistencia al agua y grabación en Full HD, ideal para capturar aventuras al aire libre.'
    ),
    (
        40,
        'Cámara de Vigilancia IP',
        'Cámara de seguridad con conexión Wi-Fi',
        '59.99',
        50,
        5,
        '/src/images/vi.jpg',
        'Cámara de seguridad IP para monitoreo remoto, con visión nocturna y detección de movimiento, accesible desde dispositivos móviles.'
    ),
    (
        41,
        'Cámara Instantánea',
        'Cámara fotográfica instantánea compacta',
        '79.99',
        20,
        5,
        '/src/images/ins.jpg',
        'Cámara instantánea para imprimir fotos al instante, ideal para eventos y momentos especiales. Disponible en varios colores.'
    ),
    (
        42,
        'Tablet Samsung Galaxy Tab A7',
        'Tablet de 10.4 pulgadas, ideal para entretenimiento y estudios',
        '229.99',
        30,
        3,
        '/src/images/a7.jpg',
        'Tablet con pantalla de alta resolución, batería de larga duración y altavoces Dolby Atmos. Perfecta para ver contenido multimedia y productividad.'
    ),
    (
        43,
        'Tablet Apple iPad 10.2\"',
        'iPad con pantalla Retina de 10.2 pulgadas',
        '329.99',
        25,
        3,
        '/src/images/ipa.jpg',
        'Apple iPad con procesador A13 Bionic, compatible con Apple Pencil y teclado inteligente. Ideal para estudiantes y creativos.'
    ),
    (
        44,
        'Tablet Amazon Fire HD 8',
        'Tablet económica de 8 pulgadas para el hogar',
        '89.99',
        40,
        3,
        '/src/images/am.jpg',
        'Tablet de uso familiar con acceso a Alexa, ideal para lectura, navegación y entretenimiento. Excelente relación calidad-precio.'
    ),
    (
        45,
        'iPhone 13',
        'Smartphone Apple con pantalla OLED y cámaras avanzadas',
        '799.99',
        20,
        2,
        '/src/images/iph.jpg',
        'iPhone 13 con pantalla Super Retina XDR, chip A15 Bionic y sistema avanzado de cámaras duales, disponible en varios colores.'
    ),
    (
        46,
        'Samsung Galaxy S21',
        'Smartphone Samsung de alta gama con pantalla AMOLED',
        '749.99',
        15,
        2,
        '/src/images/san.jpg',
        'Samsung Galaxy S21 con pantalla de 120Hz, cámaras avanzadas y batería de larga duración. Ideal para fotografía y entretenimiento.'
    );

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
    `id` int(11) NOT NULL,
    `nombre` varchar(255) NOT NULL,
    `apellido` varchar(255) NOT NULL,
    `correo` varchar(255) NOT NULL,
    `contraseña` varchar(255) NOT NULL,
    `rol` enum(
        'admin',
        'contador',
        'ayudante'
    ) NOT NULL,
    `foto_perfil` varchar(255) DEFAULT NULL
);

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO
    `usuarios` (
        `id`,
        `nombre`,
        `apellido`,
        `correo`,
        `contraseña`,
        `rol`,
        `foto_perfil`
    )
VALUES (
        1,
        'Nayelis',
        'Gilbot',
        'Nayelis.Gilbot@gmail.com',
        'password123',
        'admin',
        'nayelis.jpeg'
    ),
    (
        2,
        'Enier',
        'Arauz',
        'Enier.Arauz@gmail.com',
        'password456',
        'admin',
        'enier.jpg'
    ),
    (
        3,
        'Abdiel',
        'Montezuma',
        'Abdiel.montezuma@gmail.com',
        'password789',
        'contador',
        'abdiel.jpg'
    ),
    (
        4,
        'Imanol',
        'Aparicio',
        'Imanol.aparicio@gmail.com',
        'pass123',
        'ayudante',
        'imanol.jpg'
    ),
    (
        5,
        'Elena',
        'Garcia',
        'elena.garcia@gmail.com',
        'securepassword',
        'contador',
        'elena.jpg'
    ),
    (
        6,
        'Javier',
        'Diaz',
        'javier.diaz@gmail.com',
        'javier123',
        'ayudante',
        'javier.jpg'
    );

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
    `id` int(11) NOT NULL,
    `cliente_id` int(11) DEFAULT NULL,
    `id_producto` int(11) DEFAULT NULL,
    `cantidad` int(11) NOT NULL,
    `precio_total` decimal(10, 2) NOT NULL,
    `fecha` datetime DEFAULT CURRENT_TIMESTAMP
);

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO
    `ventas` (
        `id`,
        `cliente_id`,
        `id_producto`,
        `cantidad`,
        `precio_total`,
        `fecha`
    )
VALUES (
        1,
        1,
        1,
        1,
        '1500.00',
        '2024-11-09 22:55:22'
    ),
    (
        2,
        2,
        2,
        2,
        '1800.00',
        '2024-11-09 22:55:22'
    ),
    (
        3,
        3,
        1,
        1,
        '400.00',
        '2024-11-09 22:55:22'
    ),
    (
        4,
        4,
        4,
        3,
        '150.00',
        '2024-11-09 22:55:22'
    ),
    (
        5,
        5,
        5,
        1,
        '800.00',
        '2024-11-09 22:55:22'
    ),
    (
        6,
        6,
        6,
        2,
        '240.00',
        '2024-11-09 22:55:22'
    ),
    (
        7,
        7,
        4,
        1,
        '50.00',
        '2024-11-10 18:30:34'
    ),
    (
        8,
        8,
        3,
        1,
        '400.00',
        '2024-11-10 18:38:51'
    );

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias` ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
ADD PRIMARY KEY (`id_cliente`),
ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
ADD PRIMARY KEY (`id`),
ADD KEY `id_pedido` (`id_pedido`),
ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
ADD PRIMARY KEY (`id`),
ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `entregas`
--
ALTER TABLE `entregas`
ADD PRIMARY KEY (`id_entrega`),
ADD KEY `id_venta` (`id_venta`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
ADD PRIMARY KEY (`id`),
ADD KEY `Empleados_id` (`Empleados_id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
ADD PRIMARY KEY (`id_pago`),
ADD KEY `id_venta` (`id_venta`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
ADD PRIMARY KEY (`id_pedido`),
ADD KEY `id_cliente` (`id_cliente`),
ADD KEY `venta_id` (`venta_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
ADD PRIMARY KEY (`id`),
ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
ADD PRIMARY KEY (`id`),
ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
ADD PRIMARY KEY (`id`),
ADD KEY `cliente_id` (`cliente_id`),
ADD KEY `id_producto` (`id_producto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 8;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 9;

--
-- AUTO_INCREMENT de la tabla `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 9;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 7;

--
-- AUTO_INCREMENT de la tabla `entregas`
--
ALTER TABLE `entregas`
MODIFY `id_entrega` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 9;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 7;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 9;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 9;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 47;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 7;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalles_pedido`
--
ALTER TABLE `detalles_pedido`
ADD CONSTRAINT `detalles_pedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE,
ADD CONSTRAINT `detalles_pedido_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `entregas`
--
ALTER TABLE `entregas`
ADD CONSTRAINT `entregas_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `equipos`
--
ALTER TABLE `equipos`
ADD CONSTRAINT `equipos_ibfk_1` FOREIGN KEY (`Empleados_id`) REFERENCES `empleados` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE SET NULL,
ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id_cliente`) ON DELETE SET NULL,
ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE SET NULL;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;