-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 03, 2024 at 06:35 AM
-- Server version: 8.2.0
-- PHP Version: 8.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `motueka`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `bookingID` int UNSIGNED NOT NULL,
  `customerID` int UNSIGNED NOT NULL,
  `roomID` int UNSIGNED NOT NULL,
  `checkInDate` date NOT NULL,
  `checkOutDate` date NOT NULL,
  `numberAdults` int UNSIGNED NOT NULL,
  `numberChildren` int UNSIGNED DEFAULT '0',
  `totalPrice` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`bookingID`, `customerID`, `roomID`, `checkInDate`, `checkOutDate`, `numberAdults`, `numberChildren`, `totalPrice`) VALUES
(1, 18, 1, '2023-11-24', '2023-11-29', 1, 1, 2350.00),
(2, 11, 1, '2023-11-24', '2023-11-29', 1, 1, 2350.00),
(3, 14, 4, '2024-02-06', '2024-02-10', 2, 0, 983.50),
(4, 3, 4, '2024-04-02', '2024-04-09', 2, 1, 1340.00),
(5, 2, 3, '2023-11-20', '2023-11-22', 2, 0, 1258.00),
(6, 3, 3, '2023-11-20', '2023-11-23', 2, 0, 1758.00),
(7, 4, 7, '2024-09-04', '2024-09-06', 4, 3, 1438.71),
(8, 18, 10, '2024-04-22', '2024-04-29', 4, 2, 3100.04),
(9, 17, 6, '2024-01-25', '2024-01-27', 3, 3, 696.83),
(10, 2, 6, '2024-01-25', '2024-01-30', 2, 1, 1340.87),
(11, 8, 3, '2024-07-18', '2024-07-20', 3, 1, 455.81),
(12, 3, 12, '2024-01-09', '2024-01-11', 1, 1, 385.86),
(13, 14, 4, '2024-05-06', '2024-05-15', 3, 0, 3184.51),
(14, 14, 2, '2024-05-15', '2024-05-20', 2, 2, 2370.00),
(15, 7, 13, '2024-10-06', '2024-10-10', 1, 0, 854.56),
(16, 8, 13, '2024-08-13', '2024-05-18', 4, 3, 4402.09),
(17, 8, 2, '2024-02-18', '2024-02-20', 2, 1, 465.00),
(18, 3, 10, '2024-01-19', '2024-01-21', 2, 1, 480.80),
(19, 7, 11, '2024-03-06', '2024-03-10', 1, 0, 674.00),
(20, 8, 10, '2024-02-13', '2024-02-18', 2, 1, 1100.00),
(21, 4, 7, '2024-01-04', '2024-01-16', 2, 0, 2341.70),
(22, 18, 13, '2024-02-22', '2024-02-25', 4, 2, 1900.04),
(23, 17, 5, '2024-02-25', '2024-02-27', 2, 1, 746.00),
(24, 2, 7, '2024-01-24', '2024-01-29', 2, 2, 1240.00),
(25, 20, 5, '2023-12-07', '2023-12-12', 2, 1, 2423.00);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customerID` int UNSIGNED NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL DEFAULT '.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customerID`, `firstname`, `lastname`, `email`, `password`) VALUES
(1, 'Robert', 'Hodgson', 'yuliahodgson@gmail.com', '12345'),
(2, 'Desiree', 'Collier', 'Maecenas@non.co.uk', '.'),
(3, 'Irene', 'Walker', 'id.erat.Etiam@id.org', '.'),
(4, 'Forrest', 'Baldwin', 'eget.nisi.dictum@a.com', '.'),
(5, 'Beverly', 'Sellers', 'ultricies.sem@pharetraQuisqueac.co.uk', '.'),
(6, 'Glenna', 'Kinney', 'dolor@orcilobortisaugue.org', '.'),
(7, 'Montana', 'Gallagher', 'sapien.cursus@ultriciesdignissimlacus.edu', '.'),
(8, 'Harlan', 'Lara', 'Duis@aliquetodioEtiam.edu', '.'),
(9, 'Benjamin', 'King', 'mollis@Nullainterdum.org', '.'),
(10, 'Rajah', 'Olsen', 'Vestibulum.ut.eros@nequevenenatislacus.ca', '.'),
(11, 'Castor', 'Kelly', 'Fusce.feugiat.Lorem@porta.co.uk', '.'),
(12, 'Omar', 'Oconnor', 'eu.turpis@auctorvelit.co.uk', '.'),
(13, 'Porter', 'Leonard', 'dui.Fusce@accumsanlaoreet.net', '.'),
(14, 'Buckminster', 'Gaines', 'convallis.convallis.dolor@ligula.co.uk', '.'),
(15, 'Hunter', 'Rodriquez', 'ridiculus.mus.Donec@est.co.uk', '.'),
(16, 'Zahir', 'Harper', 'vel@estNunc.com', '.'),
(17, 'Sopoline', 'Warner', 'vestibulum.nec.euismod@sitamet.co.uk', '.'),
(18, 'Burton', 'Parrish', 'consequat.nec.mollis@nequenonquam.org', '.'),
(19, 'Abbot', 'Rose', 'non@et.ca', '.'),
(20, 'Barry', 'Burks', 'risus@libero.net', '.');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `roomID` int UNSIGNED NOT NULL,
  `roomname` varchar(100) NOT NULL,
  `description` text,
  `roomtype` char(1) DEFAULT 'D',
  `beds` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`roomID`, `roomname`, `description`, `roomtype`, `beds`) VALUES
(1, 'Kellie', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing', 'S', 5),
(2, 'Herman', 'Lorem ipsum dolor sit amet, consectetuer', 'D', 5),
(3, 'Scarlett', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 'D', 2),
(4, 'Jelani', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam', 'S', 2),
(5, 'Sonya', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus.', 'S', 5),
(6, 'Miranda', 'Lorem ipsum dolor sit amet, consectetuer adipiscing', 'S', 4),
(7, 'Helen', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam adipiscing lacus.', 'S', 2),
(8, 'Octavia', 'Lorem ipsum dolor sit amet,', 'D', 3),
(9, 'Gretchen', 'Lorem ipsum dolor sit', 'D', 3),
(10, 'Bernard', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer', 'S', 5),
(11, 'Dacey', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur', 'D', 2),
(12, 'Preston', 'Lorem', 'D', 2),
(13, 'Dane', 'Lorem ipsum dolor', 'S', 4),
(14, 'Cole', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur sed tortor. Integer aliquam', 'S', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`bookingID`),
  ADD KEY `fk_customerID` (`customerID`),
  ADD KEY `fk_roomID` (`roomID`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customerID`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`roomID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `bookingID` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customerID` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `roomID` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `fk_customerID` FOREIGN KEY (`customerID`) REFERENCES `customers` (`customerID`),
  ADD CONSTRAINT `fk_roomID` FOREIGN KEY (`roomID`) REFERENCES `rooms` (`roomID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
