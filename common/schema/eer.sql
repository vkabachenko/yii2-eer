-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 19 2015 г., 19:27
-- Версия сервера: 5.5.44
-- Версия PHP: 5.4.45-1+deb.sury.org~precise+1

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Изучаемые модули' AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `discipline`
--

INSERT INTO `discipline` (`id`, `id_program`, `code`, `kind`, `block`) VALUES
(1, 4, '0071', 0, 2),
(4, 4, '004', 0, 1),
(5, 4, '005', 1, 0),
(6, 1, '006', 2, 1),
(7, 4, '008', 0, 0),
(9, 6, '001', 0, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Файлы дисциплин (М:М)' AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `discipline_file`
--

INSERT INTO `discipline_file` (`id`, `id_discipline_name`, `id_file`) VALUES
(2, 1, 11),
(4, 7, 27),
(5, 13, 28);

-- --------------------------------------------------------

--
-- Структура таблицы `discipline_name`
--

CREATE TABLE IF NOT EXISTS `discipline_name` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор',
  `id_program_main` int(11) NOT NULL COMMENT 'Ид программы (не должно быть id_program!)',
  `id_discipline` int(11) NOT NULL COMMENT 'Ид дисциплины',
  `suffix` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Дополнение к шифру дисциплины',
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Наименование дисциплины',
  PRIMARY KEY (`id`),
  KEY `id_discipline` (`id_discipline`),
  KEY `id_program_main` (`id_program_main`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Наименование дисциплины (м.б. несколько для ДПВ)' AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `discipline_name`
--

INSERT INTO `discipline_name` (`id`, `id_program_main`, `id_discipline`, `suffix`, `name`) VALUES
(1, 4, 1, '1', 'Программа 1 - 11'),
(2, 4, 1, '2', 'Программа 1-2'),
(6, 4, 1, '3', 'Программа 4'),
(7, 4, 4, '', 'Программа 5'),
(8, 4, 5, '', 'Программа 5-1'),
(9, 1, 6, '', 'Программа 6'),
(10, 4, 7, '', 'Биология растений'),
(13, 6, 9, '', 'Строительная дисциплина');

-- --------------------------------------------------------

--
-- Структура таблицы `discipline_semester`
--

CREATE TABLE IF NOT EXISTS `discipline_semester` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор',
  `id_discipline` int(11) NOT NULL COMMENT 'Ид дисциплины',
  `course` tinyint(4) NOT NULL,
  `semester` tinyint(4) NOT NULL COMMENT 'Семестр',
  `max_rating` int(11) DEFAULT NULL COMMENT 'Макс. рейтинг дисциплины в семестре',
  PRIMARY KEY (`id`),
  KEY `id_discipline` (`id_discipline`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Семестры изучаемой дисциплины' AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `discipline_semester`
--

INSERT INTO `discipline_semester` (`id`, `id_discipline`, `course`, `semester`, `max_rating`) VALUES
(1, 1, 1, 2, 100),
(2, 1, 2, 3, 200),
(6, 4, 2, 3, 200),
(7, 5, 1, 1, NULL),
(8, 7, 2, 4, NULL),
(10, 9, 1, 1, 100);

-- --------------------------------------------------------

--
-- Структура таблицы `faculty`
--

CREATE TABLE IF NOT EXISTS `faculty` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Первичный ключ',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Наименование',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Факультет или иное структурное подразделение' AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `faculty`
--

INSERT INTO `faculty` (`id`, `name`) VALUES
(1, 'Естественно-географический'),
(2, 'Инженерно-строительный'),
(3, 'Иностранных языков'),
(4, 'Информатики'),
(5, 'Исторический'),
(6, 'Медицинского образования'),
(7, 'Менеджмента'),
(8, 'Механико-машиностроительный'),
(9, 'Образовательных технологий и дизайна'),
(10, 'Психологии'),
(11, 'Физико-математический'),
(12, 'Филологический'),
(13, 'Финансово-экономический'),
(14, 'Электромеханический'),
(15, 'Юридический');

-- --------------------------------------------------------

--
-- Структура таблицы `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор',
  `title` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Название для пользователя',
  `document` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Название файла реальное',
  `filename` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Уникальное имя файла в системе',
  `free_access` tinyint(1) NOT NULL COMMENT 'Ограничение доступа к файлу',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Хранимые файлы' AUTO_INCREMENT=31 ;

--
-- Дамп данных таблицы `file`
--

INSERT INTO `file` (`id`, `title`, `document`, `filename`, `free_access`) VALUES
(11, 'yj', 'WP_20141228_009.jpg', 'HxnnCKKJkZqrZQz4Kn1uCbIPQ5NlNLgj.jpg', 0),
(12, 'WP_20141228_004.jpg', 'WP_20141228_004.jpg', 'EoQfs38WbvItDxHVPDWxzoLw_cfVwJUb.jpg', 0),
(20, 'Результат', 'WP_20141228_008.jpg', 'RKwMCo_GSJiEgBYSUfoJrQ6C_aLzE2Cu.jpg', 0),
(22, 'Пед обр файл', 'WP_20141228_008.jpg', 'kz3UcTdtwWm6yk4CO0mUGIgUYUGwruGd.jpg', 0),
(23, 'WP_20141228_009.jpg', 'WP_20141228_009.jpg', 'Yxo_O8JGF2A6dBcm78ZlP980eD6ikbS5.jpg', 0),
(24, 'evp0105.png', 'evp0105.png', '2MZqEUGwkcrTKkTXr1PjsIPF9hZ-TmAu.png', 0),
(25, 'Новый', 'WP_20141228_009.jpg', '7QIAfTRXKTsFD0fN6zpB5BepmNqb39Mq.jpg', 1),
(27, 'Файл дисциплины  Биология', 'Снимок экрана от 2015-01-21 21:44:03.png', '00oS7ZZo3yAjQN8fiF7nenmjwl-vR07-.png', 0),
(28, 'Файл строительной дисципоины', 'WP_20150108_001.jpg', '0sNo4_jCEz4PkHwpogWEwywk_H4OOPy1.jpg', 0),
(30, 'Снимок экрана от 2015-01-23 13:09:49.png', 'Снимок экрана от 2015-01-23 13:09:49.png', 'zA1LtdnfJoRbpK_YW0RVghuZCGQLJxUI.png', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Образовательная программа' AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `program`
--

INSERT INTO `program` (`id`, `id_faculty`, `code`, `name`, `level`, `form`, `profile`, `standard`, `comment`) VALUES
(1, 1, '44.03.01', 'Педагогическое образование', 0, 0, 'Химия', NULL, '4 года'),
(2, 1, '44.03.01', 'Педагогическое образование', 0, 0, 'Биология и химия', NULL, '5 лет'),
(4, 1, '06.03.01', 'Биология', 0, 0, 'Биоэкология', '', ''),
(5, 2, '02', 'ИСФ Программа 2', 0, 0, '', '', ''),
(6, 2, '01', 'ИСФ Программа 1', 0, 0, '', '', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Файлы образовательной программы (М:М)' AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `program_file`
--

INSERT INTO `program_file` (`id`, `id_program`, `id_file`) VALUES
(6, 1, 12),
(8, 2, 22),
(9, 4, 23),
(10, 4, 24),
(11, 4, 25);

-- --------------------------------------------------------

--
-- Структура таблицы `program_header`
--

CREATE TABLE IF NOT EXISTS `program_header` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор',
  `id_program` int(11) NOT NULL COMMENT 'Ид программы',
  `field_shown` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Название показываемого поля',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_program_field_shown` (`id_program`,`field_shown`),
  KEY `id_program` (`id_program`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Поля в заголовке программы в списке, кроме обязательных code и name' AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `program_header`
--

INSERT INTO `program_header` (`id`, `id_program`, `field_shown`) VALUES
(4, 1, 'profile'),
(2, 2, 'profile'),
(5, 6, 'form');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Студент (физлицо)' AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `student`
--

INSERT INTO `student` (`id`, `name`, `email`) VALUES
(1, 'Иванов И И', 'ivanov@test.com'),
(2, 'Иванова А А', 'ivanova@test.com'),
(3, 'Петрова И И', 'petrova@test.com');

-- --------------------------------------------------------

--
-- Структура таблицы `student_education`
--

CREATE TABLE IF NOT EXISTS `student_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор',
  `id_student` int(11) NOT NULL COMMENT 'Ид студента',
  `year` int(11) NOT NULL COMMENT 'Год обучения',
  `id_program` int(11) NOT NULL COMMENT 'Ид образовательной программы',
  `course` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Курс',
  `group` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Группа',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_student_year` (`id_student`,`year`),
  KEY `id_student` (`id_student`),
  KEY `id_program` (`id_program`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Годы обучения студента' AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `student_education`
--

INSERT INTO `student_education` (`id`, `id_student`, `year`, `id_program`, `course`, `group`) VALUES
(1, 1, 2015, 4, 2, '78'),
(4, 1, 2014, 4, 1, '77'),
(5, 2, 2015, 4, 1, ''),
(6, 3, 2015, 4, 2, '77'),
(8, 1, 2016, 6, 3, '33');

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
  `document` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `filename` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_tree_NK1` (`root`),
  KEY `tbl_tree_NK2` (`lft`),
  KEY `tbl_tree_NK3` (`rgt`),
  KEY `tbl_tree_NK4` (`lvl`),
  KEY `tbl_tree_NK5` (`active`),
  KEY `id_student` (`id_student`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Портфолио студента' AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `student_portfolio`
--

INSERT INTO `student_portfolio` (`id`, `root`, `lft`, `rgt`, `lvl`, `name`, `icon`, `icon_type`, `active`, `selected`, `disabled`, `readonly`, `visible`, `collapsed`, `movable_u`, `movable_d`, `movable_l`, `movable_r`, `removable`, `removable_all`, `id_student`, `document`, `filename`) VALUES
(4, 4, 1, 6, 0, 'Учеба', NULL, 1, 1, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 0, 1, 'WP_20141228_004.jpg', 'bINPW1wjRpoSlqCnAqNgcKLuUv-70OZl.jpg'),
(5, 4, 2, 3, 1, 'Биология', NULL, 1, 1, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 0, 1, 'WP_20141229_009.jpg', 'grOTlKAyvvZQ2NHrso8ppBPsklr-WjlT.jpg'),
(6, 6, 1, 8, 0, 'Учеба Петровой', NULL, 1, 1, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 0, 3, NULL, NULL),
(7, 6, 2, 7, 1, 'Биология Петровой', NULL, 1, 1, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 0, 3, NULL, NULL),
(8, 6, 3, 4, 2, 'Ботаника Петровой', NULL, 1, 1, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 0, 3, NULL, NULL),
(9, 6, 5, 6, 2, 'Анатомия Петровой', NULL, 1, 1, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 0, 3, NULL, NULL),
(10, 10, 1, 6, 0, 'Производство', NULL, 1, 1, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 0, 2, NULL, NULL),
(11, 10, 2, 3, 1, 'Производство11', NULL, 1, 1, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 0, 2, 'evp0105.png', 'xU4tiNZubXGo8kzg7FkbcQ9GaBl2JAi2.png'),
(12, 4, 4, 5, 1, 'Ботаника', NULL, 1, 1, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 0, 1, NULL, NULL),
(13, 10, 4, 5, 1, 'Производство2', NULL, 1, 1, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 0, 2, 'WP_20141226_001.jpg', 'MKrkKrhyDD5-MXVlEkpDwJMuOYd50pR-.jpg');

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
  UNIQUE KEY `id_student_discipline` (`id_student_education`,`id_discipline_semester`),
  KEY `id_student_education` (`id_student_education`),
  KEY `id_discipline_semester` (`id_discipline_semester`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Результаты изучения дисциплины' AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `student_result`
--

INSERT INTO `student_result` (`id`, `id_student_education`, `id_discipline_semester`, `passing_date`, `examiner`, `rating`, `assesment`) VALUES
(2, 1, 6, '2015-07-02', '', 200, '5'),
(3, 1, 2, NULL, '', NULL, '4'),
(5, 6, 8, NULL, '', 100, '5');

-- --------------------------------------------------------

--
-- Структура таблицы `student_result_file`
--

CREATE TABLE IF NOT EXISTS `student_result_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор',
  `id_student_result` int(11) NOT NULL COMMENT 'Ид студент - результат',
  `id_file` int(11) NOT NULL COMMENT 'Ид файла',
  PRIMARY KEY (`id`),
  KEY `id_student_result` (`id_student_result`),
  KEY `id_file` (`id_file`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Файлы результатов изучения дисциплины (М:М)' AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `student_result_file`
--

INSERT INTO `student_result_file` (`id`, `id_student_result`, `id_file`) VALUES
(2, 2, 20),
(4, 5, 30);

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
  `id_student` int(11) DEFAULT NULL,
  `role` tinyint(4) NOT NULL COMMENT 'роль пользователя',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `id_faculty` (`id_faculty`),
  KEY `id_student` (`id_student`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Пользователи сайта' AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `auth_key`, `password_hash`, `password_reset_token`, `id_faculty`, `id_student`, `role`) VALUES
(4, 'admin', 'vkabachenko@gmail.com', 'GP7UhuyVzoKUR67yKpNTHR7itImd5ZKR', '$2y$13$xphg2Dp7NRmyi7ImU3h7dORetqjiablj56zwpMDslfrIxzR8WNhfK', 'k7JaooIBu1o4Ff9a4kNiGATaMM8b_Acd_1441862736', NULL, NULL, 3),
(6, 'e1', 'e1@test.com', '47Edc5wlDU-Wn8N4WV1NCp_TXrGm0_uG', '$2y$13$1IccIp8Jzb5NNsmcCrfR9OuIUy7CdfXI3GGS6mhhDNMw1XrUZeKqG', 'ygB8RWgvBnic5g2-joZ4Vvhmo-pHabA8_1442156989', 1, NULL, 1),
(7, 'e2', 'e2@test.com', '9VcYZ4p6mpUuYP0jtvtNAy1EgvPzMZeQ', '$2y$13$DH886DaE93Shf4Om01q/j.8.VpRMmkfeltEp9.o/IOQUTKvfiEmtq', 'LjtBzlLJxWUZA095gi2oyaCBTGzSIDEk_1442081308', 1, NULL, 2),
(8, 'i2', 'i2@test.com', 'LVbOcMWHPpge3w2KObrvsW20Egwo-42B', '$2y$13$UU6RYLWR.vynkiMCR1C2/u3vkYZDSY8cTobKIYI5H5DiniChNnCOe', 'e1vAQqFxVhkzK8WQoryrWXeS1OIh3K7__1442330863', 2, NULL, 1),
(9, 'i1', 'i1@test.com', 'S-ueflHkqdFJu8461tMO49nfcBILCzbG', '$2y$13$KTBFO6VwhnFjtaodBQXeO.AHPucwJqtunaFs7.OaSogBH8A87VcBK', 'wQOUWtdvAMLTkmhPchT6LJmhf4pffbDv_1442331137', 2, NULL, 2),
(11, 'm2', 'm2@test.com', 'FEBEg3KU_E9pf_2_ZACfpsl2gdWHUsju', '$2y$13$.0PwpFAQJmAZnSqNtWPLMuH1DWWl1MmtGpHV18jIyJu8v8pHf.7pK', '4IlH1QwzSRsI74mokNNLJ7_HEHM1eWDC_1442331227', 6, NULL, 2),
(13, 'm1', 'm1@test.com', '2eGfe9CIpEzDzQX06OpdF54jYia3tqho', '$2y$13$wJ9hbgdOhrH7sX4ckQHPeuyFeTQZ5MlCWe30YTnd7.gqJzt7oh/sy', '0wwdsQf6uCe2A_3r5dPoglUg7G3EB5ok_1442331362', 6, NULL, 1),
(15, 'iv', 'ivanova@test.com', '8iXZAY3REaA0SyCab2Gdgd6YezeovXsj', '$2y$13$KWiH0ulXVotHoC7HpAMZ6OIse/L5HnY3PR/g0QcWhjq0cm/oWSGbq', 'k9Drxh1OiFjKyniqDay4mq9ICWNfyemm_1442597385', NULL, 2, 0);

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
  ADD CONSTRAINT `discipline_name_ibfk_1` FOREIGN KEY (`id_discipline`) REFERENCES `discipline` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `discipline_name_ibfk_2` FOREIGN KEY (`id_program_main`) REFERENCES `program` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Ограничения внешнего ключа таблицы `program_header`
--
ALTER TABLE `program_header`
  ADD CONSTRAINT `program_header_ibfk_1` FOREIGN KEY (`id_program`) REFERENCES `program` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `student_education`
--
ALTER TABLE `student_education`
  ADD CONSTRAINT `student_education_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_education_ibfk_3` FOREIGN KEY (`id_program`) REFERENCES `program` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `student_portfolio`
--
ALTER TABLE `student_portfolio`
  ADD CONSTRAINT `student_portfolio_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_faculty`) REFERENCES `faculty` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
