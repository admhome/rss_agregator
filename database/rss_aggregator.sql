--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` varchar(1) NOT NULL,
  `admin` varchar(40) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin`, `password`) VALUES
('1', 'admin', '6c5ac7b4d3bd3311f033f971196cfa75');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(12) NOT NULL AUTO_INCREMENT,
  `category_title` varchar(255) NOT NULL,
  `category_order` int(12) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `feeditems`
--

CREATE TABLE IF NOT EXISTS `feeditems` (
  `item_id` int(12) NOT NULL AUTO_INCREMENT,
  `item_title` varchar(255) NOT NULL,
  `item_url` varchar(255) NOT NULL,
  `item_category_id` int(12) NOT NULL,
  `item_feed_id` int(12) NOT NULL,
  `item_details` text NOT NULL,
  `item_datetime` varchar(100) NOT NULL,
  `item_unix_datetime` int(12) NOT NULL,
  `item_hits` int(12) NOT NULL,
  `item_published` int(1) NOT NULL,
  `item_pinned` int(1) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `feeds`
--

CREATE TABLE IF NOT EXISTS `feeds` (
  `feed_id` int(12) NOT NULL AUTO_INCREMENT,
  `feed_url` varchar(255) NOT NULL,
  `feed_title` varchar(100) NOT NULL,
  `feed_logo` varchar(255) NOT NULL,
  `feed_category_id` int(12) NOT NULL,
  `feed_last_update` int(12) NOT NULL,
  `feed_items` int(3) NOT NULL,
  PRIMARY KEY (`feed_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(1) NOT NULL,
  `seo_title` varchar(255) NOT NULL,
  `seo_keywords` text NOT NULL,
  `seo_description` text NOT NULL,
  `site_template` varchar(100) NOT NULL,
  `direct_links` int(1) NOT NULL,
  `new_items_number` int(2) NOT NULL,
  `top_hits_items_number` int(2) NOT NULL,
  `category_items_number` int(2) NOT NULL,
  `ad_slot_728` text NOT NULL,
  `ad_slot_300` text NOT NULL,
  `friendly_urls` int(1) NOT NULL,
  `pagination_style` int(1) NOT NULL,
  `display_rss` int(1) NOT NULL,
  `display_category_rss` int(1) NOT NULL,
  `rss_items_number` int(4) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `google_plus` varchar(255) NOT NULL,
  `display_calendar` int(1) NOT NULL,
  `google_analytics` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `seo_title`, `seo_keywords`, `seo_description`, `site_template`, `direct_links`, `new_items_number`, `top_hits_items_number`, `category_items_number`, `ad_slot_728`, `ad_slot_300`, `friendly_urls`, `pagination_style`, `display_rss`, `display_category_rss`, `rss_items_number`, `facebook`, `twitter`, `google_plus`, `display_calendar`, `google_analytics`) VALUES
(1, 'Rss Aggregator Script', 'rss,feeds,feed,atom,aggregator', 'Rss Aggregator is a Script That Grab, Organize And Publish The Stories From Multi Sources. ', 'v2', 0, 15, 15, 15, '&lt;img src=&quot;upload/top.jpg&quot; /&gt;', '&lt;img src=&quot;upload/left.jpg&quot; /&gt;', 1, 1, 1, 1, 10, 'http://www.facebook.com/', 'http://twitter.com/', 'http://google.com', 1, '');


