-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 28, 2024 at 07:11 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medicalsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Ginecológicas'),
(2, 'Cardiovasculares'),
(3, 'Oncológicas'),
(4, 'Crónicas'),
(5, 'Alergias'),
(6, 'Oftalmológicas'),
(7, 'Pediátricos'),
(8, 'Respiratorias'),
(9, 'Mentales'),
(10, 'Gastrointestinal'),
(11, 'Dental'),
(12, 'Vacunas');

-- --------------------------------------------------------

--
-- Table structure for table `family_members`
--

CREATE TABLE `family_members` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Masculino','Femenino') DEFAULT NULL,
  `marital_status` enum('Casado','Soltero') DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `blood_type` varchar(5) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `relationship` varchar(50) DEFAULT NULL,
  `lens_prescription` varchar(50) DEFAULT NULL,
  `chronic_category` varchar(50) DEFAULT NULL,
  `chronic_subcategory` varchar(50) DEFAULT NULL,
  `observations` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `family_members`
--

INSERT INTO `family_members` (`id`, `patient_id`, `first_name`, `last_name`, `date_of_birth`, `gender`, `marital_status`, `age`, `weight`, `blood_type`, `phone`, `address`, `email`, `relationship`, `lens_prescription`, `chronic_category`, `chronic_subcategory`, `observations`) VALUES
(4, 7, 'Teresa', 'Manchego Moreyra', '1970-01-01', 'Femenino', 'Casado', 54, '70.00', 'O+', '987654321', 'Av. Siempre Viva 123', 'teresa@example.com', 'Madre', 'OD -2.00 SPH Add+2.00 OI -1.00 -0.50 x 180 Add+', 'Gota', 'Lumbalgia', 'Observaciones de ejemplo'),
(5, 7, 'Alejandro Junior', 'Cuba Morante', '2000-05-15', 'Masculino', 'Soltero', 24, '80.00', 'A+', '987654322', 'Av. Siempre Viva 124', 'alejandro@example.com', 'Hermano', 'OD -2.00 SPH Add+2.00 OI -1.00 -0.50 x 180 Add+', 'Ninguna', 'Ninguna', 'Observaciones de ejemplo'),
(8, 7, 'sssssss', 'sssssssssss', '2024-07-04', 'Masculino', 'Casado', 23, '123.00', 'A+', '123321123', 'av cuba 300 Jesús María', 'aaa@gmail.com', 'sobrino', 'xxxxxx', 'Crónica', 'Hipertensión', 'ninguna'),
(9, 7, 'Julia', 'Sarmiento', '2024-07-09', 'Femenino', 'Casado', 45, '123.00', 'O+', '789592325', 'Av Sucre 345 P Libre', 'jsarmiento@gmail.com', 'prima', 'OI -1.00 -0.50 x 180 Add+2.00', 'Crónica', 'Insuficiencia Renal', 'Ninguna'),
(10, 7, 'Cesar', 'Roditas', '2024-07-17', 'Masculino', 'Casado', 27, '123.00', 'B+', '852369741', 'Av La MArina 345', 'crodas@gmail.com', 'Sobrino', 'xxxxxxxx', 'Crónica', 'Diabetes', 'controlada');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `lens_measurements` varchar(50) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `chronic_diseases` text DEFAULT NULL,
  `gender` enum('Masculino','Femenino') DEFAULT NULL,
  `marital_status` enum('Casado','Soltero') DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `blood_type` varchar(5) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `emergency_contact_name` varchar(100) DEFAULT NULL,
  `emergency_contact_phone` varchar(20) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `user_id`, `first_name`, `last_name`, `lens_measurements`, `photo_path`, `chronic_diseases`, `gender`, `marital_status`, `age`, `weight`, `blood_type`, `phone`, `address`, `email`, `emergency_contact_name`, `emergency_contact_phone`, `date_of_birth`) VALUES
(7, 1, 'JAime', 'Añazco', 'OI -1.00 -0.50 x 180 Add+2.00', 'uploads/foto-carnet1.jpg', 'Diabetess', 'Femenino', 'Casado', 23, '185.00', 'A-', '963258741', 'av cuba 520', 'janazco@gmail.com', 'Teresa MAnchego', '951236874', '2024-07-17');

-- --------------------------------------------------------

--
-- Table structure for table `patient_subcategories`
--

CREATE TABLE `patient_subcategories` (
  `patient_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL,
  `observations` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patient_subcategories`
--

INSERT INTO `patient_subcategories` (`patient_id`, `subcategory_id`, `observations`) VALUES
(7, 2, 'EMBARAZO ECTÓPICOS'),
(7, 3, ''),
(7, 4, ''),
(7, 5, ''),
(7, 6, ''),
(7, 7, ''),
(7, 18, ''),
(7, 19, ''),
(7, 20, ''),
(7, 21, ''),
(7, 37, '');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `category_id`, `name`) VALUES
(1, 1, 'Menstruación'),
(2, 1, 'Embarazo'),
(3, 1, 'Información sobre anticoncepción y salud reproduct'),
(4, 2, 'Insuficiencia cardiaca'),
(5, 2, 'Angina de pecho inestable'),
(6, 2, 'Arritmias cardiacas'),
(7, 3, 'Leucemia'),
(8, 3, 'Cáncer de próstata'),
(9, 3, 'Cáncer de mama'),
(10, 3, 'Cáncer cervicouterino'),
(11, 4, 'Diabetes'),
(12, 4, 'Hipertensión'),
(13, 4, 'Enfermedad Renal'),
(14, 5, 'Medicamentos'),
(15, 5, 'Alimentos'),
(16, 5, 'Sustancias Ambientales'),
(17, 5, 'Otros alérgenos'),
(18, 6, 'Miopía'),
(19, 6, 'Astigmatismo'),
(20, 6, 'Hipermetropía'),
(21, 7, 'Asma'),
(22, 7, 'Bronquitis'),
(23, 7, 'Gastroenteritis'),
(24, 7, 'Sarampión'),
(25, 7, 'Rubeola'),
(26, 7, 'Varicela'),
(27, 7, 'Hepatitis'),
(28, 8, 'Enfisema Pulmonar Obstructivo Crónico'),
(29, 8, 'Fibromas pulmonar'),
(30, 8, 'Infección de vías respiratorias'),
(31, 8, 'Rinitis'),
(32, 8, 'Sinusitis'),
(33, 9, 'Animo'),
(34, 9, 'Ansiedad'),
(35, 9, 'Psicóticos'),
(36, 10, 'Colitis'),
(37, 10, 'Ulcera gástrica'),
(38, 10, 'Gastritis'),
(39, 11, 'Padecimiento'),
(40, 11, 'Seguimiento'),
(41, 12, 'Recibidas, nombre y fecha'),
(42, 12, 'Pendientes de acuerdo al calendario de vacunación');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','patient') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'patientjaime', 'J@m09679933', 'patient'),
(2, 'jmanchego@minsa.gob.pe', 'J@m09679933', 'patient');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `family_members`
--
ALTER TABLE `family_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `patient_subcategories`
--
ALTER TABLE `patient_subcategories`
  ADD PRIMARY KEY (`patient_id`,`subcategory_id`),
  ADD KEY `subcategory_id` (`subcategory_id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `family_members`
--
ALTER TABLE `family_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `family_members`
--
ALTER TABLE `family_members`
  ADD CONSTRAINT `family_members_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `patient_subcategories`
--
ALTER TABLE `patient_subcategories`
  ADD CONSTRAINT `patient_subcategories_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `patient_subcategories_ibfk_2` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
