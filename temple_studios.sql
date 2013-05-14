-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 07, 2012 at 10:23 AM
-- Server version: 5.1.61
-- PHP Version: 5.3.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `temple_studios`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE IF NOT EXISTS `addresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `profile_id` int(10) unsigned NOT NULL,
  `address_1` varchar(100) NOT NULL,
  `address_2` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=916 ;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE IF NOT EXISTS `assets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `type` varchar(25) NOT NULL,
  `user_type` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=689 ;

-- --------------------------------------------------------

--
-- Table structure for table `assets_categories`
--

CREATE TABLE IF NOT EXISTS `assets_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `assets_files`
--

CREATE TABLE IF NOT EXISTS `assets_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned NOT NULL,
  `file_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4450 ;

-- --------------------------------------------------------

--
-- Table structure for table `assets_profiles`
--

CREATE TABLE IF NOT EXISTS `assets_profiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned NOT NULL,
  `profile_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=299 ;

-- --------------------------------------------------------

--
-- Table structure for table `assets_tags`
--

CREATE TABLE IF NOT EXISTS `assets_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `parent_id` int(10) unsigned NOT NULL,
  `level` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(32) NOT NULL,
  `config_key` varchar(32) NOT NULL,
  `label` varchar(64) NOT NULL,
  `config_value` text,
  `default` text,
  `rules` text,
  `field_type` varchar(255) NOT NULL DEFAULT 'text',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group` (`group_name`,`config_key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE IF NOT EXISTS `contents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page` varchar(50) NOT NULL,
  `key` varchar(50) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE IF NOT EXISTS `donations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `campaign_id` int(10) unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_date` datetime NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `events_shares`
--

CREATE TABLE IF NOT EXISTS `events_shares` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `share_id` int(10) unsigned NOT NULL,
  `event_type` varchar(20) NOT NULL,
  `event_date` datetime NOT NULL,
  `event_value` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=172 ;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL,
  `storage` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4449 ;

-- --------------------------------------------------------

--
-- Table structure for table `friends_users`
--

CREATE TABLE IF NOT EXISTS `friends_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `friend_id` int(10) unsigned NOT NULL,
  `approved` int(2) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `oauthusers`
--

CREATE TABLE IF NOT EXISTS `oauthusers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `oauth_type` enum('facebook','twitter','google') NOT NULL,
  `oauth_user_id` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=320 ;

-- --------------------------------------------------------

--
-- Table structure for table `profanities`
--

CREATE TABLE IF NOT EXISTS `profanities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `word` varchar(25) NOT NULL,
  `type` varchar(10) NOT NULL,
  `rating` varchar(5) NOT NULL,
  `country` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=815 ;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `mission_statement` text NOT NULL,
  `show_journey` int(2) unsigned NOT NULL,
  `show_mission` int(2) unsigned NOT NULL,
  `show_graphs` int(2) unsigned NOT NULL,
  `show_media` int(2) unsigned NOT NULL,
  `show_social` int(2) unsigned NOT NULL,
  `show_friends` int(2) unsigned NOT NULL,
  `featured_mission` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=915 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles_users`
--

CREATE TABLE IF NOT EXISTS `roles_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `shares`
--

CREATE TABLE IF NOT EXISTS `shares` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unique_id` varchar(30) NOT NULL,
  `type` varchar(50) NOT NULL,
  `type_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `session_id` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=97 ;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=189 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(254) NOT NULL,
  `username` varchar(32) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone_number` varchar(30) NOT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`),
  UNIQUE KEY `uniq_email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=915 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_tokens`
--

CREATE TABLE IF NOT EXISTS `user_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `user_agent` varchar(40) NOT NULL,
  `token` varchar(40) NOT NULL,
  `type` varchar(100) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_token` (`token`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE IF NOT EXISTS `views` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `video_id` int(10) unsigned NOT NULL,
  `views` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `roles_users`
--
ALTER TABLE `roles_users`
  ADD CONSTRAINT `roles_users_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `roles_users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD CONSTRAINT `user_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'login', 'Login privileges, granted after account confirmation'),
(2, 'admin', 'Administrative user, has access to everything.');


INSERT INTO `users` (`id`, `email`, `username`, `password`, `first_name`, `last_name`, `phone_number`, `logins`, `last_login`) VALUES
(1, 'michael@templestudiosinc.com', 'michaelruelas', '8318ecf522e1ae4ebbda60b609d18b41913e580cd72d15078888bd9c5e81f6db', 'Michael', 'Ruelas', '559-997-6453', 123, 1343948096);

INSERT INTO `roles_users` (`user_id`, `role_id`) VALUES
(1, 1),
(1, 2);

INSERT INTO `config` (`id`, `group_name`, `config_key`, `label`, `config_value`, `default`, `rules`, `field_type`, `date`) VALUES
(1, 'website', 'url', 'Website URL', 's:10:"tstuds.com";', NULL, NULL, 'text', '2012-04-09 20:22:35'),
(2, 'website', 'site_name', 'Website Name', 's:6:"TSTUDS";', NULL, NULL, 'text', '2012-04-09 21:05:44'),
(3, 'website', 'contact_email', 'Contact Email', 's:25:"info@templestudiosinc.com";', NULL, NULL, 'text', '2012-04-09 23:02:23'),
(4, 'website', 'mailing_address', 'Mailing Address', 's:32:"PO Box 1234, Somewhere, CA 12345";', NULL, NULL, 'text', '2012-04-09 23:03:01'),
(5, 'website', 'phone_number', 'Phone Number', 's:14:"(123) 123-1234";', NULL, NULL, 'text', '2012-04-09 23:03:42'),
(6, 'facebook', 'appId', 'Facebook App ID', 's:15:"396098320438349";', NULL, NULL, 'text', '2012-07-06 14:17:41'),
(7, 'facebook', 'secret', 'Facebook Secret', 's:32:"1d0af0db575989a1bc8d6379f3b61e13";', NULL, NULL, 'text', '2012-07-06 14:17:41'),
(8, 'twitter', 'consumer_key', 'Twitter Consumer Key', 's:20:"PtDWeKJLMnfgPRvZ36OA";', NULL, NULL, 'text', '2012-07-06 14:19:47'),
(9, 'twitter', 'consumer_secret', 'Twitter Consumer Secret', 's:42:"T76LJMVHSF3A8PvDKYGsIhtNB7LG3L75sjvBRfg5rA";', NULL, NULL, 'text', '2012-07-06 14:19:47'),
(11, 'facebook', 'req_perms', '', 's:39:"email, publish_checkins, publish_stream";', NULL, NULL, 'text', '2012-07-06 14:32:22'),
(12, 'google', 'application_name', '', 's:12:"tstudiostest";', NULL, NULL, 'text', '2012-07-06 17:39:23'),
(13, 'google', 'oauth2_client_id', '', 's:39:"125609156090.apps.googleusercontent.com";', NULL, NULL, 'text', '2012-07-06 17:39:23'),
(14, 'google', 'oauth2_client_secret', '', 's:24:"HV8lLh9-G_zQsR9cBd-ZAhxx";', NULL, NULL, 'text', '2012-07-06 17:39:23'),
(15, 'google', 'oauth2_redirect_uri', '', 's:39:"http://www.tstuds.com/auth/login_google";', NULL, NULL, 'text', '2012-07-06 17:39:23'),
(16, 'google', 'developer_key', '', 's:39:"AIzaSyBVZAiVCjIhqVkLAChDvU5aCdLg6jgJDec";', NULL, NULL, 'text', '2012-07-06 17:39:23'),
(17, 'google', 'site_name', '', 's:10:"tstuds.com";', NULL, NULL, 'text', '2012-07-06 17:39:23'),
(18, 'google', 'api_key', '', 's:39:"AIzaSyBVZAiVCjIhqVkLAChDvU5aCdLg6jgJDec";', NULL, NULL, 'text', '2012-07-06 18:09:27'),
(19, 'paypal', 'business', '', 's:42:"cooper_1342022180_biz@templestudiosinc.com";', NULL, NULL, 'text', '2012-07-11 21:07:46'),
(20, 'paypal', 'notify_url', '', 's:33:"http://tstuds.com/paypal/listener";', NULL, NULL, 'text', '2012-07-11 21:07:46'),
(21, 'paypal', 'test', '', 's:1:"1";', NULL, NULL, 'text', '2012-07-11 21:09:22'),
(22, 'website', 'analytics', 'Analytics Key', 's:0:"";', NULL, NULL, 'text', '2012-07-12 04:38:05'),
(23, 'website', 'maintenance', 'Maintenance Mode', 's:1:"0";', NULL, NULL, 'select', '2012-07-12 04:39:54'),
(25, 'website', 'background_image', 'Default Background Image', 's:3:"320";', NULL, NULL, 'select', '2012-07-23 15:38:20');