-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 08 2022 г., 17:16
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
-- База данных: `artisanvue`
--

-- --------------------------------------------------------

--
-- Структура таблицы `baskets`
--

CREATE TABLE `baskets` (
  `Basket_id` bigint UNSIGNED NOT NULL,
  `User_id` int NOT NULL,
  `Item_id` int NOT NULL,
  `Item_Count` int DEFAULT NULL,
  `Item_TC` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `Order_id` int DEFAULT NULL,
  `Basket_Status` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `baskets`
--

INSERT INTO `baskets` (`Basket_id`, `User_id`, `Item_id`, `Item_Count`, `Item_TC`, `Order_id`, `Basket_Status`, `created_at`, `updated_at`) VALUES
(45, 3, 7, 1, '47990', 27, 1, NULL, '2022-05-08 11:56:26'),
(46, 3, 1, 1, '71990', 27, 1, NULL, '2022-05-08 11:56:26');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `Category_id` bigint UNSIGNED NOT NULL,
  `Category_Name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`Category_id`, `Category_Name`, `created_at`, `updated_at`) VALUES
(1, 'Телефоны', NULL, NULL),
(2, 'Телевизоры', NULL, NULL),
(3, 'Ноутбуки', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `items`
--

CREATE TABLE `items` (
  `id` bigint UNSIGNED NOT NULL,
  `Item_Name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Item_About` varchar(1200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Item_Price` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Item_ImageLink` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `Item_Count` int DEFAULT NULL,
  `Category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `items`
--

INSERT INTO `items` (`id`, `Item_Name`, `Item_About`, `Item_Price`, `Item_ImageLink`, `Item_Count`, `Category_id`) VALUES
(1, 'iPhone 12 White 128Gb', 'Во-первых, это быстро.\r\nМощный чип. Система двух камер. Невероятно прочная передняя панель Ceramic Shield. И великолепный яркий дисплей OLED. Всё это есть в iPhone 12. В двух размерах.', '71990', 'https://cdn1.ozone.ru/s3/multimedia-u/wc1200/6025763826.jpg', 10, 1),
(2, ' Samsung Galaxy Z Fold3', 'Операционная система Android 11\r\nКоличество SIM-карт 2\r\nТип SIM-карты nano SIM\r\nТип SIM-карты 2 eSIM\r\nМодуль сотовой связи 5G, 4G (LTE), 3G, 2G\r\nПоддержка 5G да\r\nПоддержка NFC есть\r\nЭкран 7.6\"\r\nРазрешение экрана 2208х1768\r\nЯркость 900 кд/м2\r\nТип дисплея Dynamic AMOLED 2X\r\nПлотность пикселей 374 PPI\r\nТип стекла Gorilla Glass Victus\r\nБезрамочный дисплей да\r\nДиагональ дополнительного экрана 6.2\"\r\nТип экрана Super AMOLED\r\nВес 271 г', '190990', 'https://cdn1.ozone.ru/s3/multimedia-t/wc1200/6088175981.jpg', 3, 1),
(3, 'LG 50UP75006LF 50\" 4K', '50UP75006LF\r\nLG UP75 50’’ 4K Smart UHD телевизор\r\nНастоящий 4K UHD\r\nActive HDR\r\nwebOS Smart TV\r\nЧетырехъядерный процессор 4K\r\nThinQ AI\r\n\r\nНастоящий 4K UHD. Нереальное погружение.\r\n\r\nТелевизоры LG UHD превосходят все ваши ожидания. Наслаждайтесь живым изображением и реалистичной цветопередачей благодаря улучшенному разрешению за счет увеличенного количества пикселей в 4 раза по сравнению с Full HD.', '45990', 'https://cdn1.ozone.ru/s3/multimedia-x/wc1200/6241710873.jpg', 15, 2),
(6, 'iPhone 11 64Gb черный', 'Смартфон Apple iPhone 11 - ничего лишнего. Только самое. Новая система двух камер. Аккумулятор на целый день без подзарядки. Самое прочное стекло и самый быстрый процессор iPhone. Шесть отличных новых цветов. Впечатляющий ЖК‑дисплей Liquid Retina с диагональю 6,1 дюйма.2 ', '48990', 'https://cdn1.ozone.ru/s3/multimedia-k/wc1200/6026035184.jpg', 15, 1),
(7, 'HP Laptop 15s-eq2039ur', 'Тонкий ноутбук HP с экраном 15,6\", узкими рамками и длительным временем работы аккумулятора позволяет сохранять высокую продуктивность и работать с удовольствием, где бы вы ни находились.\r\n\r\n', '47990', 'https://c.dns-shop.ru/thumb/st4/fit/0/0/dcbf1ab16ae0a1877e6a81af0c80dfb9/fa9e911711db9b2789a44f87ecfb9e43500662eb00dc32a1b6d536839e4f9e6c.jpg.webp', 10, 3),
(8, '75\" Телевизор LED Samsung', '75\" (189 см) Телевизор LED Samsung QE75QN900AUXRU серый\r\nТелевизор Samsung оснащен экраном с диагональю 189 см. Модель Samsung QE75QN900AUXRU обладает экраном с разрешением 7680x4320 (8K UltraHD), поддержкой Smart TV, операционной системой Tizen, входом спутниковой антенны, объемным звучанием.\r\n\r\n', '599999', 'https://c.dns-shop.ru/thumb/st4/fit/0/0/a1a68d336f26c3c785d10245d12a00d1/72bc40249d33314337a0923921fb56ffdfbb38770369b086fe95fd62d897bdf9.jpg.webp', 2, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_02_01_061050_create_items_table', 2),
(6, '2022_02_02_123031_create_users_table', 3),
(7, '2022_02_04_082223_create_categories_table', 4),
(8, '2022_02_05_193733_create_baskets_table', 5),
(9, '2022_02_09_185910_create_orders_table', 6),
(10, '2022_02_11_233530_create_statuses_table', 7),
(11, '2022_05_06_182330_create_paytypes_table', 8);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `Order_id` int UNSIGNED NOT NULL,
  `User_id` int NOT NULL,
  `Order_DT` timestamp NOT NULL,
  `Order_TCost` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Paytype_id` bigint NOT NULL,
  `Status_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`Order_id`, `User_id`, `Order_DT`, `Order_TCost`, `Paytype_id`, `Status_id`) VALUES
(27, 3, '2022-05-08 11:56:26', '119980', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `paytypes`
--

CREATE TABLE `paytypes` (
  `Paytype_id` bigint UNSIGNED NOT NULL,
  `Paytype_Name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Paytype_Info` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Paytype_insDT` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `paytypes`
--

INSERT INTO `paytypes` (`Paytype_id`, `Paytype_Name`, `Paytype_Info`, `Paytype_insDT`) VALUES
(1, 'Наличные', 'При получении курьеру наличными полную сумму.', '2022-05-06 13:36:35'),
(2, 'По карте', 'Оплата при помощи онлайн сервисов', '2022-05-06 13:37:22');

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `statuses`
--

CREATE TABLE `statuses` (
  `Status_id` bigint UNSIGNED NOT NULL,
  `Status_Name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `statuses`
--

INSERT INTO `statuses` (`Status_id`, `Status_Name`) VALUES
(1, 'Заказ оформлен'),
(2, 'Подготовка к отправке'),
(3, 'Отправлен'),
(4, 'Получен');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `User_Name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `User_Secname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `User_Surname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `User_Email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `User_Password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `User_Role_id` int DEFAULT NULL,
  `api_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `User_Name`, `User_Secname`, `User_Surname`, `User_Email`, `User_Password`, `User_Role_id`, `api_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'admin', 'admin@admin', 'admin', 2, 'REwy3nymbNPXevKOvRHYn1aeoZwZqqOcbOfOiZfEPzmQxrB2mJmu3WYQYGKp', NULL, '2022-05-06 13:56:57'),
(2, 'alexandr', 'velichko', 'andrevich', 'lexxvel@protonmail.com', 'password', 0, NULL, NULL, NULL),
(3, 'Алекс', 'Шигин', 'Андр', 'lexxvel@admin', 'admin', 0, 'uRijjstEQRkN9K7d9PvpmJEadVLQYCGonhLUQ7nRm8V8rzRbViiCCh136adg', NULL, '2022-05-08 11:47:02'),
(4, 'александр', 'Величко', 'андреевич', 'lexxvel@xn--j1acv', 'admin', 0, NULL, NULL, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `baskets`
--
ALTER TABLE `baskets`
  ADD PRIMARY KEY (`Basket_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Category_id`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`Order_id`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `paytypes`
--
ALTER TABLE `paytypes`
  ADD PRIMARY KEY (`Paytype_id`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Индексы таблицы `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`Status_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `baskets`
--
ALTER TABLE `baskets`
  MODIFY `Basket_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `Category_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `Order_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `paytypes`
--
ALTER TABLE `paytypes`
  MODIFY `Paytype_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `statuses`
--
ALTER TABLE `statuses`
  MODIFY `Status_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
