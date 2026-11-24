-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql100.infinityfree.com
-- Generation Time: Nov 23, 2026 at 10:47 PM
-- Server version: 11.4.14-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arang_stop`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `name`, `email`, `phone`, `password`) VALUES
(1, 'test', 'test@gmail.com', '', '$2y$10$E6QByVWH9qZcM74SS6OGsOByFa5jmu35403axF/5Gce'),
(2, 'Shiro', 'shiro@gmail.com', '', '$2y$10$htOTwdNWEEL6CKOix/11/OWGAF1iOvCKcGT9qHrUxa/'),
(3, 'okay', 'okay@gmail.com', '', 'okay123');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `category` enum('Burger','Drink','Fries') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `item_name`, `category`, `price`, `pic`) VALUES
(1, 'Classic Beef Burger', 'Burger', '13.00', 'classic_beef.jpg'),
(2, 'Classic Chicken Burger', 'Burger', '13.00', 'classic_chicken.jpeg'),
(3, 'Smoke Beef Burger', 'Burger', '17.00', 'smoke_beef.jpg'),
(4, 'Smoke Chicken Burger', 'Burger', '16.50', 'smoke_chicken.jpg'),
(5, 'Crispy Chicken Burger', 'Burger', '17.00', 'crispy_chicken.jpg'),
(6, 'Cheezy Beef Burger', 'Burger', '19.00', 'cheezy_beef.jpg'),
(7, 'Cheezy Chicken Burger', 'Burger', '19.50', 'cheezy_chicken.jpg'),
(8, 'Doubledown Burger', 'Burger', '20.00', 'doubledown.jpg'),
(9, 'Coca Cola', 'Drink', '2.00', 'coca_cola.png'),
(10, 'Sprite', 'Drink', '2.00', 'sprite.jpg'),
(11, 'A&W', 'Drink', '2.50', 'anw.jpg'),
(12, 'Orange Fanta', 'Drink', '2.00', 'orange_fanta.jpg'),
(13, 'Grape Fanta', 'Drink', '2.50', 'grape_fanta.png'),
(14, 'Curly Fries', 'Fries', '3.00', 'curly_fries.jpg'),
(15, 'Onion Rings', 'Fries', '3.50', 'onion_ring.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `status` enum('Pending','In Progress','Ready','Completed') DEFAULT 'Pending',
  `total_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `set_option` enum('Ala Carte','Set') DEFAULT NULL,
  `drink_id` int(11) DEFAULT NULL,
  `fries_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `passwords` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `username`, `passwords`) VALUES
('S001', 'admin', 'admin123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `menu_id` (`menu_id`),
  ADD KEY `drink_id` (`drink_id`),
  ADD KEY `fries_id` (`fries_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`),
  ADD CONSTRAINT `order_items_ibfk_3` FOREIGN KEY (`drink_id`) REFERENCES `menu` (`menu_id`),
  ADD CONSTRAINT `order_items_ibfk_4` FOREIGN KEY (`fries_id`) REFERENCES `menu` (`menu_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
