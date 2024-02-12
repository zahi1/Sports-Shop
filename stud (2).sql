-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2023 at 09:23 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stud`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL,
  `ip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `username`, `message`, `created_at`, `ip`) VALUES
(1, 'zz', 'zzz', '2023-11-18 15:50:21', '127.0.0.1'),
(2, 'zz', 'zzzzzzzz', '2023-11-18 15:52:39', '127.0.0.1'),
(3, 'qq', 'qwe3rfgfed', '2023-11-18 16:11:25', '127.0.0.1'),
(4, 'ss', 'swdefrtgrfdes', '2023-11-18 16:18:25', '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_status` varchar(255) NOT NULL DEFAULT 'Pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `quantity`, `order_status`, `created_at`, `address`) VALUES
(1, 57, 4, 1, 'Shipped', '2023-11-28 21:26:07', NULL),
(2, 57, 4, 4, 'Delivered', '2023-11-28 21:26:16', NULL),
(3, 57, 4, 5, 'Pending', '2023-11-28 21:27:17', NULL),
(4, 57, 4, 4, 'Delivered', '2023-11-28 21:39:18', NULL),
(5, 45, 4, 4, 'Pending', '2023-11-28 21:54:48', NULL),
(6, 45, 8, 4, 'Pending', '2023-11-28 21:54:48', NULL),
(7, 57, 8, 5, 'Pending', '2023-11-29 00:30:53', NULL),
(8, 57, 4, 7, 'Shipped', '2023-11-29 02:01:12', NULL),
(9, 57, 8, 1, 'Pending', '2023-11-29 02:02:41', NULL),
(10, 57, 10, 1, 'Pending', '2023-11-29 02:04:33', NULL),
(11, 57, 4, 1, 'Pending', '2023-11-29 02:08:19', NULL),
(12, 57, 4, 1, 'Pending', '2023-11-29 02:08:33', NULL),
(13, 57, 8, 1, 'Pending', '2023-11-29 02:10:57', NULL),
(14, 57, 4, 1, 'Pending', '2023-11-29 02:12:37', NULL),
(15, 57, 4, 1, 'Pending', '2023-11-29 02:14:26', NULL),
(16, 57, 8, 1, 'Pending', '2023-11-29 02:14:26', NULL),
(17, 57, 9, 4, 'Pending', '2023-11-29 02:25:06', NULL),
(18, 57, 10, 1, 'Pending', '2023-11-29 02:25:22', NULL),
(19, 57, 9, 2, 'Pending', '2023-11-29 02:25:36', NULL),
(20, 57, 4, 4, 'Pending', '2023-11-29 09:12:51', NULL),
(21, 57, 12, 4, 'Pending', '2023-11-29 09:39:54', NULL),
(22, 57, 10, 1, 'Pending', '2023-11-29 09:40:55', NULL),
(23, 57, 11, 3, 'Pending', '2023-11-29 09:40:55', NULL),
(24, 57, 12, 2, 'Delivered', '2023-11-29 09:40:55', NULL),
(25, 57, 10, 3, 'Pending', '2023-11-29 09:59:56', 'A. Pureno g.20'),
(26, 57, 12, 4, 'Pending', '2023-11-29 10:00:59', 'Griciupio g.57'),
(27, 57, 9, 4, 'Pending', '2023-11-29 10:19:49', 'A. Pureno g.20');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `sizes` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `category`, `description`, `image_path`, `quantity`, `sizes`) VALUES
(4, 'Adidas', '120.00', 'Shoes', 'Good old days shoes.', 'https://st4.depositphotos.com/15923508/26337/i/1600/depositphotos_263375406-stock-photo-adidas-nmd-xr1-duck-camo.jpg', 0, NULL),
(8, 'Nike', '80.00', 'Shoes', 'The one and only.', 'https://t3.ftcdn.net/jpg/04/79/14/06/360_F_479140608_7xjG5HfKnYSDoEErrGYaSDIVzNPPxArw.jpg', 0, NULL),
(9, 'Jacket', '60.00', 'Jacket', 'The jacket.', 'https://www.stormtech.ca/cdn/shop/products/QX-1_FRONT_AzureBlue_b25b323a-4e71-4f4b-8c95-0083026df8a7_2000x.jpg?v=1687562447', 0, NULL),
(10, 'Nike', '120.00', 'Shoes', 'Sweeten your look with this AJ1. Reimagining MJ\\\\\\\'s first hit shoe', 'https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco,u_126ab356-44d8-4a06-89b4-fcdcc8df0245,c_scale,fl_relative,w_1.0,h_1.0,fl_layer_apply/471ea91b-5476-4d92-b262-41cd100aad48/air-jordan-1-retro-high-og-womens-shoes-SsFGW3.png', 0, NULL),
(11, 'Reversible Jacket', '91.00', 'Jacket', 'Two moods, one undeniable fashion statement. This reversible jacket lets you create a look based on your vibe of the moment.', 'https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/7523726d7833401ca8b8f119b7df7478_9366/Embossed_Reversible_Jacket_Black_IJ6424_22_hover_model.jpg', 0, NULL),
(12, 'Adilette Slides', '40.00', 'Slides', 'Inspired by the adidas sports slides first seen in the \\\'70s, these slides are a fresh take on the famous Adilette style. With their clean shape and distinctive 3-Stripes', 'https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/4fb767d5f80443be9d08aeb401169a66_9366/Adilette_Comfort_Slides_Black_GX9835_04_standard.jpg', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `zahi_elhelou_users`
--

CREATE TABLE `zahi_elhelou_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `ip` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zahi_elhelou_users`
--

INSERT INTO `zahi_elhelou_users` (`id`, `username`, `email`, `password`, `created`, `ip`, `role`) VALUES
(20, 'ppp', 'ppp@gmail.com', '$2y$10$iessiK.Uyxg8oI18Jb4/h.2OV2g.Ifa809KIMQx/p89pNLO3Kk0Ae', '2023-11-18 18:18:46', '127.0.0.1', 'customer'),
(26, 'zahelll', 'zahel@ktu.lt', '$2y$10$SPqZ28ypCYv/UZiEbBJivuuCzUKxQhYyoMwwg2xhuuKkYy1SXurAi', '0000-00-00 00:00:00', '', 'employee'),
(38, 'jjkk', 'jj@gmail.com', '$2y$10$v03QiBPKsZnuqUaWavjI6eVN.OOoXQKAyqVdKIUREyzEa30/XOcSa', '2023-11-18 18:50:58', '127.0.0.1', 'admin'),
(39, 'jjjkkk', 'jjjkkk@gmail.com', '$2y$10$DAu47vG1pjVSF.RsYWHUWeA3HqGeeK4nCaQFC3939TmM3baFOI8Bu', '0000-00-00 00:00:00', '', 'customer'),
(40, 'zuz', 'zuz@gmail.com', '$2y$10$BR3K6dEsbuhkE064FsnLVOzZzQ7U6eebwni6zVbsbNL6pfR7GPX0y', '2023-11-18 18:52:38', '127.0.0.1', 'admin'),
(43, 'zz', 'zz@gmail.com', '$2y$10$ulAafDH/5iCy3YClIq4NreVVPMCt.qRCZgjQGqXGcOdK.wFYwCPrO', '2023-11-19 00:59:48', '127.0.0.1', 'employee'),
(44, 'ee ee ee', 'ee@gmail.com', '$2y$10$qRz/L3mkL3OaNdVnXjadRuHGyM.qFWHQIHW8WTw.0MG9zjLrYKFhG', '2023-11-19 01:42:33', '127.0.0.1', 'employee'),
(45, 'gg', 'gg@gmail.com', '$2y$10$OZ83Wb35OZx5Xka8sF..XeN.Sj8VlHDPy32MO26/FCqOSKsFBpQ9u', '2023-11-19 03:36:08', '127.0.0.1', 'customer'),
(46, 'hhh', 'hhh@gmail.com', '$2y$10$L8GEeMba8NiSHcmonK1sBurtZcris8KABYDd9vs9SP3XMUxPS2hKa', '2023-11-19 04:13:04', '127.0.0.1', 'customer'),
(47, 'qq', 'qq@gmail.com', '$2y$10$R.hJYzZw1KU3oa81jiniieVG8gFo8LIB4sd3wKh57eJKDCcpW3LHq', '2023-11-19 11:00:27', '127.0.0.1', 'admin'),
(48, 'ww', 'ww@gmail.com', '$2y$10$dwjoVEjeIUlt1DHQ4VPeXOcHUaj16QB6dfUgyH8BGPNlWk2Y1oS12', '2023-11-19 11:00:43', '127.0.0.1', 'employee'),
(49, 'za', 'za@gmail.com', '$2y$10$5.y96eYwIQ.5kzvFJyNjhu7BTBi0T/t1OO7urZzr4ujk8GbP/8cE2', '2023-11-19 13:36:38', '127.0.0.1', 'admin'),
(50, 'xa', 'xa@gmail.com', '$2y$10$58LICBP.cQuhHMoanfNQPedvYkleMh9.Iu.w6x6b9FFm/bfoU16Vy', '2023-11-19 13:37:57', '127.0.0.1', 'employee'),
(52, 'sss', 'sss@gmail.com', '$2y$10$XCQVaRFpDDCbYCdI38ZpsOHme5px.1wyILgYteW8m.PVsnHg1bPL2', '2023-11-21 18:45:43', '127.0.0.1', 'employee'),
(53, 'zahi', 'zahi@gmail.com', '$2y$10$9W.5/47pcZIEuhkyEWG/WO9wpQ3XlI4pBxUih3e/m2B3vBRipjG7.', '2023-11-22 08:30:07', '127.0.0.1', 'admin'),
(56, 'ee', 'ee@gmail.com', '$2y$10$2WQkOhz3mV4cyIvxo6z8G.k7f2p6dT2NVG8D42JH2g/hY92Y4NqIa', '2023-11-25 18:19:27', '127.0.0.1', 'employee'),
(57, 'cc', 'cc@gmail.com', '$2y$10$vaATh1GexlxCoOnIhuc31OrnKKoePf0GsL7CfMFlBQ7jbr76dJ.S.', '2023-11-25 18:19:49', '127.0.0.1', 'customer'),
(58, 'aa', 'aa@gmail.com', '$2y$10$x9Od4grUvyGXQGZXbmR8h.GG3ntxhqgYgSB0v4xuq/6P47sQYZtlO', '2023-11-25 18:32:50', '127.0.0.1', 'admin'),
(59, 'bahel', 'bahel@gmai.com', '$2y$10$rfdjWl4a2bt8HM3fuXZMZOqfC7qSZtl2ErsN7vSUWlaOxpOen17rW', '2023-11-27 12:26:14', '127.0.0.1', 'admin'),
(60, 'admin', 'admin@gmail.com', '$2y$10$1jPECmBi5RreX7q.vU8azeZ6ZLKtuPEZZjhv6qyXC9fNSg0tYDwLa', '2023-11-29 01:15:28', '127.0.0.1', 'admin'),
(62, 'employee', 'employee@gmail.com', '$2y$10$W3.V6uc1QkuzxkFEM.5N8OOS9cZ3okhY3Yr/L5u8dSOWuCimcB1XK', '2023-11-29 01:16:24', '127.0.0.1', 'employee');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zahi_elhelou_users`
--
ALTER TABLE `zahi_elhelou_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `zahi_elhelou_users`
--
ALTER TABLE `zahi_elhelou_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `zahi_elhelou_users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
