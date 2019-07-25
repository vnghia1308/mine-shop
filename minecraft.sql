-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 25, 2019 lúc 07:28 PM
-- Phiên bản máy phục vụ: 10.1.38-MariaDB
-- Phiên bản PHP: 7.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `minecraft`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ls_actions`
--

CREATE TABLE `ls_actions` (
  `id` int(11) NOT NULL,
  `timestamp` datetime DEFAULT NULL,
  `unique_user_id` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `service` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ls_inventories`
--

CREATE TABLE `ls_inventories` (
  `id` int(11) NOT NULL,
  `helmet` text COLLATE utf8_bin,
  `chestplate` text COLLATE utf8_bin,
  `leggings` text COLLATE utf8_bin,
  `boots` text COLLATE utf8_bin,
  `off_hand` text COLLATE utf8_bin,
  `contents` mediumtext COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ls_locations`
--

CREATE TABLE `ls_locations` (
  `id` int(11) NOT NULL,
  `world` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `x` double DEFAULT NULL,
  `y` double DEFAULT NULL,
  `z` double DEFAULT NULL,
  `yaw` int(11) DEFAULT NULL,
  `pitch` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ls_players`
--

CREATE TABLE `ls_players` (
  `id` int(11) NOT NULL,
  `unique_user_id` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `last_name` varchar(16) COLLATE utf8_bin DEFAULT NULL,
  `ip_address` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `hashing_algorithm` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `inventory_id` int(11) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `registration_date` date DEFAULT NULL,
  `optlock` bigint(20) NOT NULL,
  `uuid_mode` varchar(1) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ls_upgrades`
--

CREATE TABLE `ls_upgrades` (
  `id` int(11) NOT NULL,
  `version` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `applied_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shop_items`
--

CREATE TABLE `shop_items` (
  `id` int(11) NOT NULL,
  `item_name` text COLLATE utf8_bin NOT NULL,
  `item_id` text COLLATE utf8_bin NOT NULL,
  `item_icon` text COLLATE utf8_bin NOT NULL,
  `item_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Đang đổ dữ liệu cho bảng `shop_items`
--

INSERT INTO `shop_items` (`id`, `item_name`, `item_id`, `item_icon`, `item_price`) VALUES
(1, 'Stone', 'minecraft:stone', 'icon items-28-1-0', 10),
(2, 'Grass', 'minecraft:grass_block', 'icon items-28-2-0', 5),
(3, 'Cobblestone', 'minecraft:cobblestone', 'icon items-28-4-0', 20),
(4, 'Oak Plank', 'minecraft:oak_planks', 'icon items-28-5-0', 40),
(5, 'Spruce Plank', 'minecraft:spruce_planks', 'icon items-28-5-1', 40),
(6, 'Birch Plank', 'minecraft:birch_planks', 'icon items-28-5-2', 40),
(7, 'Jungle Plank', 'minecraft:jungle_planks', 'icon items-28-5-3', 40),
(8, 'Acacia Plank', 'minecraft:acacia_planks', 'icon items-28-5-4', 40),
(9, 'Dark Oak Plank', 'minecraft:dark_oak_planks', 'icon items-28-5-5', 40),
(10, 'Glass', 'minecraft:glass', 'icon items-28-20-0', 100),
(11, 'White Wool', 'minecraft:white_wool', 'icon items-28-35-0', 150),
(12, 'Orange Wool', 'minecraft:orange_wool', 'icon items-28-35-1', 150),
(13, 'Magenta Wool', 'minecraft:magenta_wool', 'icon items-28-35-2', 150),
(14, 'Light Blue Wool', 'minecraft:light_blue_wool', 'icon items-28-35-3', 150),
(15, 'Yellow Wool', 'minecraft:yellow_wool', 'icon items-28-35-4', 150),
(16, 'Lime Wool', 'minecraft:lime_wool', 'icon items-28-35-5', 150),
(17, 'Gray Wool', 'minecraft:gray_wool', 'icon items-28-35-7', 150),
(18, 'Light Gray Wool', 'minecraft:light_gray_wool', 'icon items-28-35-8', 150),
(19, 'Cyan Wool', 'minecraft:cyan_wool', 'icon items-28-35-9', 150),
(20, 'Purple Wool', 'minecraft:purple_wool', 'icon items-28-35-10', 150),
(21, 'Blue Wool', 'minecraft:blue_wool', 'icon items-28-35-11', 150),
(22, 'Brown Wool', 'minecraft:brown_wool', 'icon items-28-35-12', 150),
(23, 'Green Wool', 'minecraft:green_wool', 'icon items-28-35-13', 150),
(24, 'Red Wool', 'minecraft:red_wool', 'icon items-28-35-14', 150),
(25, 'Black Wool', 'minecraft:black_wool', 'icon items-28-35-15', 150),
(26, 'Raw Mutton', 'minecraft:mutton', 'icon items-28-423-0', 300),
(27, 'Raw Rabbit', 'minecraft:rabbit', 'icon items-28-411-0', 600),
(28, 'Raw Chicken', 'minecraft:chicken', 'icon items-28-365-0', 300),
(29, 'Iron Shovel', 'minecraft:iron_shovel', 'icon items-28-256-0', 2000),
(30, 'Iron Pickaxe', 'minecraft:iron_pickaxe', 'icon items-28-257-0', 2000),
(31, 'Iron Axe', 'minecraft:iron_axe', 'icon items-28-258-0', 2000),
(32, 'Iron Sword', 'minecraft:iron_sword', 'icon items-28-267-0', 2000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `transaction_history`
--

CREATE TABLE `transaction_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` text COLLATE utf8_bin NOT NULL,
  `item_id` text COLLATE utf8_bin NOT NULL,
  `item_count` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `method` text COLLATE utf8_bin NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Đang đổ dữ liệu cho bảng `transaction_history`
--

INSERT INTO `transaction_history` (`id`, `user_id`, `user_name`, `item_id`, `item_count`, `total_price`, `method`, `date_time`) VALUES
(1, 1, 'vynghia', 'minecraft:stone', 1, 10, '+', '2019-07-23 20:10:14'),
(2, 1, 'vynghia', 'minecraft:stone', 1, 7, '-', '2019-07-23 20:10:36'),
(3, 3, 'FallenAngel', 'minecraft:cobblestone', 64, 1280, '+', '2019-07-23 20:17:15'),
(4, 3, 'FallenAngel', 'minecraft:oak_planks', 64, 2560, '+', '2019-07-23 20:17:30'),
(5, 1, 'vynghia', 'minecraft:light_gray_wool', 1, 150, '+', '2019-07-23 20:41:39'),
(6, 1, 'vynghia', 'minecraft:cyan_wool', 1, 150, '+', '2019-07-23 20:42:57'),
(7, 1, 'vynghia', 'minecraft:black_wool', 1, 150, '+', '2019-07-23 20:43:12'),
(8, 3, 'FallenAngel', 'minecraft:white_wool', 3, 450, '+', '2019-07-23 20:53:43'),
(9, 3, 'FallenAngel', 'minecraft:oak_planks', 40, 1600, '+', '2019-07-23 21:48:31'),
(10, 3, 'FallenAngel', 'minecraft:white_wool', 3, 450, '+', '2019-07-23 21:48:44'),
(11, 3, 'FallenAngel', 'minecraft:mutton', 4, 1200, '+', '2019-07-23 21:49:04'),
(12, 3, 'FallenAngel', 'minecraft:cobblestone', 64, 896, '-', '2019-07-24 08:21:59'),
(13, 3, 'FallenAngel', 'minecraft:cobblestone', 64, 896, '-', '2019-07-24 08:22:51'),
(14, 3, 'FallenAngel', 'minecraft:cobblestone', 64, 896, '-', '2019-07-24 08:33:01'),
(15, 3, 'FallenAngel', 'minecraft:oak_planks', 64, 2560, '+', '2019-07-24 08:34:08'),
(16, 3, 'FallenAngel', 'minecraft:cobblestone', 25, 500, '+', '2019-07-24 13:31:53'),
(17, 3, 'FallenAngel', 'minecraft:jungle_planks', 30, 1200, '+', '2019-07-24 13:32:52'),
(18, 3, 'FallenAngel', 'minecraft:cobblestone', 64, 896, '-', '2019-07-24 14:03:26'),
(19, 3, 'FallenAngel', 'minecraft:cobblestone', 64, 896, '-', '2019-07-24 14:29:28'),
(20, 3, 'FallenAngel', 'minecraft:cobblestone', 64, 896, '-', '2019-07-24 14:30:02'),
(21, 3, 'FallenAngel', 'minecraft:cobblestone', 64, 896, '-', '2019-07-24 14:33:38'),
(22, 3, 'FallenAngel', 'minecraft:cobblestone', 64, 896, '-', '2019-07-24 14:40:22'),
(23, 3, 'FallenAngel', 'minecraft:oak_planks', 64, 2560, '+', '2019-07-24 14:40:39'),
(24, 3, 'FallenAngel', 'minecraft:cobblestone', 64, 896, '-', '2019-07-24 14:53:20'),
(25, 4, 'YonsOmega', 'minecraft:cobblestone', 64, 896, '-', '2019-07-24 19:59:12'),
(26, 4, 'YonsOmega', 'minecraft:cobblestone', 64, 896, '-', '2019-07-24 19:59:14'),
(27, 4, 'YonsOmega', 'minecraft:cobblestone', 64, 896, '-', '2019-07-24 19:59:15'),
(28, 4, 'YonsOmega', 'minecraft:cobblestone', 64, 896, '-', '2019-07-24 19:59:15'),
(29, 4, 'YonsOmega', 'minecraft:cobblestone', 64, 896, '-', '2019-07-24 19:59:15'),
(30, 4, 'YonsOmega', 'minecraft:cobblestone', 64, 896, '-', '2019-07-24 19:59:23'),
(31, 4, 'YonsOmega', 'minecraft:cobblestone', 64, 896, '-', '2019-07-24 19:59:24'),
(32, 4, 'YonsOmega', 'minecraft:cobblestone', 64, 896, '-', '2019-07-24 19:59:24'),
(33, 4, 'YonsOmega', 'minecraft:cobblestone', 64, 896, '-', '2019-07-24 19:59:24'),
(34, 4, 'YonsOmega', 'minecraft:cobblestone', 64, 896, '-', '2019-07-24 19:59:24'),
(35, 4, 'YonsOmega', 'minecraft:cobblestone', 64, 896, '-', '2019-07-24 19:59:45'),
(36, 4, 'YonsOmega', 'minecraft:cobblestone', 64, 896, '-', '2019-07-24 19:59:45'),
(37, 4, 'YonsOmega', 'minecraft:cobblestone', 64, 896, '-', '2019-07-24 19:59:46'),
(38, 4, 'YonsOmega', 'minecraft:cobblestone', 64, 896, '-', '2019-07-24 19:59:46'),
(39, 4, 'YonsOmega', 'minecraft:cobblestone', 64, 896, '-', '2019-07-24 19:59:46'),
(40, 4, 'YonsOmega', 'minecraft:oak_planks', 64, 2560, '+', '2019-07-24 20:46:56'),
(41, 4, 'YonsOmega', 'minecraft:oak_planks', 64, 2560, '+', '2019-07-24 20:52:06'),
(42, 8, 'Phuc', 'minecraft:cobblestone', 14, 196, '-', '2019-07-25 16:12:06'),
(43, 8, 'Phuc', 'minecraft:chicken', 1, 300, '+', '2019-07-25 16:13:09'),
(44, 8, 'Phuc', 'minecraft:chicken', 1, 300, '+', '2019-07-25 16:14:33'),
(45, 8, 'Phuc', 'minecraft:cobblestone', 14, 196, '-', '2019-07-25 16:14:52'),
(46, 8, 'Phuc', 'minecraft:chicken', 2, 600, '+', '2019-07-25 16:24:41'),
(47, 8, 'Phuc', 'minecraft:iron_Pickaxe', 1, 2000, '+', '2019-07-25 16:25:09'),
(48, 8, 'Phuc', 'minecraft:iron_Pickaxe', 1, 2000, '+', '2019-07-25 16:25:49'),
(49, 1, 'vynghia', 'minecraft:iron_Pickaxe', 1, 2000, '+', '2019-07-25 16:27:02'),
(50, 1, 'vynghia', 'minecraft:iron_Pickaxe', 1, 2000, '+', '2019-07-25 16:27:12'),
(51, 1, 'vynghia', 'minecraft:iron_pickaxe', 1, 2000, '+', '2019-07-25 16:28:27'),
(52, 3, 'FallenAngel', 'minecraft:cobblestone', 64, 896, '-', '2019-07-25 18:01:28'),
(53, 3, 'FallenAngel', 'minecraft:cobblestone', 64, 896, '-', '2019-07-25 18:01:31'),
(54, 3, 'FallenAngel', 'minecraft:cobblestone', 64, 896, '-', '2019-07-25 18:01:34'),
(55, 3, 'FallenAngel', 'minecraft:cobblestone', 64, 896, '-', '2019-07-25 18:01:38'),
(56, 3, 'FallenAngel', 'minecraft:cobblestone', 64, 896, '-', '2019-07-25 18:24:40'),
(57, 3, 'FallenAngel', 'minecraft:oak_planks', 64, 2560, '+', '2019-07-25 18:25:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users_data`
--

CREATE TABLE `users_data` (
  `id` int(11) NOT NULL,
  `player_name` text COLLATE utf8_bin NOT NULL,
  `bdcoins` int(11) NOT NULL,
  `loot_box` int(11) NOT NULL,
  `admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `ls_actions`
--
ALTER TABLE `ls_actions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ls_inventories`
--
ALTER TABLE `ls_inventories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ls_locations`
--
ALTER TABLE `ls_locations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ls_players`
--
ALTER TABLE `ls_players`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ls_upgrades`
--
ALTER TABLE `ls_upgrades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_ls_upgrades_version` (`version`);

--
-- Chỉ mục cho bảng `shop_items`
--
ALTER TABLE `shop_items`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users_data`
--
ALTER TABLE `users_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `ls_actions`
--
ALTER TABLE `ls_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `ls_inventories`
--
ALTER TABLE `ls_inventories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `ls_locations`
--
ALTER TABLE `ls_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `ls_players`
--
ALTER TABLE `ls_players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `ls_upgrades`
--
ALTER TABLE `ls_upgrades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `shop_items`
--
ALTER TABLE `shop_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `transaction_history`
--
ALTER TABLE `transaction_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT cho bảng `users_data`
--
ALTER TABLE `users_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
