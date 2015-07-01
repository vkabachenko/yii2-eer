-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июл 01 2015 г., 20:03
-- Версия сервера: 5.5.43
-- Версия PHP: 5.4.42-1+deb.sury.org~precise+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `eer`
--

-- --------------------------------------------------------

--
-- Структура таблицы `discipline`
--

CREATE TABLE IF NOT EXISTS `discipline` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор',
  `id_program` int(11) NOT NULL COMMENT 'Ид программы',
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Шифр',
  `kind` tinyint(4) NOT NULL COMMENT 'Вид (дисциплина/практика/ГИА)',
  `block` tinyint(4) NOT NULL COMMENT 'блок (базовый/вариативный/ДПВ)',
  PRIMARY KEY (`id`),
  KEY `id_program` (`id_program`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Изучаемые модули' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `discipline_file`
--

CREATE TABLE IF NOT EXISTS `discipline_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор',
  `id_discipline_name` int(11) NOT NULL COMMENT 'Ид дисциплины',
  `id_file` int(11) NOT NULL COMMENT 'Ид файла',
  PRIMARY KEY (`id`),
  KEY `id_file` (`id_file`),
  KEY `id_discipline_name` (`id_discipline_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Файлы дисциплин (М:М)' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `discipline_name`
--

CREATE TABLE IF NOT EXISTS `discipline_name` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор',
  `id_discipline` int(11) NOT NULL COMMENT 'Ид дисциплины',
  `suffix` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Дополнение к шифру дисциплины',
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Наименование дисциплины',
  PRIMARY KEY (`id`),
  KEY `id_discipline` (`id_discipline`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Наименование дисциплины (м.б. несколько для ДПВ)' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `discipline_semester`
--

CREATE TABLE IF NOT EXISTS `discipline_semester` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор',
  `id_discipline` int(11) NOT NULL COMMENT 'Ид дисциплины',
  `course` tinyint(4) NOT NULL COMMENT 'Курс',
  `semester` tinyint(4) NOT NULL COMMENT 'Семестр',
  `max_rating` int(11) DEFAULT NULL COMMENT 'Макс. рейтинг дисциплины в семестре',
  PRIMARY KEY (`id`),
  KEY `id_discipline` (`id_discipline`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Семестры изучаемой дисциплины' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `faculty`
--

CREATE TABLE IF NOT EXISTS `faculty` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Первичный ключ',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Наименование',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Факультет или иное структурное подразделение' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор',
  `title` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Название для пользователя',
  `document` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Название файла реальное',
  `filename` char(13) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Уникальное имя файла в системе',
  `role` tinyint(4) DEFAULT NULL COMMENT 'Ограничение доступа к файлу',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Хранимые файлы' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `program`
--

CREATE TABLE IF NOT EXISTS `program` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор',
  `id_faculty` int(11) NOT NULL COMMENT 'Ид факультета',
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Шифр',
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Направление',
  `level` tinyint(4) NOT NULL COMMENT 'Уровень (бакалавриат, etc)',
  `form` tinyint(4) DEFAULT NULL COMMENT 'Форма обучения (очное, etc)',
  `profile` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'профиль образования',
  `standard` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Стандарт, по кот ведется обучение',
  `comment` text COLLATE utf8_unicode_ci COMMENT 'прочая информация',
  PRIMARY KEY (`id`),
  KEY `id_faculty` (`id_faculty`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Образовательная программа' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `program_file`
--

CREATE TABLE IF NOT EXISTS `program_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор',
  `id_program` int(11) NOT NULL COMMENT 'Ид программы',
  `id_file` int(11) NOT NULL COMMENT 'Ид файла',
  PRIMARY KEY (`id`),
  KEY `id_program` (`id_program`),
  KEY `id_file` (`id_file`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Файлы образовательной программы (М:М)' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Фамилия имя отчество',
  `email` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'email',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Студент (физлицо)' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `student_education`
--

CREATE TABLE IF NOT EXISTS `student_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор',
  `id_student` int(11) NOT NULL COMMENT 'Ид студента',
  `year` int(11) NOT NULL COMMENT 'Год обучения',
  `id_faculty` int(11) NOT NULL COMMENT 'Ид факультета',
  `id_program` int(11) NOT NULL COMMENT 'Ид образовательной программы',
  `course` tinyint(4) NOT NULL COMMENT 'Курс',
  `group` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Группа',
  PRIMARY KEY (`id`),
  KEY `id_student` (`id_student`),
  KEY `id_faculty` (`id_faculty`),
  KEY `id_program` (`id_program`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Годы обучения студента' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `student_portfolio`
--

CREATE TABLE IF NOT EXISTS `student_portfolio` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique tree node identifier',
  `root` int(11) DEFAULT NULL COMMENT 'Tree root identifier',
  `lft` int(11) NOT NULL COMMENT 'Nested set left property',
  `rgt` int(11) NOT NULL COMMENT 'Nested set right property',
  `lvl` smallint(5) NOT NULL COMMENT 'Nested set level / depth',
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The tree node name / label',
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'The icon to use for the node',
  `icon_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Icon Type: 1 = CSS Class, 2 = Raw Markup',
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Whether the node is active (will be set to false on deletion)',
  `selected` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Whether the node is selected/checked by default',
  `disabled` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Whether the node is enabled',
  `readonly` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Whether the node is read only (unlike disabled - will allow toolbar actions)',
  `visible` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Whether the node is visible',
  `collapsed` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Whether the node is collapsed by default',
  `movable_u` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Whether the node is movable one position up',
  `movable_d` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Whether the node is movable one position down',
  `movable_l` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Whether the node is movable to the left (from sibling to parent)',
  `movable_r` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Whether the node is movable to the right (from sibling to child)',
  `removable` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Whether the node is removable (any children below will be moved as siblings before deletion)',
  `removable_all` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Whether the node is removable along with descendants',
  `id_student` int(11) NOT NULL COMMENT 'Ид студента',
  `id_file` int(11) DEFAULT NULL COMMENT 'Ид файла',
  PRIMARY KEY (`id`),
  KEY `tbl_tree_NK1` (`root`),
  KEY `tbl_tree_NK2` (`lft`),
  KEY `tbl_tree_NK3` (`rgt`),
  KEY `tbl_tree_NK4` (`lvl`),
  KEY `tbl_tree_NK5` (`active`),
  KEY `id_student` (`id_student`),
  KEY `id_file` (`id_file`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Портфолио студента' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `student_result`
--

CREATE TABLE IF NOT EXISTS `student_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор',
  `id_student_education` int(11) NOT NULL COMMENT 'Ид студент - год обучения',
  `id_discipline_semester` int(11) NOT NULL COMMENT 'Ид дисциплина - семестр',
  `passing_date` date DEFAULT NULL COMMENT 'Дата сдачи',
  `examiner` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Экзаменатор',
  `rating` int(11) DEFAULT NULL COMMENT 'Рейтинг',
  `assesment` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Оценка',
  PRIMARY KEY (`id`),
  KEY `id_student_education` (`id_student_education`),
  KEY `id_discipline_semester` (`id_discipline_semester`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Результаты изучения дисциплины' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `student_result_file`
--

CREATE TABLE IF NOT EXISTS `student_result_file` (
  `id` int(11) NOT NULL COMMENT 'Идентификатор',
  `id_student_result` int(11) NOT NULL COMMENT 'Ид студент - результат',
  `id_file` int(11) NOT NULL COMMENT 'Ид файла',
  PRIMARY KEY (`id`),
  KEY `id_student_result` (`id_student_result`),
  KEY `id_file` (`id_file`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Файлы результатов изучения дисциплины (М:М)';

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор',
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Логин',
  `email` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT 'email',
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'для подтверждения регистрации',
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'пароль',
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'для восстановления пароля',
  `id_faculty` int(11) DEFAULT NULL COMMENT 'Ид факультет',
  `role` tinyint(4) NOT NULL COMMENT 'роль пользователя',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `id_faculty` (`id_faculty`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Пользователи сайта' AUTO_INCREMENT=1 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `discipline`
--
ALTER TABLE `discipline`
  ADD CONSTRAINT `discipline_ibfk_1` FOREIGN KEY (`id_program`) REFERENCES `program` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `discipline_file`
--
ALTER TABLE `discipline_file`
  ADD CONSTRAINT `discipline_file_ibfk_3` FOREIGN KEY (`id_file`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `discipline_file_ibfk_4` FOREIGN KEY (`id_discipline_name`) REFERENCES `discipline_name` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `discipline_name`
--
ALTER TABLE `discipline_name`
  ADD CONSTRAINT `discipline_name_ibfk_1` FOREIGN KEY (`id_discipline`) REFERENCES `discipline` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `discipline_semester`
--
ALTER TABLE `discipline_semester`
  ADD CONSTRAINT `discipline_semester_ibfk_1` FOREIGN KEY (`id_discipline`) REFERENCES `discipline` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `program`
--
ALTER TABLE `program`
  ADD CONSTRAINT `program_ibfk_1` FOREIGN KEY (`id_faculty`) REFERENCES `faculty` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `program_file`
--
ALTER TABLE `program_file`
  ADD CONSTRAINT `program_file_ibfk_1` FOREIGN KEY (`id_program`) REFERENCES `program` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `program_file_ibfk_2` FOREIGN KEY (`id_file`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `student_education`
--
ALTER TABLE `student_education`
  ADD CONSTRAINT `student_education_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_education_ibfk_2` FOREIGN KEY (`id_faculty`) REFERENCES `faculty` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_education_ibfk_3` FOREIGN KEY (`id_program`) REFERENCES `program` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `student_portfolio`
--
ALTER TABLE `student_portfolio`
  ADD CONSTRAINT `student_portfolio_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_portfolio_ibfk_2` FOREIGN KEY (`id_file`) REFERENCES `file` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Ограничения внешнего ключа таблицы `student_result`
--
ALTER TABLE `student_result`
  ADD CONSTRAINT `student_result_ibfk_1` FOREIGN KEY (`id_student_education`) REFERENCES `student_education` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_result_ibfk_3` FOREIGN KEY (`id_discipline_semester`) REFERENCES `discipline_semester` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `student_result_file`
--
ALTER TABLE `student_result_file`
  ADD CONSTRAINT `student_result_file_ibfk_1` FOREIGN KEY (`id_student_result`) REFERENCES `student_result` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_result_file_ibfk_2` FOREIGN KEY (`id_file`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_faculty`) REFERENCES `faculty` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
