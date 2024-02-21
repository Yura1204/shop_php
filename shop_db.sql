-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Фев 06 2024 г., 17:25
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `shop_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `app_orders`
--

CREATE TABLE `app_orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `order_status` enum('pending','shipped','delivered') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `app_products`
--

CREATE TABLE `app_products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



--
-- Структура таблицы `app_users`
--

CREATE TABLE `app_users` (
  `user_id` int(11) NOT NULL,
  `login` varchar(50) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_type` enum('regular','manager','admin') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `app_users`
--

INSERT INTO `app_users` (`user_id`, `login`, `first_name`, `last_name`, `email`, `region`, `password`, `user_type`) VALUES
(1, 'admin', 'Admin', 'User', 'admin@example.com', 'New York', '$2y$10$Q3XgFT4kWhLcnGuhj0Tc6.uNGNIdfZxm/9IDThshJ1QFmaajTEs0G', 'admin'),
(2, 'manager', 'Manager', 'User', 'manager@example.com', 'Los Angeles', '$2y$10$Q3XgFT4kWhLcnGuhj0Tc6.uNGNIdfZxm/9IDThshJ1QFmaajTEs0G', 'manager'),
(3, 'user4', 'User4', 'Lastname', 'user4@example.com', 'Chicago', '$2y$10$Q3XgFT4kWhLcnGuhj0Tc6.uNGNIdfZxm/9IDThshJ1QFmaajTEs0G', 'regular'),
(4, 'user5', 'User5', 'Lastname', 'user5@example.com', 'New York', '$2y$10$Q3XgFT4kWhLcnGuhj0Tc6.uNGNIdfZxm/9IDThshJ1QFmaajTEs0G', 'regular'),
(5, 'user6', 'Andriy', 'Bulba', 'Bulbla@mail.com', 'Ukraine', '$2y$10$Q3XgFT4kWhLcnGuhj0Tc6.uNGNIdfZxm/9IDThshJ1QFmaajTEs0G', 'admin'),
(6, 'user7', 'Sasha', 'Sergeev', 'Sergeev@email.com', 'England', '$2y$10$BcYObxvVgHZ27IqiNsrBa.Z8rX30RewpmrRuNiGl88fSF1OdX5hyi', 'regular');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `app_orders`
--
ALTER TABLE `app_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `app_products`
--
ALTER TABLE `app_products`
  ADD PRIMARY KEY (`product_id`);

--
-- Индексы таблицы `app_users`
--
ALTER TABLE `app_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `app_orders`
--
ALTER TABLE `app_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `app_products`
--
ALTER TABLE `app_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `app_users`
--
ALTER TABLE `app_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `app_orders`
--
ALTER TABLE `app_orders`
  ADD CONSTRAINT `app_orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `app_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `app_orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `app_products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
