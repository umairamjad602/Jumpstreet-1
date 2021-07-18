-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2021 at 07:35 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jumpstreet`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `active`) VALUES
(20, 'Sandwiches', 1),
(21, 'Burgers', 1),
(22, 'Extras', 1),
(23, 'Soft Drinks', 1);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `service_charge_value` varchar(255) NOT NULL,
  `vat_charge_value` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `currency` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company_name`, `service_charge_value`, `vat_charge_value`, `address`, `phone`, `country`, `message`, `currency`) VALUES
(1, 'Jabron Burgers and Sandwiches', '0', '0', '!st Floor Moaz Plaza G..T  road Ghakkhar', '', 'Pakistan ', '<p>Real taste is here</p>', 'PKR');

-- --------------------------------------------------------

--
-- Table structure for table `end_system_date`
--

CREATE TABLE `end_system_date` (
  `id` int(100) NOT NULL,
  `dat_esystem` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `end_system_date`
--

INSERT INTO `end_system_date` (`id`, `dat_esystem`) VALUES
(1, '04-03-2021');

-- --------------------------------------------------------

--
-- Table structure for table `expanse`
--

CREATE TABLE `expanse` (
  `id` int(11) NOT NULL,
  `expanse_date` date NOT NULL,
  `comment` text NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `permission` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group_name`, `permission`) VALUES
(1, 'Super Administrator', 'a:45:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s:11:\"createGroup\";i:5;s:11:\"updateGroup\";i:6;s:9:\"viewGroup\";i:7;s:11:\"deleteGroup\";i:8;s:11:\"createStore\";i:9;s:11:\"updateStore\";i:10;s:9:\"viewStore\";i:11;s:11:\"deleteStore\";i:12;s:11:\"createStock\";i:13;s:11:\"updateStock\";i:14;s:9:\"viewStock\";i:15;s:11:\"deleteStock\";i:16;s:11:\"createTable\";i:17;s:11:\"updateTable\";i:18;s:9:\"viewTable\";i:19;s:11:\"deleteTable\";i:20;s:14:\"createCategory\";i:21;s:14:\"updateCategory\";i:22;s:12:\"viewCategory\";i:23;s:14:\"deleteCategory\";i:24;s:13:\"createProduct\";i:25;s:13:\"updateProduct\";i:26;s:11:\"viewProduct\";i:27;s:13:\"deleteProduct\";i:28;s:11:\"createOrder\";i:29;s:11:\"updateOrder\";i:30;s:9:\"viewOrder\";i:31;s:11:\"deleteOrder\";i:32;s:10:\"createLoan\";i:33;s:10:\"updateLoan\";i:34;s:8:\"viewLoan\";i:35;s:10:\"deleteLoan\";i:36;s:13:\"createExpanse\";i:37;s:13:\"updateExpanse\";i:38;s:11:\"viewExpanse\";i:39;s:13:\"deleteExpanse\";i:40;s:10:\"viewReport\";i:41;s:13:\"updateCompany\";i:42;s:11:\"viewProfile\";i:43;s:13:\"updateSetting\";i:44;s:8:\"endOfDay\";}'),
(4, 'Manager', 'a:20:{i:0;s:11:\"createStore\";i:1;s:9:\"viewStore\";i:2;s:11:\"createStock\";i:3;s:9:\"viewStock\";i:4;s:11:\"createTable\";i:5;s:9:\"viewTable\";i:6;s:14:\"createCategory\";i:7;s:12:\"viewCategory\";i:8;s:13:\"createProduct\";i:9;s:11:\"viewProduct\";i:10;s:11:\"createOrder\";i:11;s:11:\"updateOrder\";i:12;s:9:\"viewOrder\";i:13;s:10:\"createLoan\";i:14;s:8:\"viewLoan\";i:15;s:13:\"createExpanse\";i:16;s:11:\"viewExpanse\";i:17;s:10:\"viewReport\";i:18;s:11:\"viewProfile\";i:19;s:8:\"endOfDay\";}'),
(5, 'Staff', 'a:6:{i:0;s:9:\"viewTable\";i:1;s:11:\"viewProduct\";i:2;s:11:\"createOrder\";i:3;s:11:\"updateOrder\";i:4;s:9:\"viewOrder\";i:5;s:11:\"viewProfile\";}'),
(9, 'Test', 'a:18:{i:0;s:11:\"createStore\";i:1;s:9:\"viewStore\";i:2;s:11:\"createStock\";i:3;s:9:\"viewStock\";i:4;s:11:\"createTable\";i:5;s:9:\"viewTable\";i:6;s:14:\"createCategory\";i:7;s:12:\"viewCategory\";i:8;s:13:\"createProduct\";i:9;s:11:\"viewProduct\";i:10;s:11:\"createOrder\";i:11;s:9:\"viewOrder\";i:12;s:10:\"createLoan\";i:13;s:8:\"viewLoan\";i:14;s:13:\"createExpanse\";i:15;s:11:\"viewExpanse\";i:16;s:10:\"viewReport\";i:17;s:11:\"viewProfile\";}');

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE `loan` (
  `id` int(11) NOT NULL,
  `geter_name` text NOT NULL,
  `phoneno` text NOT NULL,
  `cnicno` text NOT NULL,
  `given_date` date NOT NULL,
  `receiving_date` date NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `bill_no` varchar(255) NOT NULL,
  `date_time` varchar(255) NOT NULL,
  `gross_amount` varchar(255) NOT NULL,
  `service_charge_rate` varchar(255) NOT NULL,
  `service_charge_amount` varchar(255) NOT NULL,
  `vat_charge_rate` varchar(255) NOT NULL,
  `vat_charge_amount` varchar(255) NOT NULL,
  `discount` varchar(255) NOT NULL,
  `net_amount` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `paid_status` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `is_day_end` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `bill_no`, `date_time`, `gross_amount`, `service_charge_rate`, `service_charge_amount`, `vat_charge_rate`, `vat_charge_amount`, `discount`, `net_amount`, `user_id`, `table_id`, `paid_status`, `store_id`, `is_day_end`) VALUES
(123, 'BILPR-C1AF', '1614798152', '528.00', '0', '0', '0', '0', '20', '422.40', 1, 48, 1, 9, 0),
(124, 'BILPR-5E98', '1614798189', '936', '0', '0', '0', '0', '', '936', 1, 49, 1, 9, 0),
(126, 'BILPR-6F38', '1614629880', '986', '0', '0', '0', '0', '', '986', 1, 50, 1, 7, 0),
(128, 'BILPR-D1DA', '1614854880', '259', '0', '0', '0', '0', '', '259', 1, 50, 1, 7, 0),
(129, 'BILPR-4E6B', '1614856620', '249', '0', '0', '0', '0', '', '249', 1, 48, 1, 9, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` varchar(255) NOT NULL,
  `rate` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `qty`, `rate`, `amount`) VALUES
(390, 106, 260, '2', '249', '498.00'),
(391, 107, 260, '1', '249', '249'),
(448, 124, 261, '1', '259', '259'),
(449, 124, 262, '1', '269', '269'),
(450, 124, 265, '1', '209', '209'),
(451, 124, 264, '1', '199', '199'),
(458, 126, 261, '1', '259', '259'),
(459, 126, 261, '1', '259', '259'),
(460, 126, 262, '1', '269', '269'),
(461, 126, 264, '1', '199', '199'),
(468, 128, 261, '1', '259', '259'),
(469, 123, 261, '1', '259', '259'),
(470, 123, 262, '1', '269', '269'),
(471, 129, 260, '1', '249', '249');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` text NOT NULL,
  `store_id` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `store_id`, `name`, `price`, `description`, `image`, `active`) VALUES
(260, '[\"20\"]', '[\"7\",\"9\"]', 'Cocktail Sandwich', '249', '', 'assets/images/product_image/60263dffde1dd.jpg', 1),
(261, '[\"20\"]', '[\"7\",\"9\"]', 'Creamy Cheese Sandwich', '259', '', 'assets/images/product_image/603000a14bd02.png', 1),
(262, '[\"20\"]', '[\"7\",\"9\"]', 'BBQ Sandwich', '269', '', 'assets/images/product_image/6030009205388.jpg', 1),
(263, '[\"20\"]', '[\"7\",\"9\"]', 'Mashroom Mayo Sandich', '279', '', 'assets/images/product_image/6030007f63e82.png', 1),
(264, '[\"21\"]', '[\"7\",\"9\"]', 'Grill Burger with Mexican Sauce', '199', '', 'assets/images/product_image/6030002672870.png', 1),
(265, '[\"21\"]', '[\"7\",\"9\"]', 'Grill Burger with creamy cheese Sauce', '209', '', 'assets/images/product_image/60300036c953a.png', 1),
(266, '[\"21\"]', '[\"7\",\"9\"]', 'Grill Burger with BBQ Sauce', '219', '', 'assets/images/product_image/6030004c6fa5e.jpg', 1),
(267, '[\"21\"]', '[\"7\",\"9\"]', 'Grill Burger with Mayo and Mash Sauce', '229', '', 'assets/images/product_image/6030006995b46.png', 1),
(268, '[\"22\"]', '[\"7\",\"9\"]', 'Extra Cheese', '30', '', 'assets/images/product_image/6027ffef98977.jpg', 1),
(269, '[\"22\"]', '[\"7\",\"9\"]', 'Dip Sauce', '50', '', 'assets/images/product_image/6028004036eb7.jpg', 1),
(270, '[\"23\"]', '[\"7\",\"9\"]', 'Pepsi half litre', '80', '', 'assets/images/product_image/602801bf61b2b.jpg', 1),
(271, '[\"23\"]', '[\"7\",\"9\"]', '7up half litre', '80', '', 'assets/images/product_image/6028021d7ca04.jpg', 1),
(272, '[\"23\"]', '[\"7\",\"9\"]', 'Sting HAlf Litre', '80', '', 'assets/images/product_image/6028024461b7f.jpg', 1),
(273, '[\"23\"]', '[\"7\",\"9\"]', 'Mineral Water', '50', '', 'assets/images/product_image/602802a436a3f.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `date_time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `qty`, `category_id`, `date_time`) VALUES
(277, 99970, 20, '1613297887'),
(278, 99977, 21, '1613297897'),
(279, 100000, 22, '1613297906'),
(280, 99999, 23, '1613297913');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `name`, `active`) VALUES
(7, 'Home Delivery', 1),
(9, 'Takeaways', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` int(11) NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `capacity` varchar(255) NOT NULL,
  `available` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `table_name`, `capacity`, `available`, `active`, `store_id`) VALUES
(34, 'D4', '19', 2, 1, 7),
(35, 'D3', '12', 2, 1, 7),
(36, 'D2', '10', 2, 1, 7),
(37, 'D1', '10', 2, 1, 7),
(39, 'D5', '10', 2, 1, 7),
(40, 'D6', '10', 2, 1, 7),
(41, 'D7', '10', 2, 1, 7),
(42, 'D8', '10', 2, 1, 7),
(43, 'D9', '10', 2, 1, 7),
(44, 'D10', '10', 2, 1, 7),
(45, 'T1', '10', 2, 1, 9),
(46, 'T2', '10', 2, 1, 9),
(47, 'T3', '10', 2, 1, 9),
(48, 'T4', '10', 2, 1, 9),
(49, 'T5', '10', 2, 1, 9),
(50, 'as', '12', 1, 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `gender` int(11) NOT NULL,
  `store_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `firstname`, `lastname`, `phone`, `gender`, `store_id`) VALUES
(1, 'admin', '$2y$10$43iyWt29xEQ0c3Th9wvrCeRhctcb7Ux0OP/ebm3XiNIL26bJVUJ1W', 'admin@admin.com', 'john', 'doe', '80789998', 1, '0'),
(17, 'Asrar', '$2y$10$QZNKZyQPZvSD1kYD4aUVJeYeX1yLAMKIKWo4hlI6wljEfXXEFckiu', 'asrarbutt@gmail.com', 'Asrar', 'Butt', '030064646464', 1, '[\"9\"]'),
(18, 'Amir Ishfaq', '$2y$10$Pr1pYdFZMVC///swljBooO0fOoMAT2gAdeelh2.UFyUAEyCsX4bNW', 'amir@gmail.com', 'Amir', 'Ishfaq', '1234567890', 1, '[\"9\",\"7\"]');

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE `user_group` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(10, 9, 5),
(11, 10, 5),
(12, 11, 4),
(13, 12, 5),
(14, 13, 5),
(15, 14, 9),
(16, 15, 9),
(17, 16, 4),
(18, 17, 4),
(19, 18, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `end_system_date`
--
ALTER TABLE `end_system_date`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expanse`
--
ALTER TABLE `expanse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan`
--
ALTER TABLE `loan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `end_system_date`
--
ALTER TABLE `end_system_date`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expanse`
--
ALTER TABLE `expanse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `loan`
--
ALTER TABLE `loan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=472;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=274;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=281;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user_group`
--
ALTER TABLE `user_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
