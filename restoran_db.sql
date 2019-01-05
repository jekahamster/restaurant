-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 15, 2018 at 03:04 AM
-- Server version: 5.6.41
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restoran_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `id` int(11) NOT NULL,
  `dish` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `time` time NOT NULL,
  `price` float NOT NULL,
  `products` text NOT NULL,
  `quantity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`id`, `dish`, `class`, `time`, `price`, `products`, `quantity`) VALUES
(1, 'Курка «Пікассо»', 'Basic', '00:30:00', 29.99, 'Куряча грудка, Лук, Солодкий перець, Часник, Помідори, Сир, Вода ', '4, 2, 3, 1, 3, 0.1, 0.25'),
(2, 'Курка в кисло-солодкому соусі', 'Basic', '00:10:00', 14.99, 'Куряче Філе, Соєвий соус, Яблучний оцет, Цукор, Вода, Томатна паста, Солодкий перець, Консервованій ананас, Помідори', '0.5, 0.04, 0.04, 0.05, 0.1, 0.01, 1, 1, 2'),
(3, 'Картопля «Айдахо»', 'Basic', '00:30:00', 9.99, 'Картопля, Кріп, Петрушка, Часник', '10, 1, 1, 1'),
(4, 'Куряче філе з грибами і сиром', 'Basic', '00:20:00', 14.99, 'Печериці, Куряче філе, Сметана, Майонез, Цибуля ріпчаста, Петрушка, Сир', '0.2, 0.5, 0.15, 0.15, 1, 1, 0.15'),
(5, 'Мясо по-французьки', 'Basic', '00:40:00', 19.99, 'Картопля, Цибуля ріпчаста, Свинина, Печериці, Сир, Майонез', '10, 0.8, 0.8, 0.3, 0.8, 0.25'),
(6, 'Плов з куркою', 'Basic', '00:40:00', 19.99, 'Рис, Цибуля ріпчаста, Куряче філе, Морква', '0.55, 2, 3, 5'),
(7, 'Італійський салат з шинкою', 'Salads', '00:05:00', 9.99, 'Шинка, Помідори, Солодкий перець, Макарони, Консервована курка, Сир, Майонез', '0.3, 2, 2, 0.4, 0.3, 0.2, 0.1'),
(8, 'Салат «Цезар»', 'Salads', '00:05:00', 9.99, 'Зелений салат, Помідори, Куряче філе, Вершкове масло, Часник, Сир пармезан', '1, 1, 0.3, 0.1, 2, 0.2'),
(9, 'Шаурма з куркою і майонезом', 'Fastfood', '00:10:00', 19.99, 'Вірменський лаваш, Солодкий перець, Помідори, Морква, Сир, Курка, Кетчуп, Майонез', '1, 0.05, 0.05, 0.1, 0.15, 0.1, 0.1, 0.1'),
(10, 'Coca Cola', 'Drinks', '00:00:00', 4.99, 'Coca Cola', '0.5'),
(11, 'Pepsi', 'Drinks', '00:00:00', 4.99, 'Pepsi', '0.5'),
(12, 'Dr.Pepper', 'Drinks', '00:00:00', 4.99, 'Dr.Pepper', '0.5'),
(13, 'Fanta', 'Drinks', '00:00:00', 4.99, 'Fanta', '0.5');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `driver_name` varchar(255) NOT NULL,
  `location` text NOT NULL,
  `order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `driver_id`, `driver_name`, `location`, `order_id`) VALUES
(160, 4, 'Linda Smith', '', NULL),
(165, 6, 'John Rain', '33.401092999999996, 49.0692506', 58);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_pass` varchar(255) NOT NULL,
  `ordered_dishes` text NOT NULL,
  `address` text NOT NULL,
  `summary_time` time NOT NULL,
  `delivery_time` time DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `finish_time` varchar(8) NOT NULL,
  `summary_price` float NOT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `location` text,
  `finished` varchar(5) NOT NULL DEFAULT 'False',
  `message` text NOT NULL,
  `phone` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_pass`, `ordered_dishes`, `address`, `summary_time`, `delivery_time`, `date`, `finish_time`, `summary_price`, `driver_id`, `location`, `finished`, `message`, `phone`) VALUES
(1, '332655', 'Шаурма з куркою і майонезом\r\nPepsi\r\n', 'Вулиця Маяковського, д 56, кв 7', '00:10:00', NULL, '2018-09-28 16:13:55', '', 24.98, NULL, NULL, 'True', 'Недостатньо продуктів для цього замовлення. Спробуйте пізніше.', ''),
(3, '332564', 'Шаурма з куркою і майонезом\r\nPepsi\r\n', 'Вулиця Маяковського, д 56, кв 7', '00:10:00', NULL, '2018-09-28 16:18:06', '', 24.98, NULL, NULL, 'True', 'Недостатньо продуктів для цього замовлення. Спробуйте пізніше.', ''),
(4, '12656', 'Coca Cola\r\n', 'Вулиця Маяковського, д 56, кв 7', '00:00:00', '00:11:44', '2018-09-28 19:49:26', '23:01:10', 4.99, NULL, NULL, 'False', '', ''),
(5, '65237', 'Fanta\r\n', 'Вулиця Маяковського, д 56, кв 7', '00:00:00', NULL, '2018-09-28 19:58:44', '', 4.99, NULL, NULL, 'True', 'Недостатньо продуктів для цього замовлення. Спробуйте пізніше.', ''),
(6, '5369', 'Fanta\r\n', 'Вулиця Маяковського, д 56, кв 7', '00:00:00', NULL, '2018-09-28 20:02:06', '', 4.99, NULL, NULL, 'True', 'Недостатньо продуктів для цього замовлення. Спробуйте пізніше.', ''),
(8, '129687', 'Курка «Пікассо»\r\n', 'Вул. Київська 45, кв. 12', '00:30:00', NULL, '2018-09-28 20:03:50', '', 29.99, NULL, NULL, 'True', 'Недостатньо продуктів для цього замовлення. Спробуйте пізніше.', ''),
(15, '12365', 'Pepsi\r\n', 'Вул. Київська 45, кв. 12', '00:00:00', '00:11:44', '2018-10-28 23:19:46', '01:31:30', 4.99, NULL, NULL, 'False', '', '73219585'),
(16, '123', 'Мінімалістичний плов з куркою\r\nІталійський салат з шинкою, сиром і овочами\r\n', 'Вул. Київська 45, кв. 12', '00:40:00', '00:10:00', '2018-10-30 05:53:53', '08:43:53', 29.98, NULL, '33.412029, 49.083157', 'False', 'Ваше замовлення доставляється', '066-7891011'),
(17, '123', 'Мінімалістичний плов з куркою\r\n', 'вул. Троїцька 1, кв. 45', '00:40:00', NULL, '2018-10-30 06:16:28', '', 19.99, NULL, NULL, 'False', '', '050607080'),
(18, '15254', 'Курка «Пікассо»\r\nКурка «Пікассо»\r\nКурка «Пікассо»\r\nКурка «Пікассо»\r\nКурка «Пікассо»\r\nКурка «Пікассо»\r\nКурка «Пікассо»\r\nКурка «Пікассо»\r\nКурка «Пікассо»\r\n', 'Test', '00:30:00', NULL, '2018-10-30 13:34:26', '', 269.91, NULL, NULL, 'True', 'Недостатньо продуктів для цього замовлення. Спробуйте пізніше.', '123'),
(20, '339', 'Pepsi\r\n', 'вул. Троїцька 1, кв. 45', '00:00:00', NULL, '2018-10-30 14:07:06', '', 4.99, NULL, NULL, 'False', '', 'rshrhyrh'),
(21, '566', 'Coca Cola\r\n', 'вул. Троїцька 1, кв. 45', '00:00:00', NULL, '2018-10-30 15:04:51', '', 4.99, NULL, NULL, 'False', '', 'efefeffe'),
(23, 'фів', 'Fanta\r\n', 'іфв', '00:00:00', NULL, '2018-10-30 18:54:58', '', 4.99, NULL, NULL, 'False', '', 'фів'),
(24, 'asd', 'Fanta\r\n', 'asd', '00:00:00', NULL, '2018-10-30 18:56:14', '', 4.99, NULL, NULL, 'False', '', 'asd'),
(25, '', 'Курка в кисло-солодкому соусі\r\n', 'kkk', '00:10:00', NULL, '2018-10-30 19:03:24', '', 14.99, NULL, NULL, 'False', '', 'kk'),
(26, '', 'Курка в кисло-солодкому соусі\r\n', 'fefeff', '00:10:00', NULL, '2018-10-30 19:08:18', '', 14.99, NULL, NULL, 'False', '', 'number'),
(27, '', 'Fanta\r\n', 'Test', '00:00:00', NULL, '2018-10-30 19:42:11', '', 4.99, NULL, NULL, 'True', 'Недостатньо продуктів для цього замовлення. Спробуйте пізніше.', 'Test'),
(57, '', 'Fanta\r\n', 'Yeg', '00:00:00', NULL, '2018-10-30 20:14:09', '', 4.99, NULL, NULL, 'True', 'Недостатньо продуктів для цього замовлення. Спробуйте пізніше.', 'Dhhd'),
(58, '123', 'Картопля «Айдахо»\r\n', 'Licey', '00:30:00', '00:10:00', '2018-10-30 22:50:53', '01:30:53', 9.99, 6, '33.401092999999996, 49.0692506', 'False', '', '223321'),
(59, '123', 'Pepsi\r\n', 'asd', '00:00:00', NULL, '2018-12-14 17:30:03', '', 4.99, NULL, NULL, 'False', '', 'asd'),
(60, '', 'Салат «Цезар»\r\n', 'asd', '00:05:00', NULL, '2018-12-14 23:55:28', '', 9.99, NULL, NULL, 'True', 'Недостатньо продуктів для цього замовлення. Спробуйте пізніше.', 'asd'),
(61, '', 'Coca Cola\r\n', 'asd', '00:00:00', NULL, '2018-12-14 23:56:06', '', 4.99, NULL, NULL, 'True', 'Недостатньо продуктів для цього замовлення. Спробуйте пізніше.', 'asd'),
(62, '123', 'Dr.Pepper\r\n', 'asd', '00:00:00', NULL, '2018-12-14 23:56:13', '', 4.99, NULL, NULL, 'False', '', 'asd');

-- --------------------------------------------------------

--
-- Table structure for table `order_statistics`
--

CREATE TABLE `order_statistics` (
  `id` int(11) NOT NULL,
  `dish_id` int(255) NOT NULL,
  `dish_name` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_statistics`
--

INSERT INTO `order_statistics` (`id`, `dish_id`, `dish_name`, `date`) VALUES
(26, 2, 'Курка в кисло-солодкому соусі по-китайськи', '2018-09-27 23:04:48'),
(27, 10, 'Coca Cola', '2018-09-27 23:05:20'),
(39, 9, 'Шаурма з куркою і майонезом', '2018-09-28 16:13:55'),
(42, 11, 'Pepsi', '2018-09-28 16:14:27'),
(43, 9, 'Шаурма з куркою і майонезом', '2018-09-28 16:18:06'),
(44, 11, 'Pepsi', '2018-09-28 16:18:06'),
(45, 10, 'Coca Cola', '2018-09-28 19:49:26'),
(46, 13, 'Fanta', '2018-09-28 19:58:44'),
(55, 1, 'Курка «Пікассо»', '2018-09-28 20:10:23'),
(56, 13, 'Fanta', '2018-10-22 16:40:50'),
(59, 11, 'Pepsi', '2018-10-28 23:19:46'),
(86, 10, 'Coca Cola', '2018-06-18 00:48:07'),
(93, 10, 'Coca Cola', '2018-05-29 14:20:34'),
(95, 10, 'Coca Cola', '2018-04-17 01:19:23'),
(106, 10, 'Coca Cola', '2018-06-02 07:38:26'),
(111, 10, 'Coca Cola', '2018-02-19 12:37:25'),
(116, 10, 'Coca Cola', '2018-02-01 06:03:54'),
(128, 10, 'Coca Cola', '2018-05-28 04:01:18'),
(139, 10, 'Coca Cola', '2018-04-20 05:54:49'),
(142, 10, 'Coca Cola', '2018-03-02 16:19:42'),
(171, 10, 'Coca Cola', '2018-04-24 00:04:56'),
(177, 10, 'Coca Cola', '2018-04-01 21:14:28'),
(223, 10, 'Coca Cola', '2018-06-19 18:25:33'),
(232, 10, 'Coca Cola', '2018-01-26 23:04:08'),
(242, 10, 'Coca Cola', '2018-05-17 11:49:15'),
(275, 10, 'Coca Cola', '2018-02-12 03:53:50'),
(276, 10, 'Coca Cola', '2018-06-09 07:08:00'),
(313, 10, 'Coca Cola', '2018-02-23 15:17:16'),
(334, 10, 'Coca Cola', '2018-04-04 13:05:55'),
(340, 10, 'Coca Cola', '2018-06-04 08:21:12'),
(373, 10, 'Coca Cola', '2018-02-19 04:45:46'),
(388, 10, 'Coca Cola', '2018-03-23 07:05:51'),
(398, 10, 'Coca Cola', '2018-05-10 08:59:09'),
(401, 10, 'Coca Cola', '2018-06-09 01:47:57'),
(413, 10, 'Coca Cola', '2018-04-01 20:44:40'),
(435, 10, 'Coca Cola', '2018-01-18 19:47:45'),
(493, 10, 'Coca Cola', '2018-04-13 14:16:10'),
(542, 10, 'Coca Cola', '2018-03-31 12:33:38'),
(549, 10, 'Coca Cola', '2018-02-22 07:55:53'),
(550, 10, 'Coca Cola', '2018-03-02 22:32:07'),
(558, 10, 'Coca Cola', '2018-03-26 02:39:27'),
(591, 10, 'Coca Cola', '2018-04-10 06:42:15'),
(597, 10, 'Coca Cola', '2018-03-06 13:35:40'),
(611, 10, 'Coca Cola', '2018-06-10 18:50:44'),
(614, 10, 'Coca Cola', '2018-06-20 02:47:38'),
(646, 10, 'Coca Cola', '2018-06-20 16:20:57'),
(647, 10, 'Coca Cola', '2018-04-21 10:44:18'),
(702, 10, 'Coca Cola', '2018-03-27 06:27:49'),
(744, 10, 'Coca Cola', '2018-02-14 01:56:56'),
(745, 10, 'Coca Cola', '2018-02-10 12:48:23'),
(763, 10, 'Coca Cola', '2018-06-14 03:22:39'),
(793, 10, 'Coca Cola', '2018-04-05 13:12:38'),
(816, 10, 'Coca Cola', '2018-02-04 02:06:16'),
(823, 10, 'Coca Cola', '2018-06-01 18:11:07'),
(843, 10, 'Coca Cola', '2018-03-13 20:35:38'),
(854, 10, 'Coca Cola', '2018-04-04 18:44:25'),
(861, 10, 'Coca Cola', '2018-05-19 12:51:58'),
(898, 10, 'Coca Cola', '2018-06-07 01:17:59'),
(903, 10, 'Coca Cola', '2018-02-12 12:48:50'),
(960, 10, 'Coca Cola', '2018-02-19 02:52:13'),
(967, 10, 'Coca Cola', '2018-02-18 00:20:43'),
(974, 10, 'Coca Cola', '2018-02-09 16:25:35'),
(1006, 10, 'Coca Cola', '2018-01-24 03:16:28'),
(1021, 10, 'Coca Cola', '2018-04-24 12:07:42'),
(1037, 10, 'Coca Cola', '2018-06-09 12:49:08'),
(1052, 10, 'Coca Cola', '2018-01-17 21:28:59'),
(1073, 10, 'Coca Cola', '2018-06-22 22:53:43'),
(1103, 10, 'Coca Cola', '2018-02-10 18:25:54'),
(1107, 10, 'Coca Cola', '2018-06-28 01:45:36'),
(1124, 10, 'Coca Cola', '2018-02-15 05:19:59'),
(1151, 10, 'Coca Cola', '2018-03-05 02:51:28'),
(1161, 10, 'Coca Cola', '2018-02-01 05:48:51'),
(1178, 10, 'Coca Cola', '2018-02-25 03:53:21'),
(1189, 10, 'Coca Cola', '2018-06-24 09:28:11'),
(1195, 10, 'Coca Cola', '2018-06-01 14:41:24'),
(1220, 10, 'Coca Cola', '2018-03-25 20:39:08'),
(1225, 10, 'Coca Cola', '2018-04-12 23:54:53'),
(1243, 10, 'Coca Cola', '2018-03-02 13:57:30'),
(1253, 10, 'Coca Cola', '2018-06-16 07:52:43'),
(1272, 10, 'Coca Cola', '2018-03-17 03:35:02'),
(1279, 10, 'Coca Cola', '2018-06-26 06:55:17'),
(1281, 10, 'Coca Cola', '2018-03-16 05:33:06'),
(1306, 10, 'Coca Cola', '2018-02-06 03:00:12'),
(1339, 10, 'Coca Cola', '2018-05-10 12:21:08'),
(1340, 10, 'Coca Cola', '2018-03-08 16:31:54'),
(1413, 10, 'Coca Cola', '2018-03-21 04:57:36'),
(1425, 10, 'Coca Cola', '2018-06-05 23:19:32'),
(1451, 10, 'Coca Cola', '2018-06-11 18:00:51'),
(1488, 10, 'Coca Cola', '2018-03-30 04:30:28'),
(1516, 10, 'Coca Cola', '2018-01-27 19:53:35'),
(1520, 10, 'Coca Cola', '2018-01-28 07:17:59'),
(1521, 10, 'Coca Cola', '2018-04-06 02:52:59'),
(1522, 10, 'Coca Cola', '2018-03-31 09:37:42'),
(1525, 10, 'Coca Cola', '2018-05-25 17:17:51'),
(1580, 10, 'Coca Cola', '2018-04-12 20:33:52'),
(1586, 10, 'Coca Cola', '2018-04-27 01:06:57'),
(1594, 10, 'Coca Cola', '2018-02-19 02:25:37'),
(1595, 10, 'Coca Cola', '2018-04-17 15:57:09'),
(1596, 10, 'Coca Cola', '2018-03-23 18:35:33'),
(1602, 10, 'Coca Cola', '2018-05-24 05:36:32'),
(1643, 10, 'Coca Cola', '2018-03-10 05:13:52'),
(1654, 10, 'Coca Cola', '2018-01-16 14:16:35'),
(1677, 10, 'Coca Cola', '2018-06-17 08:16:45'),
(1682, 10, 'Coca Cola', '2018-04-16 03:14:52'),
(1690, 10, 'Coca Cola', '2018-03-31 07:59:19'),
(1697, 10, 'Coca Cola', '2018-05-09 06:42:08'),
(1706, 10, 'Coca Cola', '2018-06-07 03:12:57'),
(1727, 10, 'Coca Cola', '2018-06-28 05:56:17'),
(1744, 10, 'Coca Cola', '2018-06-14 00:35:57'),
(1747, 10, 'Coca Cola', '2018-02-28 10:47:36'),
(1757, 10, 'Coca Cola', '2018-03-09 21:28:32'),
(1789, 10, 'Coca Cola', '2018-06-28 13:38:26'),
(1805, 10, 'Coca Cola', '2018-04-20 05:43:32'),
(1816, 10, 'Coca Cola', '2018-04-09 18:30:49'),
(1829, 10, 'Coca Cola', '2018-02-08 05:51:39'),
(1859, 10, 'Coca Cola', '2018-04-30 22:30:29'),
(1885, 10, 'Coca Cola', '2018-05-01 20:39:39'),
(1886, 10, 'Coca Cola', '2018-04-21 23:16:08'),
(1917, 10, 'Coca Cola', '2018-05-11 06:45:57'),
(1946, 10, 'Coca Cola', '2018-06-20 03:01:49'),
(2002, 10, 'Coca Cola', '2018-06-10 10:35:14'),
(2025, 10, 'Coca Cola', '2018-03-29 00:45:33'),
(2028, 10, 'Coca Cola', '2018-05-24 21:57:44'),
(2053, 10, 'Coca Cola', '2018-01-16 13:09:49'),
(2084, 10, 'Coca Cola', '2018-01-29 12:03:27'),
(2097, 10, 'Coca Cola', '2018-06-24 11:37:08'),
(2115, 10, 'Coca Cola', '2018-06-24 21:27:25'),
(2124, 10, 'Coca Cola', '2018-05-10 18:46:07'),
(2152, 10, 'Coca Cola', '2018-06-25 07:12:38'),
(2169, 10, 'Coca Cola', '2018-06-14 12:29:46'),
(2170, 10, 'Coca Cola', '2018-05-01 06:54:57'),
(2187, 10, 'Coca Cola', '2018-05-27 05:32:58'),
(2195, 10, 'Coca Cola', '2018-01-16 08:55:36'),
(2198, 10, 'Coca Cola', '2018-05-26 03:06:00'),
(2204, 10, 'Coca Cola', '2018-01-23 10:40:14'),
(2237, 10, 'Coca Cola', '2018-02-11 14:50:58'),
(2247, 10, 'Coca Cola', '2018-06-26 01:21:09'),
(2252, 10, 'Coca Cola', '2018-02-02 15:58:07'),
(2263, 10, 'Coca Cola', '2018-02-24 19:20:49'),
(2275, 10, 'Coca Cola', '2018-04-04 12:37:54'),
(2296, 10, 'Coca Cola', '2018-02-14 05:58:58'),
(2319, 10, 'Coca Cola', '2018-06-12 11:25:03'),
(2321, 10, 'Coca Cola', '2018-03-24 22:35:38'),
(2327, 10, 'Coca Cola', '2018-05-17 12:12:59'),
(2328, 10, 'Coca Cola', '2018-03-19 01:29:44'),
(2336, 10, 'Coca Cola', '2018-02-17 22:17:54'),
(2362, 10, 'Coca Cola', '2018-06-16 12:44:16'),
(2367, 10, 'Coca Cola', '2018-04-21 19:14:51'),
(2383, 10, 'Coca Cola', '2018-06-07 14:06:11'),
(2396, 10, 'Coca Cola', '2018-03-21 00:25:01'),
(2410, 10, 'Coca Cola', '2018-02-26 17:37:45'),
(2447, 10, 'Coca Cola', '2018-04-09 14:58:07'),
(2460, 10, 'Coca Cola', '2018-06-02 19:55:25'),
(2498, 10, 'Coca Cola', '2018-03-31 15:36:01'),
(2599, 10, 'Coca Cola', '2018-01-18 11:45:00'),
(2634, 10, 'Coca Cola', '2018-02-13 12:11:52'),
(2669, 10, 'Coca Cola', '2018-04-12 21:52:29'),
(2683, 10, 'Coca Cola', '2018-02-21 15:54:05'),
(2712, 10, 'Coca Cola', '2018-06-28 10:24:21'),
(2758, 10, 'Coca Cola', '2018-04-10 03:22:05'),
(2781, 10, 'Coca Cola', '2018-06-02 19:16:02'),
(2785, 10, 'Coca Cola', '2018-04-03 06:17:16'),
(2792, 10, 'Coca Cola', '2018-04-10 11:24:50'),
(2805, 10, 'Coca Cola', '2018-01-23 00:18:08'),
(2817, 10, 'Coca Cola', '2018-05-03 00:09:59'),
(2845, 10, 'Coca Cola', '2018-03-04 08:25:18'),
(2848, 10, 'Coca Cola', '2018-02-12 11:31:52'),
(2867, 10, 'Coca Cola', '2018-01-17 06:32:07'),
(2889, 10, 'Coca Cola', '2018-05-27 14:02:00'),
(2921, 10, 'Coca Cola', '2018-05-27 15:08:10'),
(2922, 10, 'Coca Cola', '2018-02-17 20:30:41'),
(2928, 10, 'Coca Cola', '2018-04-05 03:41:44'),
(2932, 10, 'Coca Cola', '2018-05-29 20:00:55'),
(2952, 10, 'Coca Cola', '2018-06-20 02:32:34'),
(2967, 10, 'Coca Cola', '2018-04-15 18:11:47'),
(3003, 10, 'Coca Cola', '2018-05-24 07:32:53'),
(3005, 10, 'Coca Cola', '2018-06-19 21:23:34'),
(3019, 10, 'Coca Cola', '2018-02-06 00:25:41'),
(3041, 10, 'Coca Cola', '2018-03-07 07:04:40'),
(3053, 10, 'Coca Cola', '2018-02-19 15:52:29'),
(3074, 10, 'Coca Cola', '2018-04-10 07:54:14'),
(3084, 10, 'Coca Cola', '2018-02-09 23:06:22'),
(3124, 10, 'Coca Cola', '2018-01-28 04:32:54'),
(3129, 10, 'Coca Cola', '2018-03-27 16:46:07'),
(3132, 10, 'Coca Cola', '2018-03-22 08:56:37'),
(3146, 10, 'Coca Cola', '2018-05-27 22:10:20'),
(3152, 10, 'Coca Cola', '2018-04-27 04:18:15'),
(3168, 10, 'Coca Cola', '2018-04-12 18:57:57'),
(3223, 10, 'Coca Cola', '2018-05-04 06:10:57'),
(3227, 10, 'Coca Cola', '2018-06-06 06:36:11'),
(3253, 10, 'Coca Cola', '2018-04-19 23:59:18'),
(3256, 10, 'Coca Cola', '2018-06-21 06:03:27'),
(3324, 10, 'Coca Cola', '2018-03-03 10:58:55'),
(3339, 10, 'Coca Cola', '2018-01-22 01:06:53'),
(3385, 10, 'Coca Cola', '2018-06-16 06:41:39'),
(3388, 10, 'Coca Cola', '2018-02-19 10:52:47'),
(3414, 10, 'Coca Cola', '2018-05-23 11:51:53'),
(3470, 10, 'Coca Cola', '2018-06-02 18:34:09'),
(3472, 10, 'Coca Cola', '2018-02-10 11:19:29'),
(3473, 10, 'Coca Cola', '2018-03-03 04:33:42'),
(3539, 10, 'Coca Cola', '2018-01-22 06:26:16'),
(3594, 10, 'Coca Cola', '2018-03-18 07:15:20'),
(3597, 10, 'Coca Cola', '2018-02-18 16:04:03'),
(3639, 10, 'Coca Cola', '2018-06-13 22:08:17'),
(3648, 10, 'Coca Cola', '2018-01-28 04:56:40'),
(3663, 10, 'Coca Cola', '2018-04-27 08:15:28'),
(3692, 10, 'Coca Cola', '2018-02-10 22:25:56'),
(3698, 10, 'Coca Cola', '2018-05-13 08:12:18'),
(3712, 10, 'Coca Cola', '2018-03-14 17:02:18'),
(3715, 10, 'Coca Cola', '2018-05-28 12:28:06'),
(3716, 10, 'Coca Cola', '2018-02-28 00:53:09'),
(3719, 10, 'Coca Cola', '2018-06-05 20:55:08'),
(3729, 10, 'Coca Cola', '2018-06-11 07:18:56'),
(3730, 10, 'Coca Cola', '2018-05-08 01:13:51'),
(3745, 10, 'Coca Cola', '2018-06-23 20:38:11'),
(3757, 10, 'Coca Cola', '2018-03-30 18:38:27'),
(3808, 10, 'Coca Cola', '2018-04-25 00:44:03'),
(3809, 10, 'Coca Cola', '2018-03-13 21:38:43'),
(3824, 10, 'Coca Cola', '2018-03-04 16:03:29'),
(3872, 10, 'Coca Cola', '2018-01-22 15:26:26'),
(3906, 10, 'Coca Cola', '2018-05-29 08:49:08'),
(3956, 10, 'Coca Cola', '2018-02-02 06:51:16'),
(3969, 10, 'Coca Cola', '2018-06-13 12:23:33'),
(3987, 10, 'Coca Cola', '2018-02-12 19:22:18'),
(3991, 10, 'Coca Cola', '2018-05-20 10:20:11'),
(4001, 10, 'Coca Cola', '2018-01-19 05:37:08'),
(4023, 10, 'Coca Cola', '2018-04-16 00:00:43'),
(4048, 10, 'Coca Cola', '2018-03-16 08:02:56'),
(4062, 10, 'Coca Cola', '2018-03-11 13:16:40'),
(4098, 10, 'Coca Cola', '2018-05-23 16:29:47'),
(4128, 10, 'Coca Cola', '2018-02-25 05:21:07'),
(4146, 10, 'Coca Cola', '2018-05-21 05:57:13'),
(4169, 10, 'Coca Cola', '2018-05-01 06:50:50'),
(4195, 10, 'Coca Cola', '2018-04-11 15:03:27'),
(4202, 10, 'Coca Cola', '2018-05-15 06:04:22'),
(4221, 10, 'Coca Cola', '2018-05-22 20:58:52'),
(4236, 10, 'Coca Cola', '2018-05-26 05:22:49'),
(4258, 10, 'Coca Cola', '2018-02-28 13:55:39'),
(4298, 10, 'Coca Cola', '2018-05-24 12:22:01'),
(4324, 10, 'Coca Cola', '2018-06-10 00:15:45'),
(4332, 10, 'Coca Cola', '2018-06-10 08:24:32'),
(4334, 11, 'Pepsi', '2018-12-14 17:30:03'),
(4335, 0, '', '2018-12-14 23:55:28'),
(4336, 0, '', '2018-12-14 23:55:28'),
(4337, 0, '', '2018-12-14 23:56:06'),
(4338, 0, '', '2018-12-14 23:56:06'),
(4339, 12, 'Dr.Pepper', '2018-12-14 23:56:13');

-- --------------------------------------------------------

--
-- Table structure for table `registration_keys`
--

CREATE TABLE `registration_keys` (
  `id` int(11) NOT NULL,
  `position` varchar(255) NOT NULL,
  `registration_key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `registration_keys`
--

INSERT INTO `registration_keys` (`id`, `position`, `registration_key`) VALUES
(1, 'admin', 'f7go8qrk%d'),
(2, 'Operator', 'jw83nsiua0'),
(3, 'Driver', 'jhw92ks9a7');

-- --------------------------------------------------------

--
-- Table structure for table `storage`
--

CREATE TABLE `storage` (
  `id` int(11) NOT NULL,
  `product` varchar(255) NOT NULL,
  `quantity` float NOT NULL DEFAULT '0',
  `shelf_life` date DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `storage`
--

INSERT INTO `storage` (`id`, `product`, `quantity`, `shelf_life`) VALUES
(1, 'Куряча грудка', 92, '2018-11-18'),
(2, 'Лук', 96, '2018-11-18'),
(3, 'Солодкий перець', 89, '2018-11-18'),
(4, 'Часник', 96, '2018-11-18'),
(5, 'Помідори', 84, '2018-11-18'),
(6, 'Сир', 99.8, '2018-11-18'),
(7, 'Вода', 99, '2018-11-18'),
(8, 'Куряче філе', 97.5, '2018-11-18'),
(9, 'Соєвий соус', 99.8, '2018-11-18'),
(10, 'Яблучний оцет', 99.8, '2018-11-18'),
(11, 'Цукор', 99.75, '2018-11-18'),
(12, 'Томатна паста', 99.95, '2018-11-18'),
(13, 'Консервованій ананас', 95, '2018-11-18'),
(14, 'Картопля', 80, '2018-11-18'),
(15, 'Кріп', 98, '2018-11-18'),
(16, 'Петрушка', 98, '2018-11-18'),
(17, 'Печериці', 100, '2018-11-18'),
(18, 'Сметана', 100, '2018-11-18'),
(19, 'Майонез', 100, '2018-11-18'),
(20, 'Цибуля ріпчаста', 100, '2018-11-18'),
(21, 'Свинина', 100, '2018-11-18'),
(22, 'Рис', 100, '2018-11-18'),
(23, 'Морква', 100, '2018-11-18'),
(24, 'Шинка', 100, '2018-11-18'),
(25, 'Макарони', 100, '2018-11-18'),
(26, 'Консервована курка', 100, '2018-11-18'),
(27, 'Зелений салат', 100, '2018-11-18'),
(28, 'Вершкове масло', 100, '2018-11-18'),
(29, 'Сир пармезан', 99.8, '2018-11-18'),
(30, 'Вірменський лаваш', 100, '2018-11-18'),
(31, 'Курка', 100, '2018-11-18'),
(32, 'Кетчуп', 100, '2018-11-18'),
(33, 'Coca Cola', 100, '2018-11-18'),
(34, 'Pepsi', 99.5, '2018-11-18'),
(35, 'Dr.Pepper', 99.5, '2018-12-18'),
(36, 'Fanta', 0, '2018-11-18');

-- --------------------------------------------------------

--
-- Table structure for table `time_shift_request`
--

CREATE TABLE `time_shift_request` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `updated_time` time NOT NULL,
  `cause` text NOT NULL,
  `confirmation` varchar(9) NOT NULL DEFAULT 'No answer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Login` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Position` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `Username`, `Login`, `Password`, `Position`) VALUES
(1, 'Jeka Golovko', 'admin', '183d126ae8be2984a61a1a23c988b6b5c52bb518c8d29731cdfe87eabec8eaee880d2e68192e9a5c823a6bc51f4db33ef74e1c76a1dec99e135ce9c9cd915e94', 'admin'),
(3, 'Allen Birfer', 'birfer@gmail.com', '3fb230039e5c6f3c56b923c4cead281140774a7f1b67b46996dcb6c96ccec28b6625ec8885837753866c0c05541cae70ef93e09f930a2a07a585de00b4700d95', 'admin'),
(4, 'Linda Smith', 'lindasmith@gmail.com', 'a3ca420b3f87941a480605a8bc46a24b2acb7bdc551290115c4b02cdb4e03916b628d9667235ee96324c11039be43c178523824803d425ad0ef98740d0d46aa8', 'Driver'),
(5, 'John Middle', 'johnmiddle@gmail.com', '8ab4a01ea4e567933b4b9b779f56b29f0a50b6b86397378e28fc24f3db444d3e41a35f771a316936901cb4650814c9de35f9961deabb708176330703ffb0154d', 'Operator'),
(6, 'John Rain', 'johnrain@gmail.com', 'e2c5f2b43f344ef3684cc166a5c08e486a68229d4f95166e49cb59a137ddf2cb1f8b919c0e04d393c7913c031697d2079579010f344bc476242d2df37f994b04', 'Driver');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_statistics`
--
ALTER TABLE `order_statistics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registration_keys`
--
ALTER TABLE `registration_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `storage`
--
ALTER TABLE `storage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_shift_request`
--
ALTER TABLE `time_shift_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `order_statistics`
--
ALTER TABLE `order_statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4340;

--
-- AUTO_INCREMENT for table `registration_keys`
--
ALTER TABLE `registration_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `storage`
--
ALTER TABLE `storage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `time_shift_request`
--
ALTER TABLE `time_shift_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
