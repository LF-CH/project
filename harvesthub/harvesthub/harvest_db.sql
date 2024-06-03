-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2024 at 03:03 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `harvest_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adm_id` int(11) NOT NULL,
  `username` varchar(222) NOT NULL,
  `password` varchar(222) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adm_id`, `username`, `password`) VALUES
(1, 'control1', 'pass1');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `bookings_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `collection_date` date DEFAULT NULL,
  `collection_time` time DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `ret_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`bookings_id`, `user_id`, `collection_date`, `collection_time`, `status`, `total_amount`, `ret_name`) VALUES
(231, 7, '2024-01-03', '22:56:00', 'Pending', '5.00', 'Taste of Italy'),
(232, 1, '2024-02-18', '18:45:00', 'Pending', '12.50', 'Grocery Supermarket'),
(233, 1, '2024-02-22', '20:46:00', 'Pending', '25.00', 'Grocery Supermarket'),
(234, 1, '2024-02-02', '18:59:00', 'Pending', '50.00', 'Grocery Supermarket'),
(235, 7, '2024-03-22', '01:54:00', 'Pending', '25.00', 'Grocery Supermarket'),
(236, 7, '2024-03-18', '05:52:00', 'Pending', '25.00', 'Grocery Supermarket'),
(237, 7, '2024-03-27', '03:58:00', 'Pending', '37.50', 'Grocery Supermarket');

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `detail_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking_details`
--

INSERT INTO `booking_details` (`detail_id`, `food_id`, `booking_id`, `quantity`, `total_amount`) VALUES
(58, 22, 96, 1, '0.00'),
(59, 22, 98, 1, '0.00'),
(60, 22, 100, 1, '0.00'),
(61, 22, 102, 1, '0.00'),
(62, 22, 103, 1, '0.00'),
(63, 19, 144, 1, '1.50'),
(64, 19, 145, 2, '3.00'),
(65, 19, 146, 1, '1.50'),
(66, 19, 147, 1, '1.50'),
(67, 19, 148, 1, '1.50'),
(68, 19, 149, 3, '4.50'),
(69, 19, 150, 1, '1.50'),
(70, 19, 151, 3, '4.50'),
(71, 22, 152, 1, '3.00'),
(72, 22, 153, 1, '3.00'),
(73, 22, 154, 1, '3.00'),
(74, 22, 155, 2, '6.00'),
(75, 22, 156, 5, '15.00'),
(76, 22, 157, 2, '6.00'),
(77, 22, 158, 1, '3.00'),
(78, 22, 160, 1, '3.00'),
(79, 22, 161, 1, '3.00'),
(80, 22, 162, 3, '9.00'),
(81, 22, 163, 2, '6.00'),
(82, 22, 164, 1, '3.00'),
(83, 22, 165, 1, '3.00'),
(84, 22, 166, 2, '6.00'),
(85, 22, 167, 1, '3.00'),
(86, 22, 168, 2, '6.00'),
(87, 22, 169, 2, '6.00'),
(88, 22, 170, 1, '3.00'),
(89, 12, 172, 1, '1.99'),
(90, 12, 173, 2, '3.98'),
(91, 12, 174, 3, '5.97'),
(92, 12, 175, 1, '1.99'),
(93, 12, 176, 1, '1.99'),
(94, 12, 177, 7, '13.93'),
(95, 12, 178, 4, '7.96'),
(96, 22, 182, 2, '6.00');

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `food_id` int(11) NOT NULL,
  `ret_name` varchar(50) DEFAULT NULL,
  `food_name` varchar(50) DEFAULT NULL,
  `img` varchar(222) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`food_id`, `ret_name`, `food_name`, `img`, `description`, `price`, `expiry_date`) VALUES
(1, 'Grocery Supermarket', 'Asparagus', 'asparagus.jpg', 'Fresh, green asparagus spears, organically grown, crisp and tender.', '12.50', '2024-03-06'),
(2, 'Grocery Supermarket', 'Bread', 'bread.jpg', 'Whole grain bread, freshly baked, with a soft interior and a crusty exterior.', '1.20', '2024-04-06'),
(3, 'Grocery Supermarket', 'Macaroons', 'macaroons.jpg', 'Assorted French macaroons, with flavors like chocolate, vanilla, and raspberry.', '0.99', '2024-05-06'),
(4, 'Grocery Supermarket', 'Tomatoes', 'tomatoes.jpg', 'Ripe, juicy tomatoes, perfect for salads and sandwiches.', '0.30', '2024-06-06'),
(5, 'Espresso Cafe', 'Cake', 'cake.jpg', 'Classic vanilla sponge cake with buttercream frosting.', '15.00', '2024-07-06'),
(6, 'Espresso Cafe', 'Fruit Salad', 'fruitsalad.jpg', 'Fresh fruit salad with a mix of seasonal fruits.', '2.99', '2024-08-06'),
(7, 'Espresso Cafe', 'Pancake', 'pancake.jpg', 'Fluffy, homemade pancakes, served with maple syrup.', '1.50', '2024-09-06'),
(8, 'Espresso Cafe', 'Sandwich', 'sandwich.jpg', 'Ham and cheese sandwich on whole grain bread with lettuce and tomato.', '2.99', '2024-10-06'),
(9, 'Grove Restaurant', 'Chips', 'chips.jpg', 'Crispy, golden potato chips, lightly salted.', '1.00', '2024-11-06'),
(10, 'Grove Restaurant', 'Pasta', 'pasta.jpg', 'Dry spaghetti pasta, perfect for a variety of dishes.', '0.99', '2024-12-06'),
(11, 'Grove Restaurant', 'Salad', 'salad.jpg', 'Mixed green salad with a variety of fresh vegetables.', '2.50', '2024-02-06'),
(12, 'Grove Restaurant', 'Soup', 'soup.jpg', 'Classic tomato soup, rich in flavor and perfect as a warm starter.', '1.99', '2024-01-13'),
(13, 'Heaven Restaurant', 'Burger and Chips', 'burgerchips.jpg', 'Beef burger with lettuce, tomato, and cheese, served with a side of chips.', '5.50', '2024-06-14'),
(14, 'Heaven Restaurant', 'Hot Dog', 'hotdog.jpg', 'Classic hot dog with mustard and ketchup, served in a soft bun.', '3.00', '2024-06-15'),
(15, 'Heaven Restaurant', 'Spaghetti', 'spaghetti.jpg', 'Freshly cooked spaghetti with a rich tomato sauce.', '4.50', '2024-06-16'),
(16, 'Green Grocers', 'Onion', 'onion.jpg', 'Fresh, whole onions, perfect for cooking and seasoning.', '0.20', '2024-06-17'),
(17, 'Green Grocers', 'Orange', 'orange.jpg', 'Juicy, sweet oranges, full of vitamin C.', '0.50', '2024-06-18'),
(18, 'Green Grocers', 'Potatoes', 'potatoes.jpg', 'Versatile, starchy potatoes, ideal for boiling, mashing, or frying.', '1.50', '2024-06-19'),
(19, 'Green Grocers', 'Eggs', 'eggs.jpg', 'Fresh, free-range eggs, perfect for breakfast or baking.', '1.50', '2024-06-20'),
(20, 'Taste of Italy', 'Seafood Spaghetti', 'seafood.jpg', 'Spaghetti with a mix of seafood like shrimp and mussels in a garlic sauce.', '6.50', '2024-06-21'),
(21, 'Taste of Italy', 'Green Spaghetti', 'greenspag.jpg', 'Spaghetti infused with spinach, served with a creamy pesto sauce.', '5.00', '2024-06-22'),
(33, 'Taste of Italy', 'Green salad', 'greensalad.jpg', 'spinach with dressing', '80.00', '2024-02-01');

-- --------------------------------------------------------

--
-- Table structure for table `retailer`
--

CREATE TABLE `retailer` (
  `retailer_id` int(11) NOT NULL,
  `ret_name` varchar(50) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `retailer`
--

INSERT INTO `retailer` (`retailer_id`, `ret_name`, `location`, `description`, `image`) VALUES
(1, 'Grocery Supermarket', 'Manchester', 'A one-stop shop for all your daily needs, offering a wide range of fresh produce, dairy products, and pantry staples. Located in the heart of Manchester, Grocery Supermarket is renowned for its quality goods and friendly service.', 'grocery_logo.jpg'),
(2, 'Espresso Cafe', 'Manchester', 'Espresso Cafe in Manchester is a cozy spot for coffee enthusiasts and casual catch-ups. Famous for its artisanal coffee, freshly baked pastries, and a warm, inviting ambiance.', 'coffee-beans_logo.png'),
(3, 'Grove Restaurant', 'Birmingham', 'Grove Restaurant in Birmingham presents a unique dining experience with its exquisite fusion cuisine, elegant decor, and an extensive wine selection. Perfect for both romantic dinners and special family gatherings.', 'logo.png'),
(4, 'Heaven Restaurant', 'Birmingham', 'Nestled in Birmingham, Heaven Restaurant offers a heavenly culinary journey with its gourmet dishes, sophisticated atmosphere, and impeccable service. A go-to destination for fine dining lovers.', 'main_logo.png'),
(5, 'Green Grocers', 'London', 'Located in London, Green Grocers is dedicated to providing fresh, organic produce straight from local farms. A favorite among health-conscious shoppers and culinary enthusiasts.', 'shoplogo.jpg'),
(6, 'Taste of Italy', 'London', 'Taste of Italy in London brings authentic Italian cuisine to your table. Enjoy a delightful array of traditional Italian dishes, fine wines, and a charming atmosphere reminiscent of Italy.', 'italylogo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `retailer_dash`
--

CREATE TABLE `retailer_dash` (
  `retailerdash_id` int(11) NOT NULL,
  `retailer_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `retailer_dash`
--

INSERT INTO `retailer_dash` (`retailerdash_id`, `retailer_id`, `username`, `password`) VALUES
(2, 1, 'groceryuser', 'supermarketpass'),
(3, 2, 'espressouser', 'cafepass'),
(4, 3, 'groveuser', 'restaurantpass'),
(5, 4, 'heavenuser', 'restaurantpass'),
(6, 5, 'greengroceruser', 'grocerpass'),
(7, 6, 'italyuser', 'italypass');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `mobile_number` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `full_name`, `mobile_number`) VALUES
(1, 'lily0', 'password1', 'lilypink@mail.com', 'Lily Smith', '01234567891'),
(7, 'Leah', 'testing', 'leah@mail.com', 'Leah Test', '09876543212'),
(9, 'JohnS', 'password88', 'Jsmith@mail.com', 'John smith', '1276223212');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adm_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`bookings_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `ret_name` (`ret_name`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `foodidkfk` (`food_id`);

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`food_id`),
  ADD KEY `fk_ret_name` (`ret_name`);

--
-- Indexes for table `retailer`
--
ALTER TABLE `retailer`
  ADD PRIMARY KEY (`retailer_id`),
  ADD KEY `ret_name` (`ret_name`);

--
-- Indexes for table `retailer_dash`
--
ALTER TABLE `retailer_dash`
  ADD PRIMARY KEY (`retailerdash_id`),
  ADD KEY `FK_retailer_id` (`retailer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `bookings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=238;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `retailer`
--
ALTER TABLE `retailer`
  MODIFY `retailer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `retailer_dash`
--
ALTER TABLE `retailer_dash`
  MODIFY `retailerdash_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD CONSTRAINT `booking_details_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`bookings_id`);

--
-- Constraints for table `foods`
--
ALTER TABLE `foods`
  ADD CONSTRAINT `fk_ret_name` FOREIGN KEY (`ret_name`) REFERENCES `retailer` (`ret_name`);

--
-- Constraints for table `retailer_dash`
--
ALTER TABLE `retailer_dash`
  ADD CONSTRAINT `FK_retailer_id` FOREIGN KEY (`retailer_id`) REFERENCES `retailer` (`retailer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
