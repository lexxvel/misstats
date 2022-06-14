-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 14 2022 г., 09:51
-- Версия сервера: 8.0.24
-- Версия PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `misstats`
--

-- --------------------------------------------------------

--
-- Структура таблицы `causes`
--

CREATE TABLE `causes` (
  `Cause_id` int NOT NULL,
  `Cause_Name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Cause_Failcount` int DEFAULT NULL,
  `Cause_Type` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `causes`
--

INSERT INTO `causes` (`Cause_id`, `Cause_Name`, `Cause_Failcount`, `Cause_Type`, `updated_at`) VALUES
(1, 'Не все учтено при оценке', 1, NULL, '2022-06-10 20:12:28'),
(2, 'Затянута разработка', 1, NULL, '2022-06-10 20:48:03'),
(3, 'Много ошибок', 2, NULL, '2022-06-11 17:51:49'),
(101, 'Не указана', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `persons`
--

CREATE TABLE `persons` (
  `Person_id` int NOT NULL,
  `Person_Name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Person_Secname` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Person_Surname` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Person_Fullname` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Person_Email` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Person_TableId` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Person_Failcount` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `persons`
--

INSERT INTO `persons` (`Person_id`, `Person_Name`, `Person_Secname`, `Person_Surname`, `Person_Fullname`, `Person_Email`, `Person_TableId`, `Person_Failcount`, `updated_at`) VALUES
(1, 'Тестан', 'Тестовиич', 'Тестенко', 'Тестенко Тестан Тестовиич', 'test@rtmi.ru', '00011', 1, '2022-06-11 19:46:51'),
(2, 'Александр', 'Андреевич', 'Величко', 'Величко Александр Андреевич', 'aleksandr.a.velichko@rtmis.ru', NULL, 1, NULL),
(101, 'Не указан', 'Не указан', 'Не указан', 'Не указан', 'Не указан', NULL, NULL, NULL),
(102, 'Иван', 'Иванович', 'Иванов', 'Иванов Иван Иванович', 'test@test.rt', NULL, 2, '2022-06-11 17:51:52');

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `Task_id` int NOT NULL,
  `Task_Number` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Task_Plantime` float NOT NULL,
  `Task_Facttime` float DEFAULT NULL,
  `Task_Failcause` int DEFAULT NULL,
  `Task_Failperson` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`Task_id`, `Task_Number`, `Task_Plantime`, `Task_Facttime`, `Task_Failcause`, `Task_Failperson`, `updated_at`) VALUES
(1, '87900', 0.2, 1.7, 2, 102, '2022-06-10 20:48:03'),
(11, '124', 0.1, 0.2, 3, 2, '2022-06-10 20:06:22'),
(16, '22', 322, 2, 1, 101, '2022-06-10 20:12:28'),
(17, '1', 1, 2.5, 3, 102, '2022-06-10 20:15:24'),
(28, '121212', 0.2, NULL, 101, 1, '2022-06-11 19:46:51'),
(29, '12123', 1, 4, 101, 101, '2022-06-12 15:00:45'),
(30, '12343', 1, 3, 101, 101, '2022-06-12 15:02:49'),
(31, '23232', 1, 3, 101, 101, '2022-06-12 15:18:13'),
(32, '777', 7, 77, 101, 101, '2022-06-12 15:48:36');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `User_Name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `User_Email` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `User_Password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `User_Role_id` int NOT NULL,
  `api_token` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `User_Name`, `User_Email`, `User_Password`, `User_Role_id`, `api_token`, `updated_at`) VALUES
(1, 'admin', 'admin@admin', 'm09v3q3M8V53M4*$$%352@#$fer', 10, 'wIiV205ER907VfE6NZrkkB0SNs7eMYvhDaFAII06cPMCJKMpGGXNF9Luexvm', '2022-06-13 09:07:09'),
(2, 'Team Стационар', 'aleksandr.a.velichko@rtmis.ru', '@TeamStac2022RTMIS', 1, '', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `causes`
--
ALTER TABLE `causes`
  ADD PRIMARY KEY (`Cause_id`);

--
-- Индексы таблицы `persons`
--
ALTER TABLE `persons`
  ADD PRIMARY KEY (`Person_id`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`Task_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `causes`
--
ALTER TABLE `causes`
  MODIFY `Cause_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT для таблицы `persons`
--
ALTER TABLE `persons`
  MODIFY `Person_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `Task_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
