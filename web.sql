-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 26 2025 г., 15:40
-- Версия сервера: 5.7.33-log
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `deti`
--

-- --------------------------------------------------------

--
-- Структура таблицы `children`
--

CREATE TABLE `children` (
  `ID_child` int(11) NOT NULL,
  `Full_Name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Birth_Date` date DEFAULT NULL,
  `Address` text COLLATE utf8mb4_unicode_ci,
  `ID_group` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `children`
--

INSERT INTO `children` (`ID_child`, `Full_Name`, `Birth_Date`, `Address`, `ID_group`) VALUES
(1, 'Анна Кузнецова', '2018-05-12', 'ул. Ленина, 12', 1),
(2, 'Дмитрий Орлов', '2017-09-08', 'ул. Пушкина, 20', 2),
(3, 'София Иванова', '2018-07-22', 'ул. Гоголя, 30', 3),
(4, 'Максим Сидоров', '2017-11-15', 'ул. Чехова, 5', 4),
(5, 'Екатерина Павлова', '2018-03-10', 'ул. Толстого, 9', 5),
(7, 'Алексей', '2025-02-26', 'ава', 1),
(8, 'Алексей', '2025-02-26', 'ава', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `events`
--

CREATE TABLE `events` (
  `ID_event` int(11) NOT NULL,
  `Event_Name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Event_Date` date DEFAULT NULL,
  `ID_group` int(11) DEFAULT NULL,
  `ID_organizer` int(11) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `events`
--

INSERT INTO `events` (`ID_event`, `Event_Name`, `Event_Date`, `ID_group`, `ID_organizer`, `image`, `price`) VALUES
(1, 'Новый год', '2024-12-10', 1, 1, '	new_year.jpg', '1000.00'),
(2, 'День знаний', '2024-09-01', 2, 2, 'day.jpg', '1500.00'),
(3, 'Масленица', '2024-03-10', 3, 3, 'mas.jpg', '1200.00'),
(4, 'День защиты детей', '2024-06-01', 4, 4, 'ben.jpg', '1800.00'),
(5, 'Осенний бал', '2024-10-15', 5, 5, 'images.jpg', '2000.00');

-- --------------------------------------------------------

--
-- Структура таблицы `event_comments`
--

CREATE TABLE `event_comments` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `event_comments`
--

INSERT INTO `event_comments` (`id`, `event_id`, `user_id`, `comment`, `created_at`) VALUES
(1, 1, 21, 'Плохо', '2025-04-08 00:13:19'),
(2, 1, 32, 'Все отлично ', '2025-04-09 20:38:04');

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `ID_group` int(11) NOT NULL,
  `ID_kindergarten` int(11) DEFAULT NULL,
  `Children_count` int(11) DEFAULT NULL,
  `Teachers_count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`ID_group`, `ID_kindergarten`, `Children_count`, `Teachers_count`) VALUES
(1, 1, 20, 2),
(2, 2, 18, 2),
(3, 3, 22, 3),
(4, 4, 25, 3),
(5, 5, 19, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `group_organizer`
--

CREATE TABLE `group_organizer` (
  `ID_group` int(11) NOT NULL,
  `ID_organizer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `guestbook`
--

CREATE TABLE `guestbook` (
  `message_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `message_date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `kindergartens`
--

CREATE TABLE `kindergartens` (
  `ID_kindergarten` int(11) NOT NULL,
  `Address` text COLLATE utf8mb4_unicode_ci,
  `Name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `kindergartens`
--

INSERT INTO `kindergartens` (`ID_kindergarten`, `Address`, `Name`) VALUES
(1, 'ул. Ленина, 10', 'Солнышко'),
(2, 'ул. Пушкина, 15', 'Радуга'),
(3, 'ул. Гоголя, 7', 'Теремок'),
(4, 'ул. Чехова, 21', 'Звёздочка'),
(5, 'ул. Толстого, 5', 'Ладушки');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'В процессе'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_price`, `status`) VALUES
(2, 22, '2025-04-07 18:47:42', '1.00', 'Ожидает подтверждения'),
(3, 22, '2025-04-07 19:03:22', '1.00', 'Ожидает подтверждения'),
(5, 21, '2025-04-08 01:39:35', '2800.00', 'В процессе'),
(8, 21, '2025-04-08 01:45:48', '2000.00', 'Ожидает подтверждения'),
(11, 31, '2025-04-09 20:22:13', '1000.00', 'Ожидает подтверждения'),
(12, 32, '2025-04-09 20:39:34', '3000.00', 'Ожидает подтверждения');

-- --------------------------------------------------------

--
-- Структура таблицы `order_events`
--

CREATE TABLE `order_events` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `order_events`
--

INSERT INTO `order_events` (`id`, `order_id`, `event_id`) VALUES
(2, 5, 1),
(3, 5, 4),
(4, 8, 5),
(8, 11, 1),
(9, 12, 1),
(10, 12, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `organizers`
--

CREATE TABLE `organizers` (
  `ID_organizer` int(11) NOT NULL,
  `Full_Name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `organizers`
--

INSERT INTO `organizers` (`ID_organizer`, `Full_Name`, `Phone`) VALUES
(1, 'Организатор 1', '89990001111'),
(2, 'Организатор 2', '89990002222'),
(3, 'Организатор 3', '89990003333'),
(4, 'Организатор 4', '89990004444'),
(5, 'Организатор 5', '89990005555'),
(6, 'rer', '56'),
(7, 'Алексей', '+7 (919) 858-90-07');

-- --------------------------------------------------------

--
-- Структура таблицы `parents`
--

CREATE TABLE `parents` (
  `ID_parent` int(11) NOT NULL,
  `Full_Name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Address` text COLLATE utf8mb4_unicode_ci,
  `Phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ID_child` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `parents`
--

INSERT INTO `parents` (`ID_parent`, `Full_Name`, `Address`, `Phone`, `ID_child`) VALUES
(1, 'Сергей Кузнецов', 'ул. Ленина, 12', '89031234567', 1),
(2, 'Елена Орлова', 'ул. Пушкина, 20', '89035678901', 2),
(3, 'Александр Иванов', 'ул. Гоголя, 30', '89039876543', 3),
(4, 'Оксана Сидорова', 'ул. Чехова, 5', '89036789012', 4),
(5, 'Николай Павлов', 'ул. Толстого, 9', '89037894561', 5),
(6, 'rer', 'tt4', 't4', 4),
(7, 'rer', 'tt4', 't4', 4),
(9, 'gfg', 'gfgf', 'gfg', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `teachers`
--

CREATE TABLE `teachers` (
  `ID_teacher` int(11) NOT NULL,
  `Full_Name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ID_group` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `teachers`
--

INSERT INTO `teachers` (`ID_teacher`, `Full_Name`, `ID_group`) VALUES
(1, 'Иван Иванов', 1),
(2, 'Петр Петров', 2),
(3, 'Мария Смирнова', 3),
(4, 'Ольга Сидорова', 4),
(5, 'Алексей Павлов', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `teacher_event_child`
--

CREATE TABLE `teacher_event_child` (
  `ID_teacher` int(11) NOT NULL,
  `ID_event` int(11) NOT NULL,
  `ID_child` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `teacher_event_child`
--

INSERT INTO `teacher_event_child` (`ID_teacher`, `ID_event`, `ID_child`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `ID_user` int(11) NOT NULL,
  `login` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reg_date` date NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`ID_user`, `login`, `password`, `email`, `reg_date`, `photo`) VALUES
(1, 'testuser', '$2y$10$examplehashedpassword', 'test@example.com', '2025-04-06', NULL),
(6, 'alex', '$2y$10$78aMv7O/tGeLu6pE6CSsv.ZZLzXCORvpSblCo0kTBX43O5/GR2hC.', 'alex200309@mail.ru', '2025-04-06', NULL),
(17, 'max', '$2y$10$Zc.B2HxBA0XrO6dK1xLwwuMk2Bd1FTY/G3sTkeFtBK1CWyq5tTmBq', 'alex200309@mail.ru', '2025-04-07', '1743976432_1743975772_holiday1.jpg'),
(21, 'Oxxxymiron', '$2y$10$AJJhFzBEfbKxEV2tpKL4iu0f7Xp3XumLPp0Dge09usphqznM9mH0q', 'alex200309@mail.com', '2025-04-07', '680cade90a5fb_Акаши.jpg'),
(22, 'max321', '$2y$10$26vecSqJ2.czNSny52OncOLFSHEnIpaMo2PggpJrieUEi2eHxHa16', 'alex200309@mail.c', '2025-04-07', ''),
(23, 'max333', '$2y$10$GV0fFS9hVVZJlFYwgeFjOuwhSbM.UsoAGA1UVnIpDJGKMmsBLSa6q', 'alex200309@mail.com3', '2025-04-07', ''),
(24, 'read', '$2y$10$calxwsLEKzpU77K1jizM5ev13Ig8b2QFzahanQItUal3NubML.mHO', '111@mail.tu', '2025-04-07', ''),
(25, 'alex2222', '$2y$10$1bIxzXpkN1z3rTFrOyRWkOpYvL5QJ4FABX679pGWh2jNyuDP/cxnq', '2222@mail.ru', '2025-04-07', ''),
(26, '2222', '$2y$10$vm9GynF5HiuiEXvrB2MLr.QH2KiFRP3NEx5e3U0UdPBDGer6fIhYq', 'alex200309@mail.yet', '2025-04-07', ''),
(27, 'alex2003', '$2y$10$FjZGGXOhIsmUy5LI0SwE/eeJEAupXw70UP5RhA7UDw2fCsvf6Q.pu', 'alex200309@mail.rudw', '2025-04-09', 'uploads/WIN_20250110_13_24_11_Pro.jpg'),
(28, 'Oxxxymiron12', '$2y$10$ixY8hhFzluG3oUj1jMaGmeAgExYEEZbgg03N1.OLA3cScaS8uZsd.', 'alex200309@mail.ru23', '2025-04-09', 'uploads/WIN_20250110_13_24_11_Pro.jpg'),
(29, 'Oxxxymiron1', '$2y$10$G0rIazA4WbtP89tvfoRqUe6eNM9laT8EA4LBUCn5gcl55hQ6svM3i', 'alex20030911@mail.com', '2025-04-09', 'uploads/WIN_20250110_13_24_11_Pro.jpg'),
(30, 'max322', '$2y$10$OQuEyMxec/xzzF6mRW7UnedKVB72.oTiE5cfUVL.v.EXWKjd4UbPK', 'kursto64@gmail.com11', '2025-04-09', 'uploads/Reper-Oxxxymiron-64c8f4090f6cf.jpg'),
(31, 'Oxxxymiron111', '$2y$10$AlHI9kobPRw1OouCsfui7OhldhZ82ibtohOWkas.wn8ujaqXKlvT2', 'alex200309@mail.ru11', '2025-04-09', 'avatar_67f6aca3e49a80.97605601.jpg'),
(32, 'Aleksey', '$2y$10$S.byoFl6QQP8O1nYJJeTFOBxfFk9i5qNL0SxMrugPOADcxGvUzqc6', 'alex2003@mail.ru', '2025-04-09', 'avatar_67f6afa5db06b7.67959652.jpg');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `children`
--
ALTER TABLE `children`
  ADD PRIMARY KEY (`ID_child`),
  ADD KEY `ID_group` (`ID_group`);

--
-- Индексы таблицы `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`ID_event`),
  ADD KEY `ID_group` (`ID_group`),
  ADD KEY `ID_organizer` (`ID_organizer`);

--
-- Индексы таблицы `event_comments`
--
ALTER TABLE `event_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`ID_group`),
  ADD KEY `ID_kindergarten` (`ID_kindergarten`);

--
-- Индексы таблицы `group_organizer`
--
ALTER TABLE `group_organizer`
  ADD PRIMARY KEY (`ID_group`,`ID_organizer`),
  ADD KEY `ID_organizer` (`ID_organizer`);

--
-- Индексы таблицы `guestbook`
--
ALTER TABLE `guestbook`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `kindergartens`
--
ALTER TABLE `kindergartens`
  ADD PRIMARY KEY (`ID_kindergarten`),
  ADD UNIQUE KEY `Name` (`ID_kindergarten`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `order_events`
--
ALTER TABLE `order_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Индексы таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Индексы таблицы `organizers`
--
ALTER TABLE `organizers`
  ADD PRIMARY KEY (`ID_organizer`);

--
-- Индексы таблицы `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`ID_parent`),
  ADD KEY `ID_child` (`ID_child`);

--
-- Индексы таблицы `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`ID_teacher`),
  ADD KEY `ID_group` (`ID_group`);

--
-- Индексы таблицы `teacher_event_child`
--
ALTER TABLE `teacher_event_child`
  ADD PRIMARY KEY (`ID_teacher`,`ID_event`,`ID_child`),
  ADD KEY `ID_event` (`ID_event`),
  ADD KEY `ID_child` (`ID_child`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID_user`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `children`
--
ALTER TABLE `children`
  MODIFY `ID_child` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `events`
--
ALTER TABLE `events`
  MODIFY `ID_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `event_comments`
--
ALTER TABLE `event_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `ID_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `guestbook`
--
ALTER TABLE `guestbook`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `kindergartens`
--
ALTER TABLE `kindergartens`
  MODIFY `ID_kindergarten` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `order_events`
--
ALTER TABLE `order_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `organizers`
--
ALTER TABLE `organizers`
  MODIFY `ID_organizer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `parents`
--
ALTER TABLE `parents`
  MODIFY `ID_parent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `teachers`
--
ALTER TABLE `teachers`
  MODIFY `ID_teacher` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `ID_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `children`
--
ALTER TABLE `children`
  ADD CONSTRAINT `children_ibfk_1` FOREIGN KEY (`ID_group`) REFERENCES `groups` (`ID_group`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`ID_group`) REFERENCES `groups` (`ID_group`) ON DELETE SET NULL,
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`ID_organizer`) REFERENCES `organizers` (`ID_organizer`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `event_comments`
--
ALTER TABLE `event_comments`
  ADD CONSTRAINT `event_comments_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`ID_event`),
  ADD CONSTRAINT `event_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID_user`);

--
-- Ограничения внешнего ключа таблицы `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`ID_kindergarten`) REFERENCES `kindergartens` (`ID_kindergarten`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `group_organizer`
--
ALTER TABLE `group_organizer`
  ADD CONSTRAINT `group_organizer_ibfk_1` FOREIGN KEY (`ID_group`) REFERENCES `groups` (`ID_group`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `group_organizer_ibfk_2` FOREIGN KEY (`ID_organizer`) REFERENCES `organizers` (`ID_organizer`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `guestbook`
--
ALTER TABLE `guestbook`
  ADD CONSTRAINT `guestbook_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID_user`);

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID_user`);

--
-- Ограничения внешнего ключа таблицы `order_events`
--
ALTER TABLE `order_events`
  ADD CONSTRAINT `order_events_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_events_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`ID_event`);

--
-- Ограничения внешнего ключа таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`ID_event`);

--
-- Ограничения внешнего ключа таблицы `parents`
--
ALTER TABLE `parents`
  ADD CONSTRAINT `parents_ibfk_1` FOREIGN KEY (`ID_child`) REFERENCES `children` (`ID_child`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`ID_group`) REFERENCES `groups` (`ID_group`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `teacher_event_child`
--
ALTER TABLE `teacher_event_child`
  ADD CONSTRAINT `teacher_event_child_ibfk_1` FOREIGN KEY (`ID_teacher`) REFERENCES `teachers` (`ID_teacher`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_event_child_ibfk_2` FOREIGN KEY (`ID_event`) REFERENCES `events` (`ID_event`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_event_child_ibfk_3` FOREIGN KEY (`ID_child`) REFERENCES `children` (`ID_child`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
