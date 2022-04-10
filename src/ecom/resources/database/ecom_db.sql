-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2022 at 10:54 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecom_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `cat_title` varchar(255) NOT NULL,
  `cat_description` text NOT NULL,
  `cat_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`, `cat_description`, `cat_image`) VALUES
(13, 'Computers', 'top laptops', 'category-computers.jpg'),
(23, 'Lawn Mowers', 'best grass maintenance', 'category-lawnmowers.jpg'),
(32, 'Televisions', 'latest screens', 'category-tvs.jpg'),
(34, 'Football Boots', 'keep active!', 'category-football.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_total` decimal(10,2) NOT NULL,
  `order_subtotal` decimal(10,2) NOT NULL,
  `order_shipping` decimal(10,2) NOT NULL,
  `order_currency` varchar(255) NOT NULL,
  `order_transaction` varchar(255) NOT NULL,
  `order_status` varchar(255) NOT NULL,
  `order_timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_cat_id` int(11) NOT NULL,
  `product_cat_title` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_description` text NOT NULL,
  `product_short_desc` text NOT NULL,
  `product_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_cat_id`, `product_cat_title`, `product_price`, `product_quantity`, `product_description`, `product_short_desc`, `product_image`) VALUES
(72, 'LG UP81', 32, 'Televisions', '459.00', 3, '1. Incredible 4K Ultra HD Experience vibrant picture quality in incredible detail with up to 4K clarity and lavish colours and contrast depth 2. Absorbing and atmospheric sound quality LG’s AI Sound feature puts you right at the centre of the action, creating an absorbing atmosphere in any room. 3. LG’s webOS smart platform Access all of your must-have apps like Freeview Play, NOW TV, Netflix, Prime Video, Disney+, Twitch and more on LG’s easy-to-use webOS smart platform. 4. Sleek and slim design with crescent stand A beautifully crafted TV to enhance any room, supported by a unique crescent stand design. 5. Easy voice control command with Google Assistant and Alexa Use voice control command with Google Assistant and Alexa to control your TV and your entire smart home with ease.', 'LG 55UP81006LR 55 inch 4K UHD HDR Smart LED TV (2021 Model) [Energy Class G]', 'product-lgtv.jpg'),
(73, 'Samsung', 32, 'Televisions', '379.00', 5, 'Experience Life In Ultra HD With The AU8000 – Our 43 Inch Smart TV doesn’t compromise on greatness. Offering dynamic crystal colour, adaptive sound audio, built in voice assistants &amp; streaming services; all contained within a sleek air slim design. Witness stunning visuals on your Samsung Smart TV- immerse yourself in the magic of tv with striking detail that bursts from the screen. Get that cinematic feeling straight from your living room.', 'Samsung AU8000 43 Inch Smart TV (2021) - Crystal 4K AirSlim Smart TV with HDR10+', 'product-samsungtv.jpg'),
(74, 'JVC Fire TV', 32, 'Televisions', '269.00', 4, 'JVC Fire TV is a new generation of television featuring the Fire TV experience built-in and including a Voice Remote with Alexa. With true-to-life 4K Ultra HD picture quality and access to movies and TV shows you love, JVC delivers a TV experience that gets smarter every day. The Voice Remote with Alexa lets you do everything you would expect from a remote—plus, easily launch apps, search for titles, play music, switch inputs, control compatible smart home devices, and more, using your voice.Smart but simple in every way. Just plug it in, connect to Wi-Fi, and enjoy.', 'JVC Fire TV 43 inch Smart 4K Ultra HD HDR LED TV with FreeviewPlay and true-to-life 4K', 'product-jvc_fire_tv.jpg'),
(75, 'Bosch Rotak', 23, 'Lawnmowers', '119.00', 7, 'Perfectly cut lawn. You are guaranteed a perfect finish thanks to the rotary blade and the advanced 1300W Powerdrive motor. The integrated rear roller also gives your lawn a lovely striped effect With inset front heels and grass combs the Rotak 34 R can cut grass growing close to or over the edge of your lawn. This ensures that no uncut grass is left behind even when cutting up against flower beds, walls or paths, reducing the need for trimming.', 'Bosch Electric Lawnmower Rotak 34R 1300 W, Cutting Width: 34 cm, Cutting Height: 20-70 mm', 'product-Bosch Rotak 34R.jpg'),
(76, 'Flymo 32V', 23, 'Lawn Mowers', '89.99', 3, 'Utilises a powerful 1200W motor and 32cm cutting width so you can tackle your lawn with ease. Choose your ideal cutting height with a choice of three settings between 20 to 60 mm for a perfect lawn. Equipped with dual lever handles allow you to comfortably operate the lawn mower with either hand for greater flexibility and manoeuvrability. It’s 10m cable gives you the freedom and flexibility to move around your garden area without the need to worry about reach. Equipped with a large 29L grass box so you can spend less time emptying as well as a rear roller for a striped finish to your lawn', 'Flymo Chevron 32 V Electric Wheeled Lawn Mower, 1200 W, Cutting Width 32 cm. Dual levers', 'product-Flymo-Chevron-32VC.jpg'),
(77, 'Ryobi OLM', 23, 'Lawn Mowers', '159.95', 2, '33cm (13”) cutting path designed for easy manoeuvrability around the garden. Cordless Battery convenience - no potentially dangerous mains cable or messy petrol. Mow right to the perimeter with easy edge grass Comb feature – no need to finish it off with a grass trimmer. 5-Levels of cutting height (25-65mm) and 3-position telescopic handle. Part of the Ryobi one+ system – over 100 tools powered by one battery', 'Ryobi OLM1833B 18V ONE+ Cordless 33cm Lawnmower. Designed for easy manoeuvrability', 'product-Ryobi.jpg'),
(81, 'PUMA Ultra', 34, 'Football Boots', '79.99', 4, 'Heralding a new generation of speed, the ULTRA 3.3 boots are the weapon of choice on firm or artificial ground. These lightweight mesh shoes with internal SPEEDCAGE are fused to PUMA’s ultra fast SpeedUnit outsole with running-spike DNA at their core. The GripControl skin delivers decisive power on the ball to ensure you hit the back of the net every time.', 'Heralding a new generation of speed, the ULTRA 3.3 boots are the choice on fg or ag', 'product-puma-ultra.jpg'),
(82, 'Adidas Messi', 34, 'Football Boots', '56.79', 5, 'For amazing comfort, make sure not to miss out on the Adidas Messi 16.3 fg/ag football boots. Synthetic agilityknit zero wear-in upper, molds to your foot for a snug fit that offers unbeatable ball feel and support. Monotongue construction provides explosive agility and keeps debris out of you cleat during the heat of battle. Mess i fg stud pattern offers insane speed, agility and traction on firm ground playing surfaces.', 'For amazing comfort, make sure not to miss out on the Adidas Messi 16.3 fg/ag football boots', 'product-addidas messi.jpg'),
(83, 'Nike Phantom', 34, 'Football Boots', '78.35', 2, 'Nike football boot. Designed in mesh for excellent transpiration during the game. Comfortable and durable shoe.Ideal for all football lovers', 'Nike Phantom Venom Academy Fg, Unisex Adults Football Shoes Football Shoes, 7.5 UK (42 EU)', 'product-nike-phantom-venom.jpg'),
(85, 'HP OMEN', 13, 'Computers', '924.59', 8, 'Ultra-thin, ultra-light, and unbelievably powerful, the OMEN 15-dh1005na Laptop proves that you do not have to sacrifice power for size.With high-performance NVIDIA GeForce RTX 2060 graphics, 10th generation Intel Core i7-10750H processing power, and a blazing-fast refresh rate packed into a sleek design, this laptop lets you play like a pro and stay on-the-go. Designed to run any game you throw at it, get ready to crank up the settings.', 'HP OMEN 15.6 inch Laptop PC 15-dh1005sa, Intel i7, 16GB RAM, RTX 2060, 1TB, FHD', 'product-hp-omen.jpg'),
(86, 'Acer Aspire', 13, 'Computers', '789.59', 5, 'PREMIUM PERFORMANCE: The powerful Intel Core i5 CPU and 8GB of RAM ensure you will breeze through the most demanding of tasks. VISIBLY STUNNING: The 15.6-inch Full HD IPS screen combines incredibly sharp detail, vivid lifelike colours and wide viewing angles for a brilliant visual experience. INGENIOUS DESIGN: The re-designed chassis features a raised hinge which provides a more comfortable typing position, clearer audio and better cooling. PLENTY OF STORAGE: With a 1TB SSD, you get plenty of room for all your apps, documents and media as well as lightning-fast performance. ALL-DAY BATTERY: The battery lasts up-to 8.5 hours from a single charge, allowing you to use it all day without having to worry about charging', 'Acer Aspire 5 A515-56 15.6 inch Laptop - Intel Core i5-1135G7, 8GB, 1TB SSD, Full HD Display', 'product-aceraspire.jpg'),
(87, 'Dell Inspiron', 13, 'Computers', '299.99', 9, 'PCIe NVMe solid-state drives (SSD) provide more responsive, quieter performance along with improved shock resistance when compared to traditional hard disk drives (HDD) 15.6-inch FHD (1920 x 1080) Anti-glare LED Backlight Non-Touch Narrow Border WVA Display. Intel Pentium Silver N5030 Processor (4MB Cache, 3.1 GHz) Intel UHD 605 with shared graphics memory 128GB M.2 PCIe NVMe Solid State Drive 4GB,1x4GB, DDR4, 2400MHz Memory', 'Dell Inspiron 3502 15.6 inch FHD Laptop, Intel Pentium, 4GB RAM, 128GB SSD, Windows 11', 'product-dellinspiron.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `product_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE `slides` (
  `slide_id` int(11) NOT NULL,
  `slide_title` varchar(255) NOT NULL,
  `slide_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`slide_id`, `slide_title`, `slide_image`) VALUES
(94, 'Football Boots', 'slide-football.jpg'),
(97, 'Televisions', 'slide-tvs.jpg'),
(100, 'Lawn Mowers', 'slide-lawnmowers.jpg'),
(101, 'Computers', 'slide-computers.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `account` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `account`) VALUES
(1, 'admin', 'admin@gmail.com', '123', 'admin'),
(4, 'cust', 'cust@gmail.com', '123', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`slide_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;

--
-- AUTO_INCREMENT for table `slides`
--
ALTER TABLE `slides`
  MODIFY `slide_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
