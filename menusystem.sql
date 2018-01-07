-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2018 at 03:31 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `datbaseassinment`
--

-- --------------------------------------------------------

--
-- Table structure for table `allergy`
--

CREATE TABLE `allergy` (
  `allergry_id` int(11) NOT NULL,
  `allergy_name` varchar(50) NOT NULL,
  `allergy_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `allergy`
--

INSERT INTO `allergy` (`allergry_id`, `allergy_name`, `allergy_description`) VALUES
(1, 'Fish', 'People with a fish allergy might be allergic to some types of fish but not others. Although most allergic reactions to fish happen when someone eats fish, sometimes people can react to touching fish or breathing in vapors from cooking fish; e.g., bass, flounder, cod.'),
(2, 'Milk', 'A milk allergy is a food allergy, an adverse immune reaction to one or more of the constituents of milk from any animal (most commonly alpha S1-casein, a protein in cow\'s milk). This milk-induced allergic reaction can involve anaphylaxis, a potentially life-threatening condition'),
(3, 'Nuts', 'Nuts and peanuts can cause allergic reactions, which are sometimes severe. A severe reaction to nuts is called anaphylaxis and can be life-threatening. Symptoms often start quickly, within an hour of coming into contact with a nut, and sometimes within minutes.'),
(4, 'Celery', 'This includes celery stalks, leaves, seeds and the root called celeriac. You can find celery in celery salt, salads, some meat products, soups and stock cubes'),
(5, 'Cereals containing gluten', 'Wheat (such as spelt and Khorasan wheat/Kamut), rye, barley and oats is often found in foods containing flour, such as some types of baking powder, batter, breadcrumbs, bread, cakes, couscous, meat products, pasta, pastry, sauces, soups and fried foods which are dusted with flour.'),
(6, 'Crustaceans', 'Crabs, lobster, prawns and scampi are crustaceans. Shrimp paste, often used in Thai and south-east Asian curries or salads, is an ingredient to look out for.'),
(7, 'Eggs', 'Eggs are often found in cakes, some meat products, mayonnaise, mousses, pasta, quiche, sauces and pastries or foods brushed or glazed with egg.'),
(8, 'Lupin', 'Yes, lupin is a flower, but itâ€™s also found in flour! Lupin flour and seeds can be used in some types of bread, pastries and even in pasta.'),
(9, 'Molluscs', 'These include mussels, land snails, squid and whelks, but can also be commonly found in oyster sauce or as an ingredient in fish stews.'),
(10, 'Mustard', 'Liquid mustard, mustard powder and mustard seeds fall into this category. This ingredient can also be found in breads, curries, marinades, meat products, salad dressings, sauces and soups.'),
(11, 'Peanuts', 'Peanuts are actually a legume and grow underground, which is why itâ€™s sometimes called a groundnut. Peanuts are often used as an ingredient in biscuits, cakes, curries, desserts, sauces (such as satay sauce), as well as in groundnut oil and peanut flour.'),
(12, 'Sesame seeds', 'These seeds can often be found in bread (sprinkled on hamburger buns for example), breadsticks, houmous, sesame oil and tahini. They are sometimes toasted and used in salads.'),
(13, 'Soya', 'Often found in bean curd, edamame beans, miso paste, textured soya protein, soya flour or tofu, soya is a staple ingredient in oriental food. It can also be found in desserts, ice cream, meat products, sauces and vegetarian products.'),
(14, 'Sulphur dioxide', 'This is an ingredient often used in dried fruit such as raisins, dried apricots and prunes. You might also find it in meat products, soft drinks, vegetables as well as in wine and beer. If you have asthma, you have a higher risk of developing a reaction to sulphur dioxide.');

-- --------------------------------------------------------

--
-- Table structure for table `allergy_meal`
--

CREATE TABLE `allergy_meal` (
  `allergy_meal_id` int(11) NOT NULL,
  `alergy_id` int(11) NOT NULL,
  `meal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `allergy_meal`
--

INSERT INTO `allergy_meal` (`allergy_meal_id`, `alergy_id`, `meal_id`) VALUES
(29, 4, 48),
(30, 10, 48),
(37, 4, 58),
(38, 5, 58),
(39, 2, 59),
(41, 3, 40),
(45, 2, 57),
(46, 6, 45),
(48, 1, 39);

-- --------------------------------------------------------

--
-- Table structure for table `drinks`
--

CREATE TABLE `drinks` (
  `drink_id` int(11) NOT NULL,
  `drink_name` varchar(50) NOT NULL,
  `drink_description` varchar(255) NOT NULL,
  `drink_image` varchar(50) NOT NULL,
  `drink_price` float(10,2) NOT NULL,
  `drink_category_id` int(11) NOT NULL,
  `drink_portions` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `drinks`
--

INSERT INTO `drinks` (`drink_id`, `drink_name`, `drink_description`, `drink_image`, `drink_price`, `drink_category_id`, `drink_portions`) VALUES
(3, 'Fleur de Lys Dry White', 'Very distinctive to Zinfandel, this wine is abundant with all the qualities of the varietal, vibrant red colour with fresh blackberry fruit flavors and aromas, cinnamon and cedar, with a taste that lingers on the palate - white dry version.', 'white-wine-1761575_640.jpg', 7.00, 2, 0),
(4, 'John Smiths', 'John Smiths Original is a malty, bitter sweet ale with a slight fruitiness and a bitter aftertaste.', 'John Smiths.jpg', 20.00, 3, 0),
(5, 'Fleur de Lys Med White', 'Very distinctive to Zinfandel, this wine is abundant with all the qualities of the varietal, vibrant red color with fresh blackberry fruit flavors and aromas, cinnamon and cedar, with a taste that lingers on the palate - white version.', 'chateau-diana-DSC_0050.JPG', 1.00, 2, 0),
(51, 'Vin de pays Chenin Blanc', 'Vin de pays is a French term meaning country whine. Chenin blanc is a white wine grape variety from the Loire valley of France.', 'Vin-De-Pays.jpg', 2.00, 2, 0),
(52, 'Von de Pays Chardonnay', 'Vin de pays is a French term meaning country whine. Chardonnay is a green-skinned grape variety used in the production of white wine.', 'baron-philippe.jpg', 7.00, 2, 0),
(53, 'Macon-Blanc-Villages', 'The MÃ¢connais white wines are the colour of white or yellow gold or straw coloured with gently glowing silvery or greenish highlights.', 'louis-jadot-macon-villiages.jpg', 10.00, 2, 0),
(54, 'Seppelt Moyston Chard', 'The first Moyston was made by the legendary Colin Preece in 1951 and was originally labelled as Bin H66-68 Claret - a historic wine in the Seppelt portfolio.', 'Seppelt Jaluka Chardonnay.png', 72.00, 2, 0),
(55, 'Chablis', 'A dry white burgundy wine from Chablis in eastern.', 'white-wine-1761575_640.jpg', 25.72, 2, 5),
(56, 'Errazuriz Sauv Blanc', 'This cool-climate Sauvignon Blanc from Errazuriz comes from the Casablanca Valley.', '261081011_0_640x640.jpg', 45.56, 2, 0),
(57, 'Oyster Bay Sauvignon Bl', 'Cool fermentation in stainless steel vats brings out every last ounce of flavour and concentration in the grapes. Showing pronounced aromas of gooseberry and tropical fruits, alongside a subtle herbaceousness. Crisp, elegant and refreshing.', '041861.jpg', 17.00, 2, 0),
(58, 'Dunnewood Chardonnay', 'The Majestic Definition range captures the quintessential qualities of the world\\\'s greatest wine styles, with a little help from some of the world\\\'s greatest winemaker...Chardonnay.', 'les-combesjpg.jpg', 34.56, 2, 0),
(59, 'Wynns Riesling, Coonawarra', 'Wynns Coonawarra Estate Riesling was first made in 1962 and has gained a reputation as one of Australia\\\'s most consistent, value-for-money white wines.', 'wynns-coonawarra.jpg', 4.00, 2, 0),
(60, 'Fleur de Lys Red', 'Very distinctive to Zinfandel, this wine is abundant with all the qualities of the varietal, vibrant red color with fresh blackberry fruit flavors and aromas, cinnamon and cedar, with a taste that lingers on the palate - red version.', 'f47f80b0a4d71f8f181d2c2f9606a0d1.jpg', 23.56, 2, 0),
(61, 'Syrah-Mourvedre', 'Syrah, also known as Shiraz, is a dark-skinned grape variety grown throughout the world and used primarily to produce red wine.', '579249jpg.jpg', 10.00, 2, 0),
(62, 'Cotes du Rhone', 'A typically easy drinking wine from the RhÃ´ne Valley, France.', 'les-combesjpg.jpg', 2.00, 2, 0),
(63, 'Chateau des Tuquets', 'ChÃ¢teau Des Tuquets Bordeaux 2010.', 'Chateau des Tuquets.jpg', 5.00, 2, 0),
(64, 'Chianti Classico', 'A Chianti wine Italian pronunciation: is any wine produced in the Chianti region.', 'Fiasco_di_chianti_monteriggioni.jpg', 5.00, 2, 10),
(65, 'Rioja Reserva', 'The Majestic Definition range captures the quintessential qualities of the world\\\'s greatest wine styles, with a little help from some of the worlds greatest winemakers...', 'IMG_8966.jpg', 15.00, 2, 0),
(66, 'Laurenti Pere et Fils Brut NV', 'A Champagne cuvÃ©e reserved exclusively for the on-trade. Crafted using the non-malolactic method, the wine is aged for about 40 years.', 'laurenti-grande.jpg', 45.76, 2, 0),
(67, 'Leo Buring Shiraz', 'Australia\\\'s most popular grape varietal, Shiraz is full-bodied with high alcohol, and vibrant berry and plum on both the nose and palate.', 'LeoBuringSHCAB79.jpg', 20.00, 2, 0),
(68, 'Essington Shiraz', 'Wine made in the district of Shiraz, city in Persia, 1630s.', '348s.jpg', 22.00, 2, 0),
(70, 'Dunnewood Cab Sauvignon', 'A dry red wine made from a premium red grape used in wine making.', '00qv6uqh1zohc_375x500.jpg', 1.00, 2, 15),
(71, 'Zevenwacht Estate Pino', 'Whine from the  Zevenwacht estate.', 'zevenwacht-wine-estate.jpg', 3.00, 2, 0),
(72, 'Seppelt great Western', 'A whine from one of the most fabulous old wineries in Australia (Seppelt Great Western).', 'SeppeltGWRies.JPG', 5.00, 2, 0),
(73, 'Kronenbourg', 'Kronenbourg  is a golden pale lager with an alcohol percentage of 5.00% ABV.', 'Kronenbourg (1).jpg', 20.00, 3, 1),
(74, 'Fosters', 'Foster Lager is an internationally distributed Australian brand of lager.', 'fooster.jpg', 20.00, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `drink_category`
--

CREATE TABLE `drink_category` (
  `drink_category_id` int(11) NOT NULL,
  `drink_category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `drink_category`
--

INSERT INTO `drink_category` (`drink_category_id`, `drink_category_name`) VALUES
(2, 'WINE'),
(3, 'DRAUGHT BEERS'),
(4, 'SPIRITS'),
(5, 'BOTTLED BEER/CIDER'),
(6, 'WINE (By the Glass)'),
(7, 'MINERALS');

-- --------------------------------------------------------

--
-- Table structure for table `drink_menu`
--

CREATE TABLE `drink_menu` (
  `drink_menu_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `drink_menu_image` varchar(50) NOT NULL,
  `drink_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `drink_menu`
--

INSERT INTO `drink_menu` (`drink_menu_id`, `order_id`, `drink_menu_image`, `drink_id`) VALUES
(1, 0, 'snow.jpg', 71),
(2, 0, '', 4),
(3, 0, '', 5),
(4, 0, '', 55),
(5, 0, '', 70),
(6, 0, '', 66),
(7, 0, '', 64),
(8, 0, '', 73),
(9, 0, '', 74),
(14, 0, 'rain.jpg', 72);

-- --------------------------------------------------------

--
-- Table structure for table `drink_order_drinks`
--

CREATE TABLE `drink_order_drinks` (
  `drink_order_drinks_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `drink_id` int(11) NOT NULL,
  `item_quantity` int(11) NOT NULL,
  `product_price_at_sale` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `drink_order_drinks`
--

INSERT INTO `drink_order_drinks` (`drink_order_drinks_id`, `order_id`, `drink_id`, `item_quantity`, `product_price_at_sale`) VALUES
(29, 154, 55, 5, 25.72),
(30, 154, 64, 10, 5.00),
(31, 154, 70, 15, 1.00),
(32, 164, 73, 1, 20.00);

-- --------------------------------------------------------

--
-- Table structure for table `food_menu`
--

CREATE TABLE `food_menu` (
  `food_menu_id` int(11) NOT NULL,
  `meal_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `food_menu_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `food_menu`
--

INSERT INTO `food_menu` (`food_menu_id`, `meal_id`, `order_id`, `food_menu_image`) VALUES
(2, 59, 0, ''),
(3, 47, 0, ''),
(4, 45, 0, ''),
(5, 56, 0, ''),
(6, 39, 0, 'rain.jpg'),
(7, 48, 0, ''),
(8, 49, 0, ''),
(9, 50, 0, ''),
(10, 46, 0, ''),
(11, 52, 0, ''),
(13, 58, 0, ''),
(14, 57, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `indivigual_page_content`
--

CREATE TABLE `indivigual_page_content` (
  `indivigual_page_content_id` int(11) NOT NULL,
  `indivigual_page_content_text` text NOT NULL,
  `indivigual_page_content_image_one` varchar(50) NOT NULL,
  `indivigual_page_content_image_two` varchar(50) NOT NULL,
  `indivigual_page_content_page_name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `indivigual_page_content`
--

INSERT INTO `indivigual_page_content` (`indivigual_page_content_id`, `indivigual_page_content_text`, `indivigual_page_content_image_one`, `indivigual_page_content_image_two`, `indivigual_page_content_page_name`) VALUES
(20, 'The Allan cafe~~<p class=\"MsoNormal\">The Allan cafe is a catering firm, which is contracted to local FE colleges in the UK to provide caf&eacute; &amp; restaurant food. It has a distribution warehouse in Birmingham that supplies all their raw ingredients.</p>~Why choose the Allan cafe?~<p>.Focused service.Competitively priced.Personal attentio</p>~Past and present clients include:~<p>.Steven Harrys</p><p></p>~<p><span lang=\"EN-US\">Why wait for excellent food?</span></p><p><br /><br /></p>~', 'alancafe.PNG', 'alancafe.PNG', 'index.php'),
(21, 'What We Do~Do your business need an efficient and reliable health and safety consultant?~<p>There has been a tendency in the health and safety industry to produce shelves full of paperwork and manuals, that if the truth be told, are seldom read and certainly not by those doing the work</p>~We think that people in charge of a business need to know:~<p>.What health and safety law applies to me?.Am I doing what I am supposed to?.Where I am not, what do I need to do?</p>~Services include:~<p><strong>.</strong><strong>Health and safety reviews</strong>-We compare what you are doing against your legal obligations and provide clear advice on what you need to do to comply.<strong>Health and safety policies</strong> - We produce jargon free concise documents stating clearly how you meet your health and safety responsibilities.<strong>Risk assessments</strong> - We either do these on your behalf or show you how to do them .<strong>Computer assessments</strong> - We assess your computer workstations or train your staff how to do them.<strong>COSHH assessments</strong> - We assess how you use hazardous substances or show you how to do this.<strong>Contractor assessment schemes</strong> - We help companies through CHAS, Safe Contractor, Exor and other contractor accreditation schemes</p><p style=\"margin: 0cm; margin-bottom: .0001pt;\"></p>~<p>That is why we concentrate on giving you short, clear and straightforward processes where people understand what they have got to do and how to do it.</p><p>We offer a wide range of services which help prevent accidents and keep you legally compliant.</p><p></p>~<p><span lang=\"en-GB\">We believe in making things as <strong>simple and short</strong> as possible because shelves full of manuals do not stop accidents - straightforward processes, where people understand what is expected of them</span><span lang=\"en-GB\">- <strong><em>this is what stops accidents</em></strong></span></p>~', 'imageone.png', 'staff.PNG', 'healthandsafetyservices.php'),
(22, 'About Us~Sean Conry Ltd is a safety consultanty company based in North London~<p><span lang=\"EN-US\">We were founded in 1998 and became a limited company in 2001. </span><span lang=\"EN-US\">We typically work for small to medium size businesses who may not have the need for full time safety staff.</span></p><p><span lang=\"EN-US\">Since we started we have helped over two hundred companies to be safer across a large range of industries.</span></p><p></p><p></p>~Past and present clients include:~<p>.Populous.The Independent Newspaper.St Paul\'s Cathedral.Friends of the Earth.Associate Vending Services (AVS).Evening Standard Newspaper.Hill Homes Housing Association.Christ the King Sixth Form College.Many construction companies.Bonhams</p><p></p>~<p><span lang=\"en-GB\" style=\"color: black; font-family: Arial; language: en-GB;\">Most clients have been with us for years - some for more than ten.<span lang=\"en-GB\" style=\"color: black; font-family: Arial; language: en-GB;\">We have excellent customer retention not because we get people to commit to long contracts, we don&rsquo;t, but because we deliver. </span></span></p>~', 'imageone.png', 'staff.PNG', 'whoweare.php');

-- --------------------------------------------------------

--
-- Table structure for table `meal`
--

CREATE TABLE `meal` (
  `meal_id` int(11) NOT NULL,
  `meal_name` varchar(50) NOT NULL,
  `meal_description` varchar(255) NOT NULL,
  `meal_image` varchar(50) NOT NULL,
  `meal_portions` int(11) NOT NULL,
  `meal_type_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meal`
--

INSERT INTO `meal` (`meal_id`, `meal_name`, `meal_description`, `meal_image`, `meal_portions`, `meal_type_id`, `category_id`) VALUES
(39, 'Vegetable soup', 'A soup with vegetables.', 'SaladBox-1246621.jpg', 60, 1, 1),
(40, 'Salad Box', 'A type of food product created and formulated in various food colours, flavors, ingredients and salad in a container.', 'Salad.jpg', 5, 1, 2),
(45, 'Roast Chicken and Gravy', 'Roast chicken is chicken prepared as food by roasting whether in a home kitchen, over a fire, with gravy.', 'chiken.jpg', 5, 1, 3),
(46, 'Pasta Bolognaise', 'A thick meat and tomato sauce made with wine and milk or cream, served with spaghetti.', 'spaghetti-787048_640.jpg', 10, 1, 7),
(47, 'Chocolate Gateaux', 'A rich cake, typically one containing layers of cream or fruit.', 'Chocolate Gateaux .jpg', 30, 1, 8),
(48, 'Beef burger', 'A flat round cake of minced beef, fried or grilled and typically eaten in a bun', 'appetite-1238459_640.jpg', 25, 1, 4),
(49, 'Battered deep fried', 'Battered fish which is deep-fried and served with chips.', 'batter-1239028_640.jpg', 141, 1, 5),
(50, 'Stuffed tomato', 'Tomato cases filled with various salad mixtures and served cold', 'Tomato.jpg', 10, 1, 6),
(51, 'Pasta Bolognaise', 'New potatoes have thin, wispy skins and a crisp, waxy texture.', 'New Potatoes.jpg', 10, 1, 9),
(52, 'Apple crumble and custard', 'A crumble is a dish of British origin that can be made in a sweet or savoury version.', 'applecustered.jpg', 176, 1, 8),
(56, 'Roasted Tomato soup', 'A soup made of  roasted tomato.', 'tomatosoop.jpg', 10, 1, 1),
(57, 'Cauliflower and cheese soup', 'A soup made of cauliflower and cheese.', 'Broccoli_cheese_soup_1.jpg', 5, 1, 1),
(58, 'Carrot and corriander soup', 'A soup made of carrot and coriander.', 'Correnand-Soup-2157199.jpg', 20, 1, 1),
(59, 'Cream of Tomato', 'A soup made of cream and tomato.', 'Cream of Tomato.jpg', 46, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `meal_category`
--

CREATE TABLE `meal_category` (
  `meal_category_id` int(11) NOT NULL,
  `meal_category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meal_category`
--

INSERT INTO `meal_category` (`meal_category_id`, `meal_category_name`) VALUES
(1, 'Soup and Starters'),
(2, 'Cold preparation and salads'),
(3, 'Poultry / game'),
(4, 'Meat and offal'),
(5, 'Fish / Shellfish'),
(6, 'Vegetarian'),
(7, 'Pasta & Rice'),
(8, 'Hot and Cold desserts'),
(9, 'Potatoes / Vegetables');

-- --------------------------------------------------------

--
-- Table structure for table `meal_order_meals`
--

CREATE TABLE `meal_order_meals` (
  `meal_order_meals_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `meal_id` int(11) NOT NULL,
  `item_quantity` int(11) NOT NULL,
  `product_price_at_sale` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `meal_order_meals`
--

INSERT INTO `meal_order_meals` (`meal_order_meals_id`, `order_id`, `meal_id`, `item_quantity`, `product_price_at_sale`) VALUES
(242, 162, 52, 5, 3.50),
(243, 163, 48, 5, 3.50),
(244, 163, 47, 10, 3.50),
(245, 163, 59, 1, 3.50),
(246, 165, 52, 1, 3.50),
(247, 165, 59, 5, 3.50),
(248, 165, 39, 5, 3.50),
(249, 166, 52, 5, 3.50),
(250, 166, 49, 6, 3.50);

-- --------------------------------------------------------

--
-- Table structure for table `meal_type`
--

CREATE TABLE `meal_type` (
  `meal_type_id` int(11) NOT NULL,
  `meal_type_name` varchar(50) NOT NULL,
  `meal_type_cost` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meal_type`
--

INSERT INTO `meal_type` (`meal_type_id`, `meal_type_name`, `meal_type_cost`) VALUES
(1, 'Main', 3.50),
(4, 'Dessert', 1.20);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_date`) VALUES
(154, '2017-05-01 02:52:20'),
(162, '2017-05-01 03:33:15'),
(163, '2017-05-01 04:06:28'),
(164, '2017-05-01 04:06:49'),
(165, '2017-05-01 04:08:36'),
(166, '2018-01-07 03:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_DOB` date NOT NULL,
  `user_first_name` varchar(50) NOT NULL,
  `user_last_name` varchar(50) NOT NULL,
  `user_image` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_password`, `user_name`, `user_DOB`, `user_first_name`, `user_last_name`, `user_image`, `user_email`, `user_role`) VALUES
(4, '$2y$12$pB9kk0u3ufF1JxGshMhKaORzNcWPIrklWPvkX6bQ7E6my0Da60t7C', 'SamFrancis', '0000-00-00', '', '', '', 'hollowsamff@aol.com', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allergy`
--
ALTER TABLE `allergy`
  ADD PRIMARY KEY (`allergry_id`);

--
-- Indexes for table `allergy_meal`
--
ALTER TABLE `allergy_meal`
  ADD PRIMARY KEY (`allergy_meal_id`),
  ADD KEY `allergy_id` (`alergy_id`),
  ADD KEY `meal_id` (`meal_id`);

--
-- Indexes for table `drinks`
--
ALTER TABLE `drinks`
  ADD PRIMARY KEY (`drink_id`),
  ADD KEY `drink_category_id` (`drink_category_id`);

--
-- Indexes for table `drink_category`
--
ALTER TABLE `drink_category`
  ADD PRIMARY KEY (`drink_category_id`);

--
-- Indexes for table `drink_menu`
--
ALTER TABLE `drink_menu`
  ADD PRIMARY KEY (`drink_menu_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `drink_id` (`drink_id`);

--
-- Indexes for table `drink_order_drinks`
--
ALTER TABLE `drink_order_drinks`
  ADD PRIMARY KEY (`drink_order_drinks_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`drink_id`),
  ADD KEY `order_id_2` (`order_id`),
  ADD KEY `meal_id` (`drink_id`);

--
-- Indexes for table `food_menu`
--
ALTER TABLE `food_menu`
  ADD PRIMARY KEY (`food_menu_id`),
  ADD KEY `meal_id` (`meal_id`);

--
-- Indexes for table `indivigual_page_content`
--
ALTER TABLE `indivigual_page_content`
  ADD PRIMARY KEY (`indivigual_page_content_id`);

--
-- Indexes for table `meal`
--
ALTER TABLE `meal`
  ADD PRIMARY KEY (`meal_id`),
  ADD KEY `meal_type_id` (`meal_type_id`);

--
-- Indexes for table `meal_category`
--
ALTER TABLE `meal_category`
  ADD PRIMARY KEY (`meal_category_id`);

--
-- Indexes for table `meal_order_meals`
--
ALTER TABLE `meal_order_meals`
  ADD PRIMARY KEY (`meal_order_meals_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`meal_id`),
  ADD KEY `order_id_2` (`order_id`),
  ADD KEY `meal_id` (`meal_id`);

--
-- Indexes for table `meal_type`
--
ALTER TABLE `meal_type`
  ADD PRIMARY KEY (`meal_type_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allergy`
--
ALTER TABLE `allergy`
  MODIFY `allergry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `allergy_meal`
--
ALTER TABLE `allergy_meal`
  MODIFY `allergy_meal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `drinks`
--
ALTER TABLE `drinks`
  MODIFY `drink_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT for table `drink_category`
--
ALTER TABLE `drink_category`
  MODIFY `drink_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `drink_menu`
--
ALTER TABLE `drink_menu`
  MODIFY `drink_menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `drink_order_drinks`
--
ALTER TABLE `drink_order_drinks`
  MODIFY `drink_order_drinks_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `food_menu`
--
ALTER TABLE `food_menu`
  MODIFY `food_menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `indivigual_page_content`
--
ALTER TABLE `indivigual_page_content`
  MODIFY `indivigual_page_content_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `meal`
--
ALTER TABLE `meal`
  MODIFY `meal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `meal_category`
--
ALTER TABLE `meal_category`
  MODIFY `meal_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `meal_order_meals`
--
ALTER TABLE `meal_order_meals`
  MODIFY `meal_order_meals_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;
--
-- AUTO_INCREMENT for table `meal_type`
--
ALTER TABLE `meal_type`
  MODIFY `meal_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `allergy_meal`
--
ALTER TABLE `allergy_meal`
  ADD CONSTRAINT `allergy_meal_ibfk_1` FOREIGN KEY (`alergy_id`) REFERENCES `allergy` (`allergry_id`),
  ADD CONSTRAINT `allergy_meal_ibfk_2` FOREIGN KEY (`meal_id`) REFERENCES `meal` (`meal_id`);

--
-- Constraints for table `drinks`
--
ALTER TABLE `drinks`
  ADD CONSTRAINT `drinks_ibfk_1` FOREIGN KEY (`drink_category_id`) REFERENCES `drink_category` (`drink_category_id`);

--
-- Constraints for table `drink_menu`
--
ALTER TABLE `drink_menu`
  ADD CONSTRAINT `drink_menu_ibfk_1` FOREIGN KEY (`drink_id`) REFERENCES `drinks` (`drink_id`);

--
-- Constraints for table `drink_order_drinks`
--
ALTER TABLE `drink_order_drinks`
  ADD CONSTRAINT `drink_order_drinks_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `drink_order_drinks_ibfk_2` FOREIGN KEY (`drink_id`) REFERENCES `drinks` (`drink_id`);

--
-- Constraints for table `food_menu`
--
ALTER TABLE `food_menu`
  ADD CONSTRAINT `food_menu_ibfk_1` FOREIGN KEY (`meal_id`) REFERENCES `meal` (`meal_id`);

--
-- Constraints for table `meal`
--
ALTER TABLE `meal`
  ADD CONSTRAINT `meal_ibfk_1` FOREIGN KEY (`meal_type_id`) REFERENCES `meal_type` (`meal_type_id`);

--
-- Constraints for table `meal_order_meals`
--
ALTER TABLE `meal_order_meals`
  ADD CONSTRAINT `meal_order_meals_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `meal_order_meals_ibfk_2` FOREIGN KEY (`meal_id`) REFERENCES `meal` (`meal_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
