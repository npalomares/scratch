-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 13, 2012 at 08:08 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `blog_np`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(1, 'Miscellaneous'),
(2, 'Sports'),
(3, 'News'),
(4, 'Music');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `name` text NOT NULL,
  `url` text NOT NULL,
  `email` text NOT NULL,
  `body` text NOT NULL,
  `post_id` mediumint(9) NOT NULL,
  `is_approved` tinyint(4) NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `date`, `name`, `url`, `email`, `body`, `post_id`, `is_approved`) VALUES
(1, '2012-02-17 09:58:13', 'Jonny', 'http://www.google.com', 'johndoe@hotmail.com', 'This is a great Blog! I''m blown away!', 1, 1),
(2, '2012-02-17 09:59:27', 'Billy Bob', 'htt://wordpress.org', 'billy5@aol.com', 'Great Content, stories, and theme! Very Impressive.', 2, 1),
(3, '2012-02-24 08:37:13', 'Theodore', 'me@hotmail.com', '', 'Whoa now this is an awesome blog!!\r\nGood JOB', 1, 1),
(4, '2012-02-24 09:46:17', 'nick', 'http://www.nicholaspalomares.com/portfolio', 'saucealito26@yahoo.com', 'I totally agree with Billy Bob. This site is the SHIT!', 2, 1),
(5, '2012-02-28 08:39:46', 'Thomas', '', 'Thom@thom.com', 'It''s Tuesday again! This one really sucks!', 3, 1),
(9, '2012-02-28 09:13:00', 'jon', 'www.gmail.com', 'job@hotmail.com', 'hello', 3, 1),
(10, '2012-02-28 09:14:46', 'billy', 'www.billy.com', 'billy@hotmail.com', 'Traffic was awful this morning', 4, 1),
(11, '2012-03-05 10:06:13', 'Carl', 'http://www.wow.com', 'cabad@hotmail.com', 'You said it man... I hate mondays too!', 5, 1),
(12, '2012-03-07 19:42:45', 'Mark J', '', 'misterJ@hotmail.com', 'Well, I read your latest entry, and I must say...I''m impressed! I don''t know how you do it, but keep it up.\r\n\r\nPeace Out', 6, 1),
(13, '2012-03-09 09:16:38', 'Jamie', '', '', 'Aren''t you excited?! I sure am! What are you doing this weekend?', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

DROP TABLE IF EXISTS `links`;
CREATE TABLE IF NOT EXISTS `links` (
  `link_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `url` text NOT NULL,
  `link_title` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`link_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `links`
--

INSERT INTO `links` (`link_id`, `url`, `link_title`, `description`) VALUES
(1, 'http://www.yahoo.com', 'Yahoo!', 'This is a link to Yahoo! Have fun!'),
(2, 'http://www.google.com', 'Google!', 'This is a link to Google! Best site ever!');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `body` text NOT NULL,
  `date` datetime NOT NULL,
  `category_id` mediumint(9) NOT NULL,
  `user_id` mediumint(9) NOT NULL,
  `is_published` tinyint(4) NOT NULL,
  `allow_comments` tinyint(4) NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `body`, `date`, `category_id`, `user_id`, `is_published`, `allow_comments`) VALUES
(2, 'It''s almost Break TIME', 'I''m getting Coffee!', '2012-02-17 09:49:31', 2, 1, 1, 1),
(3, 'Happy Tuesday!!', 'How was your three day weekend? Not long enough, huh?', '2012-02-21 09:48:52', 1, 1, 1, 1),
(4, 'Traffic!', 'There was a lot of traffic in and around San Diego this morning!', '2012-02-28 08:48:29', 3, 1, 1, 1),
(5, 'Monday..Bloody Monday!', 'This is just a really bad Monday. I''m tired and it sucks BIG time.', '2012-03-05 10:04:37', 3, 1, 1, 1),
(6, 'I''m logged IN!', 'I am finally able to log in on my own, and manage my comments on this blog. This is just a really great site, and i''m so happy that you made it. WOW!', '2012-03-07 09:33:45', 3, 1, 1, 1),
(7, 'Getting Setup at Home', 'Why is this so much harder to do when I''m at home? For some reason, something always go wrong. Betta Luck Next Time!', '2012-03-07 18:23:52', 3, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `user_name` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `join_date` datetime NOT NULL,
  `is_admin` tinyint(4) NOT NULL,
  `avatar_link` text NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `password`, `email`, `join_date`, `is_admin`, `avatar_link`) VALUES
(1, 'Nicholas', 'c114541db297be8d5f7bcbb7b5636d14832d35fb', 'nicholaspalomares@gmail.com', '2012-02-17 00:00:00', 1, 'uploads/avatar_38f1570658af22aec618bfdce9d21175b3cdaf3b.jpg'),
(2, 'Jamie K', 'eb488474d19f44661f0a71cb1c62d81bb64b2e69', 'jkylstad@hotmail.com', '2012-02-17 00:00:00', 0, 'uploads/avatar_48ee51a6b1fda7ca2c6448a9947fde09260b8543.jpg'),
(3, 'saucealito26', 'f0d6c3d69fb2466c5590b96ac8e82c6569affdc7', 'nick@aol.com', '2012-03-06 10:02:19', 0, ''),
(4, 'Jonathan', '74139eb0a2a80d852c11bd3209a58f4d82064cb9', 'jonjon20@aol.com', '2012-03-06 10:59:51', 0, 'uploads/avatar_7a8257a032c4cda8290e72405545efcfe6819924.jpg'),
(5, 'Theodore', 'c669412bc4590d5c732ba58623460ac2e8fc62ac', 'theomeo@hotmail.com', '2012-03-06 11:11:35', 0, 'uploads/avatar_bb2614a68d507a65cc0efea79efd6ba45dd776f6.jpg'),
(6, 'Barney', '4397939a979aae0d47b563f45b55225d7b75ee16', 'barney5@aol.com', '2012-03-07 18:20:35', 0, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
