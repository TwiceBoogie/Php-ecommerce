-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 05, 2023 at 01:08 PM
-- Server version: 8.0.32
-- PHP Version: 8.2.5
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;
--
-- Database: `php_project`
--

-- --------------------------------------------------------
--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int AUTO_INCREMENT PRIMARY KEY,
  `admin_name` varchar(100) NOT NULL,
  `admin_email` varchar(40) NOT NULL,
  `admin_password` varchar(250) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
-- --------------------------------------------------------
--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int AUTO_INCREMENT PRIMARY KEY,
  `order_cost` decimal(6, 2) NOT NULL,
  `order_status` varchar(100) NOT NULL DEFAULT 'on_hold',
  `user_id` int NOT NULL,
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
-- --------------------------------------------------------
--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int AUTO_INCREMENT PRIMARY KEY,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(6, 2) NOT NULL,
  `product_quantity` int NOT NULL,
  `user_id` int NOT NULL,
  `order_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
-- --------------------------------------------------------
--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int AUTO_INCREMENT PRIMARY KEY,
  `product_name` varchar(100) NOT NULL,
  `product_category` varchar(100) NOT NULL,
  `product_description` varchar(2000) NOT NULL,
  `product_image` varchar(255) NOT NULL DEFAULT 'no-data.jpg',
  `product_image2` varchar(255) NOT NULL DEFAULT 'no-data.jpg',
  `product_image3` varchar(255) NOT NULL DEFAULT 'no-data.jpg',
  `product_image4` varchar(255) NOT NULL DEFAULT 'no-data.jpg',
  `product_price` decimal(6, 2) NOT NULL,
  `product_color` varchar(100) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
--
-- Dumping data for table `products`
--

INSERT INTO `products` (
    `product_name`,
    `product_category`,
    `product_description`,
    `product_image`,
    `product_image2`,
    `product_image3`,
    `product_image4`,
    `product_price`,
    `product_color`
  )
VALUES (
    'Keyboard 1',
    'keyboards',
    'awesome Keyboard 1',
    'prod1.jpg',
    'prod1.2.jpg',
    'prod1.3.jpg',
    'prod1.4.jpg',
    91.00,
    'silver'
  ),
  (
    'Keyboard 2',
    'keyboards',
    'Awesome Keyboard 2',
    'prod2.jpg',
    'prod2.2.jpg',
    'prod2.3.jpg',
    'prod2.4.jpg',
    89.99,
    'black'
  ),
  (
    'Keyboard 3',
    'keyboards',
    'Awesome Keyboard 3',
    'prod3.jpg',
    'prod3.2.jpg',
    'prod3.3.jpg',
    'prod3.4.jpg',
    89.99,
    'white/blue'
  ),
  (
    'Keyboard 4',
    'keyboards',
    'Awesome Keyboard 4',
    'prod4.jpg',
    'prod4.2.jpg',
    'prod4.3.jpg',
    'prod4.4.jpg',
    89.99,
    'black/gold'
  ),
  (
    'Keyboard 5',
    'keyboards',
    'Awesome Keyboard 5',
    'prod5.jpg',
    'prod5.2.jpg',
    'prod5.3.jpg',
    'prod5.4.jpg',
    76.00,
    'black/white'
  ),
  (
    'Keyboard 6',
    'keyboards',
    'Awesome Keyboard 6',
    'prod6.jpg',
    'prod6.2.jpg',
    'prod6.3.jpg',
    'prod6.4.jpg',
    75.00,
    'white/black'
  ),
  (
    'Keyboard 7',
    'keyboards',
    'Awesome Keyboard 7',
    'prod7.jpg',
    'prod7.2.jpg',
    'prod7.3.jpg',
    'prod7.4.jpg',
    75.00,
    'gray/white'
  ),
  (
    'Keyboard 8',
    'keyboards',
    'Awesome Keyboard 8',
    'prod8.jpg',
    'prod8.2.jpg',
    'prod8.3.jpg',
    'prod8.4.jpg',
    75.00,
    'sherbet'
  ),
  (
    'Mouse 1',
    'mice',
    'Mouse 1',
    'prod9.jpg',
    'prod9.2.jpg',
    'prod9.3.jpg',
    'prod9.4.jpg',
    50.00,
    'black'
  ),
  (
    'Mouse 2',
    'mice',
    'Mouse 2',
    'prod10.jpg',
    'prod10.2.jpg',
    'prod10.3.jpg',
    'prod10.4.jpg',
    50.00,
    'black'
  ),
  (
    'Mouse 3',
    'mice',
    'Mouse 3',
    'prod11.jpg',
    'prod11.2.jpg',
    'prod11.3.jpg',
    'prod11.4.jpg',
    50.00,
    'black'
  ),
  (
    'Mouse 4',
    'mice',
    'Mouse 4',
    'prod12.jpg',
    'prod12.2.jpg',
    'prod12.3.jpg',
    'prod12.4.jpg',
    50.00,
    'white'
  ),
  (
    'Mouse 5',
    'mice',
    'Mouse 5',
    'prod13.jpg',
    'prod13.2.jpg',
    'prod13.3.jpg',
    'prod13.4.jpg',
    50.00,
    'black'
  ),
  (
    'Headset 1',
    'heatset',
    'HeadSet 1',
    'prod14.jpg',
    'prod14.2.jpg',
    'prod14.3.jpg',
    'prod14.4.jpg',
    50.00,
    'black'
  ),
  (
    'Microphone 1',
    'microphone',
    'Microphone 1',
    'prod15.jpg',
    'prod15.2.jpg',
    'prod15.3.jpg',
    'prod15.4.jpg',
    50.00,
    'gray'
  ),
  (
    'Sound System 1',
    'soundsystem',
    'Sound System 1',
    'prod16.jpg',
    'prod16.2.jpg',
    'prod16.3.jpg',
    'prod16.4.jpg',
    50.00,
    'black/wood'
  ),
  (
    'Apple Keyboard',
    'keyboards',
    'Apple product',
    'prod27-0.jpg',
    'prod27-1.jpg',
    'prod27-2.jpg',
    'prod27-3.jpg',
    201.00,
    'white'
  );
-- --------------------------------------------------------
--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int AUTO_INCREMENT PRIMARY KEY,
  `role_name` varchar(50) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_name`)
VALUES ('ADMIN'),
  ('USER');
-- --------------------------------------------------------
--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int AUTO_INCREMENT PRIMARY KEY,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(40) NOT NULL,
  `user_password` varchar(250) NOT NULL,
  `user_role` int NOT NULL DEFAULT '2',
  `confirmed` enum('Y', 'N') NOT NULL DEFAULT 'Y',
  `register_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id_user_details` int AUTO_INCREMENT PRIMARY KEY,
  `user_id` int NOT NULL,
  `phone` varchar(30) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(100) NOT NULL DEFAULT ''
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
--
-- Indexes for table `admin`
--
-- ALTER TABLE `admin`
--   ADD PRIMARY KEY (`admin_id`);
--
-- Indexes for table `orders`
--
-- ALTER TABLE `orders`
--   ADD PRIMARY KEY (`order_id`);
--
-- Indexes for table `order_items`
--
-- ALTER TABLE `order_items`
--   ADD PRIMARY KEY (`item_id`);
--
-- Indexes for table `products`
--
-- ALTER TABLE `products`
--   ADD PRIMARY KEY (`product_id`);
--
-- Indexes for table `roles`
--
-- ALTER TABLE `roles`
--   ADD PRIMARY KEY (`role_id`);
--
-- Indexes for table `users`
--
-- ALTER TABLE `users`
--   ADD PRIMARY KEY (`user_id`);
--
-- Indexes for table `user_details`
--
-- ALTER TABLE `user_details`
--   ADD PRIMARY KEY (`id_user_details`);
--
-- AUTO_INCREMENT for table `admin`
--
-- ALTER TABLE `admin`
--   MODIFY `admin_id` int NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `products`
--
-- ALTER TABLE `products`
--   MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `roles`
--
-- ALTER TABLE `roles`
--   MODIFY `role_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
-- COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;