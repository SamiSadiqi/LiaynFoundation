-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2020 at 12:56 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `liyan_foundation`
--

-- --------------------------------------------------------

--
-- Table structure for table `h_tbl_districts`
--

CREATE TABLE IF NOT EXISTS `h_tbl_districts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` smallint(6) DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `defaults` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `h_tbl_helps_transactions`
--

CREATE TABLE IF NOT EXISTS `h_tbl_helps_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(60) NOT NULL,
  `name` varchar(100) NOT NULL,
  `father` varchar(300) NOT NULL,
  `SSN` varchar(60) NOT NULL,
  `staffs_id` int(11) NOT NULL,
  `contact` varchar(30) NOT NULL,
  `districts_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `distributed_id` int(11) NOT NULL DEFAULT '0',
  `distributed_time` varchar(200) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` smallint(6) DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `defaults` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `h_tbl_staff_managers`
--

CREATE TABLE IF NOT EXISTS `h_tbl_staff_managers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `date` varchar(60) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` smallint(6) DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `defaults` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_assets`
--

CREATE TABLE IF NOT EXISTS `tbl_assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `asset_types_id` int(11) NOT NULL,
  `cost` double(10,2) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double(16,4) NOT NULL,
  `banks_id` int(11) NOT NULL,
  `useful_age` int(10) DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `home_amount` double(10,2) NOT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_asset_types`
--

CREATE TABLE IF NOT EXISTS `tbl_asset_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL,
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_backup`
--

CREATE TABLE IF NOT EXISTS `tbl_backup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL,
  `verified` int(11) NOT NULL DEFAULT '1',
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_banks`
--

CREATE TABLE IF NOT EXISTS `tbl_banks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `category_id` int(11) NOT NULL,
  `date` varchar(20) NOT NULL,
  `opening_balance` double NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double NOT NULL,
  `home_amount` double NOT NULL,
  `description` text NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_banks`
--

INSERT INTO `tbl_banks` (`id`, `name`, `category_id`, `date`, `opening_balance`, `currencies_id`, `rate`, `home_amount`, `description`, `deleted`, `defaults`, `removed_by`, `created_at`, `changed_at`, `users_id`) VALUES
(2, 'عزیزی بانک 2', 3, '1399-06-29', 2000, 3, 0.0128, 25.6, 'اینجا لندن است', 0, 0, 0, 1600508658, NULL, 22);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_banks_category`
--

CREATE TABLE IF NOT EXISTS `tbl_banks_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `users_id` int(11) NOT NULL,
  `verified` int(11) NOT NULL,
  `verified_by` int(11) NOT NULL,
  `deleted` smallint(6) DEFAULT NULL,
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_banks_category`
--

INSERT INTO `tbl_banks_category` (`id`, `name`, `users_id`, `verified`, `verified_by`, `deleted`, `defaults`, `removed_by`, `created_at`, `changed_at`) VALUES
(1, 'عزیزی بانک2', 22, 0, 0, 1, 0, 22, 1600507884, NULL),
(2, 'عزیزی بانک', 22, 0, 0, 0, 0, 0, 1600508096, NULL),
(3, 'کابل بانک', 22, 1, 0, 0, 0, 0, 1600508642, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bank_exchange`
--

CREATE TABLE IF NOT EXISTS `tbl_bank_exchange` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(40) NOT NULL,
  `source_bank_id` int(11) NOT NULL,
  `destination_banks_id` int(11) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `des_currencies_id` int(11) NOT NULL,
  `exchange_rate` double(10,8) NOT NULL,
  `amount` double(11,2) NOT NULL,
  `des_amount` double(10,2) NOT NULL,
  `description` text NOT NULL,
  `approved` int(11) NOT NULL DEFAULT '1',
  `home_amount` double(10,2) NOT NULL,
  `des_home_amount` double(10,2) NOT NULL,
  `rate` double(10,8) NOT NULL,
  `des_rate` double(10,8) NOT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `verified` int(11) NOT NULL,
  `verified_by` int(11) NOT NULL,
  `check_cash` varchar(40) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bank_statement`
--

CREATE TABLE IF NOT EXISTS `tbl_bank_statement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `place` varchar(100) NOT NULL,
  `reference` varchar(100) NOT NULL,
  `transaction_type` int(11) NOT NULL,
  `amount` double(34,2) NOT NULL,
  `banks_id` int(11) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double(10,5) DEFAULT NULL,
  `home_amount` double(20,2) NOT NULL,
  `description` text NOT NULL,
  `categories_id` int(11) DEFAULT NULL,
  `sub_categories_id` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `tbl_bank_statement`
--

INSERT INTO `tbl_bank_statement` (`id`, `date`, `place`, `reference`, `transaction_type`, `amount`, `banks_id`, `currencies_id`, `rate`, `home_amount`, `description`, `categories_id`, `sub_categories_id`, `deleted`, `removed_by`, `created_at`, `changed_at`, `users_id`) VALUES
(1, '', 'Support Ceremonies', '', 2, 16200.00, 2, 3, 0.01280, 207.36, 'چاپ بنیر  و چاچ تحسین نامه ها', NULL, NULL, 0, 0, 0, NULL, 22),
(2, '', 'Support Ceremonies', '', 2, 2000.00, 0, 3, 0.01280, 25.60, 'خرید ده بسته ماسک', NULL, NULL, 0, 0, 0, NULL, 22),
(3, '1399-07-26', 'Support Ceremonies', '', 2, 1000.00, 2, 3, 0.01280, 12.80, 'زل ضد عفونی کننده، به خاطر ضد عفونی کردن دست ها', NULL, NULL, 0, 0, 0, NULL, 22),
(4, '1399-07-26', 'School Expense Transaction', '1', 2, 4000.00, 2, 3, 0.01280, 51.20, 'شما که میدانید این یک کار خیر است', 1, NULL, 0, 0, 0, NULL, 22),
(5, '1399-07-26', 'Materials Distribution', '1', 2, 121700.00, 2, 3, 0.01280, 1557.76, '', 1, NULL, 0, 0, 1602933650, NULL, 22),
(6, '1399-08-04', 'Support Ceremonies', '', 2, 500.00, 2, 3, 0.01280, 6.40, 'ما به این دنیا همه‌ی کارهای نیک را انجام  داده بودیم که انسانی خوبی بودیم', NULL, NULL, 0, 0, 0, NULL, 22),
(7, '1399-08-04', 'Materials Distribution', '2', 2, 17000.00, 2, 3, 0.01280, 217.60, '', 3, NULL, 0, 0, 1603620382, NULL, 22),
(8, '1399-08-04', 'Support Ceremonies', '', 2, 20000.00, 2, 3, 0.01280, 256.00, '', NULL, NULL, 0, 0, 0, NULL, 22),
(9, '1399-08-04', 'Materials Distribution', '3', 2, 21600.00, 2, 3, 0.01280, 276.48, '', 4, NULL, 0, 0, 1603621334, NULL, 22),
(10, '1399-08-04', 'School Expense Transaction', '2', 2, 4000.00, 2, 3, 0.01280, 51.20, '', 4, NULL, 0, 0, 0, NULL, 22),
(11, '1399-08-04', 'Support Ceremonies', '', 2, 200.00, 2, 3, 0.01280, 2.56, 'توضیحات را باید، صحیح برسانیم', NULL, NULL, 0, 0, 0, NULL, 22),
(12, '1399-08-05', 'Support Ceremonies', '', 2, 30000.00, 2, 3, 0.01280, 384.00, 'این یک محل اتصال برای همه هست', NULL, NULL, 0, 0, 0, NULL, 22),
(13, '1399-08-05', 'Materials Distribution', '4', 2, 6900.00, 2, 3, 0.01280, 88.32, '', 4, NULL, 0, 0, 1603692991, NULL, 22),
(14, '1399-08-05', 'School Expense Transaction', '3', 2, 400.00, 2, 3, 0.01280, 5.12, 'این مصرف به خاطر تعمیرات است', 4, NULL, 0, 0, 0, NULL, 22),
(15, '1399-08-05', 'School Expense Transaction', '4', 2, 3000.00, 2, 3, 0.01280, 38.40, 'این یک دنیای خوبی نیست، سراسر غم  و مشکلات در این دیده می‌شود.', 4, NULL, 0, 0, 0, NULL, 22),
(16, '1399-08-05', 'Support Ceremonies', '', 2, 3000.00, 2, 3, 0.01280, 38.40, 'این دگه چی رقم است', NULL, NULL, 0, 0, 0, NULL, 22);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_constructions_type`
--

CREATE TABLE IF NOT EXISTS `tbl_constructions_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` smallint(6) DEFAULT NULL,
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_constructions_type`
--

INSERT INTO `tbl_constructions_type` (`id`, `name`, `users_id`, `deleted`, `defaults`, `removed_by`, `created_at`, `changed_at`) VALUES
(1, 'تعمیر خیمه', 22, 0, 0, 0, 1603620180, NULL),
(2, 'تعمیر میز و چوکی', 22, 0, 0, 0, 1603621183, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_currencies`
--

CREATE TABLE IF NOT EXISTS `tbl_currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `code` char(40) DEFAULT NULL,
  `deleted` smallint(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `verified` int(11) NOT NULL DEFAULT '1',
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_currency_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=168 ;

--
-- Dumping data for table `tbl_currencies`
--

INSERT INTO `tbl_currencies` (`id`, `name`, `code`, `deleted`, `removed_by`, `verified`, `users_id`) VALUES
(1, 'Andorran Peseta', 'ADP', 1, 0, 1, 1),
(2, 'United Arab Emirates Dirham', 'AED', 1, 22, 1, 1),
(3, 'Afghanistan Afghani', 'افغانی', 0, 0, 1, 1),
(4, 'Albanian Lek', 'ALL', 1, 0, 1, 1),
(5, 'Netherlands Antillian Guilder', 'ANG', 1, 0, 1, 1),
(6, 'Angolan Kwanza', 'AOK', 1, 0, 1, 1),
(7, 'Argentine Peso', 'ARS', 1, 0, 1, 1),
(9, 'Australian Dollar', 'AUD', 1, 0, 1, 1),
(10, 'Aruban Florin', 'AWG', 1, 0, 1, 1),
(11, 'Barbados Dollar', 'BBD', 1, 0, 1, 1),
(12, 'Bangladeshi Taka', 'BDT', 1, 0, 1, 1),
(14, 'Bulgarian Lev', 'BGN', 1, 0, 1, 1),
(15, 'Bahraini Dinar', 'BHD', 1, 0, 1, 1),
(16, 'Burundi Franc', 'BIF', 1, 0, 1, 1),
(17, 'Bermudian Dollar', 'BMD', 1, 0, 1, 1),
(18, 'Brunei Dollar', 'BND', 1, 0, 1, 1),
(19, 'Bolivian Boliviano', 'BOB', 1, 0, 1, 1),
(20, 'Brazilian Real', 'BRL', 1, 0, 1, 1),
(21, 'Bahamian Dollar', 'BSD', 1, 0, 1, 1),
(22, 'Bhutan Ngultrum', 'BTN', 1, 0, 1, 1),
(23, 'Burma Kyat', 'BUK', 1, 0, 1, 1),
(24, 'Botswanian Pula', 'BWP', 1, 0, 1, 1),
(25, 'Belize Dollar', 'BZD', 1, 0, 1, 1),
(26, 'Canadian Dollar', 'CAD', 1, 0, 1, 1),
(27, 'Swiss Franc', 'CHF', 1, 0, 1, 1),
(28, 'Chilean Unidades de Fomento', 'CLF', 1, 0, 1, 1),
(29, 'Chilean Peso', 'CLP', 1, 0, 1, 1),
(30, 'Yuan (Chinese) Renminbi', 'CNY', 1, 0, 1, 1),
(31, 'Colombian Peso', 'COP', 1, 0, 1, 1),
(32, 'Costa Rican Colon', 'CRC', 1, 0, 1, 1),
(33, 'Czech Republic Koruna', 'CZK', 1, 0, 1, 1),
(34, 'Cuban Peso', 'CUP', 1, 0, 1, 1),
(35, 'Cape Verde Escudo', 'CVE', 1, 0, 1, 1),
(36, 'Cyprus Pound', 'CYP', 1, 0, 1, 1),
(40, 'Danish Krone', 'DKK', 1, 0, 1, 1),
(41, 'Dominican Peso', 'DOP', 1, 0, 1, 1),
(42, 'Algerian Dinar', 'DZD', 1, 0, 1, 1),
(43, 'Ecuador Sucre', 'ECS', 1, 0, 1, 1),
(44, 'Egyptian Pound', 'EGP', 1, 0, 1, 1),
(45, 'Estonian Kroon (EEK)', 'EEK', 1, 0, 1, 1),
(46, 'Ethiopian Birr', 'ETB', 1, 0, 1, 1),
(47, 'Euro', 'EUR', 1, 22, 1, 1),
(49, 'Fiji Dollar', 'FJD', 1, 0, 1, 1),
(50, 'Falkland Islands Pound', 'FKP', 1, 0, 1, 1),
(52, 'British Pound', 'GBP', 1, 0, 1, 1),
(53, 'Ghanaian Cedi', 'GHC', 1, 0, 1, 1),
(54, 'Gibraltar Pound', 'GIP', 1, 0, 1, 1),
(55, 'Gambian Dalasi', 'GMD', 1, 0, 1, 1),
(56, 'Guinea Franc', 'GNF', 1, 0, 1, 1),
(58, 'Guatemalan Quetzal', 'GTQ', 1, 0, 1, 1),
(59, 'Guinea-Bissau Peso', 'GWP', 1, 0, 1, 1),
(60, 'Guyanan Dollar', 'GYD', 1, 0, 1, 1),
(61, 'Hong Kong Dollar', 'HKD', 1, 0, 1, 1),
(62, 'Honduran Lempira', 'HNL', 1, 0, 1, 1),
(63, 'Haitian Gourde', 'HTG', 1, 0, 1, 1),
(64, 'Hungarian Forint', 'HUF', 1, 0, 1, 1),
(65, 'Indonesian Rupiah', 'IDR', 1, 0, 1, 1),
(66, 'Irish Punt', 'IEP', 1, 0, 1, 1),
(67, 'Israeli Shekel', 'ILS', 1, 0, 1, 1),
(68, 'Indian Rupee', 'INR', 1, 0, 1, 1),
(69, 'Iraqi Dinar', 'IQD', 1, 0, 1, 1),
(70, 'Iranian Rial', 'IRR', 1, 0, 1, 1),
(73, 'Jamaican Dollar', 'JMD', 1, 0, 1, 1),
(74, 'Jordanian Dinar', 'JOD', 1, 0, 1, 1),
(75, 'Japanese Yen', 'JPY', 1, 0, 1, 1),
(76, 'Kenyan Schilling', 'KES', 1, 0, 1, 1),
(77, 'Kampuchean (Cambodian) Riel', 'KHR', 1, 0, 1, 1),
(78, 'Comoros Franc', 'KMF', 1, 0, 1, 1),
(79, 'North Korean Won', 'KPW', 1, 0, 1, 1),
(80, '(South) Korean Won', 'KRW', 1, 0, 1, 1),
(81, 'Kuwaiti Dinar', 'KWD', 1, 0, 1, 1),
(82, 'Cayman Islands Dollar', 'KYD', 1, 0, 1, 1),
(83, 'Lao Kip', 'LAK', 1, 0, 1, 1),
(84, 'Lebanese Pound', 'LBP', 1, 0, 1, 1),
(85, 'Sri Lanka Rupee', 'LKR', 1, 0, 1, 1),
(86, 'Liberian Dollar', 'LRD', 1, 0, 1, 1),
(87, 'Lesotho Loti', 'LSL', 1, 0, 1, 1),
(89, 'Libyan Dinar', 'LYD', 1, 0, 1, 1),
(90, 'Moroccan Dirham', 'MAD', 1, 0, 1, 1),
(91, 'Malagasy Franc', 'MGF', 1, 0, 1, 1),
(92, 'Mongolian Tugrik', 'MNT', 1, 0, 1, 1),
(93, 'Macau Pataca', 'MOP', 1, 0, 1, 1),
(94, 'Mauritanian Ouguiya', 'MRO', 1, 0, 1, 1),
(95, 'Maltese Lira', 'MTL', 1, 0, 1, 1),
(96, 'Mauritius Rupee', 'MUR', 1, 0, 1, 1),
(97, 'Maldive Rufiyaa', 'MVR', 1, 0, 1, 1),
(98, 'Malawi Kwacha', 'MWK', 1, 0, 1, 1),
(99, 'Mexican Peso', 'MXP', 1, 0, 1, 1),
(100, 'Malaysian Ringgit', 'MYR', 1, 0, 1, 1),
(101, 'Mozambique Metical', 'MZM', 1, 0, 1, 1),
(102, 'Namibian Dollar', 'NAD', 1, 0, 1, 1),
(103, 'Nigerian Naira', 'NGN', 1, 0, 1, 1),
(104, 'Nicaraguan Cordoba', 'NIO', 1, 0, 1, 1),
(105, 'Norwegian Kroner', 'NOK', 1, 0, 1, 1),
(106, 'Nepalese Rupee', 'NPR', 1, 0, 1, 1),
(107, 'New Zealand Dollar', 'NZD', 1, 0, 1, 1),
(108, 'Omani Rial', 'OMR', 1, 0, 1, 1),
(109, 'Panamanian Balboa', 'PAB', 1, 0, 1, 1),
(110, 'Peruvian Nuevo Sol', 'PEN', 1, 0, 1, 1),
(111, 'Papua New Guinea Kina', 'PGK', 1, 0, 1, 1),
(112, 'Philippine Peso', 'PHP', 1, 0, 1, 1),
(113, 'Pakistan Rupee', 'PKR', 1, 22, 1, 1),
(114, 'Polish Zloty', 'PLN', 1, 0, 1, 1),
(116, 'Paraguay Guarani', 'PYG', 1, 0, 1, 1),
(117, 'Qatari Rial', 'QAR', 1, 0, 1, 1),
(118, 'Romanian Leu', 'RON', 1, 0, 1, 1),
(119, 'Rwanda Franc', 'RWF', 1, 0, 1, 1),
(120, 'Saudi Arabian Riyal', 'SAR', 1, 0, 1, 1),
(121, 'Solomon Islands Dollar', 'SBD', 1, 0, 1, 1),
(122, 'Seychelles Rupee', 'SCR', 1, 0, 1, 1),
(123, 'Sudanese Pound', 'SDP', 1, 0, 1, 1),
(124, 'Swedish Krona', 'SEK', 1, 0, 1, 1),
(125, 'Singapore Dollar', 'SGD', 1, 0, 1, 1),
(126, 'St. Helena Pound', 'SHP', 1, 0, 1, 1),
(127, 'Sierra Leone Leone', 'SLL', 1, 0, 1, 1),
(128, 'Somali Schilling', 'SOS', 1, 0, 1, 1),
(129, 'Suriname Guilder', 'SRG', 1, 0, 1, 1),
(130, 'Sao Tome and Principe Dobra', 'STD', 1, 0, 1, 1),
(131, 'Russian Ruble', 'RUB', 1, 0, 1, 1),
(132, 'El Salvador Colon', 'SVC', 1, 0, 1, 1),
(133, 'Syrian Potmd', 'SYP', 1, 0, 1, 1),
(134, 'Swaziland Lilangeni', 'SZL', 1, 0, 1, 1),
(135, 'Thai Baht', 'THB', 1, 0, 1, 1),
(136, 'Tunisian Dinar', 'TND', 1, 0, 1, 1),
(137, 'Tongan Paanga', 'TOP', 1, 0, 1, 1),
(138, 'East Timor Escudo', 'TPE', 1, 0, 1, 1),
(139, 'Turkish Lira', 'TRY', 1, 0, 1, 1),
(140, 'Trinidad and Tobago Dollar', 'TTD', 1, 0, 1, 1),
(141, 'Taiwan Dollar', 'TWD', 1, 0, 1, 1),
(142, 'Tanzanian Schilling', 'TZS', 1, 0, 1, 1),
(143, 'Uganda Shilling', 'UGX', 1, 0, 1, 1),
(144, 'US Dollar', 'دالر', 0, 0, 1, 1),
(145, 'Uruguayan Peso', 'UYU', 1, 0, 1, 1),
(146, 'Venezualan Bolivar', 'VEF', 1, 0, 1, 1),
(147, 'Vietnamese Dong', 'VND', 1, 0, 1, 1),
(148, 'Vanuatu Vatu', 'VUV', 1, 0, 1, 1),
(149, 'Samoan Tala', 'WST', 1, 0, 1, 1),
(150, 'CommunautÃƒÂ© FinanciÃƒÂ¨re Africaine BEAC, Francs', 'XAF', 1, 0, 1, 1),
(151, 'Silver, Ounces', 'XAG', 1, 0, 1, 1),
(152, 'Gold, Ounces', 'XAU', 1, 0, 1, 1),
(153, 'East Caribbean Dollar', 'XCD', 1, 0, 1, 1),
(154, 'International Monetary Fund (IMF) Special Drawing Rights', 'XDR', 1, 0, 1, 1),
(155, 'CommunautÃƒÂ© FinanciÃƒÂ¨re Africaine BCEAO - Francs', 'XOF', 1, 0, 1, 1),
(156, 'Palladium Ounces', 'XPD', 1, 0, 1, 1),
(157, 'Comptoirs FranÃƒÂ§ais du Pacifique Francs', 'XPF', 1, 0, 1, 1),
(158, 'Platinum, Ounces', 'XPT', 1, 0, 1, 1),
(159, 'Democratic Yemeni Dinar', 'YDD', 1, 0, 1, 1),
(160, 'Yemeni Rial', 'YER', 1, 0, 1, 1),
(161, 'New Yugoslavia Dinar', 'YUD', 1, 0, 1, 1),
(162, 'South African Rand', 'ZAR', 1, 0, 1, 1),
(163, 'Zambian Kwacha', 'ZMK', 1, 25, 1, 1),
(164, 'Zaire Zaire', 'ZRZ', 1, 0, 1, 1),
(165, 'Zimbabwe Dollar', 'ZWD', 1, 0, 1, 1),
(166, 'Slovak Koruna', 'SKK', 1, 25, 1, 1),
(167, 'Armenian Dram', 'AMD', 1, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_currency_rate`
--

CREATE TABLE IF NOT EXISTS `tbl_currency_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(40) COLLATE utf16_persian_ci NOT NULL,
  `rate` double(10,4) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` smallint(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) DEFAULT '0',
  `verified` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_persian_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_currency_rate`
--

INSERT INTO `tbl_currency_rate` (`id`, `date`, `rate`, `currencies_id`, `users_id`, `deleted`, `removed_by`, `verified`) VALUES
(1, '1399-01-10', 1.0000, 144, 25, 0, 0, 1),
(2, '1399-06-17', 0.0128, 3, 22, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dealers`
--

CREATE TABLE IF NOT EXISTS `tbl_dealers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `family` varchar(100) NOT NULL,
  `contact` varchar(45) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `address` text NOT NULL,
  `request_type` int(11) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dealer_statement`
--

CREATE TABLE IF NOT EXISTS `tbl_dealer_statement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `place` varchar(100) NOT NULL,
  `reference` varchar(100) NOT NULL,
  `transaction_type` int(11) NOT NULL,
  `amount` double NOT NULL,
  `dealers_id` int(11) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double NOT NULL,
  `home_amount` double NOT NULL,
  `description` text NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dealer_transaction`
--

CREATE TABLE IF NOT EXISTS `tbl_dealer_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(40) NOT NULL,
  `due_date` varchar(200) NOT NULL,
  `dealers_id` int(11) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `amount` decimal(20,0) NOT NULL,
  `rate` double NOT NULL,
  `banks_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `type` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `home_amount` double NOT NULL,
  `check_cash` varchar(50) NOT NULL,
  `users_id` int(11) NOT NULL,
  `approved` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '0',
  `request_type` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `verified` int(11) NOT NULL,
  `verified_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_districts`
--

CREATE TABLE IF NOT EXISTS `tbl_districts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL,
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_districts`
--

INSERT INTO `tbl_districts` (`id`, `name`, `deleted`, `defaults`, `removed_by`, `created_at`, `changed_at`, `users_id`) VALUES
(1, 'انجیل', 0, 0, 0, 1602915628, NULL, 22),
(2, 'زنده جان', 0, 0, 0, 1602915650, NULL, 22),
(3, 'معارف شهر', 0, 0, 0, 1602915673, NULL, 22),
(4, 'غوریان', 0, 0, 0, 1603618665, NULL, 22);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_donations_materials_details`
--

CREATE TABLE IF NOT EXISTS `tbl_donations_materials_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titles_id` int(11) NOT NULL,
  `items_id` int(11) NOT NULL,
  `stocks_id` int(11) DEFAULT NULL,
  `items_unit_id` int(11) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `fee` double(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tbl_donations_materials_details`
--

INSERT INTO `tbl_donations_materials_details` (`id`, `titles_id`, `items_id`, `stocks_id`, `items_unit_id`, `amount`, `fee`, `total_amount`, `description`, `users_id`, `deleted`, `removed_by`, `created_at`, `changed_at`) VALUES
(1, 1, 2, 1, 2, 34.00, 50.00, '1700.00', 'این یک آدم پستی بوده است ', 22, 0, 0, 1602933650, NULL),
(2, 1, 1, 1, 1, 4000.00, 30.00, '120000.00', 'بیب', 22, 0, 0, 1602933650, NULL),
(3, 2, 1, 1, 1, 300.00, 30.00, '9000.00', 'ای علم تو بوده است، که راه را طولانی فکر کرده بودی.', 22, 0, 0, 1603620382, NULL),
(4, 2, 2, 1, 2, 400.00, 20.00, '8000.00', 'ما این تخته ها را فروخته ایم ', 22, 0, 0, 1603620382, NULL),
(5, 3, 2, 1, 2, 10.00, 2000.00, '20000.00', '', 22, 0, 0, 1603621334, NULL),
(6, 3, 1, 1, 1, 2.00, 800.00, '1600.00', '', 22, 0, 0, 1603621334, NULL),
(7, 4, 2, 1, 2, 300.00, 23.00, '6900.00', 'این جان لندن است', 22, 0, 0, 1603692991, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_donations_materials_title`
--

CREATE TABLE IF NOT EXISTS `tbl_donations_materials_title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `schools_id` int(11) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double NOT NULL,
  `request_number` varchar(50) NOT NULL,
  `banks_id` int(11) NOT NULL,
  `factor_price` double(20,2) NOT NULL,
  `description` text NOT NULL,
  `home_amount` double(16,2) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_donations_materials_title`
--

INSERT INTO `tbl_donations_materials_title` (`id`, `date`, `schools_id`, `currencies_id`, `rate`, `request_number`, `banks_id`, `factor_price`, `description`, `home_amount`, `users_id`, `deleted`, `removed_by`, `created_at`, `changed_at`) VALUES
(1, '1399-07-26', 1, 3, 0.0128, '232', 2, 121700.00, '', 1557.76, 22, 0, 0, 1602933650, NULL),
(2, '1399-08-04', 3, 3, 0.0128, '200', 2, 17000.00, '', 217.60, 22, 0, 0, 1603620382, NULL),
(3, '1399-08-04', 4, 3, 0.0128, '34', 2, 21600.00, '', 276.48, 22, 0, 0, 1603621334, NULL),
(4, '1399-08-05', 4, 3, 0.0128, '12', 2, 6900.00, '', 88.32, 22, 0, 0, 1603692991, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expenses`
--

CREATE TABLE IF NOT EXISTS `tbl_expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(100) NOT NULL,
  `expense_category_id` int(11) NOT NULL,
  `expense_type_id` int(11) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double(10,6) NOT NULL,
  `banks_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `document` text NOT NULL,
  `home_amount` double(10,2) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` smallint(6) DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expense_categories`
--

CREATE TABLE IF NOT EXISTS `tbl_expense_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` smallint(6) DEFAULT NULL,
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expense_types`
--

CREATE TABLE IF NOT EXISTS `tbl_expense_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `expense_categories_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` smallint(6) DEFAULT NULL,
  `defaults` int(11) DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_items`
--

CREATE TABLE IF NOT EXISTS `tbl_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(69) NOT NULL,
  `name` varchar(100) NOT NULL,
  `item_units_id` int(11) NOT NULL,
  `stocks_id` int(11) NOT NULL,
  `item_categories_id` int(11) NOT NULL,
  `opening_balance` double(15,2) NOT NULL,
  `description` text NOT NULL,
  `deleted` int(11) NOT NULL,
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_items`
--

INSERT INTO `tbl_items` (`id`, `date`, `name`, `item_units_id`, `stocks_id`, `item_categories_id`, `opening_balance`, `description`, `deleted`, `defaults`, `removed_by`, `created_at`, `changed_at`, `users_id`) VALUES
(1, '1399-07-26', 'خیمه', 1, 1, 1, 2000.00, 'ما دو هزار دانه خیمه داریم به این شهر خود', 0, 0, 0, 1602932884, NULL, 22),
(2, '1399-07-26', 'تخته', 2, 1, 2, 20000.00, 'مشکلات روحی و اقتصادی دارد', 0, 0, 0, 1602933049, NULL, 22);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_item_categories`
--

CREATE TABLE IF NOT EXISTS `tbl_item_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` int(6) DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `defaults` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_item_categories`
--

INSERT INTO `tbl_item_categories` (`id`, `name`, `users_id`, `deleted`, `removed_by`, `defaults`, `created_at`, `changed_at`) VALUES
(1, 'اجناس دست دوم', 22, 0, 0, 0, 1602932862, NULL),
(2, 'جدید', 22, 0, 0, 0, 1602933011, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_item_units`
--

CREATE TABLE IF NOT EXISTS `tbl_item_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` int(11) DEFAULT '0',
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_item_units`
--

INSERT INTO `tbl_item_units` (`id`, `name`, `users_id`, `deleted`, `defaults`, `removed_by`, `created_at`, `changed_at`) VALUES
(1, 'دانه', 22, 0, 0, 0, 1602932774, NULL),
(2, 'پایه', 22, 0, 0, 0, 1602933002, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login_details`
--

CREATE TABLE IF NOT EXISTS `tbl_login_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `login_date` int(11) DEFAULT NULL,
  `last_seen_visit` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_persian_ci AUTO_INCREMENT=72 ;

--
-- Dumping data for table `tbl_login_details`
--

INSERT INTO `tbl_login_details` (`id`, `users_id`, `login_date`, `last_seen_visit`) VALUES
(1, 25, 1574839590, 1574839590),
(2, 25, 1574914723, 1574914723),
(3, 25, 1574935153, 1574935153),
(4, 25, 1575087595, 1575087595),
(5, 25, 1575175893, 1575175893),
(6, 25, 1575350743, 1575350743),
(7, 25, 1575368913, 1575368913),
(8, 25, 1575433345, 1575433345),
(9, 25, 1575519255, 1575519255),
(10, 25, 1585372038, 1585372038),
(11, 25, 1585462144, 1585462144),
(12, 25, 1585546950, 1585546950),
(13, 25, 1585631258, 1585631258),
(14, 25, 1587537437, 1587537437),
(15, 25, 1587537778, 1587537778),
(16, 25, 1587881114, 1587881114),
(17, 25, 1588052165, 1588052165),
(18, 25, 1588137555, 1588137555),
(19, 25, 1588396046, 1588396046),
(20, 25, 1588489193, 1588489193),
(21, 25, 1588572100, 1588572100),
(22, 25, 1588748914, 1588748914),
(23, 25, 1588837562, 1588837562),
(24, 25, 1589008767, 1589008767),
(25, 25, 1589103788, 1589103788),
(26, 25, 1589178667, 1589178667),
(27, 25, 1589270954, 1589270954),
(28, 25, 1589350152, 1589350152),
(29, 25, 1589440778, 1589440778),
(30, 25, 1589878558, 1589878558),
(31, 25, 1590904068, 1590904068),
(32, 25, 1590983482, 1590983482),
(33, 25, 1591425575, 1591425575),
(34, 25, 1591505867, 1591505867),
(35, 25, 1595054053, 1595054053),
(36, 25, 1595398724, 1595398724),
(37, 22, 1595655511, 1595655511),
(38, 22, 1599383198, 1599383198),
(39, 22, 1599454896, 1599454896),
(40, 22, 1599626453, 1599626453),
(41, 22, 1599715337, 1599715337),
(42, 22, 1599882662, 1599882662),
(43, 22, 1599967605, 1599967605),
(44, 22, 1600055524, 1600055524),
(45, 22, 1600147265, 1600147265),
(46, 22, 1600232388, 1600232388),
(47, 22, 1600315710, 1600315710),
(48, 22, 1600341137, 1600341137),
(49, 22, 1600343929, 1600343929),
(50, 22, 1600344007, 1600344007),
(51, 22, 1600489340, 1600489340),
(52, 22, 1600577948, 1600577948),
(53, 22, 1600855195, 1600855195),
(54, 22, 1600924312, 1600924312),
(55, 22, 1602141736, 1602141736),
(56, 22, 1602309357, 1602309357),
(57, 22, 1602391506, 1602391506),
(58, 22, 1602416003, 1602416003),
(59, 22, 1602475492, 1602475492),
(60, 22, 1602487587, 1602487587),
(61, 22, 1602567982, 1602567982),
(62, 22, 1602735385, 1602735385),
(63, 22, 1602907555, 1602907555),
(64, 22, 1602933212, 1602933212),
(65, 22, 1603003794, 1603003794),
(66, 22, 1603081089, 1603081089),
(67, 22, 1603168453, 1603168453),
(68, 22, 1603605186, 1603605186),
(69, 22, 1603686738, 1603686738),
(70, 22, 1603772462, 1603772462),
(71, 22, 1603860749, 1603860749);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_organizations`
--

CREATE TABLE IF NOT EXISTS `tbl_organizations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `districts_id` int(11) NOT NULL DEFAULT '0',
  `description` date NOT NULL,
  `deleted` int(11) NOT NULL,
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_organization_expense_transactions`
--

CREATE TABLE IF NOT EXISTS `tbl_organization_expense_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(40) NOT NULL,
  `schools_id` int(11) NOT NULL DEFAULT '0',
  `expense_categories_id` int(11) DEFAULT '0',
  `amount` double(20,2) NOT NULL,
  `document` text NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `banks_id` int(11) NOT NULL,
  `rate` double NOT NULL,
  `description` text NOT NULL,
  `home_amount` double(25,2) NOT NULL,
  `users_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_organization_expense_transactions`
--

INSERT INTO `tbl_organization_expense_transactions` (`id`, `date`, `schools_id`, `expense_categories_id`, `amount`, `document`, `currencies_id`, `banks_id`, `rate`, `description`, `home_amount`, `users_id`, `created_at`, `changed_at`, `deleted`, `removed_by`) VALUES
(1, '1399-07-26', 1, 1, 4000.00, '../documents/لیسه تجربوی ذکور باغ نظرگاه2755.jpg', 3, 2, 0.0128, 'شما که میدانید این یک کار خیر است', 51.20, 22, 0, NULL, 0, 0),
(2, '1399-08-04', 4, 1, 4000.00, '../documents/لیسه خواجه محمد عقاب2205.jpg', 3, 2, 0.0128, '', 51.20, 22, 0, NULL, 0, 0),
(3, '1399-08-05', 4, 2, 400.00, '../documents/لیسه خواجه محمد عقاب4311.jpg', 3, 2, 0.0128, 'این مصرف به خاطر تعمیرات است', 5.12, 22, 0, NULL, 0, 0),
(4, '1399-08-05', 4, 3, 3000.00, '../documents/لیسه تجربوی ذکور باغ نظرگاه2864.jpg', 3, 2, 0.0128, 'این یک دنیای خوبی نیست، سراسر غم  و مشکلات در این دیده می‌شود.', 38.40, 22, 0, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_org_construction_requests`
--

CREATE TABLE IF NOT EXISTS `tbl_org_construction_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(30) NOT NULL,
  `request_number` double(25,2) NOT NULL DEFAULT '0.00',
  `schools_id` int(11) NOT NULL DEFAULT '0',
  `construction_types_id` int(11) NOT NULL DEFAULT '0',
  `quantity` double(25,2) NOT NULL,
  `document` varchar(400) NOT NULL,
  `description` text NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_org_construction_requests`
--

INSERT INTO `tbl_org_construction_requests` (`id`, `date`, `request_number`, `schools_id`, `construction_types_id`, `quantity`, `document`, `description`, `deleted`, `status`, `removed_by`, `created_at`, `changed_at`, `users_id`) VALUES
(1, '1399-08-04', 34.00, 3, 1, 200.00, '../documents/لیسه قوچانک3695.jpg', 'این یک نوع توضیحات است که ما به شما می‌رسانیم.', 0, 0, 0, 0, NULL, 22),
(2, '1399-08-04', 23.00, 4, 2, 200.00, '../documents/لیسه تجربوی ذکور باغ نظرگاه563.jpg', 'توسط تیم بنیاد بازرسی', 0, 0, 0, 0, NULL, 22);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_org_expense_categories`
--

CREATE TABLE IF NOT EXISTS `tbl_org_expense_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` smallint(6) DEFAULT NULL,
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_org_expense_categories`
--

INSERT INTO `tbl_org_expense_categories` (`id`, `name`, `users_id`, `deleted`, `defaults`, `removed_by`, `created_at`, `changed_at`) VALUES
(1, 'خرید آهن', 22, 0, 0, 0, 1602924237, NULL),
(2, 'ترمیم میز و چوکی است', 22, 0, 0, 0, 1603693160, NULL),
(3, 'مزد جوشکار', 22, 0, 0, 0, 1603693548, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_org_req_materials_details`
--

CREATE TABLE IF NOT EXISTS `tbl_org_req_materials_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_title_id` int(11) NOT NULL,
  `items_id` int(11) NOT NULL DEFAULT '0',
  `items_unit_id` int(11) NOT NULL DEFAULT '0',
  `quantity` double(25,2) NOT NULL,
  `description` text NOT NULL,
  `dist_date` varchar(60) NOT NULL,
  `dist_quantity` double(25,4) NOT NULL,
  `dist_description` text NOT NULL,
  `distributed` int(11) NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_org_req_materials_details`
--

INSERT INTO `tbl_org_req_materials_details` (`id`, `request_title_id`, `items_id`, `items_unit_id`, `quantity`, `description`, `dist_date`, `dist_quantity`, `dist_description`, `distributed`, `deleted`, `defaults`, `removed_by`, `created_at`, `changed_at`, `users_id`) VALUES
(1, 1, 2, 2, 900.00, 'این جا لندن است، همه باید بدانند این را ', '', 0.0000, '', 0, 0, 0, 0, 0, NULL, 22),
(2, 1, 1, 1, 1000.00, 'این یک شهر خوبی است که باید همه این را بدانند.', '', 0.0000, '', 0, 0, 0, 0, 0, NULL, 22),
(3, 2, 2, 2, 20.00, 'به خاطر متنننن', '', 0.0000, '', 0, 0, 0, 0, 0, NULL, 22),
(4, 2, 1, 1, 4.00, 'بخاطر که ندارند ', '', 0.0000, '', 0, 0, 0, 0, 0, NULL, 22);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_org_req_materials_title`
--

CREATE TABLE IF NOT EXISTS `tbl_org_req_materials_title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `schools_id` int(11) NOT NULL,
  `request_number` int(25) DEFAULT NULL,
  `document` varchar(400) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_org_req_materials_title`
--

INSERT INTO `tbl_org_req_materials_title` (`id`, `date`, `schools_id`, `request_number`, `document`, `deleted`, `status`, `removed_by`, `created_at`, `changed_at`, `users_id`) VALUES
(1, '1399-08-04', 3, 232, '../documents/لیسه بوزان1706.jpg', 0, 0, 0, 0, NULL, 22),
(2, '1399-08-04', 4, 12, '../documents/لیسه تجربوی ذکور باغ نظرگاه4708.jpg', 0, 0, 0, 0, NULL, 22);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_positions`
--

CREATE TABLE IF NOT EXISTS `tbl_positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8_persian_ci NOT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `verified` int(11) NOT NULL DEFAULT '1',
  `verified_by` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `description` text COLLATE utf8_persian_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_schools`
--

CREATE TABLE IF NOT EXISTS `tbl_schools` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `manager_name` varchar(150) NOT NULL,
  `districts_id` int(11) NOT NULL DEFAULT '0',
  `contact` varchar(60) NOT NULL,
  `school_type` int(11) NOT NULL DEFAULT '0',
  `total_students` int(11) NOT NULL DEFAULT '0',
  `address` text NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_schools`
--

INSERT INTO `tbl_schools` (`id`, `date`, `name`, `manager_name`, `districts_id`, `contact`, `school_type`, `total_students`, `address`, `deleted`, `defaults`, `removed_by`, `created_at`, `changed_at`, `users_id`) VALUES
(1, '1399-07-26', 'ریاست معارف ولایت هرات', 'زکریا رحیمی', 3, '0790160154', 3, 0, 'چهار راهی معارف', 0, 0, 0, 1602915904, NULL, 22),
(2, '1399-07-19', 'مکتب عبدالواسع جبلی', 'سادات', 1, '0402223077', 3, 1200, 'جاده عبدالواسع جبلی', 0, 0, 0, 1602923917, NULL, 22),
(3, '1399-08-04', 'مکتب متوسطه شهید بلخی', 'نمی دانم', 4, '040223077', 3, 230, 'این یک شهر خوبی است، که باید از آن استفاده خوب بکنیم', 0, 0, 0, 1603618871, NULL, 22),
(4, '1399-08-04', 'لیسه مرکز', 'نمی فهمم', 2, '04002332', 3, 500, 'ولسوالی زنده جان - مرکز', 0, 0, 0, 1603621101, NULL, 22);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_school_managers`
--

CREATE TABLE IF NOT EXISTS `tbl_school_managers` (
  `date` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(220) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL,
  `defaults` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff`
--

CREATE TABLE IF NOT EXISTS `tbl_staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `family` varchar(100) NOT NULL,
  `contact` varchar(45) NOT NULL,
  `ssn` varchar(30) NOT NULL,
  `job_type` varchar(45) NOT NULL,
  `opening_balance` double NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double NOT NULL,
  `home_amount` double NOT NULL,
  `address` text NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stocks`
--

CREATE TABLE IF NOT EXISTS `tbl_stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  `defaults` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_stocks`
--

INSERT INTO `tbl_stocks` (`id`, `name`, `description`, `deleted`, `removed_by`, `created_at`, `changed_at`, `users_id`, `defaults`) VALUES
(1, 'گدام بنیاد لیان امیری', 'طبقه دوم است', 0, 0, 1600493970, NULL, 22, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stock_balance`
--

CREATE TABLE IF NOT EXISTS `tbl_stock_balance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `items_id` int(11) NOT NULL,
  `stocks_id` int(11) NOT NULL,
  `amount` double(15,2) NOT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_stock_balance`
--

INSERT INTO `tbl_stock_balance` (`id`, `items_id`, `stocks_id`, `amount`, `users_id`) VALUES
(1, 1, 1, -2302.00, 22),
(2, 2, 1, 19256.00, 22);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stock_statement`
--

CREATE TABLE IF NOT EXISTS `tbl_stock_statement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `place` varchar(100) NOT NULL,
  `reference` varchar(100) NOT NULL,
  `transaction_type` int(11) NOT NULL,
  `amount` double(34,2) NOT NULL,
  `stocks_id` int(11) NOT NULL,
  `items_id` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `categories_id` int(11) DEFAULT NULL,
  `sub_categories_id` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_stock_statement`
--

INSERT INTO `tbl_stock_statement` (`id`, `date`, `place`, `reference`, `transaction_type`, `amount`, `stocks_id`, `items_id`, `description`, `categories_id`, `sub_categories_id`, `deleted`, `removed_by`, `created_at`, `changed_at`, `users_id`) VALUES
(1, '1399-07-26', 'Opening Balance Item', '1', 1, 2000.00, 1, 1, 'ما دو هزار دانه خیمه داریم به این شهر خود', NULL, NULL, 0, 0, 1602932884, NULL, 22),
(2, '1399-07-26', 'Opening Balance Item', '2', 1, 20000.00, 1, 2, 'مشکلات روحی و اقتصادی دارد', NULL, NULL, 0, 0, 1602933049, NULL, 22);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_stock_transaction`
--

CREATE TABLE IF NOT EXISTS `tbl_stock_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(40) NOT NULL,
  `source_stocks_id` int(11) NOT NULL,
  `items_id` int(11) NOT NULL,
  `transfer_amount` double(11,2) NOT NULL,
  `destination_stocks_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_support_ceremonies_requests`
--

CREATE TABLE IF NOT EXISTS `tbl_support_ceremonies_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `request_number` double(25,2) DEFAULT '0.00',
  `name` varchar(400) NOT NULL,
  `schools_id` int(11) NOT NULL,
  `document` varchar(340) NOT NULL,
  `amount` double(25,2) NOT NULL,
  `description` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbl_support_ceremonies_requests`
--

INSERT INTO `tbl_support_ceremonies_requests` (`id`, `date`, `request_number`, `name`, `schools_id`, `document`, `amount`, `description`, `status`, `deleted`, `removed_by`, `created_at`, `changed_at`, `users_id`) VALUES
(1, '1399-07-26', 87.00, 'محفل تدویر روز معلم', 1, '../documents/لیسه خواجه محمد عقاب3078.jpg', 0.00, 'این درخواستی به تاییدی و هدایت محترم انجینر صاحب بهمن دریافت گردیده است', 0, 0, 0, 0, NULL, 22),
(2, '1399-08-04', 90.00, 'محفل شهید بلخی', 3, '../documents/لیسه خواجه محمد عقاب824.jpg', 0.00, 'این یک شهر خوبی است', 0, 0, 0, 0, NULL, 22),
(3, '1399-08-04', 34.00, 'روز معلم یا روزمدیر', 4, '../documents/لیسه خواجه محمد عقاب294.jpg', 0.00, '', 0, 0, 0, 0, NULL, 22),
(4, '1399-08-05', 89.00, 'محفل  دومی  از لیسه مرکز', 4, '../documents/لیسه بوزان2468.jpg', 0.00, 'اینجا لندن است', 0, 0, 0, 0, NULL, 22);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_support_ceremonies_response_tran`
--

CREATE TABLE IF NOT EXISTS `tbl_support_ceremonies_response_tran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `ceremonies_id` int(11) NOT NULL,
  `amount` double(34,2) NOT NULL,
  `banks_id` int(11) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double(10,5) DEFAULT NULL,
  `document` text NOT NULL,
  `home_amount` double(20,2) NOT NULL,
  `description` text NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tbl_support_ceremonies_response_tran`
--

INSERT INTO `tbl_support_ceremonies_response_tran` (`id`, `date`, `ceremonies_id`, `amount`, `banks_id`, `currencies_id`, `rate`, `document`, `home_amount`, `description`, `deleted`, `removed_by`, `created_at`, `changed_at`, `users_id`) VALUES
(1, '1399-07-26', 1, 16200.00, 2, 3, 0.01280, '../documents/آمریت عمومی معارف کشک رباط سنگی2526.jpg', 207.36, 'چاپ بنیر  و چاچ تحسین نامه ها', 0, 0, 0, NULL, 22),
(2, '1399-07-26', 1, 2000.00, 2, 3, 0.01280, '../documents/لیسه تجربوی ذکور باغ نظرگاه4758.jpg', 25.60, 'خرید ده بسته ماسک', 0, 0, 0, NULL, 22),
(3, '1399-07-26', 1, 1000.00, 2, 3, 0.01280, '../documents/لیسه تجربوی ذکور باغ نظرگاه2117.jpg', 12.80, 'زل ضد عفونی کننده، به خاطر ضد عفونی کردن دست ها', 0, 0, 0, NULL, 22),
(4, '1399-08-04', 2, 500.00, 2, 3, 0.01280, '../documents/لیسه خواجه محمد عقاب4639.jpg', 6.40, 'ما به این دنیا همه‌ی کارهای نیک را انجام  داده بودیم که انسانی خوبی بودیم', 0, 0, 0, NULL, 22),
(5, '1399-08-04', 3, 20000.00, 2, 3, 0.01280, '../documents/لیسه رازی3008.jpg', 256.00, '', 0, 0, 0, NULL, 22),
(6, '1399-08-04', 3, 200.00, 2, 3, 0.01280, '../documents/لیسه خواجه محمد عقاب2157.jpg', 2.56, 'توضیحات را باید، صحیح برسانیم', 0, 0, 0, NULL, 22),
(7, '1399-08-05', 3, 30000.00, 2, 3, 0.01280, '../documents/لیسه خواجه محمد عقاب3048.jpg', 384.00, 'این یک محل اتصال برای همه هست', 0, 0, 0, NULL, 22),
(8, '1399-08-05', 4, 3000.00, 2, 3, 0.01280, '../documents/documents2667.', 38.40, 'این دگه چی رقم است', 0, 0, 0, NULL, 22);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `family` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(70) NOT NULL,
  `password` varchar(250) NOT NULL,
  `photo` varchar(388) NOT NULL,
  `user_type` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `remove` int(11) NOT NULL DEFAULT '0',
  `addForm` int(11) NOT NULL DEFAULT '0',
  `edit` int(11) NOT NULL DEFAULT '0',
  `remove_report` int(11) NOT NULL DEFAULT '0',
  `edit_report` int(11) NOT NULL DEFAULT '0',
  `deleted` smallint(6) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `verified` int(11) NOT NULL DEFAULT '1',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `name`, `family`, `username`, `email`, `password`, `photo`, `user_type`, `position_id`, `status`, `remove`, `addForm`, `edit`, `remove_report`, `edit_report`, `deleted`, `removed_by`, `verified`, `created_at`, `changed_at`) VALUES
(11, 'Sohaib', 'Raoufy', 'Sohaib', '-----------.786@gmail.com', 'Mzk1MDRhMTlmMzk4MGUzODM4MWUxYTA2Zjg2ZmQxZjdiMjJmZDZlYWZiODVjNTE0YTI5OTJlOTJmZGRjOGY5MA==', '../uploads/6aa4632f-814a-4c0d-85bf-0124b20871fe470.JPG', 1002, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1551906634, 1556696158),
(12, 'Engineer Faisal', 'Raufi', 'Ahmad Faisal', 'a.sami.sadiqi2017@gmail.com', 'NTk5NDQ3MWFiYjAxMTEyYWZjYzE4MTU5ZjZjYzc0YjRmNTExYjk5ODA2ZGE1OWIzY2FmNWE5YzE3M2NhY2ZjNQ==', '../uploads/67d5fbe2-1ae0-4034-88a6-f3f2064d6815254.JPG', 1002, 3, 0, 1, 1, 1, 0, 0, 0, 0, 1, 1551906634, 1556425966),
(14, 'Mohammad Ismail', 'Noorkhail', 'Noorkhail', 'a.sami.sadiqi2017@gmail.com', 'Yzg0Y2MxNDYzYjI2NTBhOTQ3NzY0NmVhY2FhMWI5NTU0MDNiNmJkNDVmYWZiMTg4ZThiNzI3MGU4M2ViNzYxYQ==', '../uploads/noorkhil144.PNG', 1002, 4, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1551935925, 1551935925),
(15, 'Azizullah', 'jan', 'azizullah', '-----------.786@gmail.com', 'NWVmNjIwMmMzMTE5NTRhMjY2MDE0Yjk1NmFlZjUxMGViNjFhODkyYTkxMmU3ZDE2NGZmNTVjYTQwYTExZGJiOA==', '../uploads/Tulips286.jpg', 1002, 6, 0, 1, 1, 1, 0, 0, 0, 0, 1, 1551939099, 2147483647),
(16, 'Saed Ismail', 'Amiri', 'amiri', '-----------.786@gmail.com', 'YWE5NDVlNmU3ZTdjNGRhYTU0NDhlN2I0OWI0YzBiMzQzNDhiMzJkZjQ5NGJhMWMxNTk1Nzg4ODEzY2Q4OTE4NQ==', '../uploads/pp253.jpg', 1001, 2, 0, 1, 1, 1, 0, 0, 0, 0, 1, 1551946134, 1551946134),
(21, 'Eng Bahman', 'Sarwary', 'sarwary', 'a.sami.sadiqi2017@gmail.com', 'OWFlYTVjNjM0ZjcxMGYyY2E3MzIxMmFhMzFhOTNmZjVjOWEyNzYyNWQ0YzI1Nzc4MTY3ZGY2N2Q5YTFjNjg3Yw==', '../uploads/Hydrangeas397.jpg', 1002, 5, 0, 1, 1, 1, 0, 0, 0, 0, 1, 1551906634, 1556080308),
(22, 'Abdul Sami', 'Sadiqi', 'sadiqi', 'sadiqi@yahoo.com', 'YmMwNmVlZTQ5NDUxYjQxZGRjNzk4ZDM3MjkwNDFmMTYzYjYyYjJkZmViMGY1NGU3NjBhZjZkNmEwM2EyODFmNQ==', '../uploads/Capture452.PNG', 1001, 0, 0, 1, 1, 1, 1, 1, 0, 0, 1, 1551906634, 1556189121),
(25, 'Abdul Sami2', 'Sadiqi', 'sadiqi2', 'azizi@gmail.com', 'NDkwMzkwYTVkZmIwMWNmNWIxN2VjNjVhNmYwNjZjMzg3ODQyOGRjMGRiZTMwMzExMzFlMGJhOWQ2ODM1ZGIwYg==', '../uploads/69740775_2341712862545045_8440527832416780288_n418.jpg', 1002, 6, 0, 1, 1, 1, 1, 1, 0, 0, 1, 1555232502, 1574053573),
(34, 'tawa', 'yousfui', 'Tawab', 'tawab@gmail.com', 'NTk5NDQ3MWFiYjAxMTEyYWZjYzE4MTU5ZjZjYzc0YjRmNTExYjk5ODA2ZGE1OWIzY2FmNWE5YzE3M2NhY2ZjNQ==', '../uploads/69740775_2341712862545045_8440527832416780288_n122.jpg', 1002, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1574159030, 1574159458);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vendors`
--

CREATE TABLE IF NOT EXISTS `tbl_vendors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `vendor_type` int(11) NOT NULL,
  `contact` varchar(150) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `opening_balance` double(25,2) NOT NULL,
  `rate` double(10,3) NOT NULL,
  `address` text NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `defaults` int(11) DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `home_amount` double(25,2) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vendor_bill_details`
--

CREATE TABLE IF NOT EXISTS `tbl_vendor_bill_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_bills_id` int(11) NOT NULL,
  `items_id` int(11) NOT NULL,
  `stocks_id` int(11) DEFAULT NULL,
  `items_unit_id` int(11) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `fee` double(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vendor_bill_title`
--

CREATE TABLE IF NOT EXISTS `tbl_vendor_bill_title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(20) NOT NULL,
  `vendors_id` int(11) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double NOT NULL,
  `factor_number` varchar(50) NOT NULL,
  `banks_id` int(11) NOT NULL,
  `factor_price` double(20,2) NOT NULL,
  `factor_payment` double(20,2) NOT NULL,
  `description` text NOT NULL,
  `home_amount` double(16,2) NOT NULL,
  `home_amount_factor_price` double(16,2) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vendor_categories`
--

CREATE TABLE IF NOT EXISTS `tbl_vendor_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `users_id` int(11) NOT NULL,
  `deleted` smallint(6) DEFAULT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `defaults` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vendor_payment`
--

CREATE TABLE IF NOT EXISTS `tbl_vendor_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(40) NOT NULL,
  `vendors_id` int(11) NOT NULL,
  `reference_id` int(11) DEFAULT '0' COMMENT 'factor title id ',
  `currencies_id` int(11) NOT NULL,
  `amount` double(20,2) NOT NULL,
  `rate` double NOT NULL,
  `banks_id` int(11) NOT NULL,
  `factor_number` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `payment_type` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `home_amount` double NOT NULL,
  `users_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL,
  `removed_by` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vendor_statement`
--

CREATE TABLE IF NOT EXISTS `tbl_vendor_statement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(40) NOT NULL,
  `place` varchar(100) NOT NULL,
  `reference` varchar(100) NOT NULL,
  `transaction_type` int(11) NOT NULL,
  `amount` double(25,2) NOT NULL,
  `vendors_id` int(11) NOT NULL,
  `currencies_id` int(11) NOT NULL,
  `rate` double(10,3) NOT NULL,
  `home_amount` double(25,2) NOT NULL,
  `description` text NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `removed_by` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `changed_at` int(11) DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
