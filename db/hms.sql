-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2024 at 09:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `aname` text NOT NULL,
  `aemail` varchar(100) NOT NULL,
  `aphone` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `aname`, `aemail`, `aphone`, `password`, `reg_date`) VALUES
(2, 'Administrator', 'admin@gmail.com', '0714141456', '81dc9bdb52d04dc20036dbd8313ed055', '2023-12-08 15:11:29');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doc_id` int(11) NOT NULL,
  `appointment_date` date DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id`, `patient_id`, `doc_id`, `appointment_date`, `status`) VALUES
(1, 1, 6, '2024-03-01', 2),
(3, 1, 6, '2024-03-01', 1),
(4, 1, 7, '2024-03-01', 2),
(5, 1, 8, '2024-03-04', 2),
(6, 1, 9, '2024-09-26', 2),
(7, 1, 6, '2024-09-26', 2);

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `id` int(11) NOT NULL,
  `visit_id` int(11) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `bill_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` float NOT NULL,
  `status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`id`, `visit_id`, `invoice_no`, `bill_date`, `total`, `status`) VALUES
(3, 4, 'HSP34994451', '2023-12-10 09:45:31', 920, 1),
(4, 5, 'HSP88003796', '2024-03-04 06:47:44', 90, 1);

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `docid` varchar(100) NOT NULL,
  `docname` text NOT NULL,
  `docspec` varchar(100) NOT NULL,
  `docfees` float NOT NULL,
  `password` varchar(100) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `docid`, `docname`, `docspec`, `docfees`, `password`, `reg_date`) VALUES
(6, 'DOC515', 'Dr. Omar Mathias', 'General', 70000, '81dc9bdb52d04dc20036dbd8313ed055', '2023-12-08 14:26:36'),
(7, 'DOC9239', 'Dr.koilel', 'therapist', 100000, '81dc9bdb52d04dc20036dbd8313ed055', '2024-03-01 06:26:14'),
(8, 'DOC4628', 'Abigael', 'Dentist', 70000, '81dc9bdb52d04dc20036dbd8313ed055', '2024-03-04 06:43:56'),
(9, 'DOC7277', 'Dr. Luka', 'Therapist', 25000, '1234', '2024-09-26 07:23:49');

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE `medicine` (
  `id` int(11) NOT NULL,
  `mname` varchar(100) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`id`, `mname`, `reg_date`) VALUES
(1, 'Amoxilin', '2023-12-08 16:35:33'),
(3, 'Paracetamol', '2023-12-08 16:38:53'),
(4, 'Sona Moja', '2024-09-26 07:32:27'),
(5, 'Piriton', '2024-09-26 07:33:46');

-- --------------------------------------------------------

--
-- Table structure for table `med_details`
--

CREATE TABLE `med_details` (
  `id` int(11) NOT NULL,
  `med_id` int(11) NOT NULL,
  `packing` int(20) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `med_details`
--

INSERT INTO `med_details` (`id`, `med_id`, `packing`, `price`) VALUES
(1, 1, 20, 50),
(3, 1, 120, 200),
(4, 3, 10, 20),
(5, 4, 10, 30),
(6, 5, 8, 50);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `pno` varchar(100) NOT NULL,
  `pname` text NOT NULL,
  `pphone` varchar(20) NOT NULL,
  `pidno` int(10) NOT NULL,
  `paddress` text NOT NULL,
  `pgender` varchar(100) NOT NULL,
  `age` int(10) NOT NULL,
  `password` varchar(100) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `pno`, `pname`, `pphone`, `pidno`, `paddress`, `pgender`, `age`, `password`, `reg_date`) VALUES
(1, 'P8793', 'Juma Mwalekwa', '0789123456', 12345678, 'VOI', 'male', 23, '81dc9bdb52d04dc20036dbd8313ed055', '2023-12-08 16:01:52'),
(3, 'P8476', 'michael kaluka', '0712548745', 3254789, '421', 'male', 20, '', '2024-03-01 12:07:53'),
(4, 'P5465', 'Kudate', '07', 1, '', 'male', 21, '', '2024-09-26 07:24:37'),
(5, 'P3029', 'jennifer', '0723568695', 2, '236', 'male', 18, '', '2024-09-26 07:25:43');

-- --------------------------------------------------------

--
-- Table structure for table `patients_visit`
--

CREATE TABLE `patients_visit` (
  `id` int(11) NOT NULL,
  `visit_date` date NOT NULL,
  `next_visit_date` date DEFAULT NULL,
  `bp` varchar(50) NOT NULL,
  `weight` int(20) NOT NULL,
  `disease` text NOT NULL,
  `patient_id` int(11) NOT NULL,
  `doc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients_visit`
--

INSERT INTO `patients_visit` (`id`, `visit_date`, `next_visit_date`, `bp`, `weight`, `disease`, `patient_id`, `doc_id`) VALUES
(4, '2023-12-11', '0000-00-00', '25/80', 60, 'General', 1, 6),
(5, '2024-03-03', '2024-03-07', '25', 56, '    malaria                                ', 1, 8),
(6, '2024-09-26', '0000-00-00', '', 66, '             malaria                       ', 5, 9);

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE `prescription` (
  `id` int(11) NOT NULL,
  `visit_id` int(11) NOT NULL,
  `med_id` int(11) NOT NULL,
  `dosage` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescription`
--

INSERT INTO `prescription` (`id`, `visit_id`, `med_id`, `dosage`) VALUES
(5, 4, 3, '1X3'),
(6, 4, 4, '2X3'),
(7, 5, 4, '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doc_id` (`doc_id`);

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visit_id` (`visit_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine`
--
ALTER TABLE `medicine`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `med_details`
--
ALTER TABLE `med_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `med_id` (`med_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients_visit`
--
ALTER TABLE `patients_visit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doc_id` (`doc_id`);

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visit_id` (`visit_id`),
  ADD KEY `med_id` (`med_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `medicine`
--
ALTER TABLE `medicine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `med_details`
--
ALTER TABLE `med_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `patients_visit`
--
ALTER TABLE `patients_visit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`doc_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bill`
--
ALTER TABLE `bill`
  ADD CONSTRAINT `bill_ibfk_1` FOREIGN KEY (`visit_id`) REFERENCES `patients_visit` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `med_details`
--
ALTER TABLE `med_details`
  ADD CONSTRAINT `med_details_ibfk_1` FOREIGN KEY (`med_id`) REFERENCES `medicine` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `patients_visit`
--
ALTER TABLE `patients_visit`
  ADD CONSTRAINT `patients_visit_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `patients_visit_ibfk_2` FOREIGN KEY (`doc_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `prescription`
--
ALTER TABLE `prescription`
  ADD CONSTRAINT `prescription_ibfk_1` FOREIGN KEY (`visit_id`) REFERENCES `patients_visit` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prescription_ibfk_2` FOREIGN KEY (`med_id`) REFERENCES `med_details` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
