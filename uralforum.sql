-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: mysql
-- Время создания: Окт 02 2023 г., 20:27
-- Версия сервера: 5.7.42
-- Версия PHP: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `uralforum`
--

-- --------------------------------------------------------

--
-- Структура таблицы `authors`
--

CREATE TABLE `authors` (
  `id` int(11) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `date_register` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `authors`
--

INSERT INTO `authors` (`id`, `author_name`, `date_register`) VALUES
(1, 'иван', '2023-09-24'),
(2, 'петр', '2023-09-11'),
(20, 'qwerty', '2023-09-30'),
(21, 'герман', '2023-10-01'),
(22, 'глеб', '2023-10-01'),
(23, 'влад', '2023-10-01'),
(24, 'аркадий', '2023-10-01'),
(25, 'игорь', '2023-10-01'),
(26, 'иван', '2023-10-02');

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `author_id` int(11) NOT NULL,
  `date_create_post` datetime NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `text`, `author_id`, `date_create_post`, `category_id`) VALUES
(2, 'продаются детали для машин', 1, '2023-09-20 00:00:00', 10),
(3, 'расписание на год обучения', 2, '2023-09-24 10:00:00', 11),
(4, 'привет! каким спортом занимаетесь?', 2, '2023-09-25 00:00:00', 13),
(5, 'спорт спорт спорт', 1, '2023-09-27 00:00:00', 13),
(6, 'бла бла бла спорт', 1, '2023-09-27 00:00:00', 13),
(10, 'не согласен с вами', 20, '2023-09-30 00:00:00', 13),
(11, 'с чем именно?', 2, '2023-09-30 00:00:00', 13),
(12, 'какие именно', 20, '2023-09-30 00:00:00', 10),
(13, 'скинь  расписание на следующую неделю....', 21, '2023-10-01 09:10:00', 11),
(14, 'какая группа?', 2, '2023-10-01 09:12:00', 11),
(25, 'Э505', 21, '2023-10-02 11:48:23', 11),
(26, 'ОК....держи!!!1', 2, '2023-10-02 11:48:39', 11),
(27, 'пн-англ.яз, вт- химия, ср - физика, чт -физика, пт- математика', 2, '2023-10-02 11:49:41', 11),
(28, 'ок. спасибо!', 21, '2023-10-02 11:50:15', 11),
(29, 'А для нашей группы?', 1, '2023-10-02 11:50:34', 11),
(30, 'Какой именно...нашей?', 21, '2023-10-02 11:50:56', 11),
(31, 'ЕЕ521', 1, '2023-10-02 11:51:09', 11),
(32, 'Для ЕЕ521  нет данных', 2, '2023-10-02 11:51:59', 11),
(33, 'все вопросы к в деканат', 2, '2023-10-02 11:52:19', 11),
(34, 'ясно.....а у кого узнать можно?', 1, '2023-10-02 11:52:55', 11),
(35, 'не знаю.....в деканате!', 2, '2023-10-02 11:53:37', 11),
(36, 'всем привет!!! все узнал расписание для группы ТТ521', 1, '2023-10-02 12:40:45', 11),
(37, 'кому надо....обращайтесь', 1, '2023-10-02 12:41:12', 11),
(38, 'для запорожца', 26, '2023-10-02 14:29:00', 10),
(39, 'кто какую музыку слущает', 1, '2023-10-02 22:27:05', 43);

-- --------------------------------------------------------

--
-- Структура таблицы `post_category`
--

CREATE TABLE `post_category` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(255) NOT NULL,
  `author_cat_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `post_category`
--

INSERT INTO `post_category` (`id`, `cat_name`, `author_cat_id`) VALUES
(10, 'машины', 1),
(11, 'учеба', 1),
(12, 'хобби', 2),
(13, 'спорт', 1),
(40, 'Рыбалка', 1),
(41, 'путешествия', 22),
(42, 'кино', 22),
(43, 'музыка', 1),
(44, 'театр', 2),
(45, 'политика', 23),
(46, 'история', 23),
(47, 'видеоигры', 24),
(48, 'анекдоты', 21),
(49, 'другое', 25),
(50, 'садоводство', 24),
(51, 'самовары', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `post_category`
--
ALTER TABLE `post_category`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT для таблицы `post_category`
--
ALTER TABLE `post_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
