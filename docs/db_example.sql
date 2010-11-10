-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 27, 2009 at 10:30 PM
-- Server version: 5.1.35
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `reeshop`
--

-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Dumping data for table `page`
--

INSERT INTO `page` (`id`, `heading`, `url`, `text`, `menu`, `last_change`) VALUES
(9, 'Lorem ipsum', 'lorem-ipsum', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vel lectus tellus. Suspendisse malesuada nisl ut diam egestas viverra. Suspendisse rhoncus, enim ullamcorper eleifend euismod, magna turpis fringilla lacus, et gravida eros ipsum quis massa. Maecenas ut ultrices magna. Aliquam erat volutpat. Suspendisse potenti. Vivamus consectetur, sapien at placerat imperdiet, tellus urna dapibus justo, quis mollis tellus quam at lectus. In posuere tellus nec quam pharetra dapibus. Pellentesque sed mauris tellus, et laoreet turpis. Curabitur tincidunt nulla nec nibh posuere cursus.<strong> Mauris erat risus, imperdiet vel tempor id, adipiscing eu nulla.</strong></p>\n<p>Integer sem elit, faucibus quis pulvinar ut, laoreet a sapien. Vivamus tincidunt tortor at odio consectetur a consectetur mauris tincidunt. Donec commodo lacus a risus luctus hendrerit. Sed et eros ante.</p>\n<p><em>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce iaculis tortor eget nisi placerat hendrerit. Vestibulum mauris sem, scelerisque at fringilla vel, luctus sed leo. Integer nec sagittis urna. Pellentesque non velit nisi, et porta lorem.</em></p>\n<h4><em>Heading<br /></em></h4>\n<p>Quisque tortor ante, feugiat ac mollis vitae, pharetra id ligula. Maecenas nibh mi, auctor ut volutpat nec, iaculis ut tortor. Sed blandit viverra rhoncus. In commodo porta varius. Cras vehicula semper odio, a mollis urna blandit et. Aenean eget justo sapien. Quisque enim turpis, mollis sit amet egestas id, ullamcorper non sapien. Duis id nunc sapien, vitae venenatis arcu. Morbi eu sapien dui. Aliquam molestie velit aliquam felis feugiat dignissim. Ut egestas molestie tellus vitae bibendum.</p>', 1, '2009-07-18 15:40:39');

-- --------------------------------------------------------

-- --------------------------------------------------------
--
-- Dumping data for table `shop_cat`
--

INSERT INTO `shop_cat` (`id`, `parent`, `name`, `hidden`) VALUES
(24, 0, 'Lorem', 0),
(25, 24, 'Ipsum', 0),
(26, 0, 'Dolor', 0),
(27, 26, 'Ispum', 0),
(18, 17, 'Dreams', 0);

-- --------------------------------------------------------
--
-- Dumping data for table `shop_manufacturer`
--

INSERT INTO `shop_manufacturer` (`id`, `name`) VALUES
(7, 'Bad wolf'),
(6, 'Big bad company');

-- --------------------------------------------------------
--
-- --------------------------------------------------------
-- --------------------------------------------------------
-- Dumping data for table `shop_payment`
--

INSERT INTO `shop_payment` (`id`, `name`, `hidden`, `default`, `type`, `info`) VALUES
(1, 'Transfer', 0, 1, 'post', 'Please transfer exact amount to account 22-22222222/1111'),
(2, 'Credit card', 0, 0, 'pre', '');

-- --------------------------------------------------------

--
-- Table structure for table `shop_product`
--

CREATE TABLE IF NOT EXISTS `shop_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `short_description` text NOT NULL,
  `description` text NOT NULL,
  `manufacturer` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `news` tinyint(1) NOT NULL,
  `tip` tinyint(1) NOT NULL,
  `discount` tinyint(1) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='E-Shop products' AUTO_INCREMENT=18 ;

--
-- Dumping data for table `shop_product`
--

INSERT INTO `shop_product` (`id`, `name`, `short_description`, `description`, `manufacturer`, `price`, `news`, `tip`, `discount`, `hidden`) VALUES
(1, 'Wonderful MP3 player', 'Lorem ipsum', '<p>Splendid, wonderful, the smallest, the cheapest...</p>', 0, 123, 0, 0, 0, 1),
(15, 'Example', 'Phasellus quis <strong>ligula</strong> eros, eu <a href="http://google.cz">placerat</a> tellus.', '<p>Integer sem elit, faucibus quis pulvinar ut, laoreet a sapien. Vivamus tincidunt tortor at odio consectetur a consectetur mauris tincidunt. Donec commodo lacus a risus luctus hendrerit.</p>\n<p>Sed et eros ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce iaculis tortor eget nisi placerat hendrerit. Vestibulum mauris sem, scelerisque at fringilla vel, luctus sed leo. Integer nec sagittis urna.</p>\n<ul>\n<li>Pellentesque non velit nisi, et porta lorem. Quisque tortor ante, feugiat ac mollis vitae, pharetra id ligula. Maecenas nibh mi, auctor ut volutpat nec, iaculis ut tortor. Sed blandit viverra rhoncus. In commodo porta varius. </li>\n<li>Cras vehicula semper odio, a mollis urna blandit et. Aenean eget justo sapien. Quisque enim turpis, mollis sit amet egestas id, ullamcorper non sapien. Duis id nunc sapien, vitae venenatis arcu. Morbi eu sapien dui. Aliquam molestie velit aliquam felis feugiat dignissim. Ut egestas molestie tellus vitae bibendum.</li>\n</ul>\n<p> </p>', 7, 123, 0, 1, 1, 0),
(16, 'Example 2', 'Lorem ipsum', '', 6, 99, 0, 1, 0, 0),
(17, 'Example 3', 'Lorem ipsum', '', 0, 44, 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `shop_product_cat`
--

CREATE TABLE IF NOT EXISTS `shop_product_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` int(11) NOT NULL,
  `cat` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Bridge between products and cats' AUTO_INCREMENT=40 ;

--
-- Dumping data for table `shop_product_cat`
--

INSERT INTO `shop_product_cat` (`id`, `product`, `cat`) VALUES
(16, 1, 8),
(38, 17, 26),
(39, 16, 26),
(36, 15, 26);

-- --------------------------------------------------------
--
-- Dumping data for table `shop_shipping`
--

INSERT INTO `shop_shipping` (`id`, `name`, `hidden`, `default`) VALUES
(1, 'Post', 0, 0),
(2, 'Shipping company', 0, 1);

-- --------------------------------------------------------

-- Dumping data for table `shop_user_extend`
--

INSERT INTO `shop_user_extend` (`user`, `customer_street`, `customer_city`, `customer_postal_code`, `customer_phone`, `billing_name`, `billing_street`, `billing_city`, `billing_postal_code`, `billing_identity_number`, `billing_vat_number`) VALUES
(1, 'Street', 'City', 'Postal code', 'Telephone', 'Name', 'Street', 'City', 'Postal code', 'ID', 'VAT');

-- --------------------------------------------------------
--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `created`, `email`, `password`, `name`, `permission`, `hash`, `hash_time`) VALUES
(1, '2009-04-04 17:04:47', 'demo@demo.de', '89e495e7941cf9e40e6980d14a16bf023ccd4c91', 'Demo user', 2, '', '0000-00-00 00:00:00');
