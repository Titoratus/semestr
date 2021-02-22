-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Июн 02 2018 г., 18:25
-- Версия сервера: 10.1.31-MariaDB
-- Версия PHP: 7.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `id3094576_semester`
--

-- --------------------------------------------------------

--
-- Структура таблицы `diploma`
--

CREATE TABLE `diploma` (
  `id` int(11) NOT NULL,
  `d_mark` tinyint(1) NOT NULL,
  `d_student` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `diploma`
--

INSERT INTO `diploma` (`id`, `d_mark`, `d_student`) VALUES
(3, 5, 31);

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `g_name` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `g_curator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`g_name`, `g_curator`) VALUES
('532', 1),
('142', 6);

-- --------------------------------------------------------

--
-- Структура таблицы `marks`
--

CREATE TABLE `marks` (
  `sub_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `s1` int(1) NOT NULL,
  `s2` int(1) NOT NULL,
  `s3` int(1) NOT NULL,
  `s4` int(1) NOT NULL,
  `s5` int(1) NOT NULL,
  `s6` int(1) NOT NULL,
  `s7` int(1) NOT NULL,
  `s8` int(1) NOT NULL,
  `diploma` int(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `marks`
--

INSERT INTO `marks` (`sub_id`, `s_id`, `s1`, `s2`, `s3`, `s4`, `s5`, `s6`, `s7`, `s8`, `diploma`) VALUES
(25, 9, 4, 5, 4, 0, 4, 0, 0, 0, 5),
(16, 9, 0, 0, 5, 0, 0, 0, 0, 0, 0),
(25, 31, 0, 0, 3, 0, 0, 0, 0, 0, 0),
(30, 31, 0, 0, 0, 5, 0, 0, 0, 0, 0),
(25, 23, 0, 0, 0, 5, 0, 0, 0, 0, 0),
(32, 9, 0, 3, 0, 0, 0, 0, 0, 0, 0),
(33, 9, 0, 0, 4, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `o_name` varchar(40) NOT NULL,
  `o_date` date NOT NULL,
  `o_student` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `o_name`, `o_date`, `o_student`) VALUES
(6, 'ляпуша', '2018-05-08', 25);

-- --------------------------------------------------------

--
-- Структура таблицы `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `s_name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_group` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade_11` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `students`
--

INSERT INTO `students` (`id`, `s_name`, `s_group`, `grade_11`) VALUES
(5, 'Нумирова Анна Петровна', '532', 1),
(8, 'Кувеев Лолич Кумеевич', '532', 1),
(9, 'Гатиолов Андрей Петрович', '532', 0),
(22, 'Рящин Гавриил Богданович', '532', 0),
(23, 'Горшкова Пелагея Георгиевна', '532', 1),
(24, 'Качурина Ираида Давидовна', '532', 0),
(25, 'Ляпушкин Феофан Еремеевич', '532', 1),
(26, 'Ягренев Марк Агапович', '532', 1),
(27, 'Смирновский Агафон Кириллович', '532', 1),
(29, 'Макаркина Евгения Виталиевна', '532', 0),
(30, 'Митрохин Валерьян Платонович', '532', 1),
(31, 'Королёва Галина Всеволодовна', '532', 0),
(32, 'Трутнев Ярослав Владимирович', '532', 1),
(50, 'Коновалов Алексей', '532', 1),
(51, 'Локутова Мария Владимировна', '142', 0),
(52, 'Гудыма Ярослав Владимирович', '142', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `sub_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `subjects`
--

INSERT INTO `subjects` (`id`, `sub_name`) VALUES
(6, 'sdfsdf'),
(7, 'ertertert'),
(8, '55522f'),
(9, 'Леевев'),
(10, 'Новый кук'),
(11, 'гнег'),
(12, 'Коловарка'),
(13, 'Системы автоматизации устройств сложного предназначения и не'),
(14, 'fsdf'),
(15, 'Предназнчение сложных вещей в нектором смысле и тогда'),
(16, 'Математика'),
(17, 'Математика'),
(18, 'Математика'),
(19, 'кен'),
(20, 'АБак'),
(21, 'ккук'),
(22, 'баб'),
(23, 'Метрология, стандартизация, сертификация и тех. средства'),
(24, 'lolys'),
(25, 'Русский язык'),
(26, 'wer'),
(27, 'trrt'),
(28, 'Лолус'),
(29, 'Философия'),
(30, 'Основы буддийской культуры'),
(31, 'Информатика'),
(32, 'Музыка'),
(33, 'Физкультура'),
(34, 'Проектирование'),
(35, 'Изобразительное искусство'),
(36, 'Мировая художественная культура'),
(37, 'Обществознание'),
(38, 'Химия'),
(39, 'Астрономия'),
(40, 'Физика'),
(41, 'Практика'),
(42, 'Математика'),
(43, 'Математика'),
(44, 'Русский'),
(45, 'Математика'),
(46, 'Литература'),
(47, 'Биология');

-- --------------------------------------------------------

--
-- Структура таблицы `subs_curators`
--

CREATE TABLE `subs_curators` (
  `sub_id` int(11) NOT NULL,
  `cur_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `subs_curators`
--

INSERT INTO `subs_curators` (`sub_id`, `cur_id`) VALUES
(25, 1),
(23, 1),
(16, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(44, 6),
(16, 6),
(46, 6),
(47, 6);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `u_name` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `u_spec` varchar(40) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `pass`, `u_name`, `admin`, `u_spec`) VALUES
(1, 'admin', '$2y$10$lGgvDIhlJg1Cqty0kDXd4OE1.boOQAQ5YiNkYOKg6FU0V7/TD4Vsy', 'Каронтов Дмитрий Петрович', 0, ''),
(2, 'qwer', '$2y$10$KHP6jpsR7r8rbbgz.ZeX2OMdhgFc62MBYL89R/AfDjLOSWOEpQEza', 'Квадратов Иван Круглович', 1, 'Физическая культура'),
(4, 'kekus', '$2y$10$xlJwJDHwm8iFpgtvzGjYVeqc0Lm9lslFPN5gnRmeAIIFjFP7LaL7q', 'Тирагор Орн', 0, 'Дошкольное образование'),
(6, 'semenovvs', '$2y$10$9N7IDpv59DUxcvzTNQfm1eH340ZuTrDtKVlxf2RLUMkwEKEI3PyEa', 'Семенов Виталий Сергеевич ', 0, 'Прикладная информатика');

-- --------------------------------------------------------

--
-- Структура таблицы `works`
--

CREATE TABLE `works` (
  `id` int(11) NOT NULL,
  `w_name` varchar(40) NOT NULL,
  `w_mark` tinyint(1) NOT NULL,
  `w_student` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `works`
--

INSERT INTO `works` (`id`, `w_name`, `w_mark`, `w_student`) VALUES
(3, 'ываыва', 4, 23),
(5, '424', 5, 50),
(10, 'ничего ', 5, 31),
(11, 'да', 5, 8),
(13, '1', 5, 9);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `diploma`
--
ALTER TABLE `diploma`
  ADD PRIMARY KEY (`id`),
  ADD KEY `d_student` (`d_student`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`g_name`),
  ADD KEY `g_curator` (`g_curator`);

--
-- Индексы таблицы `marks`
--
ALTER TABLE `marks`
  ADD KEY `sub_id` (`sub_id`),
  ADD KEY `s_id` (`s_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `o_student` (`o_student`);

--
-- Индексы таблицы `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `s_group` (`s_group`);

--
-- Индексы таблицы `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `subs_curators`
--
ALTER TABLE `subs_curators`
  ADD KEY `cur_id` (`cur_id`),
  ADD KEY `sub_id` (`sub_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `works`
--
ALTER TABLE `works`
  ADD PRIMARY KEY (`id`),
  ADD KEY `w_student` (`w_student`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `diploma`
--
ALTER TABLE `diploma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT для таблицы `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `works`
--
ALTER TABLE `works`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `diploma`
--
ALTER TABLE `diploma`
  ADD CONSTRAINT `diploma_ibfk_1` FOREIGN KEY (`d_student`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`g_curator`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `marks`
--
ALTER TABLE `marks`
  ADD CONSTRAINT `marks_ibfk_1` FOREIGN KEY (`sub_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `marks_ibfk_2` FOREIGN KEY (`s_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`o_student`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`s_group`) REFERENCES `groups` (`g_name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `subs_curators`
--
ALTER TABLE `subs_curators`
  ADD CONSTRAINT `subs_curators_ibfk_1` FOREIGN KEY (`cur_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subs_curators_ibfk_2` FOREIGN KEY (`sub_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `works`
--
ALTER TABLE `works`
  ADD CONSTRAINT `works_ibfk_1` FOREIGN KEY (`w_student`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
