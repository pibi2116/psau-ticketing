-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2024 at 06:30 AM
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
-- Database: `ticket_db4`
--

-- --------------------------------------------------------

--
-- Table structure for table `ticketcommunication`
--

CREATE TABLE `ticketcommunication` (
  `communicationID` int(11) NOT NULL,
  `ticketID` int(11) NOT NULL,
  `senderID` int(11) NOT NULL,
  `message` text NOT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticketcommunication`
--

INSERT INTO `ticketcommunication` (`communicationID`, `ticketID`, `senderID`, `message`, `attachment`, `createdAt`) VALUES
(1, 1, 2, 'Check namin later', '', '2024-05-19 15:45:02'),
(2, 1, 4, 'sige po, thanks!', '', '2024-05-19 15:46:09'),
(3, 1, 4, '', 'psau-logo.png', '2024-05-19 15:46:26'),
(4, 1, 2, '', '8.png', '2024-05-19 15:46:49'),
(5, 2, 1, 'yes po?', '', '2024-05-19 15:52:09'),
(6, 3, 9, 'Try po naming re-schedule', '', '2024-05-19 16:39:26'),
(7, 3, 4, 'okay po', '', '2024-05-19 16:40:01'),
(8, 3, 4, '', '1.png', '2024-05-19 16:40:07'),
(9, 3, 1, 'Helloo, this is Admin Name', '', '2024-05-19 16:48:47');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticketID` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `priority` enum('low','medium','high') NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `attachment` text NOT NULL,
  `status` enum('Open','In Progress','Resolved') NOT NULL DEFAULT 'Open',
  `creatorID` int(11) NOT NULL,
  `assigneeID` int(11) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticketID`, `category`, `priority`, `title`, `description`, `attachment`, `status`, `creatorID`, `assigneeID`, `createdAt`, `updatedAt`) VALUES
(1, 'College of Engineering and Computer Studies (COECS)', 'medium', 'Equipment Concern', 'Yung mga chairs po sa COMLAB 2 ay sira na', 'psau-thumbnail.png', 'Resolved', 4, 2, '2024-05-19 15:39:05', '2024-05-19 15:50:33'),
(2, 'College of Veterinary Medicine (CVM)', 'low', 'Event Question', 'Kelan po ang libreng food niyo?', 'psau-thumbnail.png', 'In Progress', 2, 10, '2024-05-19 15:48:22', '2024-05-19 15:52:09'),
(3, 'College of Arts and Sciences (CAS)', 'medium', 'Event Schedule', 'Masyado pong maaga yung ceremony sa tuesday', 'psau-thumbnail.png', 'Resolved', 4, 9, '2024-05-19 16:36:45', '2024-05-19 16:49:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(60) NOT NULL,
  `image` text NOT NULL,
  `psau_email` varchar(60) NOT NULL,
  `role` enum('customer','staff','admin') NOT NULL,
  `department` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `image`, `psau_email`, `role`, `department`) VALUES
(1, 'psauadmin', '$2y$10$QgwUBoCIaD9vADt3JEQ/BufZBEeRc1AF/DIN8oVugTTcOTSTpbzMy', 'Admin Name', '1.png', 'psau@iskwela.psau.edu', 'admin', ''),
(2, 'COECS Agent', '$2y$10$j1JaG39S8FPASMJk61chb.jBylx4ag0qmQPhaGW0pVrf3VbUhFf4.', 'COECS Agent', '6.png', 'psau@iskwela.psau.edu', 'staff', 'College of Engineering and Computer Studies (COECS)'),
(4, 'customer', '$2y$10$WnNdyh6enQBz4qm0IY7DWuvE.bcZaw4KRRMZFOA4e7BtgdIpaT75i', 'Customer Name Sample', '1.png', 'psau@iskwela.psau.edu', 'customer', ''),
(6, 'CASTECH Agent', '$2y$10$op9MuS.Ikzvsqb3C9JqS/OTpA11J/rSjuwAe8JgdEMa.CQcNvXPIa', 'CASTECH Agent', '', 'psau@iskwela.psau.edu', 'staff', 'College of Agriculture Systems and Technology (CASTECH)'),
(8, 'CHEFS Agent', '$2y$10$HeknudD.QoOp88.d75ImfeSZH9lhxJQAfAWd0IEEjrQuWxO3rwe.u', 'CHEFS Agent', '', 'psau@iskwela.psau.edu', 'staff', 'College of Hospitality, Entrepreneurship, and Food Sciences (CHEFS)'),
(9, 'CAS Agent', '$2y$10$BkixJvMCHSrMpkDtf.8oFOVIgoELM047cS/k9HVnfLai/P3alE1eu', 'CAS Agent', '', 'psau@iskwela.psau.edu', 'staff', 'College of Arts and Sciences (CAS)'),
(10, 'CVM Agent', '$2y$10$75t1A4rNVtCBtGxdInJeUOOEz3ub8SOixEHzKzzr5kO7dEUdtbkxe', 'CVM Agent', '', 'psau@iskwela.psau.edu', 'staff', 'College of Veterinary Medicine (CVM)'),
(15, 'COED Agent', '$2y$10$A2jumD.4LOXuoyrMXjNHNuZ5RZr88XHLGoCg2T5xgWeWub5ZPDse.', 'COED Agent', '1.png', 'psau@iskwela.psau.edu', 'staff', 'College of Education (COED)');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ticketcommunication`
--
ALTER TABLE `ticketcommunication`
  ADD PRIMARY KEY (`communicationID`),
  ADD KEY `ticketID` (`ticketID`),
  ADD KEY `senderID` (`senderID`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticketID`),
  ADD KEY `creatorID` (`creatorID`),
  ADD KEY `assigneeID` (`assigneeID`),
  ADD KEY `creatorID_2` (`creatorID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ticketcommunication`
--
ALTER TABLE `ticketcommunication`
  MODIFY `communicationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticketID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ticketcommunication`
--
ALTER TABLE `ticketcommunication`
  ADD CONSTRAINT `ticketcommunication_ibfk_2` FOREIGN KEY (`senderID`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`creatorID`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
