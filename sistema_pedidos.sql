-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3308
-- Tiempo de generación: 06-12-2025 a las 02:45:05
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_pedidos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `email`, `telefono`) VALUES
(1, 'Carlos Cliente', 'carlos@mail.com', '999888777');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedidos`
--

CREATE TABLE `detalle_pedidos` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `notas` varchar(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pedidos`
--

INSERT INTO `detalle_pedidos` (`id`, `pedido_id`, `producto_id`, `cantidad`, `precio_unitario`, `notas`) VALUES
(1, 1, 1, 1, 8.00, 'sin mayonesa'),
(2, 1, 4, 1, 12.00, 'con todo menos aji, doble carne'),
(3, 1, 85, 1, 8.00, ''),
(4, 2, 32, 1, 10.00, 'tocino, aji, mayonesa'),
(5, 2, 36, 1, 7.00, ''),
(6, 2, 1, 1, 8.00, ''),
(7, 3, 4, 1, 12.00, 'sin mayonesa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  `estado` enum('pendiente','completado','cancelado') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `cliente_id`, `fecha`, `total`, `estado`) VALUES
(1, 1, '2025-12-05 20:05:00', 28.00, 'completado'),
(2, 1, '2025-12-05 20:09:37', 25.00, 'completado'),
(3, 1, '2025-12-05 20:32:47', 12.00, 'completado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `categoria` varchar(50) DEFAULT 'General',
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `imagen` varchar(255) DEFAULT '?',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `categoria`, `descripcion`, `precio`, `stock`, `imagen`, `fecha_creacion`) VALUES
(1, 'Hamburguesa Clásica', 'Hamburguesas', 'Carne + Papas + Ensalada', 8.00, 48, '🍔', '2025-12-06 00:55:16'),
(2, 'Hamburguesa Royal', 'Hamburguesas', 'Carne + Huevo + Papas + Ensalada', 9.50, 50, '🍳', '2025-12-06 00:55:16'),
(3, 'Hamburguesa Cubana', 'Hamburguesas', 'Carne + Huevo + Plátano + Papas + Ensalada', 11.00, 50, '🍌', '2025-12-06 00:55:16'),
(4, 'Hamburguesa Parrillera', 'Hamburguesas', 'Carne + Chorizo + Papas + Ensalada', 12.00, 48, '🔥', '2025-12-06 00:55:16'),
(5, 'Hamburguesa Royal Especial', 'Hamburguesas', 'Carne + Huevo + Queso + Jamón + Papas', 13.00, 50, '👑', '2025-12-06 00:55:16'),
(6, 'Hamburguesa La Doble', 'Hamburguesas', 'Doble Carne + Papas + Ensalada', 12.00, 50, '🥩', '2025-12-06 00:55:16'),
(7, 'Hamburguesa La Piña', 'Hamburguesas', 'Carne + Piña + Papas + Ensalada', 10.00, 50, '🍍', '2025-12-06 00:55:16'),
(8, 'Hamburguesa Hawaiana', 'Hamburguesas', 'Carne + Piña + Jamón + Papas', 11.50, 50, '🌴', '2025-12-06 00:55:16'),
(9, 'Hamburguesa La Happy', 'Hamburguesas', 'Carne+Huevo+Plátano+Tocino+Queso+Chorizo', 19.50, 50, '🤩', '2025-12-06 00:55:16'),
(10, 'Hamburguesa La de Pollo', 'Hamburguesas', 'Filete de Pollo + Papas + Ensalada', 9.50, 50, '🍗', '2025-12-06 00:55:16'),
(11, 'Choripan', 'Hamburguesas', 'Chorizo + Papas + Ensalada', 8.00, 50, '🌭', '2025-12-06 00:55:16'),
(12, 'Hamburguesa La Cheeser', 'Hamburguesas', 'Carne + Queso + Papas + Ensalada', 10.00, 50, '🧀', '2025-12-06 00:55:16'),
(13, 'Hamburguesa La Americana', 'Hamburguesas', 'Pechuga Pollo Broaster + Papas', 10.00, 50, '🇺🇸', '2025-12-06 00:55:16'),
(14, 'Hamburguesa Cheeser Especial', 'Hamburguesas', 'Doble Carne + Doble Queso + Papas', 16.00, 50, '🧀🧀', '2025-12-06 00:55:16'),
(15, 'Hamburguesa La Bacon', 'Hamburguesas', 'Carne + 4 Lonjas Tocino + Papas', 13.00, 50, '🥓', '2025-12-06 00:55:16'),
(16, 'Salchipapa Clásica', 'Salchipapas', 'Salchicha Rosada + Papas Fritas', 8.00, 100, '🌭', '2025-12-06 00:55:16'),
(17, 'Polli Papas', 'Salchipapas', 'Pollo Frito + Papas Fritas', 11.00, 80, '🍗', '2025-12-06 00:55:16'),
(18, 'Salchipapa A lo Pobre', 'Salchipapas', 'Salchicha + Huevo + Plátano + Papas', 11.00, 80, '🍳', '2025-12-06 00:55:16'),
(19, 'La Ahumada', 'Salchipapas', 'Hotdog Ahumado + Papas Fritas', 9.00, 80, '🥓', '2025-12-06 00:55:16'),
(20, 'Polli Papas Broaster', 'Salchipapas', 'Pollo Broaster + Papas Fritas', 13.00, 80, '🍗', '2025-12-06 00:55:16'),
(21, 'Choripapas', 'Salchipapas', 'Chorizo + Hotdog Ahumado + Papas', 12.50, 80, '🌭', '2025-12-06 00:55:16'),
(22, 'Salchi Pollo', 'Salchipapas', 'Salchicha + Pollo Frito + Papas', 12.50, 80, '🍗🌭', '2025-12-06 00:55:16'),
(23, 'Salchi Happy', 'Salchipapas', 'Hotdog+Pollo+Huevo+Plátano+Tocino+Chorizo', 22.00, 50, '🤩', '2025-12-06 00:55:16'),
(24, 'Porción de Nuggets', 'Salchipapas', '10 Nuggets + Papas + Cremas', 12.50, 60, '🍘', '2025-12-06 00:55:16'),
(25, 'Salchipollo Broaster', 'Salchipapas', 'Salchicha + Pollo Broaster + Papas', 14.50, 60, '🍗', '2025-12-06 00:55:16'),
(26, 'Mega Salchipapón (Para 3)', 'Salchipapones', 'Salchicha Rosada + Papas Fritas', 20.00, 30, '👨‍👩‍👧', '2025-12-06 00:55:16'),
(27, 'Mega Salchipapón Happy', 'Salchipapones', 'Salchicha+Broaster+Huevo+Plátano+2 Chorizos', 38.50, 20, '👑', '2025-12-06 00:55:16'),
(28, 'Mega Salchipapón Cubano', 'Salchipapones', 'Salchicha + 2 Huevos + Plátano + Papas', 26.00, 20, '🇨🇺', '2025-12-06 00:55:16'),
(29, 'Mega Salchipapón Ahumado', 'Salchipapones', 'Hotdog Ahumado + Abundantes Papas', 25.00, 20, '🥓', '2025-12-06 00:55:16'),
(30, 'Mega Salchipapón Broaster', 'Salchipapones', 'Salchicha + Pollo Broaster + Papas', 26.00, 20, '🍗', '2025-12-06 00:55:16'),
(31, 'Mega Choripapas', 'Salchipapones', '2 Chorizos + 3 Hotdogs Ahumados + Papas', 30.00, 20, '🌭', '2025-12-06 00:55:16'),
(32, 'Mostrito de Pollo Frito', 'Mostritos', 'Chaufa + Pollo Frito + Papas', 10.00, 39, '🍛', '2025-12-06 00:55:16'),
(33, 'Mostro de Pollo Frito', 'Mostritos', 'Chaufa + Pollo Frito (Grande) + Papas', 13.00, 40, '🦍', '2025-12-06 00:55:16'),
(34, 'Mostrito Pollo Broaster', 'Mostritos', 'Chaufa + Pollo Broaster + Papas', 11.00, 40, '🍗', '2025-12-06 00:55:16'),
(35, 'Mostro Pollo Broaster', 'Mostritos', 'Chaufa + Pollo Broaster (Grande) + Papas', 15.00, 40, '🍗🦍', '2025-12-06 00:55:16'),
(36, 'Perro Clásico', 'Hot Dogs', 'Hotdog + Papa Hilo + Queso Rallado', 7.00, 49, '🌭', '2025-12-06 00:55:16'),
(37, 'Perro Royal', 'Hot Dogs', 'Hotdog + Huevo + Papa Hilo + Queso', 8.50, 50, '🍳', '2025-12-06 00:55:16'),
(38, 'Perro Royal Especial', 'Hot Dogs', 'Hotdog+Huevo+Jamón+Cheddar+Papas Hilo', 12.00, 50, '👑', '2025-12-06 00:55:16'),
(39, 'Perro Cubano', 'Hot Dogs', 'Hotdog + Huevo + Plátano + Papa Hilo', 10.00, 50, '🍌', '2025-12-06 00:55:16'),
(40, 'Perro Parrillero', 'Hot Dogs', 'Hotdog + Chorizo + Papa Hilo', 11.00, 50, '🔥', '2025-12-06 00:55:16'),
(41, 'Perro Hawaiana', 'Hot Dogs', 'Hotdog + Jamón + Piña + Papa Hilo', 10.50, 50, '🍍', '2025-12-06 00:55:16'),
(42, 'Perro Piña', 'Hot Dogs', 'Hotdog + Piña + Papa Hilo', 9.00, 50, '🍍', '2025-12-06 00:55:16'),
(43, 'Perro Cheeser', 'Hot Dogs', 'Hotdog + Cheddar + Queso Rallado', 9.00, 50, '🧀', '2025-12-06 00:55:16'),
(44, 'Perro Happy', 'Hot Dogs', 'Hotdog+Chorizo+Tocino+Plátano+Huevo', 18.50, 50, '🤩', '2025-12-06 00:55:16'),
(45, 'Shawarma de Pollo', 'Shawarmas', 'Pollo + Papas Hilo + Repollo + Cremas', 10.00, 60, '🌯', '2025-12-06 00:55:16'),
(46, 'Shawarma Royal', 'Shawarmas', 'Pollo + Huevo + Papas Hilo + Repollo', 11.50, 60, '🍳', '2025-12-06 00:55:16'),
(47, 'Shawarma Hawaiana', 'Shawarmas', 'Pollo + Piña + Jamón + Papas Hilo', 13.50, 60, '🍍', '2025-12-06 00:55:16'),
(48, 'Shawarma de Piña', 'Shawarmas', 'Pollo + Piña + Papas Hilo', 12.00, 60, '🍍', '2025-12-06 00:55:16'),
(49, 'Shawarma Bacon', 'Shawarmas', 'Pollo + 2 Tocinos + Papas Hilo', 13.00, 60, '🥓', '2025-12-06 00:55:16'),
(50, 'Shawarma Cubano', 'Shawarmas', 'Pollo + Huevo + Plátano + Papas Hilo', 13.00, 60, '🍌', '2025-12-06 00:55:16'),
(51, 'Shawarma Parrillero', 'Shawarmas', 'Pollo + Chorizo + Papas Hilo', 14.00, 60, '🔥', '2025-12-06 00:55:16'),
(52, 'Shawarma Broaster', 'Shawarmas', 'Pollo Broaster + Papas Hilo', 15.00, 60, '🍗', '2025-12-06 00:55:16'),
(53, 'Shawarma Happy', 'Shawarmas', 'Pollo+Huevo+Plátano+Tocino+Queso+Chorizo', 23.00, 60, '🤩', '2025-12-06 00:55:16'),
(54, 'Shawarma Especial', 'Shawarmas', 'Pollo + Huevo + Queso + Jamón', 15.00, 60, '🌟', '2025-12-06 00:55:16'),
(55, 'Tequeños Jamón/Queso (5)', 'Tequeños', '+ 1 Salsa', 8.00, 50, '🥟', '2025-12-06 00:55:16'),
(56, 'Tequeños Jamón/Queso (10)', 'Tequeños', '+ 1 Salsa', 15.00, 50, '🥟', '2025-12-06 00:55:16'),
(57, 'Tequeños Chorizo/Queso (5)', 'Tequeños', '+ 1 Salsa', 9.00, 50, '🥟', '2025-12-06 00:55:16'),
(58, 'Tequeños Carne Molida (5)', 'Tequeños', '+ 1 Salsa', 10.00, 50, '🥟', '2025-12-06 00:55:16'),
(59, '1/4 Pollo Broster', 'Broster', 'Papas Fritas + Cremas + Ensalada', 15.00, 40, '🍗', '2025-12-06 00:55:16'),
(60, '1/2 Pollo Broster', 'Broster', 'Papas Fritas + Cremas + Ensalada', 25.00, 40, '🍗🍗', '2025-12-06 00:55:16'),
(61, '1 Pollo Broster Entero', 'Broster', 'Papas Fritas + Cremas + Ensalada', 45.00, 20, '🍗🍗🍗', '2025-12-06 00:55:16'),
(62, '6 Alitas Fritas', 'Alitas', 'Papas Fritas + Cremas', 19.00, 30, '🐓', '2025-12-06 00:55:16'),
(63, '6 Alitas BBQ', 'Alitas', 'Papas Fritas + Cremas', 20.00, 30, '🍖', '2025-12-06 00:55:16'),
(64, '6 Alitas Broaster BBQ', 'Alitas', 'Papas Fritas + Cremas', 22.00, 30, '🍗🍖', '2025-12-06 00:55:16'),
(65, '6 Alitas Maracuya', 'Alitas', 'Papas Fritas + Cremas + Ensalada', 22.00, 30, '🍊', '2025-12-06 00:55:16'),
(66, '6 Alitas BBQ Picante', 'Alitas', 'Alitas Broaster + Papas Fritas', 21.00, 30, '🌶️', '2025-12-06 00:55:16'),
(67, '6 Alitas Acevichadas', 'Alitas', 'Salsa Acevichada + Papas Fritas', 22.00, 30, '🍋', '2025-12-06 00:55:16'),
(68, 'Mix de Alitas', 'Alitas', '16 Alitas (4 Sabores) + Papas + Cremas', 45.00, 20, '🍱', '2025-12-06 00:55:16'),
(69, '1 Brocheta de Pollo', 'Parrilla', 'Papa Sancochada + Ensalada + Cremas', 8.00, 40, '🍢', '2025-12-06 00:55:16'),
(70, '2 Brochetas de Pollo', 'Parrilla', 'Papa Sancochada + Ensalada + Cremas', 15.00, 40, '🍢🍢', '2025-12-06 00:55:16'),
(71, 'Pollo a la Plancha', 'Parrilla', 'Papas + Arroz + Ensalada + Refresco', 10.00, 40, '🥗', '2025-12-06 00:55:16'),
(72, 'Sopa Ajinomen', 'Sopas', 'Preparada en Vaso', 5.50, 50, '🍜', '2025-12-06 00:55:16'),
(73, 'Sopa Ajinomen + Huevo', 'Sopas', 'Preparada + Huevo Duro', 7.00, 50, '🍜🥚', '2025-12-06 00:55:16'),
(74, 'Gaseosa 500ml', 'Bebidas', 'Fanta / Sprite / Pepsi', 2.50, 100, '🥤', '2025-12-06 00:55:16'),
(75, 'Gaseosa 600ml', 'Bebidas', 'Inca Kola / Coca Cola', 3.00, 100, '🥤', '2025-12-06 00:55:16'),
(76, 'Gaseosa 1.5L', 'Bebidas', 'Inca Kola / Coca Cola', 9.00, 50, '🍾', '2025-12-06 00:55:16'),
(77, 'Agua San Carlos 625ml', 'Bebidas', 'Sin gas', 1.50, 50, '💧', '2025-12-06 00:55:16'),
(78, 'Sporade 500ml', 'Bebidas', 'Rehidratante', 2.50, 50, '⚡', '2025-12-06 00:55:16'),
(79, 'Pilsen (Lata)', 'Bebidas', 'Cerveza 355ml', 5.00, 100, '🍺', '2025-12-06 00:55:16'),
(80, 'Redbull', 'Bebidas', 'Energizante 250ml', 9.00, 50, '🐂', '2025-12-06 00:55:16'),
(81, 'Mojito Clásico', 'Cocteles', 'Coctel', 10.00, 30, '🍹', '2025-12-06 00:55:16'),
(82, 'Chilcano', 'Cocteles', 'Coctel', 10.00, 30, '🍸', '2025-12-06 00:55:16'),
(83, 'Piña Colada', 'Cocteles', 'Coctel', 10.00, 30, '🍍', '2025-12-06 00:55:16'),
(84, 'Cuba Libre', 'Cocteles', 'Coctel', 10.00, 30, '🥃', '2025-12-06 00:55:16'),
(85, 'Porción Papas Fritas', 'Adicionales', 'Adicional', 8.00, 99, '🍟', '2025-12-06 00:55:16'),
(86, 'Porción Arroz Chaufa', 'Adicionales', 'Adicional', 8.00, 100, '🍚', '2025-12-06 00:55:16'),
(87, 'Pieza Pollo Broaster', 'Adicionales', 'Adicional', 6.00, 50, '🍗', '2025-12-06 00:55:16'),
(88, '3 Nuggets', 'Adicionales', 'Adicional', 4.00, 50, '🍘', '2025-12-06 00:55:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','vendedor') DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `rol`) VALUES
(1, 'Admin', 'admin@test.com', '123456', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedidos`
--
ALTER TABLE `detalle_pedidos`
  ADD CONSTRAINT `detalle_pedidos_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_pedidos_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
