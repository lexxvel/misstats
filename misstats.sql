-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Июн 15 2022 г., 20:01
-- Версия сервера: 8.0.26
-- Версия PHP: 8.0.10

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
  `Cause_Name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Cause_Failcount` int DEFAULT NULL,
  `Cause_Type` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `causes`
--

INSERT INTO `causes` (`Cause_id`, `Cause_Name`, `Cause_Failcount`, `Cause_Type`, `updated_at`) VALUES
(1, 'Не все учтено при оценке', 1, NULL, '2022-06-10 20:12:28'),
(2, 'Затянута разработка', 6, NULL, '2022-06-15 19:46:48'),
(3, 'Много ошибок', 3, NULL, '2022-06-15 19:32:13'),
(101, 'Не указана', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `persons`
--

CREATE TABLE `persons` (
  `Person_id` int NOT NULL,
  `Person_Name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Person_Secname` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Person_Surname` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Person_Fullname` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Person_Email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Person_TableId` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Person_Failcount` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `persons`
--

INSERT INTO `persons` (`Person_id`, `Person_Name`, `Person_Secname`, `Person_Surname`, `Person_Fullname`, `Person_Email`, `Person_TableId`, `Person_Failcount`, `updated_at`) VALUES
(1, 'Тестан', 'Тестовиич', 'Тестенко', 'Тестенко Тестан Тестовиич', 'test@rtmi.ru', '00011', 3, '2022-06-15 19:46:48'),
(2, 'Александр', 'Андреевич', 'Величко', 'Величко Александр Андреевич', 'aleksandr.a.velichko@rtmis.ru', NULL, 1, NULL),
(101, 'Не указан', 'Не указан', 'Не указан', 'Не указан', 'Не указан', NULL, NULL, NULL),
(102, 'Иван', 'Иванович', 'Иванов', 'Иванов Иван Иванович', 'test@test.rt', NULL, 2, '2022-06-11 17:51:52');

-- --------------------------------------------------------

--
-- Структура таблицы `sprints`
--

CREATE TABLE `sprints` (
  `Sprint_id` int NOT NULL,
  `Sprint_Name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Sprint_UserId` int NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sprints`
--

INSERT INTO `sprints` (`Sprint_id`, `Sprint_Name`, `Sprint_UserId`, `updated_at`) VALUES
(1, 'Team Стационар - Спринт 22-12', 2, '2022-06-14 17:47:29'),
(2, 'Team Поликлиника - Спринт 22-12', 1, NULL),
(3, 'Team Стационар - Спринт 22-11', 2, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `sprintscauseslink`
--

CREATE TABLE `sprintscauseslink` (
  `Sprintscauseslink_id` int NOT NULL,
  `Sprint_id` int DEFAULT NULL,
  `User_id` int DEFAULT NULL,
  `Cause_id` int NOT NULL,
  `Cause_Failcount` int NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `sprintscauseslink`
--

INSERT INTO `sprintscauseslink` (`Sprintscauseslink_id`, `Sprint_id`, `User_id`, `Cause_id`, `Cause_Failcount`, `updated_at`) VALUES
(1, 1, 2, 1, 1, NULL),
(2, 1, 2, 2, 3, '2022-06-15 19:30:24'),
(3, 1, NULL, 3, 1, NULL),
(4, 2, NULL, 2, 3, '2022-06-15 19:46:48');

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `Task_id` int NOT NULL,
  `Task_Number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Task_Plantime` float NOT NULL,
  `Task_Facttime` float DEFAULT NULL,
  `Task_Failcause` int DEFAULT NULL,
  `Task_Failperson` int DEFAULT NULL,
  `Task_SprintId` int NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`Task_id`, `Task_Number`, `Task_Plantime`, `Task_Facttime`, `Task_Failcause`, `Task_Failperson`, `Task_SprintId`, `updated_at`) VALUES
(1, '87900', 0.2, 1.7, 2, 102, 1, '2022-06-10 20:48:03'),
(11, '124', 0.1, 0.2, 3, 2, 2, '2022-06-10 20:06:22'),
(16, '22', 322, 2, 1, 101, 3, '2022-06-10 20:12:28'),
(17, '1', 1, 2.5, 3, 102, 1, '2022-06-10 20:15:24'),
(28, '121212', 0.2, NULL, 101, 1, 2, '2022-06-11 19:46:51'),
(33, '7676', 1, NULL, 2, 101, 1, '2022-06-15 19:30:24'),
(34, '9999', 1, NULL, 3, 101, 1, '2022-06-15 19:32:13'),
(35, '8989', 1, NULL, 101, 101, 2, NULL),
(36, '5444', 1, NULL, 2, 101, 2, '2022-06-15 19:38:21'),
(37, '423', 1, 2, 2, 1, 2, '2022-06-15 19:39:08'),
(38, '6565654', 1, NULL, 2, 1, 2, '2022-06-15 19:46:48');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `User_Name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `User_Email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `User_Password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `User_Role_id` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `User_Name`, `User_Email`, `User_Password`, `User_Role_id`, `api_token`, `updated_at`) VALUES
(1, 'admin', 'admin@admin', 'm09v3q3M8V53M4*$$%352@#$fer', '10', 'cYSk1q7LmdxGGDgTVXy54wWwyhAAja1q7tQkNWeWghEbSTVx5ozNcJE4q41X', '2022-06-15 19:53:29'),
(2, 'Team Стационар', 'aleksandr.a.velichko@rtmis.ru', '@TeamStac2022RTMIS', '1', 'IqTQENDKCpFzdkJPy6zJhJCZtt5GYAxYVidhagcJaySlZ2b3tLWtkhvqKMMi', '2022-06-15 19:48:12');

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
-- Индексы таблицы `sprints`
--
ALTER TABLE `sprints`
  ADD PRIMARY KEY (`Sprint_id`);

--
-- Индексы таблицы `sprintscauseslink`
--
ALTER TABLE `sprintscauseslink`
  ADD PRIMARY KEY (`Sprintscauseslink_id`);

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
-- AUTO_INCREMENT для таблицы `sprints`
--
ALTER TABLE `sprints`
  MODIFY `Sprint_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `sprintscauseslink`
--
ALTER TABLE `sprintscauseslink`
  MODIFY `Sprintscauseslink_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `Task_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
