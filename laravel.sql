-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2026. Ápr 29. 20:52
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `laravel`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `available_slots`
--

CREATE TABLE `available_slots` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nail_artist_id` bigint(20) UNSIGNED NOT NULL,
  `slot_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_booked` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `available_slots`
--

INSERT INTO `available_slots` (`id`, `nail_artist_id`, `slot_date`, `start_time`, `end_time`, `is_booked`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-05-01', '09:00:00', '10:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(2, 1, '2026-05-04', '10:30:00', '11:30:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(3, 1, '2026-05-07', '12:00:00', '13:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(4, 1, '2026-05-10', '14:00:00', '15:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(5, 1, '2026-05-13', '15:30:00', '16:30:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(6, 1, '2026-05-16', '09:00:00', '10:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(7, 1, '2026-05-19', '10:30:00', '11:30:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(8, 1, '2026-05-22', '12:00:00', '13:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(9, 1, '2026-05-25', '14:00:00', '15:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(10, 1, '2026-05-28', '15:30:00', '16:30:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(11, 1, '2026-06-01', '12:00:00', '13:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(12, 1, '2026-06-04', '14:00:00', '15:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(13, 1, '2026-06-07', '15:30:00', '16:30:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(14, 1, '2026-06-10', '09:00:00', '10:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(15, 1, '2026-06-13', '10:30:00', '11:30:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(16, 1, '2026-06-16', '12:00:00', '13:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(17, 1, '2026-06-19', '14:00:00', '15:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(18, 1, '2026-06-22', '15:30:00', '16:30:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(19, 1, '2026-06-25', '09:00:00', '10:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(20, 1, '2026-06-28', '10:30:00', '11:30:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(21, 2, '2026-05-01', '09:00:00', '10:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(22, 2, '2026-05-04', '10:30:00', '11:30:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(23, 2, '2026-05-07', '12:00:00', '13:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(24, 2, '2026-05-10', '14:00:00', '15:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(25, 2, '2026-05-13', '15:30:00', '16:30:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(26, 2, '2026-05-16', '09:00:00', '10:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(27, 2, '2026-05-19', '10:30:00', '11:30:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(28, 2, '2026-05-22', '12:00:00', '13:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(29, 2, '2026-05-25', '14:00:00', '15:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(30, 2, '2026-05-28', '15:30:00', '16:30:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(31, 2, '2026-06-01', '12:00:00', '13:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(32, 2, '2026-06-04', '14:00:00', '15:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(33, 2, '2026-06-07', '15:30:00', '16:30:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(34, 2, '2026-06-10', '09:00:00', '10:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(35, 2, '2026-06-13', '10:30:00', '11:30:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(36, 2, '2026-06-16', '12:00:00', '13:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(37, 2, '2026-06-19', '14:00:00', '15:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(38, 2, '2026-06-22', '15:30:00', '16:30:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(39, 2, '2026-06-25', '09:00:00', '10:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(40, 2, '2026-06-28', '10:30:00', '11:30:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(41, 3, '2026-05-01', '09:00:00', '10:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(42, 3, '2026-05-04', '10:30:00', '11:30:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(43, 3, '2026-05-07', '12:00:00', '13:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(44, 3, '2026-05-10', '14:00:00', '15:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(45, 3, '2026-05-13', '15:30:00', '16:30:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(46, 3, '2026-05-16', '09:00:00', '10:00:00', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(47, 3, '2026-05-19', '10:30:00', '11:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(48, 3, '2026-05-22', '12:00:00', '13:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(49, 3, '2026-05-25', '14:00:00', '15:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(50, 3, '2026-05-28', '15:30:00', '16:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(51, 3, '2026-06-01', '12:00:00', '13:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(52, 3, '2026-06-04', '14:00:00', '15:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(53, 3, '2026-06-07', '15:30:00', '16:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(54, 3, '2026-06-10', '09:00:00', '10:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(55, 3, '2026-06-13', '10:30:00', '11:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(56, 3, '2026-06-16', '12:00:00', '13:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(57, 3, '2026-06-19', '14:00:00', '15:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(58, 3, '2026-06-22', '15:30:00', '16:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(59, 3, '2026-06-25', '09:00:00', '10:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(60, 3, '2026-06-28', '10:30:00', '11:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(61, 4, '2026-05-01', '09:00:00', '10:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(62, 4, '2026-05-04', '10:30:00', '11:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(63, 4, '2026-05-07', '12:00:00', '13:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(64, 4, '2026-05-10', '14:00:00', '15:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(65, 4, '2026-05-13', '15:30:00', '16:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(66, 4, '2026-05-16', '09:00:00', '10:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(67, 4, '2026-05-19', '10:30:00', '11:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(68, 4, '2026-05-22', '12:00:00', '13:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(69, 4, '2026-05-25', '14:00:00', '15:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(70, 4, '2026-05-28', '15:30:00', '16:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(71, 4, '2026-06-01', '12:00:00', '13:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(72, 4, '2026-06-04', '14:00:00', '15:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(73, 4, '2026-06-07', '15:30:00', '16:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(74, 4, '2026-06-10', '09:00:00', '10:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(75, 4, '2026-06-13', '10:30:00', '11:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(76, 4, '2026-06-16', '12:00:00', '13:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(77, 4, '2026-06-19', '14:00:00', '15:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(78, 4, '2026-06-22', '15:30:00', '16:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(79, 4, '2026-06-25', '09:00:00', '10:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(80, 4, '2026-06-28', '10:30:00', '11:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(81, 5, '2026-05-01', '09:00:00', '10:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(82, 5, '2026-05-04', '10:30:00', '11:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(83, 5, '2026-05-07', '12:00:00', '13:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(84, 5, '2026-05-10', '14:00:00', '15:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(85, 5, '2026-05-13', '15:30:00', '16:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(86, 5, '2026-05-16', '09:00:00', '10:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(87, 5, '2026-05-19', '10:30:00', '11:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(88, 5, '2026-05-22', '12:00:00', '13:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(89, 5, '2026-05-25', '14:00:00', '15:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(90, 5, '2026-05-28', '15:30:00', '16:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(91, 5, '2026-06-01', '12:00:00', '13:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(92, 5, '2026-06-04', '14:00:00', '15:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(93, 5, '2026-06-07', '15:30:00', '16:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(94, 5, '2026-06-10', '09:00:00', '10:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(95, 5, '2026-06-13', '10:30:00', '11:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(96, 5, '2026-06-16', '12:00:00', '13:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(97, 5, '2026-06-19', '14:00:00', '15:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(98, 5, '2026-06-22', '15:30:00', '16:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(99, 5, '2026-06-25', '09:00:00', '10:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(100, 5, '2026-06-28', '10:30:00', '11:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(101, 6, '2026-05-01', '09:00:00', '10:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(102, 6, '2026-05-04', '10:30:00', '11:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(103, 6, '2026-05-07', '12:00:00', '13:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(104, 6, '2026-05-10', '14:00:00', '15:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(105, 6, '2026-05-13', '15:30:00', '16:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(106, 6, '2026-05-16', '09:00:00', '10:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(107, 6, '2026-05-19', '10:30:00', '11:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(108, 6, '2026-05-22', '12:00:00', '13:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(109, 6, '2026-05-25', '14:00:00', '15:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(110, 6, '2026-05-28', '15:30:00', '16:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(111, 6, '2026-06-01', '12:00:00', '13:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(112, 6, '2026-06-04', '14:00:00', '15:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(113, 6, '2026-06-07', '15:30:00', '16:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(114, 6, '2026-06-10', '09:00:00', '10:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(115, 6, '2026-06-13', '10:30:00', '11:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(116, 6, '2026-06-16', '12:00:00', '13:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(117, 6, '2026-06-19', '14:00:00', '15:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(118, 6, '2026-06-22', '15:30:00', '16:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(119, 6, '2026-06-25', '09:00:00', '10:00:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(120, 6, '2026-06-28', '10:30:00', '11:30:00', 0, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(121, 1, '2026-05-30', '11:00:00', '12:00:00', 1, '2026-04-29 08:38:12', '2026-04-29 08:38:12'),
(123, 1, '2026-05-01', '12:00:00', '14:00:00', 0, '2026-04-29 09:39:09', '2026-04-29 09:39:09');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nail_artist_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `available_slot_id` bigint(20) UNSIGNED DEFAULT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `nail_artist_id`, `service_id`, `available_slot_id`, `booking_date`, `booking_time`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, 121, '2026-05-30', '11:00:00', 'pending', '2026-04-29 08:38:12', '2026-04-29 08:38:12');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nail_artist_id` bigint(20) UNSIGNED NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `nail_artist_id`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 1, 'storage/gallery/sample1.jpg', '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(2, 1, 'storage/gallery/sample2.jpg', '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(3, 1, 'storage/gallery/sample3.jpg', '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(4, 2, 'storage/gallery/sample1.jpg', '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(5, 2, 'storage/gallery/sample2.jpg', '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(6, 2, 'storage/gallery/sample3.jpg', '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(7, 3, 'storage/gallery/sample1.jpg', '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(8, 3, 'storage/gallery/sample2.jpg', '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(9, 3, 'storage/gallery/sample3.jpg', '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(10, 4, 'storage/gallery/sample1.jpg', '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(11, 4, 'storage/gallery/sample2.jpg', '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(12, 4, 'storage/gallery/sample3.jpg', '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(13, 5, 'storage/gallery/sample1.jpg', '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(14, 5, 'storage/gallery/sample2.jpg', '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(15, 5, 'storage/gallery/sample3.jpg', '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(16, 6, 'storage/gallery/sample1.jpg', '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(17, 6, 'storage/gallery/sample2.jpg', '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(18, 6, 'storage/gallery/sample3.jpg', '2026-04-29 08:38:11', '2026-04-29 08:38:11');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_04_23_113216_create_users_table', 1),
(2, '2026_04_23_113343_create_nail_artists_table', 1),
(3, '2026_04_23_113359_create_bookings_table', 1),
(4, '2026_04_23_113414_create_services_table', 1),
(5, '2026_04_23_113425_create_gallery_images_table', 1),
(6, '2026_04_23_120006_create_ratings_table', 1),
(7, '2026_04_23_155357_create_personal_access_tokens_table', 1),
(8, '2026_04_23_174833_create_available_slots_table', 1),
(9, '2026_04_23_174901_add_booking_time_and_slot_to_bookings_table', 1),
(10, '2026_04_23_175803_add_service_id_to_bookings_table', 1),
(11, '2026_04_24_120527_add_address_fields_to_nail_artists_table', 1),
(12, '2026_04_25_082710_create_reports_table', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `nail_artists`
--

CREATE TABLE `nail_artists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `house_number` varchar(255) DEFAULT NULL,
  `salon_address` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `rating` double NOT NULL DEFAULT 0,
  `price_range` varchar(255) NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `nail_artists`
--

INSERT INTO `nail_artists` (`id`, `user_id`, `name`, `city`, `postal_code`, `street`, `house_number`, `salon_address`, `description`, `rating`, `price_range`, `approved`, `created_at`, `updated_at`) VALUES
(1, 3, 'Körmös 1', 'Budapest', NULL, NULL, NULL, NULL, 'Professzionális körmös, több éves tapasztalattal.', 5, '5000-15000', 1, '2026-04-29 08:38:11', '2026-04-29 08:40:47'),
(2, 4, 'Körmös 2', 'Budapest', NULL, NULL, NULL, NULL, 'Professzionális körmös, több éves tapasztalattal.', 3, '5000-15000', 1, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(3, 5, 'Körmös 3', 'Budapest', NULL, NULL, NULL, NULL, 'Professzionális körmös, több éves tapasztalattal.', 4, '5000-15000', 1, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(4, 6, 'Körmös 4', 'Budapest', NULL, NULL, NULL, NULL, 'Professzionális körmös, több éves tapasztalattal.', 3, '5000-15000', 1, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(5, 7, 'Körmös 5', 'Budapest', NULL, NULL, NULL, NULL, 'Professzionális körmös, több éves tapasztalattal.', 5, '5000-15000', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(6, 8, 'Körmös 6', 'Budapest', NULL, NULL, NULL, NULL, 'Professzionális körmös, több éves tapasztalattal.', 3, '5000-15000', 0, '2026-04-29 08:38:11', '2026-04-29 08:38:11');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nail_artist_id` bigint(20) UNSIGNED NOT NULL,
  `star` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `ratings`
--

INSERT INTO `ratings` (`id`, `user_id`, `nail_artist_id`, `star`, `comment`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 5, 'Nagyon elégedett voltam!', '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(2, 2, 2, 4, 'Szép munka, kedves kiszolgálás.', '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(3, 2, 1, 5, 'asd', '2026-04-29 08:40:47', '2026-04-29 08:40:47');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rating_id` bigint(20) UNSIGNED NOT NULL,
  `reported_by` bigint(20) UNSIGNED NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `resolved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nail_artist_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `duration_min` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `services`
--

INSERT INTO `services` (`id`, `nail_artist_id`, `name`, `price`, `duration_min`, `created_at`, `updated_at`) VALUES
(1, 1, 'Gél lakkozás', 11070, 60, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(2, 1, 'Műköröm építés', 8374, 120, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(3, 1, 'Manikűr', 5628, 45, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(4, 1, 'Pedikűr', 7845, 60, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(5, 1, 'Francia köröm', 7945, 90, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(6, 1, 'Díszítés', 9768, 30, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(7, 1, 'Köröm töltés', 9132, 75, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(8, 1, 'Eltávolítás', 9195, 30, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(9, 1, 'Spa kezelés', 10729, 60, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(10, 1, 'Expressz manikűr', 6968, 30, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(11, 2, 'Gél lakkozás', 11754, 60, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(12, 2, 'Műköröm építés', 9598, 120, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(13, 2, 'Manikűr', 9692, 45, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(14, 2, 'Pedikűr', 9149, 60, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(15, 2, 'Francia köröm', 6498, 90, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(16, 2, 'Díszítés', 3200, 30, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(17, 2, 'Köröm töltés', 9257, 75, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(18, 2, 'Eltávolítás', 7303, 30, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(19, 2, 'Spa kezelés', 5336, 60, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(20, 2, 'Expressz manikűr', 8618, 30, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(21, 3, 'Gél lakkozás', 11075, 60, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(22, 3, 'Műköröm építés', 5227, 120, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(23, 3, 'Manikűr', 7457, 45, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(24, 3, 'Pedikűr', 5941, 60, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(25, 3, 'Francia köröm', 11843, 90, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(26, 3, 'Díszítés', 11491, 30, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(27, 3, 'Köröm töltés', 9229, 75, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(28, 3, 'Eltávolítás', 11239, 30, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(29, 3, 'Spa kezelés', 8549, 60, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(30, 3, 'Expressz manikűr', 6981, 30, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(31, 4, 'Gél lakkozás', 4009, 60, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(32, 4, 'Műköröm építés', 10515, 120, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(33, 4, 'Manikűr', 6404, 45, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(34, 4, 'Pedikűr', 10039, 60, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(35, 4, 'Francia köröm', 10551, 90, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(36, 4, 'Díszítés', 8335, 30, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(37, 4, 'Köröm töltés', 8209, 75, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(38, 4, 'Eltávolítás', 3290, 30, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(39, 4, 'Spa kezelés', 10318, 60, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(40, 4, 'Expressz manikűr', 10085, 30, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(41, 5, 'Gél lakkozás', 10689, 60, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(42, 5, 'Műköröm építés', 3954, 120, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(43, 5, 'Manikűr', 6078, 45, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(44, 5, 'Pedikűr', 8424, 60, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(45, 5, 'Francia köröm', 11488, 90, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(46, 5, 'Díszítés', 5372, 30, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(47, 5, 'Köröm töltés', 3465, 75, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(48, 5, 'Eltávolítás', 7332, 30, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(49, 5, 'Spa kezelés', 4069, 60, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(50, 5, 'Expressz manikűr', 5149, 30, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(51, 6, 'Gél lakkozás', 3447, 60, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(52, 6, 'Műköröm építés', 11050, 120, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(53, 6, 'Manikűr', 9678, 45, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(54, 6, 'Pedikűr', 5680, 60, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(55, 6, 'Francia köröm', 3253, 90, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(56, 6, 'Díszítés', 11829, 30, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(57, 6, 'Köröm töltés', 6566, 75, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(58, 6, 'Eltávolítás', 10951, 30, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(59, 6, 'Spa kezelés', 4112, 60, '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(60, 6, 'Expressz manikűr', 9737, 30, '2026-04-29 08:38:11', '2026-04-29 08:38:11');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@test.com', '$2y$12$y0FCpnL8m67/n3uR/ymOle1icTfyJhQmGRJPTRFHk5mtwXDKbhfym', 'admin', '2026-04-29 08:38:10', '2026-04-29 08:38:10'),
(2, 'Normal User', 'user@test.com', '$2y$12$LySDHVXJQ8UHIJhX.zALzufHRXB6odSkaj4Xh2mXdeWMtsphtHHr6', 'user', '2026-04-29 08:38:10', '2026-04-29 08:38:10'),
(3, 'Artist 1', 'artist1@test.com', '$2y$12$/yp1NbmjTfrE1fz.KSR11uIgb8o6o0r7TmJ34ozD7QRPwKO/t7Fai', 'artist', '2026-04-29 08:38:10', '2026-04-29 08:38:10'),
(4, 'Artist 2', 'artist2@test.com', '$2y$12$YxVufsn./CxIVm580apvm.q9Hm4sxNjRdV4/seRlaCJQ5cD9G/sLq', 'artist', '2026-04-29 08:38:10', '2026-04-29 08:38:10'),
(5, 'Artist 3', 'artist3@test.com', '$2y$12$HzPUZl47grw5JJ3KN9MtcuzxlRn06bNAJny2XGC0qZqKjGdhKwuGG', 'artist', '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(6, 'Artist 4', 'artist4@test.com', '$2y$12$iJiXkKhC/rb3g7iP7cMuVeAei8mV98ON.0sjQxRvCGDGwbMa3Q6gG', 'artist', '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(7, 'Artist 5', 'artist5@test.com', '$2y$12$5Vse6Ji3RZCIvn3xjWNf5ekQMr.WsNywcsIjXaUOSWKenZZ9IIV8S', 'artist', '2026-04-29 08:38:11', '2026-04-29 08:38:11'),
(8, 'Artist 6', 'artist6@test.com', '$2y$12$F2JBKsz878..TibkN6FabuF.9K6tuvfxoCRctEc1um/sNcuubrt3a', 'artist', '2026-04-29 08:38:11', '2026-04-29 08:38:11');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `available_slots`
--
ALTER TABLE `available_slots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `available_slots_nail_artist_id_foreign` (`nail_artist_id`);

--
-- A tábla indexei `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_nail_artist_id_foreign` (`nail_artist_id`),
  ADD KEY `bookings_available_slot_id_foreign` (`available_slot_id`),
  ADD KEY `bookings_service_id_foreign` (`service_id`);

--
-- A tábla indexei `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallery_images_nail_artist_id_foreign` (`nail_artist_id`);

--
-- A tábla indexei `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `nail_artists`
--
ALTER TABLE `nail_artists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nail_artists_user_id_foreign` (`user_id`);

--
-- A tábla indexei `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- A tábla indexei `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ratings_user_id_foreign` (`user_id`),
  ADD KEY `ratings_nail_artist_id_foreign` (`nail_artist_id`);

--
-- A tábla indexei `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reports_rating_id_foreign` (`rating_id`),
  ADD KEY `reports_reported_by_foreign` (`reported_by`);

--
-- A tábla indexei `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_nail_artist_id_foreign` (`nail_artist_id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `available_slots`
--
ALTER TABLE `available_slots`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT a táblához `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT a táblához `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT a táblához `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT a táblához `nail_artists`
--
ALTER TABLE `nail_artists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT a táblához `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `available_slots`
--
ALTER TABLE `available_slots`
  ADD CONSTRAINT `available_slots_nail_artist_id_foreign` FOREIGN KEY (`nail_artist_id`) REFERENCES `nail_artists` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_available_slot_id_foreign` FOREIGN KEY (`available_slot_id`) REFERENCES `available_slots` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bookings_nail_artist_id_foreign` FOREIGN KEY (`nail_artist_id`) REFERENCES `nail_artists` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD CONSTRAINT `gallery_images_nail_artist_id_foreign` FOREIGN KEY (`nail_artist_id`) REFERENCES `nail_artists` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `nail_artists`
--
ALTER TABLE `nail_artists`
  ADD CONSTRAINT `nail_artists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_nail_artist_id_foreign` FOREIGN KEY (`nail_artist_id`) REFERENCES `nail_artists` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_rating_id_foreign` FOREIGN KEY (`rating_id`) REFERENCES `ratings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_reported_by_foreign` FOREIGN KEY (`reported_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_nail_artist_id_foreign` FOREIGN KEY (`nail_artist_id`) REFERENCES `nail_artists` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
