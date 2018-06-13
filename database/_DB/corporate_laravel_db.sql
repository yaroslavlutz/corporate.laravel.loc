-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 13, 2018 at 11:23 PM
-- Server version: 5.7.20-0ubuntu0.16.04.1
-- PHP Version: 7.0.28-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `corporate_laravel_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(10) UNSIGNED NOT NULL,
  `alias` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desctext` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fulltext` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `images` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `articles_category_id` int(10) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `alias`, `title`, `desctext`, `fulltext`, `images`, `created_at`, `updated_at`, `user_id`, `articles_category_id`) VALUES
(1, 'article1', 'Article-1: Title of article-1', 'Anyone who reads Old and Middle English literary texts will be familiar with the mid-brown volumes of the EETS, with the symbol of Alfred&#39;s jewel embossed on the front cover. Most of the works attributed to King Alfred or to Aelfric, along with some of those by bishop Wulfstan and much anonymous prose and verse from the pre-Conquest period, are...', '<p>Anyone who reads Old and Middle English literary texts will be familiar with the mid-brown volumes of the EETS, with the symbol of Alfred&#39;s jewel embossed on the front cover. Most of the works attributed to King Alfred or to Aelfric, along with some of those by bishop Wulfstan and much anonymous prose and verse from the pre-Conquest period, are to be found within the Society&#39;s three series; all of the surviving medieval drama, most of the Middle English romances, much religious and secular prose and verse including the English works of John Gower, Thomas Hoccleve and most of Caxton&#39;s prints all find their place in the publications.</p>\r\n\r\n<p>Without EETS editions, study of medieval English texts would hardly be possible. Most of the works attributed to King Alfred or to Aelfric, along with some of those by bishop Wulfstan and much anonymous prose and verse from the pre-Conquest period, are to be found within the Society&#39;s three series; all of the surviving medieval drama, most of the Middle English romances, much religious and secular prose and verse including the English works of John Gower.</p>', '{"mini":"article1-240x320.jpg","max":"article1-1280x960.jpg","origin":"article1-1280x960.jpg"}', '2018-01-04 01:10:44', '2018-05-09 16:55:32', 1, 1),
(2, 'article2', 'Article-2: Title of article-2', 'As its name states, EETS was begun as a \'club\', and it retains certain features of that even now. It has no physical location, or even office, no paid staff or editors, but books in the Original Series', '<p>As its name states, EETS was begun as a \'club\', and it retains certain features of that even now. It has no physical location, or even office, no paid staff or editors, but books in the Original Series are published in the first place to satisfy subscriptions paid by individuals or institutions.</p> <p>This means that there is need for a regular sequence of new editions, normally one or two per year; achieving that sequence can pose problems for the Editorial Secretary, who may have too few or too many texts ready for publication at any one time. Details on a separate sheet explain how individual (but not institutional) members can choose to take certain back volumes in place of the newly published volumes against their subscriptions.</p> <p>On the same sheet are given details about the very advantageous discount available to individual members on all back numbers. In 1970 a Supplementary Series was begun, a series which only appears occasionally (it currently has 24 volumes within it); some of these are new editions of texts earlier appearing in the main series.</p>', '{"mini":"article2-240x320.jpg","max":"article2-1280x960.jpg","origin":"article2-1280x960.jpg"}', '2018-01-02 11:06:08', NULL, 1, 1),
(3, 'article3', 'Article-3: Title of article-3', 'Again these volumes are available at publication and later at a substantial discount to members. All these advantages can only be obtained through the Membership Secretary', '<p>Again these volumes are available at publication and later at a substantial discount to members. All these advantages can only be obtained through the Membership Secretary (the books are sent by post); they are not available through bookshops, and such bookstores as carry EETS books have only a very limited selection of the many published.</p> <p>Editors, who receive no royalties or expenses and who are only very rarely commissioned by the Society, are encouraged to approach the Editorial Secretary with a detailed proposal of the text they wish to suggest to the Society early in their work; interest may be expressed at that point, but before any text is accepted for publication the final typescript must be approved by the Council (a body of some twenty scholars), and then assigned a place in the printing schedule. The Society now has a stylesheet to guide editors in the layout and conventions acceptable within its series. No prescriptive set of editorial principles is laid down, but it is usually expected that the evidence of all relevant medieval copies of the text(s) in question will have been considered, and that the texts edited will be complete whatever their length.</p> <p> It is all ...</p>', '{"mini":"article3-240x320.jpg","max":"article3-1280x960.jpg","origin":"article3-1280x960.jpg"}', '2018-01-01 17:28:40', NULL, 1, 2),
(4, 'article4', 'Article-4: Title of article-4', 'The normal copyright laws cover the Society\'s volumes. All enquiries about large scale reproduction, whether by photocopying or on the internet, should be directed to the Executive Secretary in the first instance...', '<p>The normal copyright laws cover the Society\'s volumes. All enquiries about large scale reproduction, whether by photocopying or on the internet, should be directed to the Executive Secretary in the first instance.</p> <p>The Society\'s continued usefulness depends on its editors and on its ability to maintain its (re)printing programme - and that depends on those who traditionally have become members of the Society. We hope you will maintain your membership, and will encourage both the libraries you use and also other individuals to join. Membership conveys many benefits for you, and for the wider academic community concerned for the understanding of medieval texts.</p> <p> Plans for publications for the coming years are well in hand: there are a number of important texts which should be published within the next five years. Anne Hudson, Honorary Director 2006-13</p> <p>Secretary in the first instance and will encourage both the libraries you use and also other individuals to join for the understanding of medieval texts. large scale reproduction, whether by photocopying or on the internet, should be directed to the conveys many benefits for you, and for the wider academic community concerned for the understanding</p>', '{"mini":"article4-240x320.jpg","max":"article4-1280x960.jpg","origin":"article4-1280x960.jpg"}', '2018-01-12 10:14:50', NULL, 2, 3),
(5, 'article5', 'Article-5: Title of article-5', 'The normal copyright laws cover the Society\'s volumes. All enquiries about large scale reproduction, whether by photocopying or on the internet, should be directed to the Executive Secretary in the first instance...', '<p>The normal copyright laws cover the Society\'s volumes. All enquiries about large scale reproduction, whether by photocopying or on the internet, should be directed to the Executive Secretary in the first instance.</p> <p>The Society\'s continued usefulness depends on its editors and on its ability to maintain its (re)printing programme - and that depends on those who traditionally have become members of the Society. We hope you will maintain your membership, and will encourage both the libraries you use and also other individuals to join. Membership conveys many benefits for you, and for the wider academic community concerned for the understanding of medieval texts.</p> <p> Plans for publications for the coming years are well in hand: there are a number of important texts which should be published within the next five years. Anne Hudson, Honorary Director 2006-13</p> <p>Secretary in the first instance and will encourage both the libraries you use and also other individuals to join for the understanding of medieval texts. large scale reproduction, whether by photocopying or on the internet, should be directed to the conveys many benefits for you, and for the wider academic community concerned for the understanding</p>', '{"mini":"article5-240x320.jpg","max":"article5-1280x960.jpg","origin":"article5-1280x960.jpg"}', '2018-01-12 10:14:50', NULL, 2, 1),
(6, 'article6', 'Article-6: Title of article-6', 'The normal copyright laws cover the Society\'s volumes. All enquiries about large scale reproduction, whether by photocopying or on the internet, should be directed to the Executive Secretary in the first instance...', '<p>The normal copyright laws cover the Society\'s volumes. All enquiries about large scale reproduction, whether by photocopying or on the internet, should be directed to the Executive Secretary in the first instance.</p> <p>The Society\'s continued usefulness depends on its editors and on its ability to maintain its (re)printing programme - and that depends on those who traditionally have become members of the Society. We hope you will maintain your membership, and will encourage both the libraries you use and also other individuals to join. Membership conveys many benefits for you, and for the wider academic community concerned for the understanding of medieval texts.</p> <p> Plans for publications for the coming years are well in hand: there are a number of important texts which should be published within the next five years. Anne Hudson, Honorary Director 2006-13</p> <p>Secretary in the first instance and will encourage both the libraries you use and also other individuals to join for the understanding of medieval texts. large scale reproduction, whether by photocopying or on the internet, should be directed to the conveys many benefits for you, and for the wider academic community concerned for the understanding</p>', '{"mini":"article6-240x320.jpg","max":"article6-1280x960.jpg","origin":"article6-1280x960.jpg"}', '2018-01-12 10:14:50', NULL, 2, 1),
(10, 'article7', 'article7', 'Laravel ships with many facades which provide access to almost all of Laravel&#39;s features. Laravel facades serve as &quot;static proxies&quot; to underlying classes in the service container, providing the benefit of a terse, expressive syntax while maintaining more testability and flexibility than traditional static methods\r\nLaravel ships with m...', '<p><strong>Laravel</strong> ships with many facades which provide access to almost all of Laravel&#39;s features. Laravel facades serve as &quot;static proxies&quot; to underlying classes in the service container, providing the benefit of a terse, expressive syntax while maintaining more testability and flexibility than traditional static methods<br />\r\n<strong>Laravel</strong> ships with many facades which provide access to almost all of Laravel&#39;s features. Laravel facades serve as &quot;static proxies&quot; to underlying classes in the service container, providing the benefit of a terse, expressive syntax while maintaining more testability and flexibility than traditional static methods Skoda Octavia</p>', '{"origin":"0v8YV_origin.jpg","max":"hTX4s_max.jpg","mini":"9mHJR_mini.jpg"}', '2018-03-01 17:20:59', '2018-03-11 21:21:19', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `articles_categories`
--

CREATE TABLE `articles_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_cat_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `articles_categories`
--

INSERT INTO `articles_categories` (`id`, `parent_cat_id`, `title`, `alias`, `created_at`, `updated_at`) VALUES
(1, 0, 'Blog', 'blog', '2018-01-03 04:17:31', NULL),
(2, 1, 'Computers', 'computers', '2018-01-03 04:17:31', NULL),
(3, 1, 'Intresting', 'intresting', '2018-01-03 04:17:31', NULL),
(4, 1, 'Soviets', 'soviets', '2018-01-03 04:17:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_comment_id` int(11) NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `article_id` int(10) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `parent_comment_id`, `text`, `name`, `email`, `site`, `created_at`, `updated_at`, `user_id`, `article_id`) VALUES
(1, 0, 'Comment #1 on article #1 text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text', '', '', '', '2018-02-14 03:08:17', NULL, 1, 1),
(2, 0, 'Comment #2 on article #1 text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text ++', '', '', '', '2018-02-21 01:47:28', NULL, 2, 1),
(3, 0, 'Comment #1 on article #2 text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text ++', '', '', '', '2018-02-16 08:18:50', NULL, 1, 2),
(4, 0, 'Comment #1 on article #3 text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text', 'Incognito Name-1', 'incognito1@mail.ru', '', '2018-02-16 08:18:50', NULL, NULL, 3),
(5, 2, 'Comment #1 on Comment ID2 on article #1 text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text', 'Incognito Name-4', 'incognito4@mail.ru', '', '2018-02-23 02:10:41', NULL, NULL, 1),
(6, 2, 'Comment #2 on Comment ID2 on article #1 text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text', '', '', '', '2018-02-14 03:08:17', NULL, 1, 1),
(7, 1, 'Comment #1 on Comment ID1 on article #1 text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text', '', '', '', '2018-02-14 03:08:17', NULL, 3, 1),
(8, 4, 'Comment #1 on Comment ID4 on article #3 text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text text', '', '', '', '2018-02-14 03:08:17', NULL, 3, 3),
(9, 0, 'Привет, как дела? Что нового?', 'Bart S', 'littus@l.jd', 'nbnbnb', '2018-03-06 18:51:22', '2018-03-06 18:51:22', NULL, 10),
(10, 9, 'Привет! Да все норм!', '', '', '', '2018-03-06 18:52:27', '2018-03-06 18:52:27', 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_menu_id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `parent_menu_id`, `title`, `url_path`, `created_at`, `updated_at`) VALUES
(1, 0, 'Home', '/', '2018-01-06 04:30:07', NULL),
(2, 0, 'Blog', 'blog', '2018-01-06 04:30:07', NULL),
(3, 2, 'Computers', 'computers', '2018-01-06 04:30:07', NULL),
(4, 2, 'Intresting', 'intresting', '2018-01-06 04:30:07', NULL),
(5, 2, 'Soviets', 'soviets', '2018-01-06 04:30:07', NULL),
(6, 0, 'Portfolio', 'portfolios', '2018-01-06 04:30:07', NULL),
(7, 0, 'Contacts', 'contacts', '2018-01-06 04:30:07', NULL),
(8, 2, 'Blog', 'blog', '2018-01-06 04:30:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(10, '2014_10_12_000000_create_users_table', 1),
(11, '2014_10_12_100000_create_password_resets_table', 1),
(12, '2018_02_05_175717_create_table_articles', 1),
(13, '2018_02_05_183820_create_table_portfolios', 1),
(14, '2018_02_05_185039_create_table_portfolio_filters', 1),
(15, '2018_02_05_193124_create_table_comments', 1),
(16, '2018_02_05_202932_create_table_sliders', 1),
(17, '2018_02_05_203344_create_table_menus', 1),
(18, '2018_02_05_204711_create_table_articles_categories', 1),
(19, '2018_02_05_224516_add_foreign_key_to_table_comments', 2),
(20, '2018_02_05_224949_add_foreign_key_to_table_articles', 3),
(21, '2018_02_05_225507_add_foreign_key_to_table_portfolios', 4),
(22, '2018_02_23_123935_create_roles_table', 5),
(23, '2018_02_23_124011_create_permissions_table', 5),
(24, '2018_02_23_125318_create_permissions_roles_table', 5),
(25, '2018_02_23_125546_create_users_roles_table', 5),
(26, '2018_02_23_131834_add_foreign_key_to_table_users_roles', 6),
(27, '2018_02_23_132302_add_foreign_key_to_table_permissions_roles', 6),
(28, '2018_04_11_211501_create_articles_posts', 7),
(29, '2018_04_12_201733_change_table_users', 8);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'VIEW_ADMIN_PANEL', NULL, NULL),
(2, 'ADD_MATERIAL', NULL, NULL),
(3, 'UPDATE_MATERIAL', NULL, NULL),
(4, 'DELETE_MATERIAL', NULL, NULL),
(5, 'ADD_USERS', NULL, NULL),
(6, 'UPDATE_USERS', NULL, NULL),
(7, 'DELETE_USERS', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions_roles`
--

CREATE TABLE `permissions_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `role_id` int(10) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions_roles`
--

INSERT INTO `permissions_roles` (`id`, `created_at`, `updated_at`, `permission_id`, `role_id`) VALUES
(1, NULL, NULL, 1, 1),
(2, NULL, NULL, 2, 1),
(3, NULL, NULL, 3, 1),
(4, NULL, NULL, 4, 1),
(5, NULL, NULL, 5, 1),
(6, NULL, NULL, 6, 1),
(7, NULL, NULL, 7, 1),
(14, NULL, NULL, 1, 2),
(15, NULL, NULL, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `portfolios`
--

CREATE TABLE `portfolios` (
  `id` int(10) UNSIGNED NOT NULL,
  `alias` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `images` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `portfolio_filter_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `portfolios`
--

INSERT INTO `portfolios` (`id`, `alias`, `title`, `text`, `customer`, `images`, `created_at`, `updated_at`, `portfolio_filter_alias`) VALUES
(1, 'project1', 'Project 1', 'Project 1 text: Without EETS editions, study of medieval English texts would hardly be possible. As its name states, EETS was begun as a \'club\'. Members of the Early English Text Society receive each year the editions published by the Society in the Ordinary Series for that year. Usually, there are two publications each year, though not always so. Individual members of the Society, but not institutions, who would prefer not to receive the new publications may instead substitute any past volumes from the Society\'s list which are currently in print up to the value of £60.00 or $120.', 'Coca-Cola', '{"mini":"service1-190x127.jpg","max":"service1-680x454.jpg","origin":"service1-340x227.jpg"}', '2016-01-06 18:11:34', NULL, 'filter_1'),
(2, 'project2', 'Project 2', 'Project 2 text: On the same sheet are given details about the very advantageous discount available to individual members on all back numbers. In 1970 a Supplementary Series was begun, a series. Members of the Early English Text Society receive each year the editions published by the Society in the Ordinary Series for that year. Usually, there are two publications each year, though not always so. Individual members of the Society, but not institutions, who would prefer not to receive the new publications may instead substitute any past volumes from the Society\'s list which are currently in print up to the value of £60.00 or $120.', 'IBM', '{"mini":"service2-190x127.jpg","max":"service2-680x454.jpg","origin":"service2-340x227.jpg"}', '2014-05-07 07:27:26', NULL, 'filter_2'),
(3, 'project3', 'Project 3', 'Project 3 text: No prescriptive set of editorial principles is laid down, but it is usually expected that the evidence of all relevant medieval copies of the text. Members of the Early English Text Society receive each year the editions published by the Society in the Ordinary Series for that year. Usually, there are two publications each year, though not always so. Individual members of the Society, but not institutions, who would prefer not to receive the new publications may instead substitute any past volumes from the Society\'s list which are currently in print up to the value of £60.00 or $120.', 'Marlboro', '{"mini":"service3-190x127.jpg","max":"service3-680x454.jpg","origin":"service3-340x227.jpg"}', '2016-04-07 07:27:26', NULL, 'filter_1'),
(4, 'project4', 'Project 4', 'Project 4 text: Dictionary is still heavily dependent on the Society\'s editions, as are the Middle English Dictionary and the Toronto Dictionary of Old English.  Members of the Early English Text Society receive each year the editions published by the Society in the Ordinary Series for that year. Usually, there are two publications each year, though not always so. Individual members of the Society, but not institutions, who would prefer not to receive the new publications may instead substitute any past volumes from the Society\'s list which are currently in print up to the value of £60.00 or $120.', 'Apple Inc.', '{"mini":"service4-190x127.jpg","max":"service4-680x454.jpg","origin":"service4-340x227.jpg"}', '2013-03-16 03:35:16', NULL, 'filter_3'),
(5, 'project5', 'Project 5', 'Project 5 text: Around 1970 an advantageous arrangement was agreed with an American reprint firm to make almost all the volumes available once more whilst maintaining the membership discounts. Members of the Early English Text Society receive each year the editions published by the Society in the Ordinary Series for that year. Usually, there are two publications each year, though not always so. Individual members of the Society, but not institutions, who would prefer not to receive the new publications may instead substitute any past volumes from the Society\'s list which are currently in print up to the value of £60.00 or $120.', 'Coca-Cola', '{"mini":"service5-190x127.jpg","max":"service5-680x454.jpg","origin":"service5-340x227.jpg"}', '2015-07-06 00:16:47', NULL, 'filter_3'),
(6, 'project6', 'Project 6', 'Project 6 text: Members of the Early English Text Society receive each year the editions published by the Society in the Ordinary Series for that year. Usually, there are two publications each year.  Members of the Early English Text Society receive each year the editions published by the Society in the Ordinary Series for that year. Usually, there are two publications each year, though not always so. Individual members of the Society, but not institutions, who would prefer not to receive the new publications may instead substitute any past volumes from the Society\'s list which are currently in print up to the value of £60.00 or $120.', 'Microsoft', '{"mini":"service6-190x127.jpg","max":"service6-680x454.jpg","origin":"service6-340x227.jpg"}', '2017-12-23 06:26:03', NULL, 'filter_3'),
(7, 'project7', 'Project 7', 'Project 7 text: list which are currently in print up to the value of £60.00 or $120, depending which currency one has paid the subscription in. (Each new year\'s subscription accrues a new credit against the back-list). Members of the Early English Text Society receive each year the editions published by the Society in the Ordinary Series for that year. Usually, there are two publications each year, though not always so. Individual members of the Society, but not institutions, who would prefer not to receive the new publications may instead substitute any past volumes from the Society\'s list which are currently in print up to the value of £60.00 or $120.', 'Disney Company', '{"mini":"service7-190x127.jpg","max":"service7-680x454.jpg","origin":"service7-340x227.jpg"}', '2016-04-19 08:13:20', NULL, 'filter_2'),
(8, 'project8', 'Project 8', 'Project 8 text: The subscription to the Society is £30.00 or US$60.00. Individual members can pay subscriptions in three ways: by PayPal, from links on this webpage, by credit or debit card.  Members of the Early English Text Society receive each year the editions published by the Society in the Ordinary Series for that year. Usually, there are two publications each year, though not always so. Individual members of the Society, but not institutions, who would prefer not to receive the new publications may instead substitute any past volumes from the Society\'s list which are currently in print up to the value of £60.00 or $120.', 'Apple Inc.', '{"mini":"service8-190x127.jpg","max":"service8-680x454.jpg","origin":"service8-340x227.jpg"}', '2012-08-11 02:09:04', NULL, 'filter_3'),
(9, 'project9', 'Project 9', 'Project 9 text: The easiest way for individuals to pay their subscription is by PayPal using the buttons on this page. You can sign up to pay a subscription annually or just this once. Members of the Early English Text Society receive each year the editions published by the Society in the Ordinary Series for that year. Usually, there are two publications each year, though not always so. Individual members of the Society, but not institutions, who would prefer not to receive the new publications may instead substitute any past volumes from the Society\'s list which are currently in print up to the value of £60.00 or $120.', '\nNokia', '{"mini":"service9-190x127.jpg","max":"service9-680x454.jpg","origin":"service9-340x227.jpg"}', '2017-01-03 02:26:21', NULL, 'filter_2');

-- --------------------------------------------------------

--
-- Table structure for table `portfolio_filters`
--

CREATE TABLE `portfolio_filters` (
  `id` int(10) UNSIGNED NOT NULL,
  `alias` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `portfolio_filters`
--

INSERT INTO `portfolio_filters` (`id`, `alias`, `title`, `created_at`, `updated_at`) VALUES
(1, 'filter_1', 'Filter 1', '2018-01-04 06:22:17', NULL),
(2, 'filter_2', 'Filter 2', '2018-01-04 06:22:17', NULL),
(3, 'filter_3', 'Filter 3', '2018-01-04 06:22:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `views_left` int(11) NOT NULL,
  `type` enum('status','video','photo') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'status',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, NULL),
(2, 'moderator', NULL, NULL),
(3, 'guest', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desctext` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `images` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `desctext`, `images`, `created_at`, `updated_at`) VALUES
(1, 'Slide number - 1', 'Slide #1: This payment will continue.', 'banner_slide_1.jpg', '2018-02-08 01:12:13', NULL),
(2, 'Slide number - 2', 'Slide #2: This payment will continue.', 'banner_slide_2.jpg', '2018-02-08 01:12:13', NULL),
(3, 'Slide number - 3', 'Slide #3: This payment will continue.', 'banner_slide_3.jpg', '2018-02-08 01:12:13', NULL),
(4, 'Slide number - 4', 'Slide #4: This payment will continue.', 'banner_slide_4.jpg', '2018-02-08 01:12:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `text` text,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `text`, `created_at`, `updated_at`) VALUES
(1, 'tag #1 text text text......', '2018-04-04', '2018-04-11'),
(2, 'tag #2 text text text......', '2018-04-12', '2018-04-21'),
(6, 'tag-331429', '2018-04-10', '2018-04-10'),
(7, 'tag-331430', '2018-04-10', '2018-04-10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `provider_id` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(110) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `provider_id`, `provider`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'admin', 'admin@mail.com', '$2y$10$IRbMU93Jh0tXD7SURqagpubkmh70KMR960es7ii1dewWR36bLuGW.', 'bmJOvNQsHbhFc6AUokwc6gGvXeBmmazBNV5Rz8ZqsNjYBueiahJWHWCaMmnc', '2018-02-05 21:31:01', '2018-02-05 21:31:01'),
(2, NULL, NULL, 'littus', 'littus@i.ua', '$2y$10$6JOKNXqTdfyjckixzhHC2O9EfH1hUciRS/Dlncpd9JYyX1Y/qIFPu', 'dcsfxhRlE179uuq7mKVfIYQb4JeXqE1I7d2TfICg5r6kWfCsIqBVDtIiDKJA', '2018-02-05 21:32:31', '2018-02-05 21:32:31'),
(3, NULL, NULL, 'fatHomer', 'homer@mail.us', '$2y$10$Jwywj4UAuRRJ.Pem23ACgu3McWg2sOfPsnqXPEWmm4yoqfttlwPna', '7auck54fAhCgbKZH0ZyPL7y5UQ1a8fqkVjewSItnbQLrws4sYe5Int2o5462', '2018-02-05 21:33:38', '2018-03-11 21:21:45'),
(28, '1846115698789232', 'facebook', 'Yaroslav Littus', 'athlonnus@gmail.com', 'facebook', 'US4O05w7RiqSjsL2wl7bPvvFLorVP2Dzvmun73mgTvPRvoaVLYeqLPyYY9nK', '2018-04-12 20:06:28', '2018-04-12 20:06:28');

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE `users_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `role_id` int(10) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`id`, `created_at`, `updated_at`, `user_id`, `role_id`) VALUES
(1, NULL, NULL, 1, 1),
(2, NULL, NULL, 2, 2),
(3, NULL, NULL, 3, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `articles_alias_unique` (`alias`),
  ADD KEY `articles_user_id_foreign` (`user_id`),
  ADD KEY `articles_articles_category_id_foreign` (`articles_category_id`);

--
-- Indexes for table `articles_categories`
--
ALTER TABLE `articles_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `articles_categories_alias_unique` (`alias`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_article_id_foreign` (`article_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions_roles`
--
ALTER TABLE `permissions_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_roles_permission_id_foreign` (`permission_id`),
  ADD KEY `permissions_roles_role_id_foreign` (`role_id`);

--
-- Indexes for table `portfolios`
--
ALTER TABLE `portfolios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `portfolios_alias_unique` (`alias`),
  ADD KEY `portfolios_portfolio_filter_alias_foreign` (`portfolio_filter_alias`);

--
-- Indexes for table `portfolio_filters`
--
ALTER TABLE `portfolio_filters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `portfolio_filters_alias_unique` (`alias`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_roles_user_id_foreign` (`user_id`),
  ADD KEY `users_roles_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `articles_categories`
--
ALTER TABLE `articles_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `permissions_roles`
--
ALTER TABLE `permissions_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `portfolios`
--
ALTER TABLE `portfolios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `portfolio_filters`
--
ALTER TABLE `portfolio_filters`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `users_roles`
--
ALTER TABLE `users_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_articles_category_id_foreign` FOREIGN KEY (`articles_category_id`) REFERENCES `articles_categories` (`id`),
  ADD CONSTRAINT `articles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`),
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `permissions_roles`
--
ALTER TABLE `permissions_roles`
  ADD CONSTRAINT `permissions_roles_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  ADD CONSTRAINT `permissions_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `portfolios`
--
ALTER TABLE `portfolios`
  ADD CONSTRAINT `portfolios_portfolio_filter_alias_foreign` FOREIGN KEY (`portfolio_filter_alias`) REFERENCES `portfolio_filters` (`alias`);

--
-- Constraints for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD CONSTRAINT `users_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `users_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
