-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 01 2020 г., 17:53
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
-- База данных: `atm`
--

-- --------------------------------------------------------

--
-- Структура таблицы `amounts`
--

CREATE TABLE `amounts` (
  `id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `quantly` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `amounts`
--

INSERT INTO `amounts` (`id`, `value`, `quantly`) VALUES
(1, 1000, 0),
(2, 500, 0),
(3, 200, 0),
(4, 100, 0),
(5, 50, 0),
(6, 20, 0),
(7, 10, 0),
(8, 5, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'anonymous',
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `amount` int(11) NOT NULL,
  `balance_before` int(11) NOT NULL,
  `balance_after` int(11) NOT NULL,
  `note` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `logs`
--

INSERT INTO `logs` (`id`, `name`, `date`, `amount`, `balance_before`, `balance_after`, `note`) VALUES
(1, 'anonymous', '2020-10-01 16:48:10', 0, 9000, 9000, 'Недостатньо коштів'),
(2, 'anonymous', '2020-10-01 16:49:17', 0, 9000, 9000, 'Невірно вказана сума (нуль неможливо видати)'),
(11, 'anonymous', '2020-10-01 17:06:07', 0, 9000, 9000, 'Невірно вказана сума (не кратна 5, неможливо видати)'),
(12, 'Ivan', '2020-10-01 17:09:39', 7735, 9000, 1265, ''),
(13, 'Petro', '2020-10-01 17:09:57', 160, 1265, 1105, ''),
(14, 'Vasyl', '2020-10-01 17:10:24', 0, 1105, 1105, 'Неможливо видати (недостатньо дрібних купюр)'),
(15, 'Mykola', '2020-10-01 17:11:17', 0, 1105, 1105, 'Недостатньо коштів'),
(16, 'anonymous', '2020-10-01 17:11:25', 1105, 1105, 0, ''),
(17, 'anonymous', '2020-10-01 17:42:19', 0, 9000, 9000, 'Недостатньо коштів'),
(18, 'Vasyl', '2020-10-01 17:42:32', 0, 9000, 9000, 'Невірно вказана сума (нуль неможливо видати)'),
(19, 'Vasyl', '2020-10-01 17:42:43', 0, 9000, 9000, 'Невірно вказана сума (не кратна 5, неможливо видати)'),
(20, 'anonymous', '2020-10-01 17:42:54', 7735, 9000, 1265, ''),
(21, 'anonymous', '2020-10-01 17:43:10', 160, 1265, 1105, ''),
(22, 'Petro', '2020-10-01 17:43:24', 0, 1105, 1105, 'Неможливо видати (недостатньо дрібних купюр)'),
(23, 'Mykola', '2020-10-01 17:43:37', 0, 1105, 1105, 'Недостатньо коштів'),
(24, 'Mykola', '2020-10-01 17:43:50', 1105, 1105, 0, '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `amounts`
--
ALTER TABLE `amounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `value` (`value`);

--
-- Индексы таблицы `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `amounts`
--
ALTER TABLE `amounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
