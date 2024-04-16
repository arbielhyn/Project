-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 16, 2024 at 10:33 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coffee`
--

-- --------------------------------------------------------

--
-- Table structure for table `cafe`
--

CREATE TABLE `cafe` (
  `Shop_id` int(10) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `Description` varchar(500) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cafe`
--

INSERT INTO `cafe` (`Shop_id`, `Name`, `Image`, `Description`, `category_id`, `created_at`, `updated_at`) VALUES
(4, 'Latte', 'yum.jpeg', 'A <b>latte</b> is a popular coffee beverage crafted by combining espresso with steamed milk and a small layer of foam on top. It typically features a balanced ratio of milk to espresso, resulting in a creamy texture and a milder coffee flavor compared to other espresso-based drinks. Lattes can be customized with various syrups or flavorings according to personal taste preferences, making them a versatile choice enjoyed by coffee enthusiasts worldwide.', 2, '2024-03-30 22:19:01', '2024-04-09 20:19:24'),
(5, 'Mocha', 'beans.jpeg', 'A mocha is a delightful coffee drink that blends the rich flavors of espresso with chocolate. This decadent beverage combines shots of espresso with steamed milk and chocolate syrup or cocoa powder, creating a luscious and indulgent flavor profile. Topped with a dollop of whipped cream, mochas offer a perfect balance of caffeine kick and sweet chocolate goodness.', 2, '2024-03-06 23:19:01', '2024-04-08 21:11:41'),
(6, 'Cappuccino', '', 'A cappuccino is a classic Italian coffee made with equal parts espresso, steamed milk, and milk foam. Its rich flavor and creamy texture result from the careful balance of these ingredients. Served in a small cup, it&#039;s a beloved indulgence enjoyed for its bold espresso kick and luxurious frothy finish.', 2, '2024-03-12 22:19:01', '2024-04-08 21:11:41'),
(7, 'Cortado', 'cortado.jpeg', 'A cortado is a Spanish coffee beverage consisting of equal parts espresso and warm milk. Unlike a cappuccino or latte, it has a stronger coffee flavor due to the minimal amount of milk used. The result is a smooth, balanced drink that&#039;s smaller in size but big on taste.', 2, '2024-03-19 22:19:01', '2024-04-08 21:11:41'),
(8, 'Espresso', '', 'Espresso is a concentrated form of coffee made by forcing hot water through finely-ground coffee beans under high pressure. It&#039;s characterized by its intense flavor, strong aroma, and rich crema on top. Served in small shots, espresso is the foundation of many coffee beverages, prized for its boldness and versatility.', 2, '2024-03-11 22:19:01', '2024-04-08 21:11:41'),
(9, 'Matcha', 'matcha.jpeg', 'Matcha is a vibrant green powdered tea made from finely ground, shade-grown green tea leaves. It&#039;s renowned for its earthy flavor, rich umami notes, and vibrant color. Packed with antioxidants and nutrients, matcha offers a smooth, energizing boost without the jitters. It&#039;s cherished for its unique taste and health benefits.\r\n\r\n\r\n\r\n\r\n', 1, '2024-03-14 22:19:01', '2024-04-08 21:11:41'),
(10, 'London Fog', '', 'A London Fog is a delightful tea-based beverage featuring Earl Grey tea, steamed milk, and vanilla syrup. It boasts a fragrant aroma and comforting taste, with the citrusy notes of Earl Grey harmonizing beautifully with the creamy milk and sweet vanilla. It&#039;s a soothing and flavorful treat perfect for any time of day.', 1, '2024-03-23 22:19:01', '2024-04-08 21:11:41'),
(11, 'Cold Brew', '', 'Cold brew is a refreshing coffee brewing method where coarse coffee grounds are steeped in cold water for an extended period, typically 12-24 hours. The result is a smooth, low-acid coffee concentrate that&#039;s served chilled or over ice. Cold brew offers a bold flavor profile and is a favorite for warm weather enjoyment.', 3, '2024-03-26 22:19:01', '2024-04-08 21:11:41'),
(12, 'Lungo', '', '&quot;Lungo&quot; is an Italian term used in coffee culture to describe a long espresso shot. It&#039;s made by extracting more water through the same amount of finely ground coffee, resulting in a larger and slightly milder coffee than a standard espresso. Lungo retains the intensity of espresso with a smoother finish.', 2, '2024-03-10 22:19:01', '2024-04-08 21:11:41'),
(14, 'Americano', '', 'An Americano is a popular coffee drink made by diluting espresso with hot water, creating a milder and larger beverage. It retains the boldness and aroma of espresso while offering a smoother taste. The Americano is enjoyed for its versatility, catering to those who prefer a lighter coffee experience without compromising on flavor.', 2, '2024-03-22 22:19:01', '2024-04-08 21:11:41'),
(15, 'Flat White', '', 'A flat white is a velvety-smooth coffee beverage originating from Australia and New Zealand. It&#039;s made by pouring microfoam over a double shot of espresso, resulting in a creamy and balanced drink. The flat white offers a harmonious blend of espresso and steamed milk, characterized by its rich flavor and velvety texture.\r\n', 2, '2024-03-17 22:19:01', '2024-04-08 21:11:41'),
(16, 'Machiato', 'coffee.jpeg', 'A macchiato, translating to &quot;stained&quot; or &quot;marked&quot; in Italian, is a simple yet flavorful espresso-based drink. It&#039;s crafted by adding a small amount of steamed milk or milk foam to a shot of espresso, resulting in a bold coffee flavor with a hint of creaminess. The macchiato is enjoyed for its intensity and balance.', 2, '2024-03-19 22:19:01', '2024-04-08 21:11:41'),
(37, 'Iced Cap', 'Drip.jpeg', 'EW', 5, '2024-04-02 22:20:35', '2024-04-08 21:11:41'),
(38, 'Double Espresso', 'latte.jpeg', 'Why would you do this to yourself?', 2, '2024-04-02 22:34:33', '2024-04-08 21:11:41'),
(40, 'Iced Tea', 'ice tea.jpeg', 'Refreshing', 1, '2024-04-03 16:36:35', '2024-04-08 21:11:41'),
(46, 'Lemonade', NULL, '<p><b>Tasty </b>lemons</p>', 4, '2024-04-10 16:03:52', '2024-04-10 16:04:31');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `type_id` int(11) NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`type_id`, `type`) VALUES
(1, 'Tea'),
(2, 'Espresso'),
(3, 'Brewed'),
(4, 'Juice'),
(5, 'Frappe'),
(6, 'Vanilla'),
(7, 'Steeped');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment` varchar(500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL,
  `shop_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment`, `created_at`, `user_id`, `shop_id`) VALUES
(3, 'i love it', '2024-03-25 23:46:14', 2, 5),
(8, 'i love earth tastes', '2024-03-26 22:04:18', 2, 9),
(9, 'broski barista approve', '2024-03-28 23:42:06', 2, 7),
(10, 'hey!!', '2024-04-02 18:38:27', 2, 4),
(11, 'It\'s so bitter the chocolate is too much', '2024-04-04 01:24:00', 2, 5),
(12, 'that\'s pretty latte art', '2024-04-09 01:42:33', 2, 7);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Password` varchar(5000) NOT NULL,
  `user_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `Username`, `Password`, `user_type`) VALUES
(2, 'coffeelover', '$2y$10$NhmNh5mCpeh379gCM1.vquctc3SIbBnM/NVHBrNhoZvFStdkDK5Na', 'admin'),
(3, 'latteart', '$2y$10$OHLy/ixkbBYCi5PmwItajePIfQu8PGdFCsb1FyxG0vZRyQ9URorJy', 'user'),
(4, 'onecoffee', '$2y$10$UtErMo/kWxdehuruUIY9w.kx2QfM5OiOyim/FDAPGUYWKM.kLeUWa', 'user'),
(6, 'patrick', '$2y$10$iw.LxuiNAA4CR8KwZkBhNOj10LFZXJrLmOap/brD/A4PRPYPml7J.', 'user'),
(8, 'spongebob', '$2y$10$j/Czax2qiJIudz.wU9ZyLuuA2II3oBYY35honUc0hmlPP/pJRG6w.', 'admin'),
(9, 'mrkrabs', '$2y$10$sguRvl9tErdv4B5vPs5DOuMz6y5GeOwdgax/xDP.XT/T5H0hyToMC', 'user'),
(10, 'frank', '$2y$10$BtWISbB1F8ZLBDNa.HgDmewsAFjVoAgKbFkCXruRDxmHBFYWlCt.y', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cafe`
--
ALTER TABLE `cafe`
  ADD PRIMARY KEY (`Shop_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cafe`
--
ALTER TABLE `cafe`
  MODIFY `Shop_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cafe`
--
ALTER TABLE `cafe`
  ADD CONSTRAINT `cafe_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
