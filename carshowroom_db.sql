-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2025 at 11:26 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carshowroom_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `password`) VALUES
(1, 'admin@gmail.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `car_name` varchar(255) NOT NULL,
  `car_model` varchar(255) NOT NULL,
  `car_year` int(11) NOT NULL,
  `car_price` decimal(10,2) NOT NULL,
  `availability_status` enum('Available','Out of Stock') DEFAULT 'Available',
  `car_description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `car_name`, `car_model`, `car_year`, `car_price`, `availability_status`, `car_description`, `created_at`) VALUES
(1, 'Morinda', 'm#12', 2025, '40000.00', 'Available', ' A stylish and fuel-efficient compact sedan known for reliability.  \r\n   Offers a smooth drive with modern tech and sporty design.\r\n', '2025-05-05 04:58:54'),
(2, 'Tauta', 'm#223', 2023, '8000.00', 'Available', '   A compact hatchback perfect for city roads and fuel economy.  \r\n   Agile handling with a youthful design and low upkeep.\r\n', '2025-05-05 05:05:22'),
(3, 'New Car', 'm#4', 2022, '1000000.00', 'Available', '  A stylish and fuel-efficient compact sedan known for reliability.  \r\n   Offers a smooth drive with modern tech and sporty design.\r\n', '2025-05-05 17:42:10'),
(4, 'Hyundai  ', 'm#14', 2024, '700000.00', 'Out of Stock', ' A sleek, affordable sedan with advanced features and mileage.  \r\n   Great for urban driving with a premium interior feel', '2025-05-05 20:29:59');

-- --------------------------------------------------------

--
-- Table structure for table `city_delivery_charges`
--

CREATE TABLE `city_delivery_charges` (
  `id` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `charge_amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `city_delivery_charges`
--

INSERT INTO `city_delivery_charges` (`id`, `city_name`, `charge_amount`) VALUES
(1, 'Karachi', '5000.00'),
(2, 'Lahore', '120.00'),
(3, 'Islamabad', '1000.00'),
(4, 'Rawalpindi', '130.00'),
(5, 'Peshawar', '110.00'),
(6, 'Quetta', '1000.00'),
(7, 'Faisalabad', '100.00'),
(8, 'Multan', '4400.00'),
(9, 'Sialkot', '85.00'),
(10, 'Sargodha', '95.00'),
(11, 'Gujranwala', '120.00'),
(12, 'Bahawalpur', '100.00'),
(13, 'Hyderabad', '110.00'),
(14, 'Murree', '2300.00'),
(15, 'Mardan', '115.00'),
(16, 'Abbottabad', '140.00'),
(17, 'Gujrat', '125.00'),
(18, 'Dera Ghazi Khan', '110.00'),
(19, 'Jhelum', '105.00'),
(20, 'Chiniot', '95.00');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cnic` varchar(20) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `guarantor_name` varchar(100) DEFAULT NULL,
  `guarantor_bank_name` varchar(100) DEFAULT NULL,
  `guarantor_account_no` varchar(50) DEFAULT NULL,
  `guarantor_branch_code` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `name`, `email`, `password`, `cnic`, `phone`, `address`, `guarantor_name`, `guarantor_bank_name`, `guarantor_account_no`, `guarantor_branch_code`, `created_at`) VALUES
(1, 'Diya Shezadi', 'diya@gmail.com', '$2y$10$w/r2F4wtvbDrSUn5.WU.Uerrop86vTBW7RMdlj1dSub.Oo5eXKy5a', '779999999999', '88888888877', 'hazro', 'Diya Shezadi', 'stat bank', '100', '100', '2025-05-05 04:24:26'),
(2, 'syeda', 'syeda@gmail.com', '$2y$10$n7TfBkJ6U0T99FFtOzLdYumEz6uESdIxNBqpogtEVOrOrS8YyjbSq', '779999999999', '8888888888', 'Pindi', 'Syeda', 'stat bank', '10099k', '773444', '2025-05-05 19:12:50');

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

CREATE TABLE `prices` (
  `price_id` int(11) NOT NULL,
  `car_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `availability_status` enum('Available','Out of Stock') DEFAULT 'Available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prices`
--

INSERT INTO `prices` (`price_id`, `car_id`, `price`, `availability_status`, `created_at`) VALUES
(1, 1, '40000.00', 'Available', '2025-05-05 04:58:54'),
(2, 2, '8000.00', 'Available', '2025-05-05 05:05:22'),
(3, 3, '1000000.00', 'Available', '2025-05-05 17:42:10'),
(4, 4, '700000.00', 'Out of Stock', '2025-05-05 20:29:59');

-- --------------------------------------------------------

--
-- Table structure for table `voucher_requests`
--

CREATE TABLE `voucher_requests` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `car_id` int(11) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `installments` int(11) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `paid_voucher` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `delivery_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `order_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `voucher_requests`
--

INSERT INTO `voucher_requests` (`id`, `customer_id`, `car_id`, `city`, `payment_method`, `installments`, `amount`, `paid_voucher`, `status`, `created_at`, `delivery_charge`, `order_time`) VALUES
(21, 1, 2, 'Karachi', 'Installment', 1, 4666.67, '../uploads/1746477168_WhatsApp Image 2024-12-21 at 9.20.24 AM (1).jpeg', 'Paid', '2025-05-05 20:31:58', '2000.00', '2025-05-05 22:31:58'),
(22, 1, 2, 'Karachi', 'Installment', 2, 2666.67, NULL, 'Pending', '2025-05-05 20:31:58', '0.00', '2025-05-05 22:31:58'),
(23, 1, 2, 'Karachi', 'Installment', 3, 2666.67, NULL, 'Pending', '2025-05-05 20:31:58', '0.00', '2025-05-05 22:31:58'),
(24, 1, 3, 'Multan', 'Installment', 1, 333423, '../uploads/1746478582_WhatsApp Image 2024-11-20 at 1.19.40 AM.jpeg', 'Paid', '2025-05-05 20:55:45', '90.00', '2025-05-05 22:55:45'),
(25, 1, 3, 'Multan', 'Installment', 2, 333333, '../uploads/1746478599_WhatsApp Image 2024-11-20 at 2.24.18 AM.jpeg', 'Paid', '2025-05-05 20:55:45', '0.00', '2025-05-05 22:55:45'),
(26, 1, 3, 'Multan', 'Installment', 3, 333333, NULL, 'Pending', '2025-05-05 20:55:45', '0.00', '2025-05-05 22:55:45'),
(27, 1, 4, 'Multan', 'Full Payment', 1, 704400, '../uploads/1746479360_mor-shani-chU5hjPfifA-unsplash.jpg', 'Paid', '2025-05-05 21:08:08', '4400.00', '2025-05-05 23:08:08'),
(28, 2, 4, 'Murree', 'Installment', 1, 177300, '../uploads/1746480288_succulent-plant-mockup-small-gray-pot.jpg', 'Paid', '2025-05-05 21:13:30', '2300.00', '2025-05-05 23:13:30'),
(29, 2, 4, 'Murree', 'Installment', 2, 175000, NULL, 'Pending', '2025-05-05 21:13:30', '0.00', '2025-05-05 23:13:30'),
(30, 2, 4, 'Murree', 'Installment', 3, 175000, NULL, 'Pending', '2025-05-05 21:13:30', '0.00', '2025-05-05 23:13:30'),
(31, 2, 4, 'Murree', 'Installment', 4, 175000, NULL, 'Pending', '2025-05-05 21:13:30', '0.00', '2025-05-05 23:13:30'),
(32, 2, 2, 'Rawalpindi', 'Full Payment', 1, 8130, NULL, 'Pending', '2025-05-05 21:16:00', '130.00', '2025-05-05 23:16:00'),
(33, 2, 3, 'Islamabad', 'Installment', 1, 334333, '../uploads/1746479912_fire-fighters-1045906_1280.jpg', 'Paid', '2025-05-05 21:17:52', '1000.00', '2025-05-05 23:17:52'),
(34, 2, 3, 'Islamabad', 'Installment', 2, 333333, NULL, 'Pending', '2025-05-05 21:17:52', '0.00', '2025-05-05 23:17:52'),
(35, 2, 3, 'Islamabad', 'Installment', 3, 333333, NULL, 'Pending', '2025-05-05 21:17:52', '0.00', '2025-05-05 23:17:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `city_delivery_charges`
--
ALTER TABLE `city_delivery_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`price_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `voucher_requests`
--
ALTER TABLE `voucher_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_customer_id` (`customer_id`),
  ADD KEY `fk_car_id` (`car_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `city_delivery_charges`
--
ALTER TABLE `city_delivery_charges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `prices`
--
ALTER TABLE `prices`
  MODIFY `price_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `voucher_requests`
--
ALTER TABLE `voucher_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `prices`
--
ALTER TABLE `prices`
  ADD CONSTRAINT `prices_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`) ON DELETE CASCADE;

--
-- Constraints for table `voucher_requests`
--
ALTER TABLE `voucher_requests`
  ADD CONSTRAINT `fk_car_id` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
