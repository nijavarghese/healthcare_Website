-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2024 at 06:38 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assignment3php`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `loginID` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date_created` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`loginID`, `username`, `password`, `date_created`) VALUES
(1, 'DOCTOR', '91ac2fa488ea37cf8d75fc19db7c9244', '2024-10-25'),
(2, 'NURSE', '91ac2fa488ea37cf8d75fc19db7c9244', '2024-10-25');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `patient_id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `gender` char(1) NOT NULL,
  `DOB` date NOT NULL,
  `phone` bigint(20) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`patient_id`, `fname`, `lname`, `gender`, `DOB`, `phone`, `email`) VALUES
(1, 'John', 'Doe', 'M', '1994-10-21', 5485772665, 'johndoe@hotmail.com'),
(2, 'Maria', 'Black', 'F', '2000-11-01', 2365897541, 'maria.black@gmail.com'),
(3, 'Mitali', 'Gharat', 'F', '2001-07-23', 9997778884, 'mgharat@gmail.com'),
(6, 'Nija Elsa', 'Varghese', 'F', '2001-10-21', 5485772665, 'n_nijaelsavarghese@fanshaweonline.ca');

-- --------------------------------------------------------

--
-- Table structure for table `patient_address`
--

CREATE TABLE `patient_address` (
  `address_id` int(11) NOT NULL,
  `fk_patient_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `province` varchar(50) NOT NULL,
  `city` varchar(100) NOT NULL,
  `postal_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_address`
--

INSERT INTO `patient_address` (`address_id`, `fk_patient_id`, `address`, `province`, `city`, `postal_code`) VALUES
(1, 1, '123 Main street', 'ON', 'London', '1N32N5'),
(2, 2, '80 Masson Crt', 'ON', 'London', 'M3F2H7'),
(3, 3, '123 Dundas street', 'ON', 'Toronto', '1M37K1'),
(6, 6, '15 Tumbleweed Cresent', 'ON', 'London', 'N6E 2N5');

-- --------------------------------------------------------

--
-- Table structure for table `patient_record`
--

CREATE TABLE `patient_record` (
  `patient_record_id` int(11) NOT NULL,
  `fk_patient_id` int(11) NOT NULL,
  `allergies` text DEFAULT NULL,
  `records` text DEFAULT NULL,
  `referrals` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_record`
--

INSERT INTO `patient_record` (`patient_record_id`, `fk_patient_id`, `allergies`, `records`, `referrals`) VALUES
(1, 1, 'Penicillin', 'takes two allergy pills a day.', 'Dr. Nija Varghese from Fanshawe'),
(2, 2, NULL, 'Had knee transplant', 'Dr. Shepherd '),
(3, 3, 'Asthma attacks', 'Taking COLD and Cough medicines', 'DR. ROSS'),
(6, 6, 'allergic to dust', 'On Penicillin for throat infection.', 'Dr. Zahir');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`loginID`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `patient_address`
--
ALTER TABLE `patient_address`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `fk_patient_address` (`fk_patient_id`);

--
-- Indexes for table `patient_record`
--
ALTER TABLE `patient_record`
  ADD PRIMARY KEY (`patient_record_id`),
  ADD KEY `fk_patientid_records` (`fk_patient_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `loginID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `patient_address`
--
ALTER TABLE `patient_address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `patient_record`
--
ALTER TABLE `patient_record`
  MODIFY `patient_record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `patient_address`
--
ALTER TABLE `patient_address`
  ADD CONSTRAINT `fk_patient_address` FOREIGN KEY (`fk_patient_id`) REFERENCES `patient` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `patient_record`
--
ALTER TABLE `patient_record`
  ADD CONSTRAINT `fk_patientid_records` FOREIGN KEY (`fk_patient_id`) REFERENCES `patient` (`patient_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
