-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2023 at 01:01 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-contract`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(2) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category`) VALUES
(1, 'Hardware and Software Services'),
(2, 'Network and Security Services'),
(3, 'IT Support and Maintenance');

-- --------------------------------------------------------

--
-- Table structure for table `contract`
--

CREATE TABLE `contract` (
  `contract_no` varchar(12) NOT NULL,
  `type_id` int(2) NOT NULL,
  `category_id` int(2) NOT NULL,
  `description` text NOT NULL,
  `date_of_agreement` date NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `life_of_contract` double(4,2) NOT NULL,
  `vendor_id` int(12) NOT NULL,
  `sdm_id` int(12) NOT NULL,
  `sdm_remarks` text NOT NULL,
  `annual_spend` int(12) NOT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `payment_terms` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `expiration_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contract`
--

INSERT INTO `contract` (`contract_no`, `type_id`, `category_id`, `description`, `date_of_agreement`, `supplier_name`, `life_of_contract`, `vendor_id`, `sdm_id`, `sdm_remarks`, `annual_spend`, `payment_type`, `payment_terms`, `status`, `expiration_id`) VALUES
('654F6A81413C', 0, 1, 'Computer', '2023-11-23', 'Supplier', 99.99, 14, 10, 'THIS IS A REMARKS', 2000, '4', '', 'Complete', 9);

-- --------------------------------------------------------

--
-- Table structure for table `expiration`
--

CREATE TABLE `expiration` (
  `expiration_id` int(11) NOT NULL,
  `contract_no` varchar(12) NOT NULL,
  `date` date NOT NULL,
  `status_days` int(4) NOT NULL,
  `renewal_provision_id` int(2) NOT NULL,
  `termination_rights` text NOT NULL,
  `assignment_provision` text NOT NULL,
  `notified` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `expiration`
--

INSERT INTO `expiration` (`expiration_id`, `contract_no`, `date`, `status_days`, `renewal_provision_id`, `termination_rights`, `assignment_provision`, `notified`) VALUES
(2, '123', '2023-11-30', 0, 0, 'qwe', 'qwe', 1),
(3, '123', '2023-11-30', 0, 0, 'qwe', 'qwe', 1),
(4, '123', '2023-11-30', 0, 0, 'qwe', 'qwe', 1),
(5, '', '2023-11-30', 0, 0, 'quwheuqhwoeihq', 'kqwnekqnwlek', 1),
(6, '1', '2023-11-30', 0, 0, 'qweqwe', 'kqwnekqnwlek', 1),
(7, '654EDF4CDC2C', '2023-11-30', 0, 0, 'qweqwe', 'qweqwe', 1),
(8, '654EDF4CDC2C', '2023-11-30', 0, 0, 'qweqwe', 'qweqwe', 1),
(9, '654F6A81413C', '2023-11-30', 0, 0, 'QWERTY', 'QWERTY', 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(12) NOT NULL,
  `contract_no` varchar(12) NOT NULL,
  `description` text NOT NULL,
  `file` text NOT NULL,
  `amount` int(12) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

CREATE TABLE `issues` (
  `id` int(12) NOT NULL,
  `contract_no` varchar(12) NOT NULL,
  `subject` text NOT NULL,
  `description` text NOT NULL,
  `issuer_name` varchar(255) NOT NULL,
  `issuer_role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notice_period`
--

CREATE TABLE `notice_period` (
  `contract_no` varchar(12) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `contract_no` varchar(12) NOT NULL,
  `status` int(1) NOT NULL,
  `notification_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_type`
--

CREATE TABLE `payment_type` (
  `payment_type_id` int(11) NOT NULL,
  `payment_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_type`
--

INSERT INTO `payment_type` (`payment_type_id`, `payment_name`) VALUES
(1, 'Cash'),
(2, 'Check'),
(3, 'Credit Card'),
(4, 'Installments'),
(5, 'PayPal');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `name`, `description`) VALUES
(1, 'user_management_access', 'Access to user management'),
(2, 'permission_create', 'Create permissions'),
(3, 'permission_edit', 'Edit permissions'),
(4, 'permission_show', 'View permissions'),
(5, 'permission_delete', 'Delete permissions'),
(6, 'permission_access', 'Access to permission management'),
(7, 'role_create', 'Create roles'),
(8, 'role_edit', 'Edit roles'),
(9, 'role_show', 'View roles'),
(10, 'role_delete', 'Delete roles'),
(11, 'role_access', 'Access to role management'),
(12, 'user_create', 'Create users'),
(13, 'user_edit', 'Edit users'),
(14, 'user_show', 'View users'),
(15, 'user_delete', 'Delete users'),
(16, 'user_access', 'Access to user management'),
(17, 'contract_create', 'Create contracts'),
(18, 'contract_edit', 'Edit contracts'),
(19, 'contract_show', 'View contracts'),
(20, 'contract_delete', 'Delete contracts'),
(21, 'contract_access', 'Access to contract management'),
(22, 'profile_password_edit', 'Edit user profile and password'),
(23, 'can_add_notice_period', 'Add notice period to contracts'),
(24, 'can_add_review', 'Add reviews to contracts'),
(25, 'can_settle_issues', 'Settle issues with contracts'),
(26, 'can_create_invoice', 'Create invoices for contracts');

-- --------------------------------------------------------

--
-- Table structure for table `renewal_provision`
--

CREATE TABLE `renewal_provision` (
  `renewal_provision_id` int(2) NOT NULL,
  `renewal_provision` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `contract_no` varchar(12) NOT NULL,
  `reviewer_name` varchar(255) NOT NULL,
  `reviewer_comments` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_delivery_manager`
--

CREATE TABLE `service_delivery_manager` (
  `sdm_id` int(12) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_no` varchar(13) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `service_delivery_manager`
--

INSERT INTO `service_delivery_manager` (`sdm_id`, `name`, `email`, `phone_no`, `role_id`) VALUES
(10, 'TEST SDM', 'sdm@gmail.com', '09262408442', 3);

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `type_id` int(2) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`type_id`, `type`) VALUES
(0, 'hardware'),
(1, 'software'),
(2, 'license'),
(3, 'other');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(42) NOT NULL,
  `role_id` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role_id`) VALUES
(1, 'admin', 'admin@gmail.com', '123', 1),
(2, 'Ankita', 'ankita@kontrak.com', 'Kontrak@1', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `role_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`role_id`, `name`) VALUES
(1, 'admin'),
(2, 'vendor'),
(3, 'service_delivery_manager');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendor_id` int(12) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_no` varchar(13) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`vendor_id`, `contact_name`, `email`, `phone_no`, `role_id`) VALUES
(13, 'TEST', 'test@gmail.com', '09262408442', 2),
(14, 'TEST VENDOR', 'vendor@gmail.com', '09262408442', 2);

-- --------------------------------------------------------

--
-- Table structure for table `view_all_users`
--

CREATE TABLE `view_all_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `view_all_users`
--

INSERT INTO `view_all_users` (`id`, `name`, `email`, `contact_phone`, `role_id`, `type`) VALUES
(1, 'TEST VENDOR', 'vendor@gmail.com', '09262408442', 2, 'vendor'),
(2, 'TEST SDM', 'sdm@gmail.com', '09262408442', 3, 'sdm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `contract`
--
ALTER TABLE `contract`
  ADD UNIQUE KEY `contract_no` (`contract_no`),
  ADD KEY `fk_contract_type` (`type_id`);

--
-- Indexes for table `expiration`
--
ALTER TABLE `expiration`
  ADD PRIMARY KEY (`expiration_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issues`
--
ALTER TABLE `issues`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`contract_no`);

--
-- Indexes for table `payment_type`
--
ALTER TABLE `payment_type`
  ADD PRIMARY KEY (`payment_type_id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `renewal_provision`
--
ALTER TABLE `renewal_provision`
  ADD PRIMARY KEY (`renewal_provision_id`);

--
-- Indexes for table `service_delivery_manager`
--
ALTER TABLE `service_delivery_manager`
  ADD PRIMARY KEY (`sdm_id`),
  ADD KEY `fk_sdm_role_id` (`role_id`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_role` (`role_id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendor_id`),
  ADD UNIQUE KEY `vendor` (`vendor_id`),
  ADD KEY `fk_vendor_role_id` (`role_id`);

--
-- Indexes for table `view_all_users`
--
ALTER TABLE `view_all_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `expiration`
--
ALTER TABLE `expiration`
  MODIFY `expiration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `issues`
--
ALTER TABLE `issues`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_type`
--
ALTER TABLE `payment_type`
  MODIFY `payment_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `renewal_provision`
--
ALTER TABLE `renewal_provision`
  MODIFY `renewal_provision_id` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_delivery_manager`
--
ALTER TABLE `service_delivery_manager`
  MODIFY `sdm_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `type_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendor_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `view_all_users`
--
ALTER TABLE `view_all_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contract`
--
ALTER TABLE `contract`
  ADD CONSTRAINT `fk_contract_type` FOREIGN KEY (`type_id`) REFERENCES `type` (`type_id`) ON DELETE CASCADE;

--
-- Constraints for table `service_delivery_manager`
--
ALTER TABLE `service_delivery_manager`
  ADD CONSTRAINT `fk_sdm_role_id` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`role_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`role_id`);

--
-- Constraints for table `vendor`
--
ALTER TABLE `vendor`
  ADD CONSTRAINT `fk_vendor_role_id` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
