-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 30 2020 г., 15:04
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `hw3_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `currenci_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `accounts`
--

INSERT INTO `accounts` (`id`, `user_id`, `balance`, `currenci_id`) VALUES
(1, 1, 1100, 2),
(3, 1, 200, 1),
(4, 1, 10000, 3),
(5, 3, 200, 2),
(6, 3, 15000, 3),
(7, 4, 300, 2),
(8, 4, 10000, 1),
(9, 4, 15000, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `amounts`
--

CREATE TABLE `amounts` (
  `id` int(11) NOT NULL,
  `cashbox_id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `quantly` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `amounts`
--

INSERT INTO `amounts` (`id`, `cashbox_id`, `value`, `quantly`) VALUES
(7, 1, 20, 50),
(8, 1, 50, 50),
(9, 1, 100, 50),
(10, 3, 50, 50),
(11, 3, 100, 50),
(12, 2, 5, 50),
(13, 2, 10, 50),
(14, 2, 20, 50),
(15, 2, 50, 50),
(16, 2, 100, 50),
(17, 2, 200, 50),
(18, 2, 500, 50),
(19, 2, 1000, 20);

-- --------------------------------------------------------

--
-- Структура таблицы `cashboxes`
--

CREATE TABLE `cashboxes` (
  `id` int(11) NOT NULL,
  `city` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currenci_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cashboxes`
--

INSERT INTO `cashboxes` (`id`, `city`, `model`, `currenci_id`) VALUES
(1, 'Poltava', 'DNSeries_U', 2),
(2, 'Poltava', 'DNSeries_H', 3),
(3, 'Poltava', 'DNSeries_E', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL,
  `sign` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `currencies`
--

INSERT INTO `currencies` (`id`, `sign`, `name`) VALUES
(1, 'EUR', 'Euro'),
(2, 'USD', 'Dollar'),
(3, 'UAH', 'Hryvnia');

-- --------------------------------------------------------

--
-- Структура таблицы `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `cashbox_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `logs`
--

INSERT INTO `logs` (`id`, `date`, `cashbox_id`, `account_id`, `amount`) VALUES
(1, '2020-09-22 14:56:08', 1, 1, 20),
(2, '2020-09-23 09:20:14', 1, 1, 20),
(3, '2020-09-23 12:21:09', 1, 5, 20),
(4, '2020-09-24 06:27:29', 1, 5, 100),
(5, '2020-09-24 08:21:56', 1, 5, 20),
(6, '2020-09-24 16:42:08', 1, 7, 100),
(7, '2020-09-25 07:36:54', 2, 4, 500),
(8, '2020-09-25 09:23:19', 2, 4, 500),
(10, '2020-09-25 12:23:53', 2, 6, 500),
(11, '2020-09-27 07:24:02', 2, 6, 500),
(12, '2020-09-27 10:24:11', 2, 6, 500),
(13, '2020-09-28 10:48:20', 2, 6, 500),
(14, '2020-09-28 07:11:33', 2, 6, 100),
(15, '2020-09-29 08:45:48', 3, 3, 100),
(16, '2020-09-30 08:35:01', 3, 8, 50);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `age`) VALUES
(1, 'Joel_West', 21),
(3, 'David_Floyd', 22),
(4, 'George_Benson', 45);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`currenci_id`),
  ADD KEY `currenci_id` (`currenci_id`);

--
-- Индексы таблицы `amounts`
--
ALTER TABLE `amounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cashbox_id` (`cashbox_id`,`value`);

--
-- Индексы таблицы `cashboxes`
--
ALTER TABLE `cashboxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `currenci_id` (`currenci_id`);

--
-- Индексы таблицы `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sign` (`sign`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `cashbox_id` (`cashbox_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `amounts`
--
ALTER TABLE `amounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `cashboxes`
--
ALTER TABLE `cashboxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`currenci_id`) REFERENCES `currencies` (`id`),
  ADD CONSTRAINT `accounts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `amounts`
--
ALTER TABLE `amounts`
  ADD CONSTRAINT `amounts_ibfk_1` FOREIGN KEY (`cashbox_id`) REFERENCES `cashboxes` (`id`);

--
-- Ограничения внешнего ключа таблицы `cashboxes`
--
ALTER TABLE `cashboxes`
  ADD CONSTRAINT `cashboxes_ibfk_1` FOREIGN KEY (`currenci_id`) REFERENCES `currencies` (`id`);

--
-- Ограничения внешнего ключа таблицы `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `logs_ibfk_2` FOREIGN KEY (`cashbox_id`) REFERENCES `cashboxes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
