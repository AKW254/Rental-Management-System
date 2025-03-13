-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 13, 2025 at 02:54 PM
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
-- Database: `rms`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `chat_message_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `chat_message` text NOT NULL,
  `chat_sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoice_id` int(11) NOT NULL,
  `agreement_id` int(11) NOT NULL,
  `invoice_date` date NOT NULL,
  `invoice_due_date` date NOT NULL,
  `invoice_amount` decimal(10,2) NOT NULL,
  `invoice_status` enum('paid','unpaid','overdue') DEFAULT 'unpaid',
  `invoice_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `invoice_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_requests`
--

CREATE TABLE `maintenance_requests` (
  `maintenance_request_id` int(11) NOT NULL,
  `agreement_id` int(11) NOT NULL,
  `maintenance_request_description` text NOT NULL,
  `maintenance_request_status` enum('submitted','in_progress','resolved','rejected') DEFAULT 'submitted',
  `maintenance_request_submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `maintenance_request_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `assigned_to` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `notice_id` int(11) NOT NULL,
  `notice_title` varchar(150) NOT NULL,
  `notice_message` text NOT NULL,
  `posted_by` int(11) DEFAULT NULL,
  `notice_posted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `notice_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification_notification_type` enum('email','sms','push') NOT NULL,
  `notification_message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `notification_status` enum('sent','failed') DEFAULT 'sent'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_amount` decimal(10,2) NOT NULL,
  `payment_method` enum('credit_card','bank_transfer','paypal','mpesa') DEFAULT NULL,
  `payment_transaction_id` varchar(100) DEFAULT NULL,
  `payment_status` enum('success','failed','pending') DEFAULT 'pending',
  `payment_late_fee` decimal(10,2) DEFAULT 0.00,
  `payment_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental_agreements`
--

CREATE TABLE `rental_agreements` (
  `agreement_id` int(11) NOT NULL,
  `renter_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `agreement_start_date` date NOT NULL,
  `agreement_end_date` date DEFAULT NULL,
  `agreement_rent_amount` decimal(10,2) NOT NULL,
  `agreement_deposit` decimal(10,2) DEFAULT NULL,
  `agreement_status` enum('Active','Terminated','Pending') DEFAULT 'Pending',
  `agreement_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `agreement_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_type` enum('Administrator','Landlord','Tenant') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_title` varchar(100) NOT NULL,
  `room_description` text DEFAULT NULL,
  `room_image` varchar(255) DEFAULT NULL,
  `room_rent_amount` decimal(10,2) NOT NULL,
  `room_availability` tinyint(1) DEFAULT 1,
  `property_manager_id` int(11) DEFAULT NULL,
  `room_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `room_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE `timezones` (
  `timezone_id` int(200) NOT NULL,
  `timezone_name` varchar(200) NOT NULL,
  `timezone_utcoffset` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`timezone_id`, `timezone_name`, `timezone_utcoffset`) VALUES
(1, 'Africa/Abidjan', 'UTC+00:00'),
(2, 'Africa/Accra', 'UTC+00:00'),
(3, 'Africa/Addis_Ababa', 'UTC+03:00'),
(4, 'Africa/Algiers', 'UTC+01:00'),
(5, 'Africa/Asmara', 'UTC+03:00'),
(6, 'Africa/Asmera', 'UTC+03:00'),
(7, 'Africa/Bamako', 'UTC+00:00'),
(8, 'Africa/Bangui', 'UTC+01:00'),
(9, 'Africa/Banjul', 'UTC+00:00'),
(10, 'Africa/Bissau', 'UTC+00:00'),
(11, 'Africa/Blantyre', 'UTC+02:00'),
(12, 'Africa/Brazzaville', 'UTC+01:00'),
(13, 'Africa/Bujumbura', 'UTC+02:00'),
(14, 'Africa/Cairo', 'UTC+03:00'),
(15, 'Africa/Casablanca', 'UTC+01:00'),
(16, 'Africa/Ceuta', 'UTC+02:00'),
(17, 'Africa/Conakry', 'UTC+00:00'),
(18, 'Africa/Dakar', 'UTC+00:00'),
(19, 'Africa/Dar_es_Salaam', 'UTC+03:00'),
(20, 'Africa/Djibouti', 'UTC+03:00'),
(21, 'Africa/Douala', 'UTC+01:00'),
(22, 'Africa/El_Aaiun', 'UTC+01:00'),
(23, 'Africa/Freetown', 'UTC+00:00'),
(24, 'Africa/Gaborone', 'UTC+02:00'),
(25, 'Africa/Harare', 'UTC+02:00'),
(26, 'Africa/Johannesburg', 'UTC+02:00'),
(27, 'Africa/Juba', 'UTC+02:00'),
(28, 'Africa/Kampala', 'UTC+03:00'),
(29, 'Africa/Khartoum', 'UTC+02:00'),
(30, 'Africa/Kigali', 'UTC+02:00'),
(31, 'Africa/Kinshasa', 'UTC+01:00'),
(32, 'Africa/Lagos', 'UTC+01:00'),
(33, 'Africa/Libreville', 'UTC+01:00'),
(34, 'Africa/Lome', 'UTC+00:00'),
(35, 'Africa/Luanda', 'UTC+01:00'),
(36, 'Africa/Lubumbashi', 'UTC+02:00'),
(37, 'Africa/Lusaka', 'UTC+02:00'),
(38, 'Africa/Malabo', 'UTC+01:00'),
(39, 'Africa/Maputo', 'UTC+02:00'),
(40, 'Africa/Maseru', 'UTC+02:00'),
(41, 'Africa/Mbabane', 'UTC+02:00'),
(42, 'Africa/Mogadishu', 'UTC+03:00'),
(43, 'Africa/Monrovia', 'UTC+00:00'),
(44, 'Africa/Nairobi', 'UTC+03:00'),
(45, 'Africa/Ndjamena', 'UTC+01:00'),
(46, 'Africa/Niamey', 'UTC+01:00'),
(47, 'Africa/Nouakchott', 'UTC+00:00'),
(48, 'Africa/Ouagadougou', 'UTC+00:00'),
(49, 'Africa/Porto-Novo', 'UTC+01:00'),
(50, 'Africa/Sao_Tome', 'UTC+00:00'),
(51, 'Africa/Timbuktu', 'UTC+00:00'),
(52, 'Africa/Tripoli', 'UTC+02:00'),
(53, 'Africa/Tunis', 'UTC+01:00'),
(54, 'Africa/Windhoek', 'UTC+02:00'),
(55, 'America/Adak', 'UTC-09:00'),
(56, 'America/Anchorage', 'UTC-08:00'),
(57, 'America/Anguilla', 'UTC-04:00'),
(58, 'America/Antigua', 'UTC-04:00'),
(59, 'America/Araguaina', 'UTC-03:00'),
(60, 'America/Argentina/Buenos_Aires', 'UTC-03:00'),
(61, 'America/Argentina/Catamarca', 'UTC-03:00'),
(62, 'America/Argentina/ComodRivadavia', 'UTC-03:00'),
(63, 'America/Argentina/Cordoba', 'UTC-03:00'),
(64, 'America/Argentina/Jujuy', 'UTC-03:00'),
(65, 'America/Argentina/La_Rioja', 'UTC-03:00'),
(66, 'America/Argentina/Mendoza', 'UTC-03:00'),
(67, 'America/Argentina/Rio_Gallegos', 'UTC-03:00'),
(68, 'America/Argentina/Salta', 'UTC-03:00'),
(69, 'America/Argentina/San_Juan', 'UTC-03:00'),
(70, 'America/Argentina/San_Luis', 'UTC-03:00'),
(71, 'America/Argentina/Tucuman', 'UTC-03:00'),
(72, 'America/Argentina/Ushuaia', 'UTC-03:00'),
(73, 'America/Aruba', 'UTC-04:00'),
(74, 'America/Asuncion', 'UTC-03:00'),
(75, 'America/Atikokan', 'UTC-05:00'),
(76, 'America/Atka', 'UTC-09:00'),
(77, 'America/Bahia', 'UTC-03:00'),
(78, 'America/Bahia_Banderas', 'UTC-06:00'),
(79, 'America/Barbados', 'UTC-04:00'),
(80, 'America/Belem', 'UTC-03:00'),
(81, 'America/Belize', 'UTC-06:00'),
(82, 'America/Blanc-Sablon', 'UTC-04:00'),
(83, 'America/Boa_Vista', 'UTC-04:00'),
(84, 'America/Bogota', 'UTC-05:00'),
(85, 'America/Boise', 'UTC-06:00'),
(86, 'America/Buenos_Aires', 'UTC-03:00'),
(87, 'America/Cambridge_Bay', 'UTC-06:00'),
(88, 'America/Campo_Grande', 'UTC-04:00'),
(89, 'America/Cancun', 'UTC-05:00'),
(90, 'America/Caracas', 'UTC-04:00'),
(91, 'America/Catamarca', 'UTC-03:00'),
(92, 'America/Cayenne', 'UTC-03:00'),
(93, 'America/Cayman', 'UTC-05:00'),
(94, 'America/Chicago', 'UTC-05:00'),
(95, 'America/Chihuahua', 'UTC-06:00'),
(96, 'America/Ciudad_Juarez', 'UTC-06:00'),
(97, 'America/Coral_Harbour', 'UTC-05:00'),
(98, 'America/Cordoba', 'UTC-03:00'),
(99, 'America/Costa_Rica', 'UTC-06:00'),
(100, 'America/Creston', 'UTC-07:00'),
(101, 'America/Cuiaba', 'UTC-04:00'),
(102, 'America/Curacao', 'UTC-04:00'),
(103, 'America/Danmarkshavn', 'UTC+00:00'),
(104, 'America/Dawson', 'UTC-07:00'),
(105, 'America/Dawson_Creek', 'UTC-07:00'),
(106, 'America/Denver', 'UTC-06:00'),
(107, 'America/Detroit', 'UTC-04:00'),
(108, 'America/Dominica', 'UTC-04:00'),
(109, 'America/Edmonton', 'UTC-06:00'),
(110, 'America/Eirunepe', 'UTC-05:00'),
(111, 'America/El_Salvador', 'UTC-06:00'),
(112, 'America/Ensenada', 'UTC-07:00'),
(113, 'America/Fort_Nelson', 'UTC-07:00'),
(114, 'America/Fort_Wayne', 'UTC-04:00'),
(115, 'America/Fortaleza', 'UTC-03:00'),
(116, 'America/Glace_Bay', 'UTC-03:00'),
(117, 'America/Godthab', 'UTC-01:00'),
(118, 'America/Goose_Bay', 'UTC-03:00'),
(119, 'America/Grand_Turk', 'UTC-04:00'),
(120, 'America/Grenada', 'UTC-04:00'),
(121, 'America/Guadeloupe', 'UTC-04:00'),
(122, 'America/Guatemala', 'UTC-06:00'),
(123, 'America/Guayaquil', 'UTC-05:00'),
(124, 'America/Guyana', 'UTC-04:00'),
(125, 'America/Halifax', 'UTC-03:00'),
(126, 'America/Havana', 'UTC-04:00'),
(127, 'America/Hermosillo', 'UTC-07:00'),
(128, 'America/Indiana/Indianapolis', 'UTC-04:00'),
(129, 'America/Indiana/Knox', 'UTC-05:00'),
(130, 'America/Indiana/Marengo', 'UTC-04:00'),
(131, 'America/Indiana/Petersburg', 'UTC-04:00'),
(132, 'America/Indiana/Tell_City', 'UTC-05:00'),
(133, 'America/Indiana/Vevay', 'UTC-04:00'),
(134, 'America/Indiana/Vincennes', 'UTC-04:00'),
(135, 'America/Indiana/Winamac', 'UTC-04:00'),
(136, 'America/Indianapolis', 'UTC-04:00'),
(137, 'America/Inuvik', 'UTC-06:00'),
(138, 'America/Iqaluit', 'UTC-04:00'),
(139, 'America/Jamaica', 'UTC-05:00'),
(140, 'America/Jujuy', 'UTC-03:00'),
(141, 'America/Juneau', 'UTC-08:00'),
(142, 'America/Kentucky/Louisville', 'UTC-04:00'),
(143, 'America/Kentucky/Monticello', 'UTC-04:00'),
(144, 'America/Knox_IN', 'UTC-05:00'),
(145, 'America/Kralendijk', 'UTC-04:00'),
(146, 'America/La_Paz', 'UTC-04:00'),
(147, 'America/Lima', 'UTC-05:00'),
(148, 'America/Los_Angeles', 'UTC-07:00'),
(149, 'America/Louisville', 'UTC-04:00'),
(150, 'America/Lower_Princes', 'UTC-04:00'),
(151, 'America/Maceio', 'UTC-03:00'),
(152, 'America/Managua', 'UTC-06:00'),
(153, 'America/Manaus', 'UTC-04:00'),
(154, 'America/Marigot', 'UTC-04:00'),
(155, 'America/Martinique', 'UTC-04:00'),
(156, 'America/Matamoros', 'UTC-05:00'),
(157, 'America/Mazatlan', 'UTC-07:00'),
(158, 'America/Mendoza', 'UTC-03:00'),
(159, 'America/Menominee', 'UTC-05:00'),
(160, 'America/Merida', 'UTC-06:00'),
(161, 'America/Metlakatla', 'UTC-08:00'),
(162, 'America/Mexico_City', 'UTC-06:00'),
(163, 'America/Miquelon', 'UTC-02:00'),
(164, 'America/Moncton', 'UTC-03:00'),
(165, 'America/Monterrey', 'UTC-06:00'),
(166, 'America/Montevideo', 'UTC-03:00'),
(167, 'America/Montreal', 'UTC-04:00'),
(168, 'America/Montserrat', 'UTC-04:00'),
(169, 'America/Nassau', 'UTC-04:00'),
(170, 'America/New_York', 'UTC-04:00'),
(171, 'America/Nipigon', 'UTC-04:00'),
(172, 'America/Nome', 'UTC-08:00'),
(173, 'America/Noronha', 'UTC-02:00'),
(174, 'America/North_Dakota/Beulah', 'UTC-05:00'),
(175, 'America/North_Dakota/Center', 'UTC-05:00'),
(176, 'America/North_Dakota/New_Salem', 'UTC-05:00'),
(177, 'America/Nuuk', 'UTC-01:00'),
(178, 'America/Ojinaga', 'UTC-05:00'),
(179, 'America/Panama', 'UTC-05:00'),
(180, 'America/Pangnirtung', 'UTC-04:00'),
(181, 'America/Paramaribo', 'UTC-03:00'),
(182, 'America/Phoenix', 'UTC-07:00'),
(183, 'America/Port-au-Prince', 'UTC-04:00'),
(184, 'America/Port_of_Spain', 'UTC-04:00'),
(185, 'America/Porto_Acre', 'UTC-05:00'),
(186, 'America/Porto_Velho', 'UTC-04:00'),
(187, 'America/Puerto_Rico', 'UTC-04:00'),
(188, 'America/Punta_Arenas', 'UTC-03:00'),
(189, 'America/Rainy_River', 'UTC-05:00'),
(190, 'America/Rankin_Inlet', 'UTC-05:00'),
(191, 'America/Recife', 'UTC-03:00'),
(192, 'America/Regina', 'UTC-06:00'),
(193, 'America/Resolute', 'UTC-05:00'),
(194, 'America/Rio_Branco', 'UTC-05:00'),
(195, 'America/Rosario', 'UTC-03:00'),
(196, 'America/Santa_Isabel', 'UTC-07:00'),
(197, 'America/Santarem', 'UTC-03:00'),
(198, 'America/Santiago', 'UTC-03:00'),
(199, 'America/Santo_Domingo', 'UTC-04:00'),
(200, 'America/Sao_Paulo', 'UTC-03:00'),
(201, 'America/Scoresbysund', 'UTC-01:00'),
(202, 'America/Shiprock', 'UTC-06:00'),
(203, 'America/Sitka', 'UTC-08:00'),
(204, 'America/St_Barthelemy', 'UTC-04:00'),
(205, 'America/St_Johns', 'UTC-02:30'),
(206, 'America/St_Kitts', 'UTC-04:00'),
(207, 'America/St_Lucia', 'UTC-04:00'),
(208, 'America/St_Thomas', 'UTC-04:00'),
(209, 'America/St_Vincent', 'UTC-04:00'),
(210, 'America/Swift_Current', 'UTC-06:00'),
(211, 'America/Tegucigalpa', 'UTC-06:00'),
(212, 'America/Thule', 'UTC-03:00'),
(213, 'America/Thunder_Bay', 'UTC-04:00'),
(214, 'America/Tijuana', 'UTC-07:00'),
(215, 'America/Toronto', 'UTC-04:00'),
(216, 'America/Tortola', 'UTC-04:00'),
(217, 'America/Vancouver', 'UTC-07:00'),
(218, 'America/Virgin', 'UTC-04:00'),
(219, 'America/Whitehorse', 'UTC-07:00'),
(220, 'America/Winnipeg', 'UTC-05:00'),
(221, 'America/Yakutat', 'UTC-08:00'),
(222, 'America/Yellowknife', 'UTC-06:00'),
(223, 'Antarctica/Casey', 'UTC+08:00'),
(224, 'Antarctica/Davis', 'UTC+07:00'),
(225, 'Antarctica/DumontDUrville', 'UTC+10:00'),
(226, 'Antarctica/Macquarie', 'UTC+11:00'),
(227, 'Antarctica/Mawson', 'UTC+05:00'),
(228, 'Antarctica/McMurdo', 'UTC+13:00'),
(229, 'Antarctica/Palmer', 'UTC-03:00'),
(230, 'Antarctica/Rothera', 'UTC-03:00'),
(231, 'Antarctica/South_Pole', 'UTC+13:00'),
(232, 'Antarctica/Syowa', 'UTC+03:00'),
(233, 'Antarctica/Troll', 'UTC+02:00'),
(234, 'Antarctica/Vostok', 'UTC+05:00'),
(235, 'Arctic/Longyearbyen', 'UTC+02:00'),
(236, 'Asia/Aden', 'UTC+03:00'),
(237, 'Asia/Almaty', 'UTC+05:00'),
(238, 'Asia/Amman', 'UTC+03:00'),
(239, 'Asia/Anadyr', 'UTC+12:00'),
(240, 'Asia/Aqtau', 'UTC+05:00'),
(241, 'Asia/Aqtobe', 'UTC+05:00'),
(242, 'Asia/Ashgabat', 'UTC+05:00'),
(243, 'Asia/Ashkhabad', 'UTC+05:00'),
(244, 'Asia/Atyrau', 'UTC+05:00'),
(245, 'Asia/Baghdad', 'UTC+03:00'),
(246, 'Asia/Bahrain', 'UTC+03:00'),
(247, 'Asia/Baku', 'UTC+04:00'),
(248, 'Asia/Bangkok', 'UTC+07:00'),
(249, 'Asia/Barnaul', 'UTC+07:00'),
(250, 'Asia/Beirut', 'UTC+03:00'),
(251, 'Asia/Bishkek', 'UTC+06:00'),
(252, 'Asia/Brunei', 'UTC+08:00'),
(253, 'Asia/Calcutta', 'UTC+05:30'),
(254, 'Asia/Chita', 'UTC+09:00'),
(255, 'Asia/Choibalsan', 'UTC+08:00'),
(256, 'Asia/Chongqing', 'UTC+08:00'),
(257, 'Asia/Chungking', 'UTC+08:00'),
(258, 'Asia/Colombo', 'UTC+05:30'),
(259, 'Asia/Dacca', 'UTC+06:00'),
(260, 'Asia/Damascus', 'UTC+03:00'),
(261, 'Asia/Dhaka', 'UTC+06:00'),
(262, 'Asia/Dili', 'UTC+09:00'),
(263, 'Asia/Dubai', 'UTC+04:00'),
(264, 'Asia/Dushanbe', 'UTC+05:00'),
(265, 'Asia/Famagusta', 'UTC+03:00'),
(266, 'Asia/Gaza', 'UTC+03:00'),
(267, 'Asia/Harbin', 'UTC+08:00'),
(268, 'Asia/Hebron', 'UTC+03:00'),
(269, 'Asia/Ho_Chi_Minh', 'UTC+07:00'),
(270, 'Asia/Hong_Kong', 'UTC+08:00'),
(271, 'Asia/Hovd', 'UTC+07:00'),
(272, 'Asia/Irkutsk', 'UTC+08:00'),
(273, 'Asia/Istanbul', 'UTC+03:00'),
(274, 'Asia/Jakarta', 'UTC+07:00'),
(275, 'Asia/Jayapura', 'UTC+09:00'),
(276, 'Asia/Jerusalem', 'UTC+03:00'),
(277, 'Asia/Kabul', 'UTC+04:30'),
(278, 'Asia/Kamchatka', 'UTC+12:00'),
(279, 'Asia/Karachi', 'UTC+05:00'),
(280, 'Asia/Kashgar', 'UTC+06:00'),
(281, 'Asia/Kathmandu', 'UTC+05:45'),
(282, 'Asia/Katmandu', 'UTC+05:45'),
(283, 'Asia/Khandyga', 'UTC+09:00'),
(284, 'Asia/Kolkata', 'UTC+05:30'),
(285, 'Asia/Krasnoyarsk', 'UTC+07:00'),
(286, 'Asia/Kuala_Lumpur', 'UTC+08:00'),
(287, 'Asia/Kuching', 'UTC+08:00'),
(288, 'Asia/Kuwait', 'UTC+03:00'),
(289, 'Asia/Macao', 'UTC+08:00'),
(290, 'Asia/Macau', 'UTC+08:00'),
(291, 'Asia/Magadan', 'UTC+11:00'),
(292, 'Asia/Makassar', 'UTC+08:00'),
(293, 'Asia/Manila', 'UTC+08:00'),
(294, 'Asia/Muscat', 'UTC+04:00'),
(295, 'Asia/Nicosia', 'UTC+03:00'),
(296, 'Asia/Novokuznetsk', 'UTC+07:00'),
(297, 'Asia/Novosibirsk', 'UTC+07:00'),
(298, 'Asia/Omsk', 'UTC+06:00'),
(299, 'Asia/Oral', 'UTC+05:00'),
(300, 'Asia/Phnom_Penh', 'UTC+07:00'),
(301, 'Asia/Pontianak', 'UTC+07:00'),
(302, 'Asia/Pyongyang', 'UTC+09:00'),
(303, 'Asia/Qatar', 'UTC+03:00'),
(304, 'Asia/Qostanay', 'UTC+05:00'),
(305, 'Asia/Qyzylorda', 'UTC+05:00'),
(306, 'Asia/Rangoon', 'UTC+06:30'),
(307, 'Asia/Riyadh', 'UTC+03:00'),
(308, 'Asia/Saigon', 'UTC+07:00'),
(309, 'Asia/Sakhalin', 'UTC+11:00'),
(310, 'Asia/Samarkand', 'UTC+05:00'),
(311, 'Asia/Seoul', 'UTC+09:00'),
(312, 'Asia/Shanghai', 'UTC+08:00'),
(313, 'Asia/Singapore', 'UTC+08:00'),
(314, 'Asia/Srednekolymsk', 'UTC+11:00'),
(315, 'Asia/Taipei', 'UTC+08:00'),
(316, 'Asia/Tashkent', 'UTC+05:00'),
(317, 'Asia/Tbilisi', 'UTC+04:00'),
(318, 'Asia/Tehran', 'UTC+03:30'),
(319, 'Asia/Tel_Aviv', 'UTC+03:00'),
(320, 'Asia/Thimbu', 'UTC+06:00'),
(321, 'Asia/Thimphu', 'UTC+06:00'),
(322, 'Asia/Tokyo', 'UTC+09:00'),
(323, 'Asia/Tomsk', 'UTC+07:00'),
(324, 'Asia/Ujung_Pandang', 'UTC+08:00'),
(325, 'Asia/Ulaanbaatar', 'UTC+08:00'),
(326, 'Asia/Ulan_Bator', 'UTC+08:00'),
(327, 'Asia/Urumqi', 'UTC+06:00'),
(328, 'Asia/Ust-Nera', 'UTC+10:00'),
(329, 'Asia/Vientiane', 'UTC+07:00'),
(330, 'Asia/Vladivostok', 'UTC+10:00'),
(331, 'Asia/Yakutsk', 'UTC+09:00'),
(332, 'Asia/Yangon', 'UTC+06:30'),
(333, 'Asia/Yekaterinburg', 'UTC+05:00'),
(334, 'Asia/Yerevan', 'UTC+04:00'),
(335, 'Atlantic/Azores', 'UTC+00:00'),
(336, 'Atlantic/Bermuda', 'UTC-03:00'),
(337, 'Atlantic/Canary', 'UTC+01:00'),
(338, 'Atlantic/Cape_Verde', 'UTC-01:00'),
(339, 'Atlantic/Faeroe', 'UTC+01:00'),
(340, 'Atlantic/Faroe', 'UTC+01:00'),
(341, 'Atlantic/Jan_Mayen', 'UTC+02:00'),
(342, 'Atlantic/Madeira', 'UTC+01:00'),
(343, 'Atlantic/Reykjavik', 'UTC+00:00'),
(344, 'Atlantic/South_Georgia', 'UTC-02:00'),
(345, 'Atlantic/St_Helena', 'UTC+00:00'),
(346, 'Atlantic/Stanley', 'UTC-03:00'),
(347, 'Australia/ACT', 'UTC+11:00'),
(348, 'Australia/Adelaide', 'UTC+10:30'),
(349, 'Australia/Brisbane', 'UTC+10:00'),
(350, 'Australia/Broken_Hill', 'UTC+10:30'),
(351, 'Australia/Canberra', 'UTC+11:00'),
(352, 'Australia/Currie', 'UTC+11:00'),
(353, 'Australia/Darwin', 'UTC+09:30'),
(354, 'Australia/Eucla', 'UTC+08:45'),
(355, 'Australia/Hobart', 'UTC+11:00'),
(356, 'Australia/LHI', 'UTC+11:00'),
(357, 'Australia/Lindeman', 'UTC+10:00'),
(358, 'Australia/Lord_Howe', 'UTC+11:00'),
(359, 'Australia/Melbourne', 'UTC+11:00'),
(360, 'Australia/NSW', 'UTC+11:00'),
(361, 'Australia/North', 'UTC+09:30'),
(362, 'Australia/Perth', 'UTC+08:00'),
(363, 'Australia/Queensland', 'UTC+10:00'),
(364, 'Australia/South', 'UTC+10:30'),
(365, 'Australia/Sydney', 'UTC+11:00'),
(366, 'Australia/Tasmania', 'UTC+11:00'),
(367, 'Australia/Victoria', 'UTC+11:00'),
(368, 'Australia/West', 'UTC+08:00'),
(369, 'Australia/Yancowinna', 'UTC+10:30'),
(370, 'Brazil/Acre', 'UTC-05:00'),
(371, 'Brazil/DeNoronha', 'UTC-02:00'),
(372, 'Brazil/East', 'UTC-03:00'),
(373, 'Brazil/West', 'UTC-04:00'),
(374, 'CET', 'UTC+02:00'),
(375, 'CST6CDT', 'UTC-05:00'),
(376, 'Canada/Atlantic', 'UTC-03:00'),
(377, 'Canada/Central', 'UTC-05:00'),
(378, 'Canada/Eastern', 'UTC-04:00'),
(379, 'Canada/Mountain', 'UTC-06:00'),
(380, 'Canada/Newfoundland', 'UTC-02:30'),
(381, 'Canada/Pacific', 'UTC-07:00'),
(382, 'Canada/Saskatchewan', 'UTC-06:00'),
(383, 'Canada/Yukon', 'UTC-07:00'),
(384, 'Chile/Continental', 'UTC-03:00'),
(385, 'Chile/EasterIsland', 'UTC-05:00'),
(386, 'Cuba', 'UTC-04:00'),
(387, 'EET', 'UTC+03:00'),
(388, 'EST', 'UTC-05:00'),
(389, 'EST5EDT', 'UTC-04:00'),
(390, 'Egypt', 'UTC+03:00'),
(391, 'Eire', 'UTC+01:00'),
(392, 'Etc/GMT', 'UTC+00:00'),
(393, 'Etc/GMT+0', 'UTC+00:00'),
(394, 'Etc/GMT+1', 'UTC-01:00'),
(395, 'Etc/GMT+10', 'UTC-10:00'),
(396, 'Etc/GMT+11', 'UTC-11:00'),
(397, 'Etc/GMT+12', 'UTC-12:00'),
(398, 'Etc/GMT+2', 'UTC-02:00'),
(399, 'Etc/GMT+3', 'UTC-03:00'),
(400, 'Etc/GMT+4', 'UTC-04:00'),
(401, 'Etc/GMT+5', 'UTC-05:00'),
(402, 'Etc/GMT+6', 'UTC-06:00'),
(403, 'Etc/GMT+7', 'UTC-07:00'),
(404, 'Etc/GMT+8', 'UTC-08:00'),
(405, 'Etc/GMT+9', 'UTC-09:00'),
(406, 'Etc/GMT-0', 'UTC+00:00'),
(407, 'Etc/GMT-1', 'UTC+01:00'),
(408, 'Etc/GMT-10', 'UTC+10:00'),
(409, 'Etc/GMT-11', 'UTC+11:00'),
(410, 'Etc/GMT-12', 'UTC+12:00'),
(411, 'Etc/GMT-13', 'UTC+13:00'),
(412, 'Etc/GMT-14', 'UTC+14:00'),
(413, 'Etc/GMT-2', 'UTC+02:00'),
(414, 'Etc/GMT-3', 'UTC+03:00'),
(415, 'Etc/GMT-4', 'UTC+04:00'),
(416, 'Etc/GMT-5', 'UTC+05:00'),
(417, 'Etc/GMT-6', 'UTC+06:00'),
(418, 'Etc/GMT-7', 'UTC+07:00'),
(419, 'Etc/GMT-8', 'UTC+08:00'),
(420, 'Etc/GMT-9', 'UTC+09:00'),
(421, 'Etc/GMT0', 'UTC+00:00'),
(422, 'Etc/Greenwich', 'UTC+00:00'),
(423, 'Etc/UCT', 'UTC+00:00'),
(424, 'Etc/UTC', 'UTC+00:00'),
(425, 'Etc/Universal', 'UTC+00:00'),
(426, 'Etc/Zulu', 'UTC+00:00'),
(427, 'Europe/Amsterdam', 'UTC+02:00'),
(428, 'Europe/Andorra', 'UTC+02:00'),
(429, 'Europe/Astrakhan', 'UTC+04:00'),
(430, 'Europe/Athens', 'UTC+03:00'),
(431, 'Europe/Belfast', 'UTC+01:00'),
(432, 'Europe/Belgrade', 'UTC+02:00'),
(433, 'Europe/Berlin', 'UTC+02:00'),
(434, 'Europe/Bratislava', 'UTC+02:00'),
(435, 'Europe/Brussels', 'UTC+02:00'),
(436, 'Europe/Bucharest', 'UTC+03:00'),
(437, 'Europe/Budapest', 'UTC+02:00'),
(438, 'Europe/Busingen', 'UTC+02:00'),
(439, 'Europe/Chisinau', 'UTC+03:00'),
(440, 'Europe/Copenhagen', 'UTC+02:00'),
(441, 'Europe/Dublin', 'UTC+01:00'),
(442, 'Europe/Gibraltar', 'UTC+02:00'),
(443, 'Europe/Guernsey', 'UTC+01:00'),
(444, 'Europe/Helsinki', 'UTC+03:00'),
(445, 'Europe/Isle_of_Man', 'UTC+01:00'),
(446, 'Europe/Istanbul', 'UTC+03:00'),
(447, 'Europe/Jersey', 'UTC+01:00'),
(448, 'Europe/Kaliningrad', 'UTC+02:00'),
(449, 'Europe/Kiev', 'UTC+03:00'),
(450, 'Europe/Kirov', 'UTC+03:00'),
(451, 'Europe/Kyiv', 'UTC+03:00'),
(452, 'Europe/Lisbon', 'UTC+01:00'),
(453, 'Europe/Ljubljana', 'UTC+02:00'),
(454, 'Europe/London', 'UTC+01:00'),
(455, 'Europe/Luxembourg', 'UTC+02:00'),
(456, 'Europe/Madrid', 'UTC+02:00'),
(457, 'Europe/Malta', 'UTC+02:00'),
(458, 'Europe/Mariehamn', 'UTC+03:00'),
(459, 'Europe/Minsk', 'UTC+03:00'),
(460, 'Europe/Monaco', 'UTC+02:00'),
(461, 'Europe/Moscow', 'UTC+03:00'),
(462, 'Europe/Nicosia', 'UTC+03:00'),
(463, 'Europe/Oslo', 'UTC+02:00'),
(464, 'Europe/Paris', 'UTC+02:00'),
(465, 'Europe/Podgorica', 'UTC+02:00'),
(466, 'Europe/Prague', 'UTC+02:00'),
(467, 'Europe/Riga', 'UTC+03:00'),
(468, 'Europe/Rome', 'UTC+02:00'),
(469, 'Europe/Samara', 'UTC+04:00'),
(470, 'Europe/San_Marino', 'UTC+02:00'),
(471, 'Europe/Sarajevo', 'UTC+02:00'),
(472, 'Europe/Saratov', 'UTC+04:00'),
(473, 'Europe/Simferopol', 'UTC+03:00'),
(474, 'Europe/Skopje', 'UTC+02:00'),
(475, 'Europe/Sofia', 'UTC+03:00'),
(476, 'Europe/Stockholm', 'UTC+02:00'),
(477, 'Europe/Tallinn', 'UTC+03:00'),
(478, 'Europe/Tirane', 'UTC+02:00'),
(479, 'Europe/Tiraspol', 'UTC+03:00'),
(480, 'Europe/Ulyanovsk', 'UTC+04:00'),
(481, 'Europe/Uzhgorod', 'UTC+03:00'),
(482, 'Europe/Vaduz', 'UTC+02:00'),
(483, 'Europe/Vatican', 'UTC+02:00'),
(484, 'Europe/Vienna', 'UTC+02:00'),
(485, 'Europe/Vilnius', 'UTC+03:00'),
(486, 'Europe/Volgograd', 'UTC+03:00'),
(487, 'Europe/Warsaw', 'UTC+02:00'),
(488, 'Europe/Zagreb', 'UTC+02:00'),
(489, 'Europe/Zaporozhye', 'UTC+03:00'),
(490, 'Europe/Zurich', 'UTC+02:00'),
(491, 'GB', 'UTC+01:00'),
(492, 'GB-Eire', 'UTC+01:00'),
(493, 'GMT', 'UTC+00:00'),
(494, 'GMT+0', 'UTC+00:00'),
(495, 'GMT-0', 'UTC+00:00'),
(496, 'GMT0', 'UTC+00:00'),
(497, 'Greenwich', 'UTC+00:00'),
(498, 'HST', 'UTC-10:00'),
(499, 'Hongkong', 'UTC+08:00'),
(500, 'Iceland', 'UTC+00:00'),
(501, 'Indian/Antananarivo', 'UTC+03:00'),
(502, 'Indian/Chagos', 'UTC+06:00'),
(503, 'Indian/Christmas', 'UTC+07:00'),
(504, 'Indian/Cocos', 'UTC+06:30'),
(505, 'Indian/Comoro', 'UTC+03:00'),
(506, 'Indian/Kerguelen', 'UTC+05:00'),
(507, 'Indian/Mahe', 'UTC+04:00'),
(508, 'Indian/Maldives', 'UTC+05:00'),
(509, 'Indian/Mauritius', 'UTC+04:00'),
(510, 'Indian/Mayotte', 'UTC+03:00'),
(511, 'Indian/Reunion', 'UTC+04:00'),
(512, 'Iran', 'UTC+03:30'),
(513, 'Israel', 'UTC+03:00'),
(514, 'Jamaica', 'UTC-05:00'),
(515, 'Japan', 'UTC+09:00'),
(516, 'Kwajalein', 'UTC+12:00'),
(517, 'Libya', 'UTC+02:00'),
(518, 'MET', 'UTC+02:00'),
(519, 'MST', 'UTC-07:00'),
(520, 'MST7MDT', 'UTC-06:00'),
(521, 'Mexico/BajaNorte', 'UTC-07:00'),
(522, 'Mexico/BajaSur', 'UTC-07:00'),
(523, 'Mexico/General', 'UTC-06:00'),
(524, 'NZ', 'UTC+13:00'),
(525, 'NZ-CHAT', 'UTC+13:45'),
(526, 'Navajo', 'UTC-06:00'),
(527, 'PRC', 'UTC+08:00'),
(528, 'PST8PDT', 'UTC-07:00'),
(529, 'Pacific/Apia', 'UTC+13:00'),
(530, 'Pacific/Auckland', 'UTC+13:00'),
(531, 'Pacific/Bougainville', 'UTC+11:00'),
(532, 'Pacific/Chatham', 'UTC+13:45'),
(533, 'Pacific/Chuuk', 'UTC+10:00'),
(534, 'Pacific/Easter', 'UTC-05:00'),
(535, 'Pacific/Efate', 'UTC+11:00'),
(536, 'Pacific/Enderbury', 'UTC+13:00'),
(537, 'Pacific/Fakaofo', 'UTC+13:00'),
(538, 'Pacific/Fiji', 'UTC+12:00'),
(539, 'Pacific/Funafuti', 'UTC+12:00'),
(540, 'Pacific/Galapagos', 'UTC-06:00'),
(541, 'Pacific/Gambier', 'UTC-09:00'),
(542, 'Pacific/Guadalcanal', 'UTC+11:00'),
(543, 'Pacific/Guam', 'UTC+10:00'),
(544, 'Pacific/Honolulu', 'UTC-10:00'),
(545, 'Pacific/Johnston', 'UTC-10:00'),
(546, 'Pacific/Kanton', 'UTC+13:00'),
(547, 'Pacific/Kiritimati', 'UTC+14:00'),
(548, 'Pacific/Kosrae', 'UTC+11:00'),
(549, 'Pacific/Kwajalein', 'UTC+12:00'),
(550, 'Pacific/Majuro', 'UTC+12:00'),
(551, 'Pacific/Marquesas', 'UTC-09:30'),
(552, 'Pacific/Midway', 'UTC-11:00'),
(553, 'Pacific/Nauru', 'UTC+12:00'),
(554, 'Pacific/Niue', 'UTC-11:00'),
(555, 'Pacific/Norfolk', 'UTC+12:00'),
(556, 'Pacific/Noumea', 'UTC+11:00'),
(557, 'Pacific/Pago_Pago', 'UTC-11:00'),
(558, 'Pacific/Palau', 'UTC+09:00'),
(559, 'Pacific/Pitcairn', 'UTC-08:00'),
(560, 'Pacific/Pohnpei', 'UTC+11:00'),
(561, 'Pacific/Ponape', 'UTC+11:00'),
(562, 'Pacific/Port_Moresby', 'UTC+10:00'),
(563, 'Pacific/Rarotonga', 'UTC-10:00'),
(564, 'Pacific/Saipan', 'UTC+10:00'),
(565, 'Pacific/Samoa', 'UTC-11:00'),
(566, 'Pacific/Tahiti', 'UTC-10:00'),
(567, 'Pacific/Tarawa', 'UTC+12:00'),
(568, 'Pacific/Tongatapu', 'UTC+13:00'),
(569, 'Pacific/Truk', 'UTC+10:00'),
(570, 'Pacific/Wake', 'UTC+12:00'),
(571, 'Pacific/Wallis', 'UTC+12:00'),
(572, 'Pacific/Yap', 'UTC+10:00'),
(573, 'Poland', 'UTC+02:00'),
(574, 'Portugal', 'UTC+01:00'),
(575, 'ROC', 'UTC+08:00'),
(576, 'ROK', 'UTC+09:00'),
(577, 'Singapore', 'UTC+08:00'),
(578, 'Turkey', 'UTC+03:00'),
(579, 'UCT', 'UTC+00:00'),
(580, 'US/Alaska', 'UTC-08:00'),
(581, 'US/Aleutian', 'UTC-09:00'),
(582, 'US/Arizona', 'UTC-07:00'),
(583, 'US/Central', 'UTC-05:00'),
(584, 'US/East-Indiana', 'UTC-04:00'),
(585, 'US/Eastern', 'UTC-04:00'),
(586, 'US/Hawaii', 'UTC-10:00'),
(587, 'US/Indiana-Starke', 'UTC-05:00'),
(588, 'US/Michigan', 'UTC-04:00'),
(589, 'US/Mountain', 'UTC-06:00'),
(590, 'US/Pacific', 'UTC-07:00'),
(591, 'US/Samoa', 'UTC-11:00'),
(592, 'UTC', 'UTC+00:00'),
(593, 'Universal', 'UTC+00:00'),
(594, 'W-SU', 'UTC+03:00'),
(595, 'WET', 'UTC+01:00'),
(596, 'Zulu', 'UTC+00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_password_reset_code` varchar(250) DEFAULT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_phone` varchar(20) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `user_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `user_password_reset_code`, `user_email`, `user_phone`, `role_id`, `user_created_at`, `user_updated_at`) VALUES
(33, 'Test', '$2y$10$TNwhfyAZUoCM8RObT.LxA.softNK88.FTwIsYBRkKZqUtnyXF1upi', '763298', 'test@mail.com', 'wf', NULL, '2025-03-12 15:17:37', '2025-03-13 08:20:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`chat_message_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `agreement_id` (`agreement_id`);

--
-- Indexes for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  ADD PRIMARY KEY (`maintenance_request_id`),
  ADD KEY `agreement_id` (`agreement_id`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`notice_id`),
  ADD KEY `posted_by` (`posted_by`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `rental_agreements`
--
ALTER TABLE `rental_agreements`
  ADD PRIMARY KEY (`agreement_id`),
  ADD KEY `renter_id` (`renter_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `property_manager_id` (`property_manager_id`);

--
-- Indexes for table `timezones`
--
ALTER TABLE `timezones`
  ADD PRIMARY KEY (`timezone_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_username` (`user_name`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `chat_message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  MODIFY `maintenance_request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `notice_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rental_agreements`
--
ALTER TABLE `rental_agreements`
  MODIFY `agreement_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timezones`
--
ALTER TABLE `timezones`
  MODIFY `timezone_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=597;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `chat_messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`agreement_id`) REFERENCES `rental_agreements` (`agreement_id`);

--
-- Constraints for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  ADD CONSTRAINT `maintenance_requests_ibfk_1` FOREIGN KEY (`agreement_id`) REFERENCES `rental_agreements` (`agreement_id`),
  ADD CONSTRAINT `maintenance_requests_ibfk_2` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `notices`
--
ALTER TABLE `notices`
  ADD CONSTRAINT `notices_ibfk_1` FOREIGN KEY (`posted_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`invoice_id`);

--
-- Constraints for table `rental_agreements`
--
ALTER TABLE `rental_agreements`
  ADD CONSTRAINT `rental_agreements_ibfk_1` FOREIGN KEY (`renter_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `rental_agreements_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`);

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`property_manager_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
