-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Čtvrtek 16. července 2009, 20:40
-- Verze MySQL: 5.1.35
-- Verze PHP: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `reeshop`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `heading` varchar(255) NOT NULL,
  `perex` text NOT NULL,
  `text` text NOT NULL,
  `insert_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='News' AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `heading` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `menu` tinyint(1) NOT NULL COMMENT 'presence in menu',
  `last_change` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Static pages' AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `shop_cart`
--

CREATE TABLE IF NOT EXISTS `shop_cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id of item',
  `user` int(10) unsigned NOT NULL COMMENT 'id of user',
  `product` int(10) unsigned NOT NULL COMMENT 'id of product',
  `quantity` tinyint(3) unsigned NOT NULL COMMENT 'number of product',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'timestamp (used for automatic cleaning)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Shopping cart' AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `shop_cat`
--

CREATE TABLE IF NOT EXISTS `shop_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='E-shop categories' AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `shop_manufacturer`
--

CREATE TABLE IF NOT EXISTS `shop_manufacturer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id of manufacturer',
  `name` varchar(255) NOT NULL COMMENT 'name of manufacturer',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Manufacturer of products' AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `shop_order`
--

CREATE TABLE IF NOT EXISTS `shop_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id of order',
  `user` int(10) unsigned NOT NULL COMMENT 'id of user',
  `payment` int(10) unsigned NOT NULL COMMENT 'id of payment method',
  `shipping` int(10) unsigned NOT NULL COMMENT 'id of of shipping method',
  `status_order` enum('none','done','cancel') NOT NULL COMMENT 'status of order',
  `status_payment` enum('none','paid') NOT NULL COMMENT 'status of payment',
  `customer_name` varchar(255) NOT NULL COMMENT 'name of customer',
  `customer_street` text NOT NULL COMMENT 'street and house number of customer',
  `customer_city` text NOT NULL COMMENT 'city of customer',
  `customer_postal_code` varchar(255) NOT NULL COMMENT 'postal code of customer',
  `customer_email` text NOT NULL COMMENT 'email of customer',
  `customer_phone` varchar(255) NOT NULL COMMENT 'telephone of customer',
  `billing_name` varchar(255) NOT NULL COMMENT 'billing name',
  `billing_street` text NOT NULL COMMENT 'billing street',
  `billing_city` text NOT NULL COMMENT 'billing city',
  `billing_postal_code` varchar(255) NOT NULL COMMENT 'billing postal code',
  `billing_identity_number` varchar(8) NOT NULL COMMENT 'Billing identity number (speciality of middle europe)',
  `billing_vat_number` varchar(12) NOT NULL COMMENT 'billing vat number',
  `delivery_name` varchar(255) NOT NULL COMMENT 'name for delivery',
  `delivery_street` text NOT NULL COMMENT 'street for delivery',
  `delivery_city` text NOT NULL COMMENT 'city for delivery',
  `delivery_postal_code` varchar(255) NOT NULL COMMENT 'postal code for delivery',
  `last_change` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Table with customers orders' AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `shop_order_product`
--

CREATE TABLE IF NOT EXISTS `shop_order_product` (
  `order` int(10) unsigned NOT NULL COMMENT 'id of order',
  `product` int(10) unsigned NOT NULL COMMENT 'id of product',
  `quantity` int(3) NOT NULL COMMENT 'quantity of product'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Items of orders';

-- --------------------------------------------------------

--
-- Struktura tabulky `shop_payment`
--

CREATE TABLE IF NOT EXISTS `shop_payment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id of shipping',
  `name` text NOT NULL COMMENT 'name of shipping',
  `hidden` tinyint(1) NOT NULL COMMENT 'status (TRUE mean it is hidden)',
  `default` tinyint(1) NOT NULL,
  `type` enum('pre','post') NOT NULL,
  `info` text NOT NULL COMMENT 'informations how to pay via this payment',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Methods of shipping' AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `shop_product`
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='E-Shop products' AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `shop_product_cat`
--

CREATE TABLE IF NOT EXISTS `shop_product_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` int(11) NOT NULL,
  `cat` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Bridge between products and cats' AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `shop_shipping`
--

CREATE TABLE IF NOT EXISTS `shop_shipping` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id of shipping',
  `name` text NOT NULL COMMENT 'name of shipping',
  `hidden` tinyint(1) NOT NULL COMMENT 'status (TRUE mean it is hidden)',
  `default` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Methods of shipping' AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `shop_user_extend`
--

CREATE TABLE IF NOT EXISTS `shop_user_extend` (
  `user` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id of user',
  `customer_street` text NOT NULL COMMENT 'street and number',
  `customer_city` text NOT NULL COMMENT 'city',
  `customer_postal_code` varchar(255) NOT NULL COMMENT 'postal code',
  `customer_phone` varchar(255) NOT NULL COMMENT 'telephone number',
  `billing_name` varchar(255) NOT NULL COMMENT 'billing name',
  `billing_street` text NOT NULL COMMENT 'billing street',
  `billing_city` text NOT NULL COMMENT 'billing city',
  `billing_postal_code` varchar(255) NOT NULL COMMENT 'postal code',
  `billing_identity_number` varchar(8) NOT NULL COMMENT 'identity number (middle europe speciality)',
  `billing_vat_number` varchar(12) NOT NULL COMMENT 'billing VAT number',
  PRIMARY KEY (`user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Customer profile' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `permission` tinyint(1) NOT NULL DEFAULT '1',
  `hash` varchar(28) NOT NULL,
  `hash_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Table of users' AUTO_INCREMENT=12 ;
