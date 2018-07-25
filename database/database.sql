-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 25, 2018 at 10:53 AM
-- Server version: 5.7.22-0ubuntu0.16.04.1
-- PHP Version: 7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `staging_getmedz`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`staging`@`localhost` FUNCTION `getTextWithoutTags` (`Dirty` VARCHAR(4000)) RETURNS VARCHAR(4000) CHARSET latin1 BEGIN
			DECLARE iStart, iEnd, iLength int;
    WHILE Locate( '<', Dirty ) > 0 And Locate( '>', Dirty, Locate( '<', Dirty )) > 0 DO
      BEGIN
        SET iStart = Locate( '<', Dirty ), iEnd = Locate( '>', Dirty, Locate('<', Dirty ));
        SET iLength = ( iEnd - iStart) + 1;
        IF iLength > 0 THEN
          BEGIN
            SET Dirty = Insert( Dirty, iStart, iLength, '');
          END;
        END IF;
      END;
    END WHILE;
    RETURN Dirty;
		END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(10) UNSIGNED NOT NULL,
  `admin_username` varchar(50) CHARACTER SET latin1 NOT NULL,
  `admin_email` varchar(50) CHARACTER SET latin1 NOT NULL,
  `admin_password` varchar(50) CHARACTER SET latin1 NOT NULL,
  `admin_active` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `admin_username`, `admin_email`, `admin_password`, `admin_active`) VALUES
(1, 'admin', 'admin@dummyid.com', '1af00814a264d77fedd879532d6d4be3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_password_resets_requests`
--

CREATE TABLE `tbl_admin_password_resets_requests` (
  `appr_admin_id` int(11) NOT NULL,
  `aprr_tocken` varchar(50) NOT NULL,
  `aprr_expiry` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_banners`
--

CREATE TABLE `tbl_banners` (
  `banner_id` int(11) NOT NULL,
  `banner_title` varchar(255) NOT NULL,
  `banner_position` int(11) NOT NULL,
  `banner_type` int(11) NOT NULL COMMENT '0=>Image, 1=>html',
  `banner_image_path` varchar(255) NOT NULL,
  `banner_url` varchar(255) NOT NULL,
  `banner_html` text NOT NULL,
  `banner_status` tinyint(4) NOT NULL,
  `banner_start_date` date NOT NULL,
  `banner_end_date` date NOT NULL,
  `banner_link_newtab` tinyint(4) NOT NULL DEFAULT '1',
  `banner_priority` int(11) NOT NULL,
  `banner_is_deleted` tinyint(1) NOT NULL,
  `banner_text` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_banners`
--

INSERT INTO `tbl_banners` (`banner_id`, `banner_title`, `banner_position`, `banner_type`, `banner_image_path`, `banner_url`, `banner_html`, `banner_status`, `banner_start_date`, `banner_end_date`, `banner_link_newtab`, `banner_priority`, `banner_is_deleted`, `banner_text`) VALUES
(1, 'Banner - 1', 0, 0, 'BannerFlorenceSmith.jpg', 'http://www.deferia.pe/florence-smith-1/brands/view/12', '', 1, '0000-00-00', '0000-00-00', 1, 1, 1, ''),
(2, 'Banner - 2', 0, 0, '20170609salebannerjpg', 'http://www.deferia.pe/permuta-beachwear-1/brands/view/11', '', 0, '0000-00-00', '0000-00-00', 1, 1, 1, 'Get Answers For Your Health Queries From our Top Doctors'),
(3, 'Banner - 3', 0, 0, 'Hydrangeasjpg_32', 'http://www.deferia.pe/-/products/search?keyword=D%26o', '', 1, '0000-00-00', '0000-00-00', 1, 3, 1, 'Hello'),
(4, 'banner-1', 0, 0, 'Hydrangeasjpg_59', 'http://getmedz.4demo.biz', '', 1, '0000-00-00', '0000-00-00', 1, 1, 1, ''),
(5, 'banner-1', 0, 0, 'Jellyfishjpg', 'http://getmedz.4demo.biz/', '', 1, '0000-00-00', '0000-00-00', 1, 1, 1, ''),
(6, 'Banner-1', 0, 0, '48_homebannerjpg', 'http://getmedz.4demo.biz', '', 1, '0000-00-00', '0000-00-00', 1, 2, 0, 'Get Answers For Your Health Queries From our Top Doctors'),
(7, 'Banner-1', 0, 0, '', 'dieJsonError', '', 1, '0000-00-00', '0000-00-00', 1, 1, 1, 'sd'),
(8, 'banner', 0, 0, 'aajpg', 'http://www.google.com', '', 0, '0000-00-00', '0000-00-00', 0, 3, 1, 'New banner'),
(9, 'banner title', 0, 0, 'E0149HemantGoeljpg', '', '', 0, '0000-00-00', '0000-00-00', 1, 0, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blog_attached_files`
--

CREATE TABLE `tbl_blog_attached_files` (
  `file_id` int(11) NOT NULL,
  `file_type` int(11) NOT NULL COMMENT '4=>user-image,5->''artist profile cover photo''6->post main Image,7=>post \r\n\r\nattach files',
  `file_record_id` int(11) NOT NULL,
  `file_record_subid` int(11) NOT NULL,
  `file_physical_path` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `file_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'For display Only',
  `file_display_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blog_contributions`
--

CREATE TABLE `tbl_blog_contributions` (
  `contribution_id` int(11) NOT NULL,
  `contribution_author_first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `contribution_author_last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `contribution_author_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contribution_author_phone` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `contribution_file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contribution_file_display_name` varchar(1500) COLLATE utf8_unicode_ci NOT NULL,
  `contribution_status` tinyint(1) NOT NULL COMMENT '0->Pending, 1->Approved, 2->Posted, 3-\r\n\r\n>Rejected',
  `contribution_date_time` datetime NOT NULL,
  `contribution_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_blog_contributions`
--

INSERT INTO `tbl_blog_contributions` (`contribution_id`, `contribution_author_first_name`, `contribution_author_last_name`, `contribution_author_email`, `contribution_author_phone`, `contribution_file_name`, `contribution_file_display_name`, `contribution_status`, `contribution_date_time`, `contribution_user_id`) VALUES
(1, 'max', 'max', 'max@gmail.com', '8989888', 'AJHogezip', 'A_J_Hoge.zip', 0, '2016-07-02 14:53:25', 0),
(2, 'max', 'max', 'max@gmail.com', '8989888', 'AJHogezip_632206', 'A_J_Hoge.zip', 0, '2016-07-02 14:55:13', 0),
(3, 'shilpa', 'bansal', 'shilpa@dummyid.com', '123456789', 'fortesttxt', 'for test.txt', 1, '2016-07-02 17:20:17', 0),
(4, 'shilpa', 'bansal', 'shilpa@dummyid.com', '', '1pdf', '1.pdf', 0, '2016-07-02 17:45:23', 0),
(5, 'shilpa', 'bansal', 'shilpa1@dummyid.com', '', 'fortesttxt_494093', 'for test.txt', 0, '2016-07-02 17:46:50', 0),
(8, 'Money', 'Kumar', 'money@dummyid.com', '7845896545', 'Illustrationpdf', 'Illustration.pdf', 2, '2016-09-06 17:51:51', 0),
(9, 'a', 'Ada', 'adsa@as.fg', '53426456', 'haveaclickyokartv8sql', 'haveaclick_yokartv8.sql', 1, '2017-10-12 18:08:13', 0),
(10, 'Pooja', 'kathpal', 'pooja@dummyid.com', '3543657', 'haveaclickyokartv8sql_619394', 'haveaclick_yokartv8.sql', 0, '2017-11-07 10:26:04', 0),
(11, 'Pooja', 'kathpal', 'pooja@dummyid.com', '3543657', 'devpolcosql', 'dev_polco.sql', 0, '2017-11-07 10:29:03', 0),
(12, 'Pooja', 'kathpal', 'pooja@dummyid.com', '3543657', 'haveaclickyokartv8sql_145220', 'haveaclick_yokartv8.sql', 0, '2017-11-07 10:29:39', 0),
(13, 'Pooja', 'kathpal', 'pooja@dummyid.com', '3543657', 'haveaclickyokartv8sql_196062', 'haveaclick_yokartv8.sql', 0, '2017-11-07 10:31:20', 0),
(14, 'Pooja', 'kathpal', 'pooja@dummyid.com', '3543657', 'devpolcosql_607159', 'dev_polco.sql', 0, '2017-11-07 10:35:51', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blog_meta_data`
--

CREATE TABLE `tbl_blog_meta_data` (
  `meta_id` int(11) NOT NULL,
  `meta_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_keywords` text COLLATE utf8_unicode_ci NOT NULL,
  `meta_description` text COLLATE utf8_unicode_ci NOT NULL,
  `meta_others` text COLLATE utf8_unicode_ci NOT NULL,
  `meta_record_id` int(11) NOT NULL,
  `meta_record_type` tinyint(4) NOT NULL COMMENT '0->Post, 1->Category'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_blog_meta_data`
--

INSERT INTO `tbl_blog_meta_data` (`meta_id`, `meta_title`, `meta_keywords`, `meta_description`, `meta_others`, `meta_record_id`, `meta_record_type`) VALUES
(1, 'Health', 'Health', 'Health', 'Health', 1, 1),
(2, 'external injuries', 'external injuries', 'external injuries', 'external injuries', 2, 1),
(3, 'Internal Injuries', 'Internal Injuries', 'Internal Injuries', 'Internal Injuries', 3, 1),
(4, '', '', '', '', 1, 0),
(5, 'Injuries', 'Injuries', 'InjuriesInjuries', 'Injuries', 4, 1),
(6, '', '', '', '', 5, 1),
(7, '', '', '', '', 2, 0),
(8, '', '', '', '', 3, 0),
(9, '', '', '', '', 4, 0),
(10, '', '', '', '', 5, 0),
(11, '', '', '', 'grandiour', 6, 0),
(12, '', '', '', '', 7, 0),
(13, '<script> alert(\"DdD\") </script>', '<script> alert(\"DdD\") </script>', '<script> alert(\"DdD\") </script>', '<script> alert(\"DdD\") </script>', 8, 0),
(14, 'Test <script> alert(\"Ddd\")</script>', 'Test <script> alert(\"Ddd\")</script>', 'Test <script> alert(\"Ddd\")</script>Test <script> alert(\"Ddd\")</script>', 'Test <script> alert(\"Ddd\")</script>', 8, 0),
(15, 'Running for health: Even a little bit is good, but a little more is probably better - Harvard Health Blog - Harvard Health Publishing', 'harvard health blog, health blog, health blogspot', 'Running for health: Even a little bit is good, but a little more is probably better - Harvard Health Blog - Harvard Health Publishing', 'aa', 9, 0),
(16, 'Teens with upbeat friends may have better emotional health - Harvard Health Blog', 'Teens with upbeat friends may have better emotional health - Harvard Health Blog', 'Recent research suggests that teens whose friends are upbeat are less likely to suffer from depression, and that  such friends can help improve the mood of teens who show signs of depression', 'Teens with upbeat friends may have better emotional health - Harvard Health Blog', 10, 0),
(17, 'Great world', 'Great world', 'Great world', '', 11, 0),
(18, 'Harvard Health Blog', 'Harvard Health Blog', 'Harvard Health Blog', 'Harvard Health Blog', 6, 1),
(19, 'disease', 'disease', 'disease', 'disease', 12, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blog_post`
--

CREATE TABLE `tbl_blog_post` (
  `post_id` int(11) NOT NULL,
  `post_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_short_description` text COLLATE utf8_unicode_ci NOT NULL,
  `post_content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `post_seo_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The name will be used in urls and must be seo \r\n\r\nfriendly',
  `post_status` tinyint(1) NOT NULL COMMENT '0->Draft, 1-Published',
  `post_comment_status` tinyint(1) NOT NULL COMMENT '0->Not Open, 1->Open',
  `post_date_time` datetime NOT NULL,
  `post_last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_published` datetime NOT NULL,
  `post_contributor_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `post_view_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_blog_post`
--

INSERT INTO `tbl_blog_post` (`post_id`, `post_title`, `post_short_description`, `post_content`, `post_seo_name`, `post_status`, `post_comment_status`, `post_date_time`, `post_last_modified`, `post_published`, `post_contributor_name`, `post_view_count`) VALUES
(9, 'Running for health: Even a little bit is good, but a little more is probably better', 'Marathoners are the thoroughbreds of high-performance runners, but even the draft horses of the running world â€” slow and steady joggers â€” improve their health. A study out this week in the Journal of the American College of Cardiology finds that even five to 10 minutes a day of low-intensity running is enough to extend life by several years, compared with not running at all. It shows that the minimal healthy â€œdoseâ€ of exercise is smaller than many people might assume.', '<p class=\"ParagraphFirst\" style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">Marathoners are the thoroughbreds of high-performance runners, but even the draft horses of the running world â€” slow and steady joggers â€” improve their health. A study out this week in the&nbsp;<a href=\"http://content.onlinejacc.org/article.aspx?articleID=1891600\" target=\"_blank\" style=\"box-sizing: border-box; touch-action: manipulation; color: rgb(181, 9, 55); text-decoration-line: none; transition: all 150ms ease-out; -webkit-font-smoothing: antialiased;\"><span style=\"font-style: italic;\">Journal of the American College of Cardiology</span></a>&nbsp;finds that even five to 10 minutes a day of low-intensity running is enough to extend life by several years, compared with not running at all. It shows that the minimal healthy \"doseâ€ of exercise is smaller than many people might assume.</p>\r\n<p class=\"ParagraphIndented\" style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">But if your favorite activity is a brisk walk in the park or a quick game of tennis, the research has implications for you, too. \"There is no question that if you are not exercising and if you make the decision to start â€” whether itâ€™s walking, jogging, cycling, or an elliptical machine â€” you are going to be better off,â€ says cardiologist Dr. Aaron Baggish, the associate director of the&nbsp;<a href=\"http://www.massgeneral.org/heartcenter/services/treatmentprograms.aspx?id=1364\" target=\"_blank\" style=\"box-sizing: border-box; touch-action: manipulation; color: rgb(181, 9, 55); text-decoration-line: none; transition: all 150ms ease-out; -webkit-font-smoothing: antialiased;\">Cardiovascular Performance Program</a>&nbsp;at Harvard-affiliated Massachusetts General Hospital and&nbsp;<a href=\"http://hms.harvard.edu/news/harvard-medicine/harvard-medicine/play/enduring-pleasures\" target=\"_blank\" style=\"box-sizing: border-box; touch-action: manipulation; color: rgb(181, 9, 55); text-decoration-line: none; transition: all 150ms ease-out; -webkit-font-smoothing: antialiased;\">an accomplished runner himself</a></p>\r\n<h3 style=\"box-sizing: border-box; font-size: 1.25rem; margin: 0px 0px 0.817em; font-family: myriad-pro, Freesans, Helmet, sans-serif, \"Apple Color Emoji\", \"Segoe UI Emoji\", \"Segoe UI Symbol\"; line-height: 1; color: rgb(96, 122, 163); -webkit-font-smoothing: antialiased; text-rendering: optimizeLegibility; background-color: rgb(255, 255, 255);\">Take five to stay alive</h3>\r\n<p class=\"ParagraphFirst\" style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">The new study focused on a group of more than 55,000 men and women ages 18 to 100. About a quarter of them were runners. Over 15 years, those who ran just 50 minutes a week or fewer at a moderate pace were less likely to die from either cardiovascular disease or any cause, compared with those who didnâ€™t run at all.</p>\r\n<p class=\"ParagraphIndented\" style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">The study suggests a relatively low entry level for the benefit of jogging, but it is not a prescription. \"A little bit is good but a little bit more is probably better,â€ Dr. Baggish says. A 2013&nbsp;<a href=\"http://aje.oxfordjournals.org/content/early/2013/02/27/aje.kws301.full\" target=\"_blank\" style=\"box-sizing: border-box; touch-action: manipulation; color: rgb(181, 9, 55); text-decoration-line: none; transition: all 150ms ease-out; -webkit-font-smoothing: antialiased;\">study in Denmark</a>&nbsp;suggested that the \"sweet spotâ€ for maximum longevity is up to 2.5 hours of running a week.</p>\r\n<p class=\"ParagraphIndented\" style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">Although running can trim away some of your existing risk of cardiovascular disease, it doesnâ€™t entirely eliminate it. The combined effect of lifestyle, diet, and family history still contribute to your lifetime risk.</p>\r\n<p class=\"ParagraphIndented\" style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">\"There is no question that the fitter you are and the more exercise you do, the longer you live and the better your quality of life,â€ Dr. Baggish says. \"But it doesnâ€™t confer immunity.â€</p>\r\n<h3 style=\"box-sizing: border-box; font-size: 1.25rem; margin: 0px 0px 0.817em; font-family: myriad-pro, Freesans, Helmet, sans-serif, \"Apple Color Emoji\", \"Segoe UI Emoji\", \"Segoe UI Symbol\"; line-height: 1; color: rgb(96, 122, 163); -webkit-font-smoothing: antialiased; text-rendering: optimizeLegibility; background-color: rgb(255, 255, 255);\">Feeling better</h3>\r\n<p class=\"ParagraphFirst\" style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">This study used preventing death to measure the benefit of running, but itâ€™s not the most typical reason for running. \"Many dedicated long-term runners do not run because they want to live longer,â€ Dr. Baggish notes. \"They run because it makes them feel better on a daily basis. There is a mood elevating, quality-of-life benefit that comes from being a regular exerciser.â€</p>\r\n<p class=\"ParagraphIndented\" style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">For regular runners, the cost of feeling good can be strains and sprains, so Dr. Baggish advocates for the value of what he calls \"active rest.â€ His rule of thumb, not supported by any specific research, is that itâ€™s a good idea to spend 25% of exercise time over the course of a year running at a lower level of intensity or doing other activities like swimming or biking.</p>\r\n<p class=\"ParagraphIndented\" style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">\"The body responds to training, but to preserve that benefit over the long haul there needs to be active periods of recovery,â€ Dr. Baggish says. \"Pulling back allows the body to repair and heal.â€</p>', 'running-for-health-even-a-little-bit-is-good-but-a-little-more-is-probably-better', 1, 1, '2016-10-20 15:32:14', '2016-10-20 10:02:14', '2017-11-06 10:07:19', 'Admin', 1),
(10, 'Teens with upbeat friends may have better emotional health', 'Pediatricians and child behavior specialists who work with teens know that adolescence is an incredibly important time for social growth. Yet these years can be fraught with anxiety for the parents of teens. How will you know if your moody teen is hanging out with the right people? Which friends might be a bad influence? How can you help your son or daughter develop healthy relationships?', '<p><span style=\"color: #999999; font-family: \'Open Sans\', sans-serif; font-size: 13px;\">\r\n		<p style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">Pediatricians and child behavior specialists who work with teens know that adolescence is an incredibly important time for social growth. Yet these years can be fraught with anxiety for the parents of teens. How will you know if your moody teen is hanging out with the right people? Which friends might be a bad influence? How can you help your son or daughter develop healthy relationships?</p>\r\n		<p style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">Recent research has addressed some aspects of these questions. One study entitled \"<a href=\"http://rspb.royalsocietypublishing.org/content/282/1813/20151180/\" target=\"_blank\" style=\"box-sizing: border-box; touch-action: manipulation; color: rgb(181, 9, 55); text-decoration-line: none; transition: all 150ms ease-out; -webkit-font-smoothing: antialiased;\">Spreading of healthy mood in adolescent social networks</a><span style=\"text-decoration: underline;\">,</span>â€ published this year in the&nbsp;<em style=\"box-sizing: border-box;\">Proceedings of the Royal Society of London</em>, investigated whether a teen whose friends have a healthy mood is less likely to be depressed. It also looked at how emotionally healthy friends affected a teenâ€™s recovery from depression. Basically, the researchers wanted to find out: is a good mood contagious?</p>\r\n		<p style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">The study involved roughly 3,000 teens. Each study volunteer completed two surveys, six months apart, in which he or she listed up to five male and five female friends. Each teen was then followed over time, to see how his or her mood changed.</p>\r\n		<p style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">One of the interesting things about this study is that these researchers defined depression as a behavior, not necessarily as a disease that someone could get. This allowed them to do their statistical analysis a little differently from previous studies looking at the same subject matter, and it uncovered the potential power of positively minded friends.</p>\r\n		<p style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">The investigators found that having a social network made up of friends with a healthy mood cut a teenagerâ€™s probability of developing depression in half over a 6- to 12-month period. It also significantly improved the chances of recovering from depression for teens who already suffered from it. While the data donâ€™t show a direct cause and effect, this study does suggest that having friends with a healthy mood may reduce the risk of depression and make it a little easier to recover from depression should it occur.</p>\r\n		<h3 style=\"box-sizing: border-box; font-size: 1.25rem; margin: 0px 0px 0.817em; font-family: myriad-pro, Freesans, Helmet, sans-serif, \"Apple Color Emoji\", \"Segoe UI Emoji\", \"Segoe UI Symbol\"; line-height: 1; color: rgb(96, 122, 163); -webkit-font-smoothing: antialiased; text-rendering: optimizeLegibility; background-color: rgb(255, 255, 255);\">Surprising findings on from social networking research</h3>\r\n		<p style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">This study is a nice example of a recent trend in epidemiology â€” using data about an individualâ€™s social network to learn things about that person. This type of research has led to numerous interesting findings, and has really shaped an entire new area of inquiry.&nbsp;<a href=\"http://www.nejm.org/doi/full/10.1056/NEJMsa066082\" target=\"_blank\" style=\"box-sizing: border-box; touch-action: manipulation; color: rgb(181, 9, 55); text-decoration-line: none; transition: all 150ms ease-out; -webkit-font-smoothing: antialiased;\">A study</a>&nbsp;published in 2007 in&nbsp;<em style=\"box-sizing: border-box;\">The New England Journal of Medicine</em>&nbsp;was one of the first of this kind. It showed that people who had obese friends and family were themselves more likely to be obese. Since then, additional research has looked at how social networks influence an individualâ€™s risk of developing (or sidestepping) specific health conditions, such as obesity, smoking, and depression.</p>\r\n		<p style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">Results of these studies have been, at times, surprising, thus giving the medical community valuable new information. For example, I myself led a&nbsp;<a href=\"http://link.springer.com/article/10.1007/s10900-011-9366-6\" target=\"_blank\" style=\"box-sizing: border-box; touch-action: manipulation; color: rgb(181, 9, 55); text-decoration-line: none; transition: all 150ms ease-out; -webkit-font-smoothing: antialiased;\">study in 2011</a>&nbsp;called \"The influence of social networks on patientsâ€™ attitudes toward type II diabetes.â€ When I started this research, I supposed that patients would be less concerned about having diabetes if more of their friends and family members had diabetes. I had guessed that these patients might have become so used to the idea of diabetes that the disease would seem common and almost normal. But in fact, my team found the opposite! Patients with a higher prevalence of diabetes within their social networks expressed greater concern about their illness. This unexpected result gave me information that helped me to better take care of my patients.</p>\r\n		<h3 style=\"box-sizing: border-box; font-size: 1.25rem; margin: 0px 0px 0.817em; font-family: myriad-pro, Freesans, Helmet, sans-serif, \"Apple Color Emoji\", \"Segoe UI Emoji\", \"Segoe UI Symbol\"; line-height: 1; color: rgb(96, 122, 163); -webkit-font-smoothing: antialiased; text-rendering: optimizeLegibility; background-color: rgb(255, 255, 255);\">Using social network data to improve your teenâ€™s mental health</h3>\r\n		<p style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">This type of research is not only helpful to doctors, but it also provides important information for anyone trying to improve his or her own health, or the health of oneâ€™s family. The study on positive mood in teensâ€™ social networks suggests that parents may be able to reduce their teenâ€™s chances of developing depression â€” or improve her or his mood if she does have depression â€” simply by promoting and supporting friendships with emotionally healthy peers. With much controversy about using antidepressants in teens, results such as these can give parents a simple way to promote emotional health and well-being in their adolescent children â€” with no medications involved.</p></span></p>', 'teens-with-upbeat-friends-may-have-better-emotional-health', 1, 0, '2016-11-21 12:24:07', '2016-11-21 06:54:07', '2017-11-06 10:05:48', 'Admin', 8),
(12, 'Researchers may have discovered a cause of multiple sclerosis', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', '<p>\r\n	<p style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">Multiple sclerosis (MS) is a condition that causes damage to the substance that covers nerve cells. This interrupts normal communication between nerves, leading to problems with movement, speech, and other functions. We donâ€™t know what causes MS but we think it is an autoimmune disease.</p>\r\n	<h3 style=\"box-sizing: border-box; font-size: 1.25rem; margin: 0px 0px 0.817em; font-family: myriad-pro, Freesans, Helmet, sans-serif, \"Apple Color Emoji\", \"Segoe UI Emoji\", \"Segoe UI Symbol\"; line-height: 1; color: rgb(96, 122, 163); -webkit-font-smoothing: antialiased; text-rendering: optimizeLegibility; background-color: rgb(255, 255, 255);\">What is an autoimmune disease?</h3>\r\n	<p style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">Autoimmune diseases develop when a personâ€™s immune system goes after its own tissues and organs. Autoimmune disease can affect all parts of the body. For example:</p>\r\n	<ul style=\"box-sizing: border-box; margin: 0px 0px 1em; padding: 0px 0px 0px 1.335em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">\r\n		<li style=\"box-sizing: border-box; margin-bottom: 0.25em;\"><em style=\"box-sizing: border-box;\">Type 1 diabetes</em>. This is the type that usually affects kids and develops when abnormal antibodies attack certain cells in the pancreas, leaving it unable to produce enough insulin, so the body canâ€™t regulate blood sugar properly</li>\r\n		<li style=\"box-sizing: border-box; margin-bottom: 0.25em;\"><em style=\"box-sizing: border-box;\">Rheumatoid arthritis</em>. Multiple joints and other organs become inflamed; the cause is unknown, but the presence of autoantibodies (antibodies directed against proteins in healthy tissues) and other abnormal immune function suggest it is an autoimmune disorder.</li>\r\n		<li style=\"box-sizing: border-box; margin-bottom: 0.25em;\"><em style=\"box-sizing: border-box;\">Pernicious anemia</em>. In this condition, anemia develops when the immune system produces antibodies that prevent absorption of vitamin B<span style=\"box-sizing: border-box; font-size: 12px; line-height: 0; position: relative; vertical-align: baseline; bottom: -0.25em;\">12</span>&nbsp;from food.</li>\r\n	</ul>\r\n	<p style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">And these are just a few. Autoimmune conditions are especially scary because the immune system goes rogue for no apparent reason. These are favorite conditions of medical television and movies, such as&nbsp;<em style=\"box-sizing: border-box;\">House</em>,&nbsp;<em style=\"box-sizing: border-box;\">Greyâ€™s Anatomy</em>, and&nbsp;<em style=\"box-sizing: border-box;\">The Big Sick</em>.</p>\r\n	<h3 style=\"box-sizing: border-box; font-size: 1.25rem; margin: 0px 0px 0.817em; font-family: myriad-pro, Freesans, Helmet, sans-serif, \"Apple Color Emoji\", \"Segoe UI Emoji\", \"Segoe UI Symbol\"; line-height: 1; color: rgb(96, 122, 163); -webkit-font-smoothing: antialiased; text-rendering: optimizeLegibility; background-color: rgb(255, 255, 255);\">What triggers autoimmune diseases?</h3>\r\n	<p style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">The most common explanation is that an affected personâ€™s immune system, partly due to the genes they inherited, is primed to react abnormally to some trigger, such as an infection, an environmental exposure (like cigarette smoke), or some other factor. For most autoimmune diseases, we canâ€™t easily figure out what triggers them. If we could, we might be able to prevent them.</p>\r\n	<h3 style=\"box-sizing: border-box; font-size: 1.25rem; margin: 0px 0px 0.817em; font-family: myriad-pro, Freesans, Helmet, sans-serif, \"Apple Color Emoji\", \"Segoe UI Emoji\", \"Segoe UI Symbol\"; line-height: 1; color: rgb(96, 122, 163); -webkit-font-smoothing: antialiased; text-rendering: optimizeLegibility; background-color: rgb(255, 255, 255);\">Are there known triggers for MS?</h3>\r\n	<p style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">Experts suspect a number of potential triggers or risk factors for MS. For example, some believe that itâ€™s due to a chronic infection (although itâ€™s unclear exactly which infection). Others believe that itâ€™s primarily a genetic neurological disease. These theories challenge the idea that MS is truly an autoimmune disease.</p>\r\n	<p style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">Some studies suggest that head injuries might be a risk factor for MS. If true, it raises important questions about how MS develops and how it might be prevented. On the other hand, itâ€™s not an easy thing to study because researchers would never intentionally cause head injuries to see if they cause MS. Another way to study this question is to enroll people who already have MS, look back at whether they had concussions, and then compare them with similar people who donâ€™t have MS.</p>\r\n	<p style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">A&nbsp;<a href=\"https://www.ncbi.nlm.nih.gov/pubmed/28869671\" target=\"_blank\" style=\"box-sizing: border-box; touch-action: manipulation; color: rgb(181, 9, 55); text-decoration-line: none; transition: all 150ms ease-out; -webkit-font-smoothing: antialiased;\">new study</a>&nbsp;published in the September 2017 issue of&nbsp;<em style=\"box-sizing: border-box;\">Annals of Neurology</em>&nbsp;did just that.</p>\r\n	<h3 style=\"box-sizing: border-box; font-size: 1.25rem; margin: 0px 0px 0.817em; font-family: myriad-pro, Freesans, Helmet, sans-serif, \"Apple Color Emoji\", \"Segoe UI Emoji\", \"Segoe UI Symbol\"; line-height: 1; color: rgb(96, 122, 163); -webkit-font-smoothing: antialiased; text-rendering: optimizeLegibility; background-color: rgb(255, 255, 255);\">New research suggests that head trauma might trigger MS</h3>\r\n	<p style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">This research included more than 7,000 people with MS and compared them with more than 70,000 people who were similar in other ways (including age, gender, and where they lived) but who did not have MS. Investigators looked for a history of physician-diagnosed concussion prior to age 20. It was important to determine whether any type of traumatic injury, or a concussion specifically, could be the link. So, researchers also assessed whether the study subjects had ever broken a bone in the upper or lower extremities prior to age 20.</p>\r\n	<p style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">Hereâ€™s what they found:</p>\r\n	<ul style=\"box-sizing: border-box; margin: 0px 0px 1em; padding: 0px 0px 0px 1.335em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">\r\n		<li style=\"box-sizing: border-box; margin-bottom: 0.25em;\">Those who had suffered a single concussion between the ages of 10 and 20 had a 22% higher rate of MS than those who had never had a concussion.</li>\r\n		<li style=\"box-sizing: border-box; margin-bottom: 0.25em;\">The rate of MS was more than doubled for those who had experienced more than one concussion.</li>\r\n		<li style=\"box-sizing: border-box; margin-bottom: 0.25em;\">There was no connection between broken bones in the arms or legs and the risk of MS.</li>\r\n	</ul>\r\n	<p style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">A study of this type cannot prove that a potential trigger (head injury) actually caused the condition of interest (MS). We can only say there is a possible link. But we do have data to suggest that there is a link, and likely not a link with other types of injuries. We might later learn that the connection isnâ€™t between concussions and MS at all, but rather some other factor (such as a drug or other treatment) that is more common among those with head injuries.</p>\r\n	<p style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">Still, these findings are hard to ignore and could represent one more reason we should all be concerned about head injuries to the developing brain.</p>\r\n	<h3 style=\"box-sizing: border-box; font-size: 1.25rem; margin: 0px 0px 0.817em; font-family: myriad-pro, Freesans, Helmet, sans-serif, \"Apple Color Emoji\", \"Segoe UI Emoji\", \"Segoe UI Symbol\"; line-height: 1; color: rgb(96, 122, 163); -webkit-font-smoothing: antialiased; text-rendering: optimizeLegibility; background-color: rgb(255, 255, 255);\">Whatâ€™s next?</h3>\r\n	<p style=\"box-sizing: border-box; margin: 0.5em 0px 1em; color: rgb(68, 68, 68); font-family: myriad-pro, Freesans, Helmet, sans-serif; font-size: 16px; background-color: rgb(255, 255, 255);\">Additional studies are needed, both to replicate these findings and to figure out just how trauma can trigger an autoimmune disease. These studies can also provide clues as to whether trauma might trigger other autoimmune diseases as well. If we gain a better understanding of how autoimmune conditions develop and how to prevent them, these conditions could become a bit less scary.</p></p>', 'lorem-ipsum-is-simply-dummy-1', 1, 0, '2017-02-23 09:55:50', '2017-02-23 04:25:50', '2017-11-06 10:04:26', 'Admin', 11);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blog_post_categories`
--

CREATE TABLE `tbl_blog_post_categories` (
  `category_id` int(11) NOT NULL,
  `category_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_description` text COLLATE utf8_unicode_ci NOT NULL,
  `category_seo_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'The name will be used in urls and must be seo \r\n\r\nfriendly',
  `category_status` tinyint(4) NOT NULL COMMENT '0->Inactive, 1->Active',
  `category_date_time` datetime NOT NULL,
  `category_parent` int(11) NOT NULL,
  `category_display_order` int(11) NOT NULL,
  `category_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_blog_post_categories`
--

INSERT INTO `tbl_blog_post_categories` (`category_id`, `category_title`, `category_description`, `category_seo_name`, `category_status`, `category_date_time`, `category_parent`, `category_display_order`, `category_code`) VALUES
(1, 'Health', '', 'health', 1, '2017-11-06 10:01:30', 6, 0, '0000600001'),
(2, 'external injuries', '', 'external-injuries', 1, '2017-11-06 10:02:37', 1, 2, '000060000100002'),
(3, 'Internal Injuries', '', 'internal-injuries', 1, '2017-11-06 10:02:19', 1, 1, '000060000100003'),
(4, 'Injuries', '', 'injuries', 1, '2017-11-06 10:01:45', 6, 0, '0000600004'),
(5, 'Shop', '', 'shop', 1, '2016-06-29 16:00:14', 4, 0, '0000400005'),
(6, 'Harvard Health Blog', '', 'harvard-health-blog', 1, '2017-11-06 10:02:49', 0, 0, '00006');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blog_post_category_relation`
--

CREATE TABLE `tbl_blog_post_category_relation` (
  `relation_post_id` int(11) NOT NULL,
  `relation_category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_blog_post_category_relation`
--

INSERT INTO `tbl_blog_post_category_relation` (`relation_post_id`, `relation_category_id`) VALUES
(9, 3),
(9, 4),
(10, 1),
(10, 2),
(10, 3),
(12, 6);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blog_post_comments`
--

CREATE TABLE `tbl_blog_post_comments` (
  `comment_id` int(11) NOT NULL,
  `comment_post_id` int(11) NOT NULL,
  `comment_author_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `comment_author_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `comment_content` text COLLATE utf8_unicode_ci NOT NULL,
  `comment_status` tinyint(1) NOT NULL COMMENT '0->Pending, 1->Approved, 2->Deleted',
  `comment_date_time` datetime NOT NULL,
  `comment_ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `comment_user_agent` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `comment_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blog_post_images`
--

CREATE TABLE `tbl_blog_post_images` (
  `post_image_id` int(11) NOT NULL,
  `post_image_post_id` int(11) NOT NULL,
  `post_image_file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `post_image_default` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_blog_post_images`
--

INSERT INTO `tbl_blog_post_images` (`post_image_id`, `post_image_post_id`, `post_image_file_name`, `post_image_default`) VALUES
(12, 12, 'Chrysanthemumjpg', 1),
(13, 12, 'Hydrangeasjpg', 0),
(14, 12, 'Desertjpg', 0),
(15, 10, 'bloggingimagejpg', 1),
(16, 10, 'bloggingimagejpg_14', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cms_contents`
--

CREATE TABLE `tbl_cms_contents` (
  `cmsc_id` int(11) NOT NULL,
  `cmsc_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cmsc_slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cmsc_content` text COLLATE utf8_unicode_ci NOT NULL,
  `cmsc_type` tinyint(2) NOT NULL COMMENT '0->LEFT, 1->RIGHT',
  `cmsc_page_identifier` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Applicationconstants::$arr_cms_page',
  `cmsc_meta_title` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `cmsc_meta_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cmsc_meta_description` text COLLATE utf8_unicode_ci NOT NULL,
  `cmsc_content_delete` tinyint(4) NOT NULL,
  `cmsc_content_active` tinyint(2) NOT NULL DEFAULT '1',
  `cmsc_sub_title` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_cms_contents`
--

INSERT INTO `tbl_cms_contents` (`cmsc_id`, `cmsc_title`, `cmsc_slug`, `cmsc_content`, `cmsc_type`, `cmsc_page_identifier`, `cmsc_meta_title`, `cmsc_meta_keywords`, `cmsc_meta_description`, `cmsc_content_delete`, `cmsc_content_active`, `cmsc_sub_title`) VALUES
(1, 'tdd', 'dfsdd', '<p>fsafsafdsdfsadfsasadfddddd</p>', 1, 'ABOUT_US', '0', '', '', 1, 1, ''),
(21, 'test1', 'unique', '<h1 style=\"text-align: justify;\"><span style=\"text-decoration: underline;\"><em><strong><span style=\"text-decoration: line-through;\">zxfgzdfgdg</span> d</strong></em></span>fgf dfgdg dg dfg dfgdgfd dfvf dfvgdf dfgdfv dfvgdfv dfbdf gdffdfr dfvdfgfgfdg dfgfrg frdfg&nbsp; dfdf dfv</h1>\r\n<hr />\r\n<h1 style=\"text-align: justify;\">fvffd sdfgfgdf dfbdfb</h1>', 2, '', '0', '', '', 1, 1, ''),
(2, 'aaa', 'gfsb', '<p>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</p>', 2, 'LEGAL', '0', '', '', 1, 1, ''),
(20, 't', 'dfs', '<p>aaaaaaaaaaaa</p>', 1, '', '0', '', '', 1, 1, ''),
(13, 'In in beatae eum rerum quam voluptatem quo dolorum tempore Nam labore ut eum totam nesciunt accusamus porro illum pariatur', 'Deserunt-sunt-do-enim-cum-non-deserunt-eveniet-consequuntur-duis-voluptatem-sed-debitis-sed-vel-ratione-adipisicing-rerum-eum-qui', 'Rem atque dolor voluptatibus duis at veniam, velit et nulla odio eius necessitatibus enim consequatur, vel autem.', 1, '', '0', '', '', 1, 1, ''),
(14, 'test page', '123', '<p>test</p>', 1, '', '0', '', '', 1, 0, ''),
(15, 'test page11', 'test', '<p>&nbsp;Hello Sir,</p>\r\n<hr />\r\n<h1>Admin section :<br />--dashboard and its sub sections<br />--ques<span style=\"text-decoration: line-through;\"><strong><span style=\"text-decoration: underline;\"><em>tion management</em></span></strong></span><br /><span style=\"text-decoration: line-through;\"><strong><span style=\"text-decoration: underline;\"><em>--customer management </em></span></strong></span><br /><span style=\"text-decoration: line-through;\"><strong><span style=\"text-decoration: underline;\"><em>--transaction management</em></span></strong></span><br /><span style=\"text-decoration: line-through;\"><strong><span style=\"text-decoration: underline;\"><em>--Manage Med</em></span></strong></span>ical categories<br />&nbsp;--Manage Countries<br />-- Manage Doctors<br />--Manage Degrees<br />--Login form<br /><br />Front end :<br />--login form of doctor and customer<br />--posted different questions and checked the functionalities<br />--checked the email verification for different scenarios<br /><br />I have made different new accounts of doctors and patients and apply their account functionalities accordingly.<br /><br />I also have discussion with Pooja Mam regarding my Issues and other queries(25 mins)<br />I also have discussion with Shelly Mam regarding task details<br /><br />I have got some Issues and suggestions.<br /><br />I also have discussion with Shelly Mam regarding task details<br /><br />PFA folder for reference<br /><br />Thanks and Regards,<br />Akshay Vermatesttest</h1>', 1, '', '0', '', '', 1, 1, ''),
(16, 'gs', 'gfsb', '<p>grftbs</p>', 2, '', '0', '', '', 1, 0, ''),
(17, 'dfsgdf', 'sgdf', '<p>fdsgdf</p>', 1, '', '0', '', '', 1, 0, ''),
(18, 'fgb', 'gbs', '<p>sbg</p>', 2, '', '0', '', '', 1, 1, ''),
(3, 'Demo', 'Demo-2', '<p>dsadsadssad</p>', 0, '', '0', '', '', 1, 0, ''),
(4, 'trew', '', '<h1 style=\"color: #ff0000;\">Terms</h1>\r\n<p><span style=\"color: #ff0000;\">Lorem ipsum dolor <span style=\"text-decoration: underline;\">sit amet, con</span>sectetur adipiscing elit. Integer commodo nibh sed interdum ultrices</span></p>\r\n<p>. Duis velit urna, iaculis vel arcu ornare, euismod malesuada libero. Integer eu dui mi. Donec quis sollicitudin lectus. Aliquam non ipsum laoreet, cursus urna eu, tempor dolor. Proin ultrices dui suscipit eros maximus varius. In sit amet vehicula ligula. Integer non auctor nibh. Curabitur volutpat nunc sit amet justo mattis convallis. Mauris gravida orci ligula, ac aliquam ligula mattis sed. Vestibulum metus est, vestibulum non neque eget, commodo imperdiet dui. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque a porta nisi, vitae rhoncus felis. Integer sollicitudin, enim in cursus bibendum, lorem massa pellentesque odio, at suscipit nibh risus sit amet eros.</p>\r\n<p>Duis consectetur finibus tortor sit amet rutrum. Vivamus dapibus felis in leo efficitur consectetur. Nullam eleifend dolor quis imperdiet vulputate. In cursus sapien posuere, pellentesque mi at, venenatis nibh. Curabitur tristique ex id iaculis vehicula. Cras euismod, erat ac sollicitudin imperdiet, lorem nisi euismod lectus, eu ultrices libero sem a tellus. Sed et felis sed eros iaculis semper. Curabitur justo mi, egestas placerat erat vitae, bibendum interdum leo. Suspendisse eget enim ante.</p>\r\n<p>Ut blandit pellentesque augue, ac interdum ante interdum in. Aliquam erat volutpat. Phasellus vel augue et nibh dapibus consectetur. Mauris maximus elit nec commodo gravida. Vivamus dictum eu leo ac vestibulum. Integer at velit efficitur, bibendum tellus at, porttitor turpis. Duis eu hendrerit metus.</p>\r\n<p>Maecenas viverra efficitur ligula eget tincidunt. Quisque fringilla nibh leo, ac vestibulum enim hendrerit at. Maecenas dignissim turpis blandit velit semper, sed mollis justo molestie. Vestibulum tortor mi, consequat eget iaculis vitae, ultricies et eros. Vivamus laoreet placerat lorem, non commodo nisl dapibus et. Nullam tellus elit, sollicitudin ac turpis ut, sollicitudin sollicitudin diam. Cras eget ipsum neque. Sed sit amet placerat ante. Aliquam eget enim mi. Donec et dolor luctus, porttitor dolor ut, hendrerit lacus. Cras tempor turpis nec orci feugiat vehicula. Etiam facilisis nunc eros, sit amet pulvinar leo cursus vitae. Mauris turpis lacus, imperdiet ac mi non, suscipit hendrerit erat. Pellentesque consectetur eget leo sed mattis.</p>\r\n<p>Quisque est justo, ullamcorper sit amet consectetur eu, tincidunt ut tortor. Proin id porta odio. Maecenas nec justo tellus. Nam sed ullamcorper mauris, sit amet tempus ex. Aenean non metus at augue fringilla auctor nec a felis. Nullam id dui eu elit semper pretium. Morbi rhoncus mi at sem consectetur, sollicitudin molestie purus mattis. Donec sagittis turpis eget ornare bibendum. Nulla hendrerit augue sit amet ultrices sollicitudin.</p>', 1, 'TERMS', 'aa', 'aaaa', 'sdfgdsa', 1, 1, ''),
(5, 'Help', 'help', '<p>HElp page coming soon</p>', 1, '', '0', '', '', 1, 0, ''),
(6, 'Careers', 'careers', '<p>\r\n	<div><br />\r\n		</div>\r\n	<div>name and job title</div>\r\n	<div>contact information including email address</div>\r\n	<div>demographic information such as postcode, preferences and interests</div>\r\n	<div>other information relevant to customer surveys and/or offers</div>\r\n	<div>What we do with the information we gather</div>\r\n	<div><br />\r\n		</div>\r\n	<div>We require this information to understand your needs and provide you with a better service, and in particular for the following reasons:</div>\r\n	<div><br />\r\n		</div>\r\n	<div>Internal record keeping.</div>\r\n	<div>We may use the information to improve our products and services.</div>\r\n	<div>We may periodically send promotional emails about new products, special offers or other information which we think you may find interesting using the email address which you have provided.</div>\r\n	<div>From time to time, we may also use your information to contact you for market research purposes. We may contact you by email, phone, fax or mail. We may use the information to customise the website according to your interests.</div>\r\n	<div>Security</div>\r\n	<div><br />\r\n		</div>\r\n	<div>We are committed to ensuring that your information is secure. In order to prevent unauthorised access or disclosure we have put in place suitable physical, electronic and managerial procedures to safeguard and secure the information we collect online.</div>\r\n	<div><br />\r\n		</div>\r\n	<div>How we use cookies</div>\r\n	<div><br />\r\n		</div>\r\n	<div>A cookie is a small file which asks permission to be placed on your computerâ€™s hard drive. Once you agree, the file is added and the cookie helps analyse web traffic or lets you know when you visit a particular site. Cookies allow web applications to respond to you as an individual. The web application can tailor its operations to your needs, likes and dislikes by gathering and remembering information about your preferences.</div>\r\n	<div><br />\r\n		</div>\r\n	<div>We use traffic log cookies to identify which pages are being used. This helps us analyse data about webpage traffic and improve our website in order to tailor it to customer needs. We only use this information for statistical analysis purposes and then the data is removed from the system.</div>\r\n	<div><br />\r\n		</div>\r\n	<div>Overall, cookies help us provide you with a better website, by enabling us to monitor which pages you find useful and which you do not. A cookie in no way gives us access to your computer or any information about you, other than the data you choose to share with us.</div>\r\n	<div><br />\r\n		</div>\r\n	<div>You can choose to accept or decline cookies. Most web browsers automatically accept cookies, but you can usually modify your browser setting to decline cookies if you prefer. This may prevent you from taking full advantage of the website.</div>\r\n	<div><br />\r\n		</div>\r\n	<div>Links to other websites</div>\r\n	<div><br />\r\n		</div>\r\n	<div>Our website may contain links to other websites of interest. However, once you have used these links to leave our site, you should note that we do not have any control over that other website. Therefore, we cannot be responsible for the protection and privacy of any information which you provide whilst visiting such sites and such sites are not governed by this privacy statement. You should exercise caution and look at the privacy statement applicable to the website in question.</div>\r\n	<div><br />\r\n		</div>\r\n	<div>Controlling your personal information</div>\r\n	<div><br />\r\n		</div>\r\n	<div>You may choose to restrict the collection or use of your personal information in the following ways:</div>\r\n	<div><br />\r\n		</div>\r\n	<div>whenever you are asked to fill in a form on the website, look for the box that you can click to indicate that you do not want the information to be used by anybody for direct marketing purposes</div>\r\n	<div>if you have previously agreed to us using your personal information for direct marketing purposes, you may change your mind at any time by writing to or emailing us at [email address]</div>\r\n	<div>We will not sell, distribute or lease your personal information to third parties unless we have your permission or are required by law to do so. We may use your personal information to send you promotional information about third parties which we think you may find interesting if you tell us that you wish this to happen.</div>\r\n	<div><br />\r\n		</div>\r\n	<div>You may request details of personal information which we hold about you under the Data Protection Act 1998. A small fee will be payable. If you would like a copy of the information held on you please write to [address].</div>\r\n	<div><br />\r\n		</div>\r\n	<div>If you believe that any information we are holding on you is incorrect or incomplete, please write to or email us as soon as possible, at the above address. We will promptly correct any information found to be incorrect.</div>\r\n	<div><br />\r\n		</div>\r\n	<div>&nbsp;</div></p>', 1, '', 'title', 'meta keywords', 'meta description', 0, 0, 'carrers'),
(7, 'Vacation', 'vacation', '<h2>Recently Asked Questions:</h2>\r\n<ul class=\"list1\">\r\n<li>bhb</li>\r\n<li>: I\'ve made an appointment to see a doctor because of my frequent...</li>\r\n<li>ome &raquo; How do I give my newborn a sponge bath? - Ask Doctor...</li>\r\n<li>fgsdgfd</li>\r\n<li>58756876</li>\r\n</ul>\r\n<ul class=\"nav-area\">\r\n<li><a class=\"active\"> Mental Health</a></li>\r\n<li><a> Sexual</a></li>\r\n<li><a> Health</a></li>\r\n<li><a> Pediatrics</a></li>\r\n<li><a> Cardiology</a></li>\r\n<li><a> Dental</a></li>\r\n<li><a> Dermatology</a></li>\r\n<li><a> OB GYN</a></li>\r\n<li><a> Urology</a></li>\r\n<li><a> Other</a></li>\r\n<li><a> General</a></li>\r\n<li><a> astama</a></li>\r\n</ul>\r\n<h3>Please explain your <span>m</span></h3>', 2, '', '0', '', '', 1, 0, ''),
(10, 'Demo', 'Demo', '<p>dasdsadsadsa</p>', 1, '', '0', '', '', 1, 1, ''),
(11, '', '', '', 0, '', '0', '', '', 1, 1, ''),
(12, '', '', '', 0, '', '0', '', '', 1, 1, ''),
(19, 'g', 'fsbh', '<p>fgb</p>', 1, '', '0', '', '', 1, 1, ''),
(22, 'test1', 'test1', '<p>test1</p>', 2, '', '', '', '', 1, 1, ''),
(23, 'Terms & Condition1', 'terms', '<div class=\"cms--content\">\r\n	<h3>Quae quidem blanditiis delectus corporis</h3>\r\n	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae quidem blanditiis delectus corporis, possimus officia sint sequi ex tenetur id impedit est pariatur iure animi non a ratione reiciendis nihil sed consequatur atque repellendus fugit perspiciatis rerum et. Dolorum consequuntur fugit deleniti, soluta fuga nobis.</p>\r\n	<ol>\r\n		<li>Morbi eu enim elit. Suspendisse sem leo, gravida eget consectetur sit amet</li>\r\n		<li>Accumsan id nisl. Praesent ipsum sem, vehicula non justo non, tristique rutrum leo. Phasellus nec dictum orci.</li>\r\n		<li>Morbi sit amet imperdiet dolor. In enim nunc, blandit nec fringilla</li>\r\n		<li>Phasellus nec dictum orci. Morbi sit amet imperdiet dolor.</li>\r\n		<li>Donec in viverra elit. Sed malesuada tellus leo, ac posuere augue laoreet ut</li>\r\n		<li>Vivamus ipsum risus, tempor eget nulla id, faucibus fermentum tellus. Maecenas eu metus tortor.</li>\r\n		<li>Duis semper laoreet diam eget iaculis. Nullam posuere nisi ac volutpat malesuada</li>\r\n		<li>Fusce ac turpis ut tortor imperdiet dictum et vehicula nisl.</li>\r\n		<li>Nam eu neque at mauris sagittis venenatis a at massa</li>\r\n		<li>Duis nec rutrum justo. Proin lorem mauris, pellentesque</li>\r\n		<li>Vivamus non urna mattis, sagittis neque quis</li>\r\n	</ol>\r\n	<p>Ducimus blanditiis velit sit iste delectus obcaecati debitis omnis, assumenda accusamus cumque perferendis eos aut quidem! Aut, totam rerum, cupiditate quae aperiam voluptas rem inventore quas, ex maxime culpa nam soluta labore at amet nihil laborum? Explicabo numquam, sit fugit, voluptatem autem atque quis quam voluptate fugiat earum rem hic, reprehenderit quaerat tempore at. Aperiam.</p>\r\n	<h3>Voluptatem autem atque quis quam voluptate</h3>\r\n	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae quidem blanditiis delectus corporis, possimus officia sint sequi ex tenetur id impedit est pariatur iure animi non a ratione reiciendis nihil sed consequatur atque repellendus fugit perspiciatis rerum et. Dolorum consequuntur fugit deleniti, soluta fuga nobis.</p>\r\n	<p>Ducimus blanditiis velit sit iste delectus obcaecati debitis omnis, assumenda accusamus cumque perferendis eos aut quidem! Aut, totam rerum, cupiditate quae aperiam voluptas rem inventore quas, ex maxime culpa nam soluta labore at amet nihil laborum? Explicabo numquam, sit fugit, voluptatem autem atque quis quam voluptate fugiat earum rem hic, reprehenderit quaerat tempore at. Aperiam.</p>\r\n	<h3>Ducimus blanditiis velit sit iste delectus obcaecati debitis omnis</h3>\r\n	<ul>\r\n		<li>Morbi eu enim elit. Suspendisse sem leo, gravida eget consectetur sit amet</li>\r\n		<li>Accumsan id nisl. Praesent ipsum sem, vehicula non justo non, tristique rutrum leo. Phasellus nec dictum orci.</li>\r\n		<li>Morbi sit amet imperdiet dolor. In enim nunc, blandit nec fringilla</li>\r\n		<li>Phasellus nec dictum orci. Morbi sit amet imperdiet dolor.</li>\r\n		<li>Donec in viverra elit. Sed malesuada tellus leo, ac posuere augue laoreet ut</li>\r\n		<li>Vivamus ipsum risus, tempor eget nulla id, faucibus fermentum tellus. Maecenas eu metus tortor.</li>\r\n		<li>Duis semper laoreet diam eget iaculis. Nullam posuere nisi ac volutpat malesuada</li>\r\n		<li>Fusce ac turpis ut tortor imperdiet dictum et vehicula nisl.</li>\r\n		<li>Nam eu neque at mauris sagittis venenatis a at massa</li>\r\n		<li>Duis nec rutrum justo. Proin lorem mauris, pellentesque</li>\r\n		<li>Vivamus non urna mattis, sagittis neque quis</li>\r\n	</ul></div>', 1, '', 'terms', '', '', 0, 1, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem'),
(24, 'HOw Does it Works?', 'howitworks', '<div class=\"working--process\">\r\n<p>Ask The Doctor is the world\'s easiest to use health platform. We are trusted by thousands of users daily and have helped save many lives. In just 3 simple steps, you will be connected to one of our top doctors to receive immediate help. Select from either a General Doctor or Specialist.</p>\r\n<ul class=\"steps--list\">\r\n<li class=\"stepFirst\">\r\n<div class=\"steps--list_box\">\r\n<div class=\"step--list_thumb-wrap\">\r\n<div class=\"step--list_thumb\"><img src=\"../images/fixed/step1.png\" alt=\"\" /></div>\r\n</div>\r\n<div class=\"step--list_content\">\r\n<h3>Select your Category</h3>\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum standard dummy has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>\r\n</div>\r\n</div>\r\n</li>\r\n<li class=\"stepSecond\">\r\n<div class=\"steps--list_box\">\r\n<div class=\"step--list_thumb-wrap\">\r\n<div class=\"step--list_thumb\"><img src=\"../images/fixed/step2.png\" alt=\"\" /></div>\r\n</div>\r\n<div class=\"step--list_content\">\r\n<h3>Ask your Health Question</h3>\r\n<p>To obtain the best answer, include as much detail as possible. You may upload medical reports and images to help our doctors answer your question as best as possible.</p>\r\n</div>\r\n</div>\r\n</li>\r\n<li class=\"stepThird\">\r\n<div class=\"steps--list_box\">\r\n<div class=\"step--list_thumb-wrap\">\r\n<div class=\"step--list_thumb\"><img src=\"../images/fixed/step3.png\" alt=\"\" /></div>\r\n</div>\r\n<div class=\"step--list_content\">\r\n<h3>Get your Health Result</h3>\r\n<p>Simply input your credit card details or use PayPal and receive your answer immediately by email. Ask The Doctor offers a 100% satisfaction guarantee. Sed ut perspiciatis unde omnis iste natus error sit voluptatem</p>\r\n</div>\r\n</div>\r\n</li>\r\n</ul>\r\n</div>', 1, '', '', '', '', 0, 1, 'HOw Does it Works?'),
(25, 'sdfsd', 'ffdfsdfdf', '<p>df</p>', 0, '', 'dfd', '', '', 1, 1, ''),
(26, 'hh', 'h-h', '<p>hh</p>', 0, '', '', '', '', 1, 1, ''),
(27, 'About us', 'about-us', '<div class=\"cms--content about\">\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae quidem blanditiis delectus corporis, possimus officia sint sequi ex tenetur id impedit est pariatur iure animi non a ratione reiciendis nihil sed consequatur atque repellendus fugit perspiciatis rerum et. Dolorum consequuntur fugit deleniti, soluta fuga nobis.</p>\r\n<p>Ducimus blanditiis velit sit iste delectus obcaecati debitis omnis, assumenda accusamus cumque perferendis eos aut quidem! Aut, totam rerum, cupiditate quae aperiam voluptas rem inventore quas, ex maxime culpa nam soluta labore at amet nihil laborum? Explicabo numquam, sit fugit, voluptatem autem atque quis quam voluptate fugiat earum rem hic, reprehenderit quaerat tempore at. Aperiam.</p>\r\n<h3>Who We are</h3>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae quidem blanditiis delectus corporis, possimus officia sint sequi ex tenetur id impedit est pariatur iure animi non a ratione reiciendis nihil sed consequatur atque repellendus fugit perspiciatis rerum et. Dolorum consequuntur fugit deleniti, soluta fuga nobis.</p>\r\n<p>Ducimus blanditiis velit sit iste delectus obcaecati debitis omnis, assumenda accusamus cumque perferendis eos aut quidem! Aut, totam rerum, cupiditate quae aperiam voluptas rem inventore quas, ex maxime culpa nam soluta labore at amet nihil laborum? Explicabo numquam, sit fugit, voluptatem autem atque quis quam voluptate fugiat earum rem hic, reprehenderit quaerat tempore at. Aperiam.</p>\r\n<h3>What We Do</h3>\r\n<ul>\r\n<li>Morbi eu enim elit. Suspendisse sem leo, gravida eget consectetur sit amet</li>\r\n<li>Accumsan id nisl. Praesent ipsum sem, vehicula non justo non, tristique rutrum leo. Phasellus nec dictum orci.</li>\r\n<li>Morbi sit amet imperdiet dolor. In enim nunc, blandit nec fringilla</li>\r\n<li>Phasellus nec dictum orci. Morbi sit amet imperdiet dolor.</li>\r\n<li>Donec in viverra elit. Sed malesuada tellus leo, ac posuere augue laoreet ut</li>\r\n<li>Vivamus ipsum risus, tempor eget nulla id, faucibus fermentum tellus. Maecenas eu metus tortor.</li>\r\n<li>Duis semper laoreet diam eget iaculis. Nullam posuere nisi ac volutpat malesuada</li>\r\n<li>Fusce ac turpis ut tortor imperdiet dictum et vehicula nisl.</li>\r\n<li>Nam eu neque at mauris sagittis venenatis a at massa</li>\r\n<li>Duis nec rutrum justo. Proin lorem mauris, pellentesque</li>\r\n<li>Vivamus non urna mattis, sagittis neque quis</li>\r\n</ul>\r\n<ol>\r\n<li>Morbi eu enim elit. Suspendisse sem leo, gravida eget consectetur sit amet</li>\r\n<li>Accumsan id nisl. Praesent ipsum sem, vehicula non justo non, tristique rutrum leo. Phasellus nec dictum orci.</li>\r\n<li>Morbi sit amet imperdiet dolor. In enim nunc, blandit nec fringilla</li>\r\n<li>Phasellus nec dictum orci. Morbi sit amet imperdiet dolor.</li>\r\n<li>Donec in viverra elit. Sed malesuada tellus leo, ac posuere augue laoreet ut</li>\r\n<li>Vivamus ipsum risus, tempor eget nulla id, faucibus fermentum tellus. Maecenas eu metus tortor.</li>\r\n<li>Duis semper laoreet diam eget iaculis. Nullam posuere nisi ac volutpat malesuada</li>\r\n<li>Fusce ac turpis ut tortor imperdiet dictum et vehicula nisl.</li>\r\n<li>Nam eu neque at mauris sagittis venenatis a at massa</li>\r\n<li>Duis nec rutrum justo. Proin lorem mauris, pellentesque</li>\r\n<li>Vivamus non urna mattis, sagittis neque quis</li>\r\n</ol></div>', 0, '', '', '', '', 0, 1, 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem'),
(28, 'Privacy Policy', 'privacy-policy', '<p>\r\n	<div>This privacy policy sets out how \"[business name]â€ uses and protects any information that you give \"[business name]â€ when you use this website.</div>\r\n	<div><br />\r\n		</div>\r\n	<div>\"[business name]â€ is committed to ensuring that your privacy is protected. Should we ask you to provide certain information by which you can be identified when using this website, then you can be assured that it will only be used in accordance with this privacy statement.</div>\r\n	<div><br />\r\n		</div>\r\n	<div>\"[business name]â€ may change this policy from time to time by updating this page. You should check this page from time to time to ensure that you are happy with any changes. This policy is effective from [date].</div>\r\n	<div><br />\r\n		</div>\r\n	<div><span style=\"font-weight: bold;\">What we collect</span></div>\r\n	<div><br />\r\n		</div>\r\n	<div>We may collect the following information:</div>\r\n	<div><br />\r\n		</div>\r\n	<div>name and job title</div>\r\n	<div>contact information including email address</div>\r\n	<div>demographic information such as postcode, preferences and interests</div>\r\n	<div>other information relevant to customer surveys and/or offers</div>\r\n	<div>What we do with the information we gather</div>\r\n	<div><br />\r\n		</div>\r\n	<div>We require this information to understand your needs and provide you with a better service, and in particular for the following reasons:</div>\r\n	<div><br />\r\n		</div>\r\n	<div>Internal record keeping.</div>\r\n	<div>We may use the information to improve our products and services.</div>\r\n	<div>We may periodically send promotional emails about new products, special offers or other information which we think you may find interesting using the email address which you have provided.</div>\r\n	<div>From time to time, we may also use your information to contact you for market research purposes. We may contact you by email, phone, fax or mail. We may use the information to customise the website according to your interests.</div>\r\n	<div>Security</div>\r\n	<div><br />\r\n		</div>\r\n	<div>We are committed to ensuring that your information is secure. In order to prevent unauthorised access or disclosure we have put in place suitable physical, electronic and managerial procedures to safeguard and secure the information we collect online.</div>\r\n	<div><br />\r\n		</div>\r\n	<div><span style=\"font-weight: bold;\">How we use cookies</span></div>\r\n	<div><br />\r\n		</div>\r\n	<div>A cookie is a small file which asks permission to be placed on your computerâ€™s hard drive. Once you agree, the file is added and the cookie helps analyse web traffic or lets you know when you visit a particular site. Cookies allow web applications to respond to you as an individual. The web application can tailor its operations to your needs, likes and dislikes by gathering and remembering information about your preferences.</div>\r\n	<div><br />\r\n		</div>\r\n	<div>We use traffic log cookies to identify which pages are being used. This helps us analyse data about webpage traffic and improve our website in order to tailor it to customer needs. We only use this information for statistical analysis purposes and then the data is removed from the system.</div>\r\n	<div><br />\r\n		</div>\r\n	<div>Overall, cookies help us provide you with a better website, by enabling us to monitor which pages you find useful and which you do not. A cookie in no way gives us access to your computer or any information about you, other than the data you choose to share with us.</div>\r\n	<div><br />\r\n		</div>\r\n	<div>You can choose to accept or decline cookies. Most web browsers automatically accept cookies, but you can usually modify your browser setting to decline cookies if you prefer. This may prevent you from taking full advantage of the website.</div>\r\n	<div><span style=\"font-weight: bold;\"><br />\r\n			</span></div>\r\n	<div><span style=\"font-weight: bold;\">Links to other websites</span></div>\r\n	<div><br />\r\n		</div>\r\n	<div>Our website may contain links to other websites of interest. However, once you have used these links to leave our site, you should note that we do not have any control over that other website. Therefore, we cannot be responsible for the protection and privacy of any information which you provide whilst visiting such sites and such sites are not governed by this privacy statement. You should exercise caution and look at the privacy statement applicable to the website in question.</div>\r\n	<div><span style=\"font-weight: bold;\"><br />\r\n			</span></div>\r\n	<div><span style=\"font-weight: bold;\">Controlling your personal information</span></div>\r\n	<div><br />\r\n		</div>\r\n	<div>You may choose to restrict the collection or use of your personal information in the following ways:</div>\r\n	<div><br />\r\n		</div>\r\n	<div>whenever you are asked to fill in a form on the website, look for the box that you can click to indicate that you do not want the information to be used by anybody for direct marketing purposes</div>\r\n	<div>if you have previously agreed to us using your personal information for direct marketing purposes, you may change your mind at any time by writing to or emailing us at [email address]</div>\r\n	<div>We will not sell, distribute or lease your personal information to third parties unless we have your permission or are required by law to do so. We may use your personal information to send you promotional information about third parties which we think you may find interesting if you tell us that you wish this to happen.</div>\r\n	<div><br />\r\n		</div>\r\n	<div>You may request details of personal information which we hold about you under the Data Protection Act 1998. A small fee will be payable. If you would like a copy of the information held on you please write to [address].</div>\r\n	<div><br />\r\n		</div>\r\n	<div>If you believe that any information we are holding on you is incorrect or incomplete, please write to or email us as soon as possible, at the above address. We will promptly correct any information found to be incorrect.</div>\r\n	<div><br />\r\n		</div>\r\n	<div>&nbsp;</div></p>', 0, '', '', '', '', 0, 1, 'privacy policy'),
(29, 'Tools', 'tools', 'Tools', 0, '', 'Tools', 'Tools', 'Tools', 0, 1, 'Tools'),
(30, 'test page', 'test-page', 'test page', 0, '', 'test page', 'test pagetest page', 'test page', 1, 1, 'test page');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_configurations`
--

CREATE TABLE `tbl_configurations` (
  `conf_name` varchar(100) NOT NULL,
  `conf_val` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_configurations`
--

INSERT INTO `tbl_configurations` (`conf_name`, `conf_val`) VALUES
('conf_date_format_jquery', '%Y-%m-%d'),
('conf_date_format_mysql', '%Y-%m-%d'),
('conf_date_format_php', 'Y-m-d'),
('conf_emails_from', 'readydoctor@dummyid.com'),
('conf_admin_email_id', 'admin@dummyid.com'),
('conf_website_name', 'Ready Doctors'),
('conf_timezone', 'Asia/Kolkata'),
('CONF_FORM_REQUIRED_STAR_POSITION', 'after'),
('CONF_FORM_REQUIRED_STAR_WITH', 'caption'),
('CONF_DEFAULT_ADMIN_PAGING_SIZE', '10'),
('CONF_CONTACT_PHONE', '5435431'),
('CONF_WEBSITE_EMAIL', 'admin@dummyid.com'),
('CONF_DEFAULT_FRONT_PAGING_SIZE', '2'),
('conf_required_reply_approval', '1'),
('CONF_HOMEPAGE_YOUTUBE_LINK', 'https://www.youtube.com/watch?v=t67DFMa1a2M'),
('conf_question_approval', '1'),
('CONF_PAGE_1_CONTENT', '<p>Dear {user_name}</p>\n<p>&nbsp;</p>\n<p>Thank test for putting your interest in my medical services. i hope i was able to answer your medical questions.</p>\n<p>&nbsp;</p>\n<p>if you have any further questions, please ask my cell phone anytime at: &nbsp;{site_tel}</p>\n<p>&nbsp;</p>\n<p>{doctor_name}</p>\n<p>{website_url}</p>\n<p>Email: &nbsp;{doctor_email}</p>\n<p>Telephone: {site_tel}</p>'),
('conf_pdf_footer_text_line_1', 'www.readydoctor.com'),
('conf_pdf_footer_text_line_2', '4640 Admiraty way, Suite 500| marina del ray, CA 90292 USA| Tel 1-855-648-1613'),
('conf_pdf_footer_text_line_3', 'support@readydoctor.com'),
('conf_pdf_call_text', '<div style=\"left: 166.693px; top: 606.372px; font-size: 20px; font-family: sans-serif; transform: scaleX(1.00263);\" data-canvas-width=\"642.5200000000006\">If test have any query,please text me or call me any time.855-648-1613 -</div>\n<div style=\"left: 166.693px; top: 630.792px; font-size: 20px; font-family: sans-serif; transform: scaleX(1.00485);\" data-canvas-width=\"241.5\">support@readydoctor.com</div>\n<div style=\"left: 166.693px; top: 657.77px; font-size: 17.5px; font-family: sans-serif; transform: scaleX(1.00713);\" data-canvas-width=\"130.3225\">readydoctor.com</div>'),
('conf_doctor_name', 'Dr.Parker'),
('conf_website_copyright', 'Copyright Â© 2018'),
('CONF_IMAGE_MIME_ALLOWED', 'image/png\nimage/jpeg\nimage/gif\nimage/svg+xml\nimage/x-icon\nimage/svg'),
('CONF_CURR_PROD_UPLOAD_DIR', ''),
('CONF_LANGUAGE', 'en'),
('CONF_FRONT_LOGO', 'logopng_93'),
('CONF_ADMIN_LOGO', 'footerlogopng_22'),
('CONF_FOOTER_LOGO', 'footerlogopng_45'),
('CONF_RECAPTACHA_SITEKEY', '6LcY7hkUAAAAADTOHlEPkUgq7xX4Rd8696jCMGe2'),
('CONF_RECAPTACHA_SECRETKEY', '6LcY7hkUAAAAAHK4KXMAFtQ9xzI0BknB0OaFCZjb'),
('CONF_PAYPAL_BUSINESS_ACCOUNT_EMAIL', 'nishan_1297919061_biz@dummyid.com'),
('CONF_PAYPAL_MODE', '0'),
('CONF_CONTRIBUTION_FILE_UPLOAD_SIZE', '1024'),
('conf_terms_Page', '23');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_content_blocks`
--

CREATE TABLE `tbl_content_blocks` (
  `block_id` int(11) NOT NULL,
  `block_identifier` varchar(50) NOT NULL,
  `block_content` text NOT NULL,
  `block_active` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_content_blocks`
--

INSERT INTO `tbl_content_blocks` (`block_id`, `block_identifier`, `block_content`, `block_active`) VALUES
(2, 'Home_page_How_does_it_work', '<div class=\"span-md-12\">\r\n	<h5 class=\"heading-text text--center text--white\">hOW Does IT wORKS?</h5>\r\n	<h6 class=\"sub-heading-text text--center text--white\">Step1 - Step 2 - Step 3</h6></div>\r\n<div class=\"span-md-12 \">\r\n	<div class=\"steps__list clearfix\">\r\n		<div class=\"media steps__item span-md-4 span-sm-4 span-xs-12\">\r\n			<div class=\"media_icon steps__img\"><img src=\"../images/fixed/step-icon.svg\" alt=\"\" /></div>\r\n			<div class=\"media__body media--content steps__content\">\r\n				<h5 class=\"steps__title\">Choose Category</h5>\r\n				<p class=\"steps__text\">Sed ut perspiciatis unde omnis iste natus error sit voluptatem</p></div></div>\r\n		<div class=\"media steps__item span-md-4 span-sm-4 span-xs-12\">\r\n			<div class=\"media_icon steps__img\"><img src=\"../images/fixed/question-icon.svg\" alt=\"\" /></div>\r\n			<div class=\"media__body media--content steps__content\">\r\n				<h5 class=\"steps__title\">Ask Your Question</h5>\r\n				<p class=\"steps__text\">Sed ut perspiciatis unde omnis iste natus error sit voluptatem</p></div></div>\r\n		<div class=\"media steps__item span-md-4 span-sm-4 span-xs-12 noBorder\">\r\n			<div class=\"media_icon steps__img\"><img src=\"../images/fixed/capsule.svg\" alt=\"\" /></div>\r\n			<div class=\"media__body media--content steps__content\">\r\n				<h5 class=\"steps__title\">get health result</h5>\r\n				<p class=\"steps__text\">Sed ut perspiciatis unde omnis iste natus error sit voluptatem</p></div></div></div></div>', 1),
(5, 'QUESTION_POST_STEP2_RIGHT_BLOCK', '<div class=\"sidebar__forminfo\">\n	<div class=\"form__infoImg\"> <img src=\"/images/fixed/patientinfo.svg\" alt=\"\"> </div>\n	<h5>Paitent Information</h5>\n	<p>Fill out the form on the left\n	  and Please explain your medical history and symptoms with your required details </p>\n  </div>', 1),
(6, 'QUESTION_POST_STEP3_RIGHT_BLOCK', '<h2>Please select your <span>age &amp; gender</span></h2>', 1),
(7, 'QUESTION_POST_STEP4_RIGHT_BLOCK', '<h2>Please select from the <span>options below</span></h2>', 1),
(8, 'QUESTION_POST_STEP5_RIGHT_BLOCK', '<h2>The doctor is <span>reviewing</span> your health concern</h2>', 1),
(11, 'FOOTER_BOTTOM_BLOCK', '<p>Copyright &copy; 2016 ReadyDoctor. All rights reserved.</p>', 1),
(12, 'CLIENT_SLIDER', '<div class=\"clients__slider span-md-12\">\r\n<div class=\"span-md-7 span-sm-12 span-xs-12 span--center\">\r\n<ul class=\"slider--client js-slider--client\">\r\n<li>\r\n<div class=\"client__brand\"><img src=\"../images/dynamic/client-CNN.png\" alt=\"\" /></div>\r\n</li>\r\n<li>\r\n<div class=\"client__brand\"><img src=\"../images/dynamic/client-BBC.png\" alt=\"\" /></div>\r\n</li>\r\n<li>\r\n<div class=\"client__brand\"><img src=\"../images/dynamic/client-MSNBC.png\" alt=\"\" /></div>\r\n</li>\r\n<li>\r\n<div class=\"client__brand\"><img src=\"../images/dynamic/client-CBS.png\" alt=\"\" /></div>\r\n</li>\r\n<li>\r\n<div class=\"client__brand\"><img src=\"../images/dynamic/client-abcNEWS.png\" alt=\"\" /></div>\r\n</li>\r\n<li>\r\n<div class=\"client__brand\"><img src=\"../images/dynamic/client-CNN.png\" alt=\"\" /></div>\r\n</li>\r\n<li>\r\n<div class=\"client__brand\"><img src=\"../images/dynamic/client-BBC.png\" alt=\"\" /></div>\r\n</li>\r\n<li>\r\n<div class=\"client__brand\"><img src=\"../images/dynamic/client-MSNBC.png\" alt=\"\" /></div>\r\n</li>\r\n<li>\r\n<div class=\"client__brand\"><img src=\"../images/dynamic/client-CBS.png\" alt=\"\" /></div>\r\n</li>\r\n<li>\r\n<div class=\"client__brand\"><img src=\"../images/dynamic/client-abcNEWS.png\" alt=\"\" /></div>\r\n</li>\r\n</ul>\r\n</div>\r\n</div>', 1),
(13, 'WHY_GET_MEDZ', '<div class=\"span-md-7 span-sm-6 span-xs-12\">\r\n	<div class=\"cta__box cta__vertical\">\r\n		<div class=\"cta__content\">\r\n			<h5 class=\"cta__title\">Why Getmedz?</h5>\r\n			<div class=\"cta__description\">\r\n				<p>&nbsp;</p>\r\n				<p>Develop new markets and find new patients TODAY â€“ easy and accessible wherever you are.You can join as a doctor to provide answers to questions online or offer online video consultations. Or as a hospital/clinic to offer your services</p>\r\n				<p>&nbsp;</p></div></div></div></div>', 1),
(14, 'Getmedz_features', '<div class=\"section\">\r\n	<div class=\"container\">\r\n		<div class=\"getmeds-features\">\r\n			<div class=\"span-row\">\r\n				<div class=\"span-md-3 span-sm-6 span-xs-12\">\r\n					<div class=\"getmed__features\">                      \r\n						<div class=\"getmed__features__Media\"><img src=\"/images/fixed/satisfaction.svg\" alt=\"\" /></div>\r\n						<h5>100% Satisfaction</h5>\r\n						<p>Millions have asked questions with their satisfaction guaranteed.</p></div></div>\r\n				<div class=\"span-md-3 span-sm-6 span-xs-12\">\r\n					<div class=\"getmed__features\">                      \r\n						<div class=\"getmed__features__Media\"><img src=\"/images/fixed/certifieddocs.svg\" alt=\"\" /></div>\r\n						<h5>Certified Doctors</h5>\r\n						<p>Getmedz provide you best qualified and certified doctors team.</p></div></div>\r\n				<div class=\"span-md-3 span-sm-6 span-xs-12\">\r\n					<div class=\"getmed__features\">                      \r\n						<div class=\"getmed__features__Media\"><img src=\"/images/fixed/convinience.svg\" alt=\"\" /></div>\r\n						<h5>Convenience</h5>\r\n						<p>Enjoy a fast and easy way to ask Experts anywhere you are online.</p></div></div>\r\n				<div class=\"span-md-3 span-sm-6 span-xs-12\">\r\n					<div class=\"getmed__features\">                      \r\n						<div class=\"getmed__features__Media\"><img src=\"/images/fixed/bestsupport.svg\" alt=\"\" /></div>\r\n						<h5>Convenience</h5>\r\n						<p>Comprehensive Support through our dedicated team which save money &amp; time</p></div></div></div></div></div></div>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_countries`
--

CREATE TABLE `tbl_countries` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(100) NOT NULL,
  `country_deleted` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_countries`
--

INSERT INTO `tbl_countries` (`country_id`, `country_name`, `country_deleted`) VALUES
(1, 'India', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_degrees`
--

CREATE TABLE `tbl_degrees` (
  `degree_id` int(11) NOT NULL,
  `degree_name` varchar(100) NOT NULL,
  `degree_active` tinyint(4) NOT NULL,
  `degree_deleted` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_degrees`
--

INSERT INTO `tbl_degrees` (`degree_id`, `degree_name`, `degree_active`, `degree_deleted`) VALUES
(1, 'BDS', 1, 0),
(2, 'MBBS', 1, 1),
(3, 'MS', 1, 0),
(4, 'BAMS', 0, 1),
(5, 'MD', 0, 1),
(6, 'MBA', 1, 1),
(8, 'VZDF', 1, 1),
(9, 'FDSEDF', 1, 1),
(10, 'Buffy Hortons', 1, 1),
(11, 'MBS', 0, 0),
(12, 'FGBF', 1, 1),
(13, 'GBSDFGSDAF', 1, 1),
(14, 'testtes', 0, 1),
(15, 'cardiologist', 0, 1),
(16, 'test', 1, 1),
(17, 'ghdfhg', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_doctors`
--

CREATE TABLE `tbl_doctors` (
  `doctor_id` int(11) NOT NULL,
  `doctor_first_name` varchar(255) NOT NULL,
  `doctor_last_name` varchar(255) NOT NULL,
  `doctor_email` varchar(255) NOT NULL,
  `doctor_med_school` varchar(255) NOT NULL,
  `doctor_med_category` int(11) NOT NULL,
  `doctor_med_degree` int(11) NOT NULL,
  `doctor_med_year` int(11) NOT NULL,
  `doctor_licence_no` varchar(255) NOT NULL,
  `doctor_allow_licence_over_phone` tinyint(4) NOT NULL,
  `doctor_active` tinyint(4) NOT NULL,
  `doctor_deleted` tinyint(4) NOT NULL,
  `doctor_med_state_id` int(11) NOT NULL,
  `doctor_reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `doctor_password` varchar(100) NOT NULL,
  `doctor_site_marker` varchar(100) NOT NULL,
  `doctor_address` varchar(255) NOT NULL,
  `doctor_city` varchar(100) NOT NULL,
  `doctor_state_id` int(11) NOT NULL,
  `doctor_house_no` varchar(100) NOT NULL,
  `doctor_phone_no` varchar(50) NOT NULL,
  `doctor_pincode` varchar(10) NOT NULL,
  `doctor_summary` varchar(255) NOT NULL,
  `doctor_last_activity` datetime NOT NULL,
  `doctor_is_online` tinyint(1) NOT NULL,
  `doctor_experience` decimal(10,1) NOT NULL,
  `doctor_experience_summary` text NOT NULL,
  `doctor_gender` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_doctors`
--

INSERT INTO `tbl_doctors` (`doctor_id`, `doctor_first_name`, `doctor_last_name`, `doctor_email`, `doctor_med_school`, `doctor_med_category`, `doctor_med_degree`, `doctor_med_year`, `doctor_licence_no`, `doctor_allow_licence_over_phone`, `doctor_active`, `doctor_deleted`, `doctor_med_state_id`, `doctor_reg_date`, `doctor_password`, `doctor_site_marker`, `doctor_address`, `doctor_city`, `doctor_state_id`, `doctor_house_no`, `doctor_phone_no`, `doctor_pincode`, `doctor_summary`, `doctor_last_activity`, `doctor_is_online`, `doctor_experience`, `doctor_experience_summary`, `doctor_gender`) VALUES
(3, 'abhis', 'Kash', 'doctor@dummyid.com', 'ak47.still.rocks', 1, 1, 1902, '345235', 0, 1, 0, 10, '2015-08-04 10:27:08', '', '', 'Admont street', 'Chicago', 5, '345', '988880909999', '35234', 'MBBS, MD, MS', '2017-11-14 09:19:51', 0, '2.0', 'dsadasdasdsa', 1),
(4, 'John', 'Cello', 'John@dummyid.com.com', 'ak47.still.rocks', 1, 1, 2011, 'e543535', 0, 1, 0, 10, '2015-08-04 12:55:31', '37075f4b1453af87de66d71a628f0973', '', '23323', '2323', 10, '32323', '344344', '5435435', 'MBBS, Ms, MD', '2017-11-10 18:36:38', 1, '1.0', 'qualified', 1),
(5, 'rahul', 'kumar', 'rahul@dummyid.com', 'ak47.still.rocks', 2, 1, 1977, 'AK-34543657', 0, 1, 1, 10, '2015-08-04 13:05:57', '', '', '445 , Eastern Area', 'Bhangarh', 10, '32323', '891674858', '46667', 'BDS', '0000-00-00 00:00:00', 0, '1981.0', 'Profession Experience of 6 years in BDS', 1),
(9, 'Akshay', 'Tripathi', 'akshay@dummyid.com', 'jnu', 1, 2, 1982, '198763524', 0, 1, 0, 11, '2015-09-01 07:48:49', '1af00814a264d77fedd879532d6d4be3', '', 'bahr valley', 'Delhi', 5, '12547', '098734653543', '897432', 'When he is alone in his study, Faustus begins experimenting with magical incantations, and suddenly Mephistophilis appears, in the form of an ugly devil. Faustus sends him away, telling him to reappear in the form of a friar. Faustus discovers that it is', '2017-10-24 19:39:52', 1, '0.0', '2', 0),
(10, 'Ronan', 'Campos', 'nesaho@dummyid.com', 'Consectetur ad sit vero doloremque at dicta eligendi nisi quam impedit porro inventore in et', 1, 3, 2007, 'Consectetur animi proident reprehenderit rerum voluptates veniam reiciendis aliquam', 0, 0, 1, 2, '2015-09-03 06:26:22', '6e0a7c0073ddf0eef9962b9d6a0e83f2', '', 'Nostrum voluptatibus odit dolor nostrum laboriosam numquam aut amet fugiat culpa animi duis', 'Culpa tempora itaque dolor vel soluta sint saepe maiores reprehenderit sunt', 4, '234', '4234345345', '4324', '', '0000-00-00 00:00:00', 0, '0.0', '', 0),
(11, 'Kimberly', 'Fitzgerald', 'didogapa@dummyid.com', 'Laudantium et fugiat et velit quos enim qui voluptatem Ea quam labore ut et qui ullam esse', 8, 2, 1989, 'Magnam velit incidunt in rem vel esse velit Nam fuga Sequi tempore illo quam dolore ut', 0, 0, 1, 2, '2015-09-03 06:28:17', '6ac7cc0f90630aebbaaadda075554f31', '', 'Aliquid elit deserunt sed lorem do quo officiis aut veniam ullam saepe doloremque harum at labore', 'Ex qui quia facilis consequatur amet nostrum omnis doloribus corporis eiusmod', 3, '12', '213213321321', '12', 'Voluptatem. Officia velit rerum rerum quibusdam nihil odit cupidatat voluptate esse anim ipsum.', '0000-00-00 00:00:00', 0, '0.0', '', 0),
(12, 'Yardley', 'Blankenship', 'dohegus@dummyid.com', 'Quia iure tenetur ipsa qui quibusdam nesciunt ullam occaecat perferendis', 7, 1, 2006, 'Et numquam sint occaecat officia est deleniti voluptas reiciendis in omnis et omnis nulla aliqua Et vel', 0, 1, 1, 4, '2015-09-03 06:30:11', 'd419d313b8d4ee6f541e7c410b55c282', '', 'In incididunt consequatur Est unde consequatur doloribus in', '1232', 2, '1232132132', '123123', '1212313', 'Distinctio. Quidem ut voluptate explicabo. Esse tempore, alias alias cumque ut consectetur consequat. Nisi accusantium culpa, quos.', '0000-00-00 00:00:00', 0, '0.0', '', 0),
(13, 'India', 'Palmer', 'fajobyqo@dummyid.com', 'Esse asperiores ad aliquip soluta tempore accusamus sunt et laboris sit sed ut facilis excepturi adipisci', 5, 2, 1982, 'Aut sapiente quasi libero anim eum enim autem dolores soluta harum adipisicing sunt ut', 0, 1, 1, 2, '2015-09-03 06:31:12', 'd7670c02e67b576f3a92dbb7eabbc966', '', 'Velit harum nesciunt cillum eos officia impedit eius dolorem debitis ipsam distinctio Perspiciatis dolore aliqua Exercitationem dignissimos molestias at', 'Ipsum quia voluptas labore laboriosam aliquid eos rerum laboriosam amet', 3, '12345', '121433213', '13244', 'Quasi rerum inventore cum architecto ex sint nihil nostrud incidunt, et in harum cum totam quis.', '0000-00-00 00:00:00', 0, '0.0', '', 0),
(14, 'Audrey', 'Levine', 'hoxyd@dummyid.com', 'Nulla aut nulla quo culpa deleniti officia fugiat in in et dolorum voluptas consequat Alias nisi numquam irure impedit', 12, 3, 1979, 'Hic tempor rem est dolores', 0, 1, 1, 2, '2015-09-03 06:32:18', '81a804c22ac61cdaf13b6821cd5a9ab7', '', 'Fuga At eius dolorum officia nostrum dolor dolorem officia omnis nostrud fuga Laborum quos officia sint commodo sit fugiat expedita', 'Et exercitationem aut dolore ut vel', 2, '1123123', '23123213213', '113123', 'Dolorem rerum dolorem temporibus ipsum quo labore illum, eius molestiae quisquam numquam itaque reprehenderit, ea illum, ut sint, est, dolorum.', '0000-00-00 00:00:00', 0, '0.0', '', 0),
(15, 'Herrod', 'Wood', 'quwotebody@dummyid.com', 'Voluptas error et qui quis a tempora cupiditate natus', 12, 3, 1971, 'Quis commodo aliquid laboriosam reprehenderit reprehenderit facere', 0, 0, 1, 3, '2015-09-03 06:33:00', '9ace98e546a78b290afafb92f72e13ce', '', 'Et laudantium non omnis non officia pariatur', 'Ut amet ducimus sit aute nobis rem unde tempore eveniet ad fugiat perspiciatis neque', 3, '12313213', '324423432', '54345435', 'Praesentium enim sit in doloremque sint in ipsa, ut recusandae. Officiis fugit, aliquam nostrum sint, consequat.', '0000-00-00 00:00:00', 0, '0.0', '', 0),
(16, 'Akshay', 'Apte', 'a1@dummyid.com', 'yes', 8, 1, 2000, '4`234234324', 0, 1, 1, 2, '2015-09-10 13:05:06', '37075f4b1453af87de66d71a628f0973', '', 'hgsgfghhhhhhsfg', 'Chandigarh', 2, '34', '41234321324324', '17410', 'yes I have', '2015-10-12 14:02:29', 1, '0.0', '', 0),
(19, 'Pooja', 'kathpal', 'pooja@dummyid.com', 'DAV', 1, 3, 1902, 'LA3543656', 0, 1, 0, 5, '2015-09-11 06:39:21', '37075f4b1453af87de66d71a628f0973', '', '55353543', 'JBD', 10, '5452', '123334', '54654756', 'MBBS', '2017-11-14 11:35:00', 1, '1.5', 'dd', 2),
(20, 'dimbu', 'borguese', 'dimbu@dummyid.com', 'abc', 9, 2, 1919, '245', 0, 1, 1, 3, '2015-09-11 06:42:11', '37075f4b1453af87de66d71a628f0973', '', 'dim,bbbbbbbbbbbbbbbbbu', 'dfgdfgdfg', 3, '23', '432534534534', '3453', 'yes', '2015-09-11 12:17:02', 0, '0.0', '', 0),
(21, 'Robert', 'bruce', 'robert@dummyid.com', 'bdm', 2, 1, 1931, '4312', 0, 1, 1, 3, '2015-09-11 06:46:14', '', '', 'yes', '153425324', 5, '15345', '451234323', '41234', 'yes', '2015-09-11 12:30:27', 0, '0.0', '', 0),
(22, 'rampal', 'raghu', 'Raghu@dummyid.com', 'bds', 2, 2, 1982, '21312312', 0, 0, 1, 2, '2015-09-11 06:54:07', '37075f4b1453af87de66d71a628f0973', '', 'rtsyerter', 'delllllllllllllllllllll', 2, '123', '1321435436454', '12345', 'tre', '0000-00-00 00:00:00', 0, '0.0', '', 0),
(23, 'pehel faredein', 'faredein', 'pahel@dummyid.com', 'sdacfs', 5, 1, 1902, '231', 0, 1, 1, 2, '2015-09-11 10:40:59', '37075f4b1453af87de66d71a628f0973', '', 'fj', 'dfhfgdf', 3, '256', '5463245', '23454', 'dfhng', '0000-00-00 00:00:00', 0, '0.0', '', 0),
(24, 'Kapil', 'sibbal', 'kapil@dummyid.com', 'test', 9, 2, 1904, '9837467878', 0, 1, 1, 3, '2015-09-15 06:44:31', '', '', 'chandigarh', 'chandigarh', 3, '12', '25345345', '343552435', 'hello hii', '0000-00-00 00:00:00', 0, '0.0', '', 0),
(25, 'tomar', 'gdfgdfg', 'tomar@dummyid.com', 'dsfcsd', 2, 1, 1906, '45234534', 0, 1, 1, 3, '2015-09-15 12:50:57', '', '', 'fgserger', 'sfghb', 2, '32421', '241235235345', '4353453452', 'fsd', '0000-00-00 00:00:00', 0, '0.0', '', 0),
(26, 'Tashya', 'Nunez', 'fybohy@dummyid.com', 'In ut consectetur eu eum qui quia sunt irure', 22, 1, 2005, 'Quo assumenda culpa optio dolore deleniti in amet adipisci qui est quaerat itaque non', 0, 1, 1, 5, '2015-10-19 11:00:30', '37075f4b1453af87de66d71a628f0973', '', 'Ea mollitia consectetur corporis dolorem officia nulla quidem consequuntur qui', '4234', 5, '324234', '2311232132', '3423', 'Temporibus aliquip ut do sit quis Nam quas ex mollitia soluta culpa.', '0000-00-00 00:00:00', 0, '0.0', '', 0),
(33, 'Ainsley', 'Gilliam', 'nosinalof@dummyid.com', 'Ducimus est reprehenderit non magnam perspiciatis', 10, 1, 2005, 'Qui cupiditate occaecat harum vel non ut magni quod aut', 0, 1, 1, 5, '2015-10-19 11:06:04', '', '', 'Velit quia mollit pariatur Similique exercitationem', 'Sint maxime facilis dolores aut vitae voluptates libero blanditiis ut deserunt corporis proident vol', 5, '3452343', '3243212308', '3525343', 'Est nisi minim dolor nobis quo in quia et soluta facilis enim architecto.', '0000-00-00 00:00:00', 0, '0.0', '', 0),
(34, 'doctor211', 'tripa5hiu', 'a3@dummyid.com', 'bndv', 7, 3, 1950, '1534253453451', 0, 1, 1, 5, '2015-10-27 15:13:03', '37075f4b1453af87de66d71a628f0973', '', 'sdfasd', 'dedfmlfasd', 10, '123', '412342354356', '4325345', 'testtest', '2017-03-20 13:55:39', 0, '0.0', '', 0),
(35, 'navdeep', 'singh', 'navdeep@dummyid.com', 'GNI', 7, 3, 1918, '3455', 0, 1, 1, 10, '2015-11-04 06:38:15', '1af00814a264d77fedd879532d6d4be3', '', 'sdfbgfh', 'craigiburn', 10, '343', '34345', '333', 'i have done dgree from austrailia`', '2015-11-17 14:49:30', 1, '0.0', '', 0),
(36, 'navi', 'singhj', 'navi@dummyid.com', 'GNI', 4, 3, 1906, '4553535', 0, 1, 1, 11, '2015-11-05 04:50:25', '', '', '435343543', 'rt', 5, '4545', '23456', '45545', 'I have done this', '2015-11-05 03:21:16', 0, '0.0', '', 0),
(37, 'Roohi', 'Sharma', 'roohisharma@dummyid.com', 'BDS School', 7, 1, 1988, '456457565467547', 0, 1, 1, 11, '2015-11-07 08:25:39', '1af00814a264d77fedd879532d6d4be3', '', '57 ground floor', 'mohali', 11, '345', '64657657578', '454365', 'MBBS ', '2015-11-10 13:38:17', 1, '0.0', '', 0),
(38, 'zdfxdg', 'gfg', 'fgdfgfd@dummyid.com', 'fgg', 5, 1, 1904, '45345345', 0, 1, 1, 10, '2015-11-09 10:55:12', '1af00814a264d77fedd879532d6d4be3', '', 'dfff', 'fdsfds', 5, '634656', '12345', '5465', 'gfdfg', '0000-00-00 00:00:00', 0, '0.0', '', 0),
(39, 'Sia', 'Mirza', 'mirza@dummyid.com', 'misc', 5, 1, 2007, '329456456456', 0, 1, 1, 10, '2015-11-16 09:13:02', '1af00814a264d77fedd879532d6d4be3', '', 'Cannot remove adhesive bandages, from my chest-like the bandages have...', 'jalandhar', 10, '456', '9463569852', '12358', 'Cannot remove adhesive bandages, from my chest-like the bandages have...', '2015-11-18 12:35:39', 1, '0.0', '', 0),
(40, 'test', 'test', 'test@dummyid.com', 'ddsds', 1, 1, 2005, '2323', 0, 1, 1, 28, '2017-02-09 07:28:57', '', '', 'ddsds', 'karnal', 28, '343', '23232232', '1111', 'sdsdsd', '0000-00-00 00:00:00', 0, '0.0', '', 0),
(41, 'test', 'test', 'testdoctor@dummyid.com', 'Lorem ipsum', 1, 2, 2005, '1', 0, 1, 1, 10, '2017-03-24 13:46:06', '', '', 'Lorem ipsum', 'chandigargh', 10, '234', '1234567890', '123344', 'Lorem ipsum', '2017-03-27 11:35:53', 1, '2.0', 'Lorem ipsum', 1),
(42, 'xcx', 'xx', 'cxz@sds.com', 'we', 1, 1, 1904, '323', 0, 0, 1, 11, '2017-04-14 05:32:14', '37075f4b1453af87de66d71a628f0973', '', 'dff', '323sds', 5, '32', '3232', '323', 'ew', '0000-00-00 00:00:00', 0, '12.0', 'wew', 0),
(43, 'gurpreet', 'kaur', 'gurpreet@dummyid.com', 'Lala ishar medical college', 7, 2, 1988, 'LV_353465', 0, 0, 1, 5, '2017-10-12 09:58:44', '', '', '#45,Phase 6', 'MOhali', 10, '56', '54643765', '4365', 'BDMS\r\nMS', '0000-00-00 00:00:00', 0, '2.0', '5 year experience in cardio', 1),
(44, 'Manveer', 'Doctor', 'manvdoc@dummyid.com', 'DAV College', 1, 3, 1999, '123123123', 0, 1, 0, 10, '2017-12-08 07:21:10', 'd32109d8218ec2b532168b5efa412356', '', '43-Officer Enclave', 'Chandigarh', 10, '43', '8968400434', '154213', 'Test', '0000-00-00 00:00:00', 1, '5.0', 'Test', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_doctor_degrees`
--

CREATE TABLE `tbl_doctor_degrees` (
  `docdegree_id` int(11) NOT NULL,
  `docdegree_doctor_id` int(11) NOT NULL,
  `docdegree_degree_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_doctor_reviews`
--

CREATE TABLE `tbl_doctor_reviews` (
  `review_id` int(11) NOT NULL,
  `review_doctor_id` int(11) NOT NULL,
  `review_user_id` int(11) NOT NULL,
  `review_question_id` varchar(15) NOT NULL,
  `review_text` text NOT NULL,
  `review_rating` int(11) NOT NULL,
  `review_posted_on` datetime NOT NULL,
  `review_active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_doctor_reviews`
--

INSERT INTO `tbl_doctor_reviews` (`review_id`, `review_doctor_id`, `review_user_id`, `review_question_id`, `review_text`, `review_rating`, `review_posted_on`, `review_active`) VALUES
(7, 3, 1, 'AD1441004901990', 'test my review1', 4, '2015-08-24 13:47:08', 1),
(8, 3, 3, 'AD1441088530626', 'I am satisfied with Doctor\'s answer', 1, '2015-09-03 11:03:56', 1),
(9, 3, 2, 'AD1441004935477', 'dsdsa', 1, '2015-09-10 13:04:33', 1),
(10, 3, 2, 'AD1441275924884', 'fdsfdsffsf', 5, '2015-09-10 16:42:30', 1),
(11, 16, 40, 'AD1441889006601', 'hiiiiiiiiiiiiiiiiii', 1, '2015-09-11 11:03:28', 1),
(14, 16, 40, 'AD1441865253332', 'xxzfzxfsa', 5, '2015-09-11 18:11:18', 1),
(17, 16, 40, 'AD144197509725', 'yuo', 4, '2015-09-11 18:21:23', 1),
(21, 3, 33, 'AD1441871558599', 'xcgdx', 1, '2015-09-14 15:30:48', 1),
(22, 3, 2, 'AD1441975755941', 'Testing dea22', 1, '2015-09-14 15:44:13', 1),
(27, 3, 40, 'AD1441964541269', 'Does spending time in the sun pose a threat to our eyes? What can we do to protect ourselves?DEAR READER: Yes, it does. And to a large extent, the damage may already be done. I spoke to Dr. Louis Pasquale, an ophthalmologist at Harvard-affiliated Massachusetts Eye and Ear Infirmary. He noted that spending a lot of time in the sun without sunglasses when you\'re young may put you at risk for developing eye problems when you\'re older. The damage would probably be done in your 20s and 30s.Read more Â»TOPICSDoes spending time in the sun pose a threat to our eyes? What can we do to protect ourselves?DEAR READER: Yes, it does. And to a large extent, the damage may already be done. I spoke to Dr. Louis Pasquale, an ophthalmologist at Harvard-affiliated Massachusetts Eye and Ear Infirmary. He noted that spending a lot of time in the sun without sunglasses when you\'re young may put you at risk for developing eye problems when you\'re older. The damage would probably be done in your 20s and 30s.Read more Â»TOPICSDoes spending time in the sun pose a threat to our eyes? What can we do to protect ourselves?DEAR READER: Yes, it does. And to a large extent, the damage may already be done. I spoke to Dr. Louis Pasquale, an ophthalmologist at Harvard-affiliated Massachusetts Eye and Ear Infirmary. He noted that spending a lot of time in the sun without sunglasses when you\'re young may put you at risk for developing eye problems when you\'re older. The damage would probably be done in your 20s and 30s.Read more Â»TOPICS', 4, '2015-09-16 17:49:27', 1),
(29, 16, 40, 'AD144230848731', 'gsdf', 1, '2015-09-17 18:30:24', 1),
(30, 9, 114, 'AD1446043461575', 'tyrtuyru', 4, '0000-00-00 00:00:00', 1),
(31, 34, 114, 'AD1446032009253', 'hiiiii.....okie very good', 5, '0000-00-00 00:00:00', 1),
(32, 3, 40, 'AD1442308855610', 'good job', 5, '0000-00-00 00:00:00', 1),
(33, 35, 135, 'AD1446624215467', 'SDFASDFSFSFFFFFFFFFFFFFFF  SDSDSDSDSDSDSDSD SDFFFFF SDRFDS SDFFFFFFF  SDFFFFFFFF SDFFFFF DSF SDFSDFSDFSDF SDFSDF SDFSDFSDFSDFSDFSDFSDF SDFFSD FSDFSDF SDFSD SDF SDF SDFDS', 1, '0000-00-00 00:00:00', 1),
(46, 35, 135, 'AD1446616105855', 'jhgf', 5, '0000-00-00 00:00:00', 1),
(50, 36, 135, 'AD1446624786846', 'zdds', 5, '0000-00-00 00:00:00', 1),
(51, 35, 135, 'AD1446724399840', 't dfbsfdfgdg', 5, '0000-00-00 00:00:00', 1),
(54, 37, 148, 'AD1446884377185', 'uyrtuyt', 4, '0000-00-00 00:00:00', 1),
(86, 35, 148, 'AD1447064454907', 'very nice doctor', 3, '0000-00-00 00:00:00', 1),
(87, 37, 148, 'AD1447132426712', 'sdasfsdfs', 3, '0000-00-00 00:00:00', 1),
(88, 39, 158, 'AD1447680742508', ' bfghbfcv gfn v fgnb ', 4, '0000-00-00 00:00:00', 1),
(89, 19, 207, 'AD14980440243', 'fg', 3, '2017-06-23 15:26:01', 1),
(90, 4, 207, 'AD1492062344719', 'test', 2, '2017-06-23 15:27:05', 1),
(91, 3, 207, 'AD1498480879450', 'TEST', 5, '2017-06-26 18:14:37', 1),
(92, 3, 207, 'AD1498482753182', 'sdf', 4, '2017-06-26 18:46:48', 1),
(93, 4, 207, 'AD1498561845987', 'sad', 5, '2017-06-30 18:46:29', 1),
(94, 19, 1, 'AD1510634789194', 'Thank you for reply', 4, '2017-11-15 11:54:26', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_email_templates`
--

CREATE TABLE `tbl_email_templates` (
  `tpl_id` int(10) UNSIGNED NOT NULL,
  `tpl_code` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tpl_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tpl_subject` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tpl_body` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tpl_replacements` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tpl_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_email_templates`
--

INSERT INTO `tbl_email_templates` (`tpl_id`, `tpl_code`, `tpl_name`, `tpl_subject`, `tpl_body`, `tpl_replacements`, `tpl_status`) VALUES
(1, 'default_email', 'Default Email Template', '{title}', '<table width=\"650\" cellspacing=\"0\" cellpadding=\"10\" border=\"0\" bgcolor=\"FFFFFF\" style=\"border:1px solid #e0e0e0;margin:0 auto; font-family:arial;\">\n  <tbody>\n    <tr>\n      <td valign=\"top\"><h1 style=\"font-size:22px;font-weight:normal;line-height:22px;margin:0 0 12px 0; text-transform:capitalize;\">Dear {user_name},</h1>\n	   <p style=\"font-size: 13px; line-height: 18px; margin:0px;\">{message} <br></p>\n    </tr>\n	                   \n    <tr>\n      <td><p style=\"font-size: 13px; line-height: 18px; margin: 0px 0 0px;\">Best wishes,<br>\n          {website_name} Team </p>\n        <a target=\"_blank\" href=\"\"> <img border=\"0\" style=\"margin-bottom:10px\" alt=\"Logo\" src=\"{website_url}/public/images/logo.png\" class=\"CToWUd\"></a></td>\n    </tr>\n    <tr>\n      <td bgcolor=\"#EAEAEA\" align=\"center\" style=\"background:#eaeaea;text-align:center\"><p style=\"font-size:10px;margin:0; line-height:15px;\">This email and any files transmitted with it are confidential and intended solely for the use of the individual or entity to whom they are addressed. If you have received this email in error please notify the system manager. This message contains confidential information and is intended only for the individual named. If you are not the named addressee you should not disseminate, distribute or copy this e-mail. Please notify the sender immediately by e-mail if you have received this e-mail by mistake and delete this e-mail from your system. If you are not the intended recipient you are notified that disclosing, copying, distributing or taking any action in reliance on the contents of this information is strictly prohibited.</p></td>\n    </tr>\n  </tbody>\n</table>', '{website_name} Name of our website<br>\n{message} Message<br>\n{title} Message Title<br>\n{user_name} Username<br>\n{website_url} Website url', 0),
(2, 'forgot_password', 'Forgot Password Verification Email', '{website_name} Reset Profile Password', '<table width=\"650\" cellspacing=\"0\" cellpadding=\"10\" border=\"0\" bgcolor=\"FFFFFF\" style=\"border:1px solid #e0e0e0;margin:0 auto; font-family:arial;\">\n  <tbody>\n    <tr>\n      <td valign=\"top\"><h1 style=\"font-size:22px;font-weight:normal;line-height:22px;margin:0 0 12px 0; text-transform:capitalize;\">Dear {user_name},</h1>\n	  \n    </tr>\n	                    <tr>\n                        <td style=\"vertical-align: bottom; text-align: center;\">\n                        <p style=\"font-size: 14px; font-weight: bold; margin: 0px;\">Please click on below link to reset your account password created at {website_name}.</p>\n                        <p style=\" font-size: 13px; margin: 4px 0px;\">If you\'ve received this mail in error, it\'s likely that another user entered your email address by mistake while trying to reset a password. If you didn\'t initiate the request, you don\'t need to take any further action and can safely disregard this email.</p>\n                       \n                        <a style=\"font-size: 14px;margin:20px 0; color:#fff; text-decoration: none; border: 2px solid; border-radius: 3px; display: inline-block; padding: 0px 20px; height: 35px; line-height: 35px; background:#000;\" href=\"{reset_url}\">Click here to reset your account password</a></td>\n                    </tr>\n    <tr>\n      <td><p style=\"font-size: 13px; line-height: 18px; margin: 0px 0 0px;\">Best wishes,<br>\n          {website_name} Team </p>\n        <a target=\"_blank\" href=\"\"> <img border=\"0\" style=\"margin-bottom:10px\" alt=\"Logo\" src=\"{website_url}/public/images/logo.png\" class=\"CToWUd\"></a></td>\n    </tr>\n    <tr>\n      <td bgcolor=\"#EAEAEA\" align=\"center\" style=\"background:#eaeaea;text-align:center\"><p style=\"font-size:10px;margin:0; line-height:15px;\">This email and any files transmitted with it are confidential and intended solely for the use of the individual or entity to whom they are addressed. If you have received this email in error please notify the system manager. This message contains confidential information and is intended only for the individual named. If you are not the named addressee you should not disseminate, distribute or copy this e-mail. Please notify the sender immediately by e-mail if you have received this e-mail by mistake and delete this e-mail from your system. If you are not the intended recipient you are notified that disclosing, copying, distributing or taking any action in reliance on the contents of this information is strictly prohibited.</p></td>\n    </tr>\n  </tbody>\n</table>', '{website_name} Name of our website<br>\n{website_url} Url of our website<br>\n{user_name} Username<br>\n', 0),
(4, 'contact_email', 'Contact Us Email', 'Contact Us', '<table width=\"650\" cellspacing=\"0\" cellpadding=\"10\" border=\"0\" bgcolor=\"FFFFFF\" style=\"border:1px solid #e0e0e0;margin:0 auto; font-family:arial;\">\n  <tbody>\n         \n                           <tr>\n      <td valign=\"top\"><h1 style=\"font-size:22px;font-weight:normal;line-height:22px;margin:0 0 12px 0; text-transform:capitalize;\">Dear Admin,</h1>\n        <p style=\"font-size: 13px; line-height: 18px; margin: 15px 0 20px;\">A user has contacted {website_name}.</p>\n        <p style=\"border:1px solid #e0e0e0;font-size:13px;line-height:20px;margin:0;padding:13px 18px;background:#f9f9f9\"> \n          <b>Name</b>:{user_full_name} <br>\n          <b>Email</b> :<a target=\"_blank\" href=\"mailto:{user_email}\" style=\"color:#f0a218; text-decoration:none\">{user_email}</a><br>\n		  <b>Phone</b>:{user_phone} <br>\n			  <b>Message</b>:{user_message} <br>	  \n		  </p></td>\n    </tr>\n    <tr>\n      <td><p style=\"font-size: 13px; line-height: 18px; margin: 0px 0 0px;\">Best wishes,<br>\n          {website_name} Team </p>\n        <a target=\"_blank\" href=\"\"> <img border=\"0\" style=\"margin-bottom:10px\" alt=\"Logo\" src=\"{website_url}/public/images/logo.png\" class=\"CToWUd\"></a></td>\n    </tr>\n    <tr>\n      <td bgcolor=\"#EAEAEA\" align=\"center\" style=\"background:#eaeaea;text-align:center\"><p style=\"font-size:10px;margin:0; line-height:15px;\">This email and any files transmitted with it are confidential and intended solely for the use of the individual or entity to whom they are addressed. If you have received this email in error please notify the system manager. This message contains confidential information and is intended only for the individual named. If you are not the named addressee you should not disseminate, distribute or copy this e-mail. Please notify the sender immediately by e-mail if you have received this e-mail by mistake and delete this e-mail from your system. If you are not the intended recipient you are notified that disclosing, copying, distributing or taking any action in reliance on the contents of this information is strictly prohibited.</p></td>\n    </tr>\n  </tbody>\n</table>', '{website_name} Name of our website<br>\n{user_email} Contact Us Email<br>\n{user_full_name} Name of the user to whom this email is being sent\n{user_phone} Contact Us Phone<br>\n{user_message} Contact Us Message<br>\n{website_url} Website Url<br>\n', 0),
(5, 'question_close', 'Question Closed', 'Question closed ', '<table width=\"650\" cellspacing=\"0\" cellpadding=\"10\" border=\"0\" bgcolor=\"FFFFFF\" style=\"border:1px solid #e0e0e0;margin:0 auto; font-family:arial;\">\n  <tbody>\n    <tr>\n      <td valign=\"top\"><h1 style=\"font-size:22px;font-weight:normal;line-height:22px;margin:0 0 12px 0; text-transform:capitalize;\">Dear {user_name},</h1>\n	\n	   \n	   <p style=\"border:1px solid #e0e0e0;font-size:13px;line-height:20px;margin:0;padding:13px 18px;background:#f9f9f9\"> <strong>Following question is closed </strong><br>\n         {question_txt}</p>\n    </tr>\n	                   \n    <tr>\n      <td><p style=\"font-size: 13px; line-height: 18px; margin: 0px 0 0px;\">Best wishes,<br>\n          {website_name} Team </p>\n        <a target=\"_blank\" href=\"\"> <img border=\"0\" style=\"margin-bottom:10px\" alt=\"Logo\" src=\"{website_url}/public/images/logo.png\" class=\"CToWUd\"></a></td>\n    </tr>\n    <tr>\n      <td bgcolor=\"#EAEAEA\" align=\"center\" style=\"background:#eaeaea;text-align:center\"><p style=\"font-size:10px;margin:0; line-height:15px;\">This email and any files transmitted with it are confidential and intended solely for the use of the individual or entity to whom they are addressed. If you have received this email in error please notify the system manager. This message contains confidential information and is intended only for the individual named. If you are not the named addressee you should not disseminate, distribute or copy this e-mail. Please notify the sender immediately by e-mail if you have received this e-mail by mistake and delete this e-mail from your system. If you are not the intended recipient you are notified that disclosing, copying, distributing or taking any action in reliance on the contents of this information is strictly prohibited.</p></td>\n    </tr>\n  </tbody>\n</table>', '{website_name} Name of our website<br>\n{user_email} Contact Us Email<br>\n{question_txt} Question<br>\n{user_name} name of user<br>\n{website_url} Website url<br>', 0),
(6, 'doctor_review', 'The doctor review', 'The doctor review', '<table width=\"650\" cellspacing=\"0\" cellpadding=\"10\" border=\"0\" bgcolor=\"FFFFFF\" style=\"border:1px solid #e0e0e0;margin:0 auto; font-family:arial;\">\n  <tbody>\n    <tr>\n      <td valign=\"top\"><h1 style=\"font-size:22px;font-weight:normal;line-height:22px;margin:0 0 12px 0; text-transform:capitalize;\">Dear {user_name},</h1>\n	\n	   \n	   <p style=\"border:1px solid #e0e0e0;font-size:13px;line-height:20px;margin:0;padding:13px 18px;background:#f9f9f9\"> <strong>{review_for} got review by {review_by} for following question.</strong><br>\n         {question_txt}</p>\n    </tr>\n	                   \n    <tr>\n      <td><p style=\"font-size: 13px; line-height: 18px; margin: 0px 0 0px;\">Best wishes,<br>\n          {website_name} Team </p>\n        <a target=\"_blank\" href=\"\"> <img border=\"0\" style=\"margin-bottom:10px\" alt=\"Logo\" src=\"{website_url}/public/images/logo.png\" class=\"CToWUd\"></a></td>\n    </tr>\n    <tr>\n      <td bgcolor=\"#EAEAEA\" align=\"center\" style=\"background:#eaeaea;text-align:center\"><p style=\"font-size:10px;margin:0; line-height:15px;\">This email and any files transmitted with it are confidential and intended solely for the use of the individual or entity to whom they are addressed. If you have received this email in error please notify the system manager. This message contains confidential information and is intended only for the individual named. If you are not the named addressee you should not disseminate, distribute or copy this e-mail. Please notify the sender immediately by e-mail if you have received this e-mail by mistake and delete this e-mail from your system. If you are not the intended recipient you are notified that disclosing, copying, distributing or taking any action in reliance on the contents of this information is strictly prohibited.</p></td>\n    </tr>\n  </tbody>\n</table>', '{website_name} Name of our website<br>\n{user_email} Contact Us Email<br>\n{question_txt} Question<br>\n{website_url} Website url<br>\n{user_name} name of user\n', 0),
(7, 'question_reply', 'Question Reply', 'Question Reply', '<table width=\"650\" cellspacing=\"0\" cellpadding=\"10\" border=\"0\" bgcolor=\"FFFFFF\" style=\"border:1px solid #e0e0e0;margin:0 auto; font-family:arial;\">\n  <tbody>\n    <tr>\n      <td valign=\"top\"><h1 style=\"font-size:22px;font-weight:normal;line-height:22px;margin:0 0 12px 0; text-transform:capitalize;\">Dear {user_name},</h1>\n	\n	    <p style=\"font-size: 13px; line-height: 18px; margin:0px;\">You Got a reply by {replied_by} on following Question<br></br>\n		\n       </p>\n		  \n		  </br>\n	   <div style=\"border:1px solid #e0e0e0;font-size:13px;line-height:20px;margin:0;padding:13px 18px;background:#f9f9f9\"> <p>   <strong>Question : </strong>{question_txt} </p>\n\n    <br/><strong>Reply: </strong>     {reply_text}\n</div>\n		 </td>\n		 \n    </tr>\n	                   \n    <tr>\n      <td><p style=\"font-size: 13px; line-height: 18px; margin: 0px 0 0px;\">Best wishes,<br>\n          {website_name} Team </p>\n        <a target=\"_blank\" href=\"\"> <img border=\"0\" style=\"margin-bottom:10px\" alt=\"Logo\" src=\"{website_url}/public/images/logo.png\" class=\"CToWUd\"></a></td>\n    </tr>\n    <tr>\n      <td bgcolor=\"#EAEAEA\" align=\"center\" style=\"background:#eaeaea;text-align:center\"><p style=\"font-size:10px;margin:0; line-height:15px;\">This email and any files transmitted with it are confidential and intended solely for the use of the individual or entity to whom they are addressed. If you have received this email in error please notify the system manager. This message contains confidential information and is intended only for the individual named. If you are not the named addressee you should not disseminate, distribute or copy this e-mail. Please notify the sender immediately by e-mail if you have received this e-mail by mistake and delete this e-mail from your system. If you are not the intended recipient you are notified that disclosing, copying, distributing or taking any action in reliance on the contents of this information is strictly prohibited.</p></td>\n    </tr>\n  </tbody>\n</table>', '{website_name} Name of our website<br>\n{user_email} Contact Us Email<br>\n{question_txt} Question<br>\n{website_url} Website url<br>\n{user_name} name of user', 0),
(8, 'question_accepted', 'Question Accepted', 'Question Accepted', '<table width=\"650\" cellspacing=\"0\" cellpadding=\"10\" border=\"0\" bgcolor=\"FFFFFF\" style=\"border:1px solid #e0e0e0;margin:0 auto; font-family:arial;\">\n  <tbody>\n    <tr>\n      <td valign=\"top\"><h1 style=\"font-size:22px;font-weight:normal;line-height:22px;margin:0 0 12px 0; text-transform:capitalize;\">Dear {user_name},</h1>\n	\n	   \n	   <p style=\"border:1px solid #e0e0e0;font-size:13px;line-height:20px;margin:0;padding:13px 18px;background:#f9f9f9\"> <strong>Following question is accepted By {doc_name} </strong><br>\n         {question_txt}</p>\n    </tr>\n	                   \n    <tr>\n      <td><p style=\"font-size: 13px; line-height: 18px; margin: 0px 0 0px;\">Best wishes,<br>\n          {website_name} Team </p>\n        <a target=\"_blank\" href=\"\"> <img border=\"0\" style=\"margin-bottom:10px\" alt=\"Logo\" src=\"{website_url}/public/images/logo.png\" class=\"CToWUd\"></a></td>\n    </tr>\n    <tr>\n      <td bgcolor=\"#EAEAEA\" align=\"center\" style=\"background:#eaeaea;text-align:center\"><p style=\"font-size:10px;margin:0; line-height:15px;\">This email and any files transmitted with it are confidential and intended solely for the use of the individual or entity to whom they are addressed. If you have received this email in error please notify the system manager. This message contains confidential information and is intended only for the individual named. If you are not the named addressee you should not disseminate, distribute or copy this e-mail. Please notify the sender immediately by e-mail if you have received this e-mail by mistake and delete this e-mail from your system. If you are not the intended recipient you are notified that disclosing, copying, distributing or taking any action in reliance on the contents of this information is strictly prohibited.</p></td>\n    </tr>\n  </tbody>\n</table>', '{website_name} Name of our website<br>\n{user_email} Contact Us Email<br>\n{website_url} Website url<br>\n{question_txt} Question<br>\n{user_name} name of user</br>\n{doc_name} Doctor name </br>', 0),
(9, 'question_posted', 'Question Posted', 'Question Posted', '<table width=\"650\" cellspacing=\"0\" cellpadding=\"10\" border=\"0\" bgcolor=\"FFFFFF\" style=\"border:1px solid #e0e0e0;margin:0 auto; font-family:arial;\">\n  <tbody>\n    <tr>\n      <td valign=\"top\"><h1 style=\"font-size:22px;font-weight:normal;line-height:22px;margin:0 0 12px 0; text-transform:capitalize;\">Dear {user_name},</h1>\n	\n	   \n	   <p style=\"border:1px solid #e0e0e0;font-size:13px;line-height:20px;margin:0;padding:13px 18px;background:#f9f9f9\"> <strong>Following question is posted </strong><br>\n         {question_txt}</p>\n    </tr>\n	                   \n    <tr>\n      <td><p style=\"font-size: 13px; line-height: 18px; margin: 0px 0 0px;\">Best wishes,<br>\n          {website_name} Team </p>\n        <a target=\"_blank\" href=\"\"> <img border=\"0\" style=\"margin-bottom:10px\" alt=\"Logo\" src=\"{website_url}/public/images/logo.png\" class=\"CToWUd\"></a></td>\n    </tr>\n    <tr>\n      <td bgcolor=\"#EAEAEA\" align=\"center\" style=\"background:#eaeaea;text-align:center\"><p style=\"font-size:10px;margin:0; line-height:15px;\">This email and any files transmitted with it are confidential and intended solely for the use of the individual or entity to whom they are addressed. If you have received this email in error please notify the system manager. This message contains confidential information and is intended only for the individual named. If you are not the named addressee you should not disseminate, distribute or copy this e-mail. Please notify the sender immediately by e-mail if you have received this e-mail by mistake and delete this e-mail from your system. If you are not the intended recipient you are notified that disclosing, copying, distributing or taking any action in reliance on the contents of this information is strictly prohibited.</p></td>\n    </tr>\n  </tbody>\n</table>', '{website_name} Name of our website<br>\n{user_email} Contact Us Email<br>\n{question_txt} Question<br>\n{website_url} Website url<br>\n{user_name} name of user\n', 0),
(10, 'new_registration ', 'New Registration ', 'Congrats! Your Account is succesfully Created.', '<table width=\"650\" cellspacing=\"0\" cellpadding=\"10\" border=\"0\" bgcolor=\"FFFFFF\" style=\"border:1px solid #e0e0e0; font-family:arial;\">\n  <tbody>\n    <tr>\n      <td valign=\"top\"><h1 style=\"font-size:22px;font-weight:normal;line-height:22px;margin:0 0 12px 0; text-transform:capitalize;\">Dear {user_name},</h1>\n        <p style=\"font-size: 13px; line-height: 18px; margin: 15px 0 20px;\">Thank you for registering with  {website_name}. We\'ve created your account.</p>\n        <p style=\"border:1px solid #e0e0e0;font-size:13px;line-height:20px;margin:0;padding:13px 18px;background:#f9f9f9\"> Use the following values when prompted to log in:<br>\n          <b>E-mail</b>: <a target=\"_blank\" href=\"mailto:terst@dummyid.com\" style=\"color:#f0a218; text-decoration:none\">{user_email}</a><br>\n          <b>Password</b>: {user_password}</p></td>\n    </tr>\n    <tr>\n      <td><p style=\"font-size: 13px; line-height: 18px; margin: 0px 0 0px;\">Best wishes,<br>\n          {website_name} Team </p>\n        <a target=\"_blank\" href=\"\"> <img border=\"0\" style=\"margin-bottom:10px\" alt=\"Logo\" src=\"{website_url}/public/images/logo.png\" class=\"CToWUd\"></a></td>\n    </tr>\n    <tr>\n        <td bgcolor=\"#EAEAEA\" align=\"center\" style=\"background:#eaeaea;text-align:center\"><p style=\"font-size:10px;margin:0; line-height:15px;\">This email and any files transmitted with it are confidential and intended solely for the use of the individual or entity to whom they are addressed. If you have received this email in error please notify the system manager. This message contains confidential information and is intended only for the individual named. If you are not the named addressee you should not disseminate, distribute or copy this e-mail. Please notify the sender immediately by e-mail if you have received this e-mail by mistake and delete this e-mail from your system. If you are not the intended recipient you are notified that disclosing, copying, distributing or taking any action in reliance on the contents of this information is strictly prohibited.</p></td>\n    </tr>\n  </tbody>\n</table>', '{user_email}->User Email<br>\r\n{user_password}->User password<br>\r\n{website_name}->Web Site name<br>\r\n{user_name}->User name<br>\r\n{website_url}->Website Url\r\n', 0),
(11, 'doctor_password_updates', 'Password Updated ', 'Yor Password has been updated.', '<table width=\"650\" cellspacing=\"0\" cellpadding=\"10\" border=\"0\" bgcolor=\"FFFFFF\" style=\"border:1px solid #e0e0e0; font-family:arial;\">\n  <tbody>\n    <tr>\n      <td valign=\"top\"><h1 style=\"font-size:22px;font-weight:normal;line-height:22px;margin:0 0 12px 0; text-transform:capitalize;\">Dear {user_name},</h1>\n        <p style=\"font-size: 13px; line-height: 18px; margin: 15px 0 20px;\">Thank you for contacting with  {website_name}. We\'ve updated your account.</p>\n        <p style=\"border:1px solid #e0e0e0;font-size:13px;line-height:20px;margin:0;padding:13px 18px;background:#f9f9f9\"> Use the following values when prompted to log in:<br>\n          <b>E-mail</b>: <a target=\"_blank\" href=\"mailto:terst@dummyid.com\" style=\"color:#f0a218; text-decoration:none\">{user_email}</a><br>\n          <b>Password</b>: {user_password}</p></td>\n    </tr>\n    <tr>\n      <td><p style=\"font-size: 13px; line-height: 18px; margin: 0px 0 0px;\">Best wishes,<br>\n          {website_name} Team </p>\n        <a target=\"_blank\" href=\"\"> <img border=\"0\" style=\"margin-bottom:10px\" alt=\"Logo\" src=\"{website_url}/public/images/logo.png\" class=\"CToWUd\"></a></td>\n    </tr>\n    <tr>\n        <td bgcolor=\"#EAEAEA\" align=\"center\" style=\"background:#eaeaea;text-align:center\"><p style=\"font-size:10px;margin:0; line-height:15px;\">This email and any files transmitted with it are confidential and intended solely for the use of the individual or entity to whom they are addressed. If you have received this email in error please notify the system manager. This message contains confidential information and is intended only for the individual named. If you are not the named addressee you should not disseminate, distribute or copy this e-mail. Please notify the sender immediately by e-mail if you have received this e-mail by mistake and delete this e-mail from your system. If you are not the intended recipient you are notified that disclosing, copying, distributing or taking any action in reliance on the contents of this information is strictly prohibited.</p></td>\n    </tr>\n  </tbody>\n</table>', '{user_email}->User Email<br>\n{user_password}->User password<br>\n{website_name}->Web Site name<br>\n{user_name}->User name<br>\n{website_url}->Website Url\n', 0),
(12, 'question_reply_disapproved', 'Question Reply Disapproved', 'Question Reply Disapproved', '<table width=\"650\" cellspacing=\"0\" cellpadding=\"10\" border=\"0\" bgcolor=\"FFFFFF\" style=\"border:1px solid #e0e0e0;margin:0 auto; font-family:arial;\">\n  <tbody>\n    <tr>\n      <td valign=\"top\"><h1 style=\"font-size:22px;font-weight:normal;line-height:22px;margin:0 0 12px 0; text-transform:capitalize;\">Dear {user_name},</h1>\n	\n	  \n	   <div style=\"border:1px solid #e0e0e0;font-size:13px;line-height:20px;margin:0;padding:13px 18px;background:#f9f9f9\"> \n  <p style=\"font-size: 13px; line-height: 18px; margin:0px;\">You  reply has been disapproved on following Question<br></br>\n		\n          <strong>Question :  </strong>{question_txt} </p>\n		  \n		  </br>\n\n     	\n          <strong>Reply :  </strong>    {reply_text}\n</div>\n		 </td>\n		 \n    </tr>\n	                   \n    <tr>\n      <td><p style=\"font-size: 13px; line-height: 18px; margin: 0px 0 0px;\">Best wishes,<br>\n          {website_name} Team </p>\n        <a target=\"_blank\" href=\"\"> <img border=\"0\" style=\"margin-bottom:10px\" alt=\"Logo\" src=\"{website_url}/public/images/logo.png\" class=\"CToWUd\"></a></td>\n    </tr>\n    <tr>\n      <td bgcolor=\"#EAEAEA\" align=\"center\" style=\"background:#eaeaea;text-align:center\"><p style=\"font-size:10px;margin:0; line-height:15px;\">This email and any files transmitted with it are confidential and intended solely for the use of the individual or entity to whom they are addressed. If you have received this email in error please notify the system manager. This message contains confidential information and is intended only for the individual named. If you are not the named addressee you should not disseminate, distribute or copy this e-mail. Please notify the sender immediately by e-mail if you have received this e-mail by mistake and delete this e-mail from your system. If you are not the intended recipient you are notified that disclosing, copying, distributing or taking any action in reliance on the contents of this information is strictly prohibited.</p></td>\n    </tr>\n  </tbody>\n</table>', '{website_name} Name of our website<br>\n{user_email} Contact Us Email<br>\n{question_txt} Question<br>\n{website_url} Website url<br>\n{user_name} name of user', 0),
(13, 'question_esclated', 'Question Esclated', 'Question Esclated', '<table width=\"650\" cellspacing=\"0\" cellpadding=\"10\" border=\"0\" bgcolor=\"FFFFFF\" style=\"border:1px solid #e0e0e0;margin:0 auto; font-family:arial;\">  \r\n	<tbody>    \r\n		<tr>      \r\n			<td valign=\"top\">\r\n				<h1 style=\"font-size:22px;font-weight:normal;line-height:22px;margin:0 0 12px 0; text-transform:capitalize;\">Dear {user_name},</h1>   \r\n	   \r\n				<p style=\"border:1px solid #e0e0e0;font-size:13px;line-height:20px;margin:0;padding:13px 18px;background:#f9f9f9\"> <strong>Following question is esclated by {doctor_name},Please reassign this question to other doctor</strong><br />\r\n					         {question_txt}</p>    </td>\r\n		</tr>                   \r\n    \r\n		<tr>      \r\n			<td>\r\n				<p style=\"font-size: 13px; line-height: 18px; margin: 0px 0 0px;\">Best wishes,<br />\r\n					          {website_name} Team </p>        <a target=\"_blank\" href=\"\"> <img border=\"0\" style=\"margin-bottom:10px\" alt=\"Logo\" src=\"{website_url}/public/images/logo.png\" class=\"CToWUd\" /></a></td>    \r\n		</tr>    \r\n		<tr>      \r\n			<td bgcolor=\"#EAEAEA\" align=\"center\" style=\"background:#eaeaea;text-align:center\">\r\n				<p style=\"font-size:10px;margin:0; line-height:15px;\">This email and any files transmitted with it are confidential and intended solely for the use of the individual or entity to whom they are addressed. If you have received this email in error please notify the system manager. This message contains confidential information and is intended only for the individual named. If you are not the named addressee you should not disseminate, distribute or copy this e-mail. Please notify the sender immediately by e-mail if you have received this e-mail by mistake and delete this e-mail from your system. If you are not the intended recipient you are notified that disclosing, copying, distributing or taking any action in reliance on the contents of this information is strictly prohibited.</p></td>    \r\n		</tr>  \r\n	</tbody>\r\n</table>', '{website_name} Name of our website<br>\r\n{user_email} Contact Us Email<br>\r\n{question_txt} Question<br>\r\n{doctor_name} Doctor Name <br>\r\n{user_name} name of user<br>\r\n{website_url} Website url<br>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_faq`
--

CREATE TABLE `tbl_faq` (
  `faq_id` int(11) NOT NULL,
  `faq_question` varchar(255) NOT NULL,
  `faq_answer` text NOT NULL,
  `faq_category_id` int(11) NOT NULL,
  `faq_display_order` int(11) NOT NULL,
  `faq_active` tinyint(4) NOT NULL,
  `faq_deleted` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_faq`
--

INSERT INTO `tbl_faq` (`faq_id`, `faq_question`, `faq_answer`, `faq_category_id`, `faq_display_order`, `faq_active`, `faq_deleted`) VALUES
(1, 'tetss', '', 2, 0, 1, 1),
(2, 'What is getMedz', '<p>GetMedz is a website where you can get solution for your problems</p>', 3, 1, 0, 1),
(3, 'How does \'health queries\' on icliniq work?', '<p></p>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\">Once you register as a user, you can post a health query to seek answers from health experts. Health experts who see your query will respond with an answer to your query.</span></li>\r\n</ul>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\">Try it yourself now,&nbsp;</span><a title=\"Ask a doctor online\" href=\"https://getmedz.4demo.biz\" style=\"box-sizing: border-box; background: 0px 0px; color: rgb(66, 139, 202); text-decoration-line: none; font-size: 10pt;\">Ask a doctor online</a><span style=\"box-sizing: border-box; font-size: 10pt;\">?</span></li>\r\n</ul>\r\n<p>&nbsp;</p>', 3, 1, 0, 0),
(4, 'dsafdsafd', '<p>asfdadsaf</p>', 3, 3, 1, 0),
(5, 'How to book a phone/voice consultation', '<p></p>\r\n<ol style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">\r\n	<li style=\"box-sizing: border-box;\">Post your health issue with the date and time you want a phone/voice consultation with the Doctor.</li>\r\n	<li style=\"box-sizing: border-box;\">Pay the consultation fee.</li>\r\n	<li style=\"box-sizing: border-box;\">A Doctor whose speciality matches with your query will pick up your consultation request and you will be notified through an SMS and EMAIL.</li>\r\n	<li style=\"box-sizing: border-box;\">Be ready at the time mentioned in the appointment schedule to receive the consultation call.</li>\r\n</ol>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 10px; font-size: 14px; color: rgb(66, 66, 66); font-family: Arimo, \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">P.S. You would receive a call from our voice room +1-754-217-2601 that will connect your call with the Doctor. Do save this number in your phone as \'icliniq voice room\'.</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 10px; font-size: 14px; color: rgb(66, 66, 66); font-family: Arimo, \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" sans-serif;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">It is extremely easy to use. Get Started Now =>&nbsp;<a title=\"Book for phone/voice consultation\" href=\"https://getmedz.4demo.biz\" style=\"box-sizing: border-box; background: 0px 0px; color: rgb(66, 139, 202); text-decoration-line: none;\">Book for Phone/Voice Consultation</a>&nbsp;NOW !</p>\r\n<p>&nbsp;</p>', 5, 1, 1, 0),
(6, 'Test Faq', '<span style=\"font-weight: bold;\">test Faq uyeoevc cx xvcx</span>&nbsp;xvxv&nbsp; &nbsp;xc vcx&nbsp; vcxzvcxvc', 3, 1, 0, 0),
(7, 'How to get faster answers for your health queries?', '<p style=\"box-sizing: border-box; margin: 0px 0px 10px; font-size: 14px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);\">When posting a health query to doctors, make sure you have provided enough details for them to understand your problem.</p>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\">Details of the symptoms</span></li>\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\">Current treatment and medications details</span></li>\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\">Your gender, age, height and weight.</span></li>\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\">Attach photos or medical reports if any.</span></li>\r\n</ul>', 3, 2, 1, 0),
(8, 'How do I post a health query for FREE', '<span style=\"color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">Of-course you can post a health query for FREE. But your query must be with less than 160 characters and you cannot attach any files with it</span>', 3, 3, 1, 0),
(9, 'How to book an online video consultation?', '<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\">Click on \"Doctors\" menu in the home page and choose a doctor of your choice to whom you wish to book a video consultation and click on \'Book a Video/Online Consultation\'.</span></li>\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\">Post your health issue and chose a date and time slot available from the doctor\'s schedule</span></li>\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\">Pay the consultation fee using debit card, credit card or internet banking.</span></li>\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\">Be ready at your computer at the time mentioned in the appointment schedule.</span></li>\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\">You will receive a link and when you click on the link your consultation will begin.</span></li>\r\n</ul>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 10px; font-size: 14px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);\">&nbsp;</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 10px; font-size: 14px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);\"><span style=\"box-sizing: border-box; font-size: 10pt;\">P.S.</span></p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 10px; font-size: 14px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);\"><span style=\"box-sizing: border-box; font-size: 10pt;\">&nbsp;</span><span style=\"box-sizing: border-box; font-size: 10pt;\">You would require a web camera to do a video consultation and good internet connectivity for uninterrupted call clarity.</span></p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 10px; font-size: 14px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);\"><span style=\"box-sizing: border-box; font-size: 10pt;\">It is extremely easy to use</span></p>', 6, 1, 1, 0),
(10, 'I am a health expert. How do I answer health queries?', '<ol style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\">If you are a health expert please do sign up with us and submit your profile to us.</li>\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\">Once your profile is activated after stringent verification, you can see a section called \"Health Queries\" in your account. You can reply to any queries, where you are expertised with, Or else you can leave it for other health experts to provide the answer.&nbsp;</span></li>\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\">Please make sure that, you do not answer a query if you do not know the answer. The user who asked the query might click on \"not-satisfied\" button and this could affect your ratings.</span></li>\r\n</ol>', 7, 1, 1, 0),
(11, 'I am a health expert. How am I paid for the money I earn on icliniq? When can I withdraw it?', '<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\">The money you earned would reflect on your icliniq dashboard as \"Wallet Balance\". .</span></li>\r\n</ul>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\">The user pays the money to icliniq through our payment gateway vendors. The vendors transfer the money to us once in 7 days i.e. a payment cycle of 7 days. We follow the same payment cycle with you for every Rs.1000 for Indian doctors or USD 50 for Non-Indian doctors.</li>\r\n</ul>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\">We would process the transaction to you if your earnings fall in the payment cycle of 7 days. If your earnings do not fall in the current payment cycle and fall in the next payment cycle, we would process it accordingly.</li>\r\n</ul>', 7, 2, 1, 0),
(12, 'I am a health expert, how do patients on icliniq.com will find me?', '<span style=\"color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">All registered doctors in icliniq will be listed in the icliniq.com\'s&nbsp;</span><a title=\"Online Doctors\" href=\"https://www.icliniq.com/search/online-doctors-directory\" style=\"box-sizing: border-box; background: 0px 0px rgb(255, 255, 255); color: rgb(66, 139, 202); text-decoration-line: none; font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px;\">doctors</a><span style=\"color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">&nbsp;page. Patients will search and find doctors by speciality. The display order of the doctors in this page will depends on whether the doctor has an active schedule in icliniq, and they have a profile photo updated; and the rest are listed in&nbsp;</span><span style=\"box-sizing: border-box; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255); font-size: 10pt;\">random order</span><span style=\"box-sizing: border-box; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255); font-size: 10pt;\">.</span>', 7, 3, 1, 0),
(13, 'I\'m health expert. How do patients post health queries directly to me?', '<p style=\"box-sizing: border-box; margin: 0px 0px 10px; font-size: 14px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);\">Patients who visit your profile page will post health queries directly to you.</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 10px; font-size: 14px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);\">Write good and niche articles and attract more visitors to your profile. icliniq\'s media team too will promote your articles and bring more visitor to your profile.</p>', 7, 4, 1, 0),
(14, 'What is a \'Virtual hospital?\' And what is the reason for icliniq to create the concept of \'Virtual hospital\'?', '<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\">A&nbsp;<span style=\"box-sizing: border-box; text-decoration-line: underline;\">virtual hospital</span>&nbsp;is an icliniq within icliniq. The features on icliniq.com +</span><span style=\"box-sizing: border-box; font-weight: 700; font-size: 10pt;\">&nbsp;lot of extra features</span><span style=\"box-sizing: border-box; font-size: 10pt;\">&nbsp;are provided for Virtual hospitals.</span></li>\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\">The concept of virtual hospitals is to create an ecosystem of personalized pages for doctors or health experts with their Clinic or Hospital.</span></li>\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\">Virtual Hospital Package comes with Electronic Medical Records for Practitioners and Hospitals.</span></li>\r\n</ul>', 8, 1, 1, 0),
(15, 'How much should I pay for the Virtual Hospital?', '<span style=\"color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">Virtual hospital package comes at a very nominal cost. Check out it on our&nbsp;</span><a href=\"https://www.icliniq.com/practice-management-solution\" style=\"box-sizing: border-box; background: 0px 0px rgb(255, 255, 255); color: rgb(66, 139, 202); text-decoration-line: none; font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px;\">Virtuial Hospital Pricing</a><span style=\"color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">&nbsp;page</span>', 8, 3, 1, 0),
(16, 'How do I register for a virtual hospital? What are the features available on a virtual hospital?', '<p style=\"box-sizing: border-box; margin: 0px 0px 10px; font-size: 14px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);\"><span style=\"box-sizing: border-box; font-size: 10pt;\">Register for a virtual hospital at&nbsp;</span><a href=\"https://www.icliniq.com/practice-management-solution\" style=\"box-sizing: border-box; background: 0px 0px; color: rgb(66, 139, 202); text-decoration-line: none; font-size: 10pt;\">https://www.icliniq.com/practice-management-solution</a>&nbsp;and get&nbsp;<a title=\"practise management solution\" href=\"https://www.icliniq.com/practice-management-solution\" style=\"box-sizing: border-box; background: 0px 0px; color: rgb(66, 139, 202); text-decoration-line: none;\">practise management solution</a>&nbsp;for your hospital.</p>\r\n<p style=\"box-sizing: border-box; margin: 0px 0px 10px; font-size: 14px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; background-color: rgb(255, 255, 255);\"><span style=\"box-sizing: border-box; font-size: 10pt;\">The additional features(modules) of Virtual hospital apart from what is available on icliniq are :</span></p>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-weight: 700; font-size: 10pt;\">Intelli-bill system for Billing and accounting -&nbsp;</span><span style=\"box-sizing: border-box; font-weight: 700; font-size: 10pt;\">Create bills in downloadable format with your logo in minutes. (NO NEED TO BUY SEPARATE BILLING SOFTWARE FOR YOUR HOSPITAL OR CLINIC)</span></li>\r\n</ul>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\">Maintain database of bills. No need to store it in your computer or hard disk or any storage device</li>\r\n</ul>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\">Send the bills to anyone in an email on the click of a single button</li>\r\n</ul>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\">Edit your bills</li>\r\n</ul>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-weight: 700;\">Store the health/medical records</span>&nbsp;of your unregistered patients also.</li>\r\n</ul>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-weight: 700;\">Appointment management system</span></li>\r\n</ul>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-weight: 700; font-size: 10pt;\">Appointment reminder system (SMS and email) - You can add appointments and type your patient\'s mobile number. He/she will automatically get an SMS immediately and also half an hour &nbsp;before the appointment intimating to visit your clinic</span></li>\r\n</ul>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-weight: 700; font-size: 10pt;\">Store health records for unregistered users</span></li>\r\n</ul>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\">All the above features are for patients who do not even have an icliniq id</li>\r\n</ul>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-weight: 700;\">A website for yourself</span>. Example :&nbsp;<a href=\"https://mnp.icliniq.com/\" target=\"_blank\" style=\"box-sizing: border-box; background: 0px 0px; color: rgb(66, 139, 202); text-decoration-line: none;\">mnp.icliniq.com</a>&nbsp;,&nbsp;<a href=\"https://arooj.icliniq.com/\" target=\"_blank\" style=\"box-sizing: border-box; background: 0px 0px; color: rgb(66, 139, 202); text-decoration-line: none;\">arooj.icliniq.com</a></li>\r\n</ul>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-weight: 700;\">Google maps</span>&nbsp;are integrated thereby making it easy for your patients to find you.</li>\r\n</ul>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-weight: 700;\">Publish news and events</span>&nbsp;on your virtual hospital.</li>\r\n</ul>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\">Individualized Query system : When your patient visits your virtual hospital online and posts a query. It will be displayed in your doctor profile alone and not to any other doctor on icliniq or any other virtual hospital.</li>\r\n</ul>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\">Lead generation benefits from icliniq : We constantly do marketing of icliniq which will benefit you and queries posted by you from icliniq will also be shown to you.</span></li>\r\n</ul>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\">Multiple doctor profiles and health expert profiles can be added to your virtual hospital.</li>\r\n</ul>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\"><span style=\"box-sizing: border-box; font-weight: 700;\">ECOSYSTEM of virtual hospitals</span>&nbsp;: When your virtual hospital becomes really popular, other doctors on icliniq could request to be an affiliate of your virtual hospital. When they do this, queries posted in your virtual hospital or they could get leads due to the fame of your brand. You can work out the commercial terms with him or her.</span></li>\r\n</ul>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\">We would pay you the money earned through queries or consultations by your affiliated and you would pay him accordingly.</span></li>\r\n</ul>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\"><span style=\"box-sizing: border-box; font-weight: 700;\">Intelli-reception system</span>&nbsp;for doctor profiles with just your phone acting as receptionist: Anyone can book direct appointment with you with just a simple SMS by texting icliniq LS to 56767. This would list your slots in a subsequent SMS. Then &nbsp;they can book the appointment by texting icliniq BK .</span></li>\r\n</ul>\r\n<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\">With intell-reception system, your mobile phone &amp; icliniq account are synced.</span></li>\r\n</ul>', 8, 2, 1, 0),
(17, 'With my virtual hospital, can I download my data? Can other virtual hospitals view my data?', '<div class=\"row\" style=\"box-sizing: border-box; margin-right: -15px; margin-left: -15px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255); padding-left: 15px;\">\r\n	<div class=\"ans\" style=\"box-sizing: border-box; padding: 2px 15px 0px;\">\r\n		<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px;\">\r\n			<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-weight: 700;\">Yes.</span>&nbsp;You can download your data in excel format from your virtual hospital control panel. Also we have options to upload your existing records in bulk through excel sheet</li>\r\n		</ul>\r\n		<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px;\">\r\n			<li style=\"box-sizing: border-box;\">Other virtual hospital or doctors can not not view or access your data. Only you and your front-desk staff can access your data.</li>\r\n		</ul></div></div><span style=\"color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">&nbsp;</span>', 8, 4, 1, 0),
(18, 'What does a \"USER\" mean in icliniq? And Is registering at icliniq free of cost?', '<ol style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\">We feel that the word \'patient\' is a bit negative and we always want to be positive because&nbsp;<span style=\"box-sizing: border-box; font-weight: 700;\">being positive</span>&nbsp;helps one have a good health.So for the sake of explanation, USER means someone who wants his/her health query answered or want to have a consultation with a health expert.</span></li>\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\">YES. Registering at icliniq as a \'user\' or \'doctor\' is totally free of cost.</span></li>\r\n</ol>', 9, 1, 1, 0),
(19, 'How does getMedz make money?', '<ul style=\"box-sizing: border-box; margin-top: 0px; margin-bottom: 10px; color: rgb(66, 66, 66); font-family: Arimo, \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);\">\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\">For video consultations and health queries, 29 percent of the doctor\'s earning is taken as icliniq platform fee.</span></li>\r\n	<li style=\"box-sizing: border-box;\"><span style=\"box-sizing: border-box; font-size: 10pt;\">For phone consultations, 50 percent of the doctor\'s earning is taken as icliniq platform fee.</span></li>\r\n</ul>', 9, 2, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_faq_category`
--

CREATE TABLE `tbl_faq_category` (
  `faqcat_id` int(11) NOT NULL,
  `faqcat_name` varchar(120) NOT NULL,
  `faqcat_display_order` int(11) NOT NULL,
  `faqcat_active` tinyint(4) NOT NULL,
  `faqcat_deleted` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='FAQ Categories';

--
-- Dumping data for table `tbl_faq_category`
--

INSERT INTO `tbl_faq_category` (`faqcat_id`, `faqcat_name`, `faqcat_display_order`, `faqcat_active`, `faqcat_deleted`) VALUES
(3, 'Health Queries - Getting medical advice from doctors by posting the health issue as Messages', 1, 1, 0),
(2, 'health', 1, 1, 1),
(4, 'New Category', 2, 1, 1),
(5, 'Phone or Mobile Consultation - Talk to the doctor on phone to get medical advice.', 2, 1, 0),
(6, 'Online Video Chat Consultation', 3, 1, 0),
(7, 'For Doctors and Health Experts', 4, 1, 0),
(8, 'For Hospitals', 5, 1, 0),
(9, 'General Questions', 6, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_files`
--

CREATE TABLE `tbl_files` (
  `file_id` int(11) NOT NULL,
  `file_record_type` int(11) NOT NULL COMMENT '1=>home_banner_image, 2=>testimonial_image',
  `file_record_id` int(11) NOT NULL,
  `file_path` varchar(200) NOT NULL,
  `file_display_name` varchar(200) NOT NULL,
  `file_display_text` varchar(255) NOT NULL,
  `file_record_subid` int(11) NOT NULL,
  `file_display_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_files`
--

INSERT INTO `tbl_files` (`file_id`, `file_record_type`, `file_record_id`, `file_path`, `file_display_name`, `file_display_text`, `file_record_subid`, `file_display_order`) VALUES
(1, 1, 54, 'Lighthousejpg_517650', 'Lighthouse.jpg', '', 0, 0),
(2, 0, 67, 'Desertjpg_125341', 'Desert.jpg', '', 0, 0),
(3, 1, 55, 'Lighthousejpg_633461', 'Lighthouse.jpg', '', 0, 0),
(4, 1, 56, 'logopng_803849', 'logo.png', '', 0, 0),
(5, 4, 33, 'customer_profile/Penguinsjpg_756046', 'Penguins.jpg', '', 0, 0),
(6, 4, 2, 'customer_profile/logosmallpng_187906', 'logo-small.png', '', 0, 0),
(7, 3, 3, 'doc_profile/femaledoctor22929877jpg', 'female-doctor-22929877.jpg', '', 0, 0),
(8, 1, 0, 'Penguinsjpg_417891', 'Penguins.jpg', '', 0, 0),
(9, 1, 0, 'Tulipsjpg_72107', 'Tulips.jpg', '', 0, 0),
(10, 1, 0, 'communication1pdf', 'communication (1).pdf', '', 0, 0),
(11, 1, 0, '1325507500Halloweenpdf', '1325507500_Halloween.pdf', '', 0, 0),
(12, 1, 58, 'iview32exe', 'i_view32.exe', '', 0, 0),
(13, 1, 58, 'ichangestxt', 'i_changes.txt', '', 0, 0),
(14, 1, 0, 'Samuel16txt', 'Samuel_16.txt', '', 0, 0),
(15, 1, 0, 'MyURLstxt', 'My URLs.txt', '', 0, 0),
(16, 1, 58, 'dddtxt', 'ddd.txt', '', 0, 0),
(17, 1, 0, 'Koalajpg_539179', 'Koala.jpg', '', 0, 0),
(18, 1, 61, 'MyTimingstxt_560516', 'My Timings.txt', '', 0, 0),
(19, 0, 77, '40745420denalicrpminijpg', '40_745_420_denali_crp_mini.jpg', '', 0, 0),
(20, 3, 16, 'doc_profile/safariesjpg_585300', 'safaries.jpg', '', 0, 0),
(21, 1, 0, '6kbjpg', '6 kb.jpg', '', 0, 0),
(22, 4, 40, 'customer_profile/jpegjpg', 'jpeg.jpg', '', 0, 0),
(23, 1, 0, 'yodrivenewzip', 'yodrive-new.zip', '', 0, 0),
(24, 1, 0, 'YoDriveUpdates13Aug15rar', 'YoDrive_Updates_13_Aug._15.rar', '', 0, 0),
(25, 1, 0, 'noc21jpg', 'noc-2 (1).jpg', '', 0, 0),
(26, 1, 0, 'noc21jpg_983746', 'noc-2 (1).jpg', '', 0, 0),
(27, 1, 0, 'noc21jpg_465834', 'noc-2 (1).jpg', '', 0, 0),
(28, 1, 0, 'searchpng', 'search.png', '', 0, 0),
(29, 1, 78, 'noc21jpg_164538', 'noc-2 (1).jpg', '', 0, 0),
(30, 1, 0, 'noc22jpg', 'noc-2 (2).jpg', '', 0, 0),
(31, 1, 0, 'noc21jpg_261330', 'noc-2 (1).jpg', '', 0, 0),
(32, 1, 79, 'RCFrontJPG', 'RC_Front.JPG', '', 0, 0),
(33, 1, 79, 'noc2jpg', 'noc-2.jpg', '', 0, 0),
(34, 0, 244, 'FRDLetPeopleHelp11docx_268328', 'FRD ', '', 0, 0),
(35, 4, 114, 'customer_profile/752kbjpg', '752 kb.jpg', '', 0, 0),
(36, 1, 85, 'Discussion2jpg', 'Discussion2.jpg', '', 0, 0),
(37, 1, 85, '40745420kayakingantarticaexplorercrpminijpg', '40_745_420_kayaking_antartica_explorer_crp_mini.jpg', '', 0, 0),
(38, 1, 85, 'Desertjpg', 'Desert.jpg', '', 0, 0),
(39, 1, 85, 'Penguinsjpg', 'Penguins.jpg', '', 0, 0),
(40, 1, 85, 'Koalajpg', 'Koala.jpg', '', 0, 0),
(41, 3, 9, 'doc_profile/AAEAAQAAAAAAAAS9AAAAJDNkODcxMmQ5LTgwNTEtNGZkZS1hMDFjLWM0Njk2ZTI2ODBiOQjpg', 'AAEAAQAAAAAAAAS9AAAAJDNkODcxMmQ5LTgwNTEtNGZkZS1hMDFjLWM0Njk2ZTI2ODBiOQ.jpg', '', 0, 0),
(42, 1, 86, 'Jellyfishjpg', 'Jellyfish.jpg', '', 0, 0),
(43, 0, 247, '118mbjpg', '1.18 mb.jpg', '', 0, 0),
(44, 1, 87, 'Koalajpg_310080', 'Koala.jpg', '', 0, 0),
(45, 1, 88, 'Lighthousejpg', 'Lighthouse.jpg', '', 0, 0),
(46, 1, 88, 'Lighthousejpg_545369', 'Lighthouse.jpg', '', 0, 0),
(47, 1, 0, 'Koalajpg_466464', 'Koala.jpg', '', 0, 0),
(48, 1, 0, 'Koalajpg_945593', 'Koala.jpg', '', 0, 0),
(49, 1, 0, 'noc21jpg_619317', 'noc-2 (1).jpg', '', 0, 0),
(50, 1, 0, 'pandajpg', 'panda.jpg', '', 0, 0),
(51, 1, 0, '752kbjpg', '752 kb.jpg', '', 0, 0),
(52, 1, 0, '13mbjpg', '13 mb.jpg', '', 0, 0),
(53, 1, 0, '752kbjpg_381268', '752 kb.jpg', '', 0, 0),
(54, 1, 95, '11odt', '11.odt', '', 0, 0),
(55, 1, 95, '11odt_762639', '11.odt', '', 0, 0),
(56, 1, 95, 'pandajpg_926085', 'panda.jpg', '', 0, 0),
(57, 1, 95, '752kbjpg_828734', '752 kb.jpg', '', 0, 0),
(58, 1, 95, 'pandajpg_354158', 'panda.jpg', '', 0, 0),
(59, 1, 95, 'pandajpg_598987', 'panda.jpg', '', 0, 0),
(60, 1, 95, '752kbjpg_312276', '752 kb.jpg', '', 0, 0),
(61, 1, 96, '118mbjpg_504253', '1.18 mb.jpg', '', 0, 0),
(62, 1, 0, 'pandajpg_272984', 'panda.jpg', '', 0, 0),
(63, 1, 0, '752kbjpg_550836', '752 kb.jpg', '', 0, 0),
(64, 1, 101, '752kbjpg_888893', '752 kb.jpg', '', 0, 0),
(65, 1, 101, '752kbjpg_107983', '752 kb.jpg', '', 0, 0),
(66, 1, 101, '752kbjpg_578292', '752 kb.jpg', '', 0, 0),
(67, 1, 0, 'Koalajpg_777685', 'Koala.jpg', '', 0, 0),
(68, 1, 0, 'Lighthousejpg_233711', 'Lighthouse.jpg', '', 0, 0),
(69, 1, 0, 'Penguinsjpg_389473', 'Penguins.jpg', '', 0, 0),
(70, 1, 104, 'pandajpg_599325', 'panda.jpg', '', 0, 0),
(71, 1, 104, '752kbjpg_371612', '752 kb.jpg', '', 0, 0),
(72, 1, 104, '118mbjpg_926399', '1.18 mb.jpg', '', 0, 0),
(73, 1, 105, 'Lighthousejpg_991005', 'Lighthouse.jpg', '', 0, 0),
(74, 1, 105, 'Desertjpg_900332', 'Desert.jpg', '', 0, 0),
(75, 1, 0, 'Lighthousejpg_663697', 'Lighthouse.jpg', '', 0, 0),
(76, 1, 0, 'Koalajpg_630983', 'Koala.jpg', '', 0, 0),
(77, 1, 0, 'Koalajpg_867111', 'Koala.jpg', '', 0, 0),
(78, 1, 0, 'Koalajpg_381567', 'Koala.jpg', '', 0, 0),
(79, 1, 0, 'Penguinsjpg_974046', 'Penguins.jpg', '', 0, 0),
(80, 1, 0, 'Koalajpg_853090', 'Koala.jpg', '', 0, 0),
(81, 1, 0, 'Koalajpg_687819', 'Koala.jpg', '', 0, 0),
(82, 1, 115, 'Koalajpg_712163', 'Koala.jpg', '', 0, 0),
(83, 1, 115, 'Penguinsjpg_352718', 'Penguins.jpg', '', 0, 0),
(84, 1, 116, 'pandajpg_688052', 'panda.jpg', '', 0, 0),
(85, 1, 116, '2kbjpg', '2 kb.jpg', '', 0, 0),
(86, 1, 117, '118mbjpg_550328', '1.18 mb.jpg', '', 0, 0),
(87, 1, 119, 'pandajpg_73408', 'panda.jpg', '', 0, 0),
(88, 1, 119, '118mbjpg_863361', '1.18 mb.jpg', '', 0, 0),
(89, 4, 116, 'customer_profile/1jpg', '1.jpg', '', 0, 0),
(90, 1, 0, 'Lighthousejpg_653298', 'Lighthouse.jpg', '', 0, 0),
(91, 3, 34, 'doc_profile/pandajpg', 'panda.jpg', '', 0, 0),
(92, 1, 0, 'Koalajpg_893861', 'Koala.jpg', '', 0, 0),
(93, 1, 0, 'Koalajpg_74752', 'Koala.jpg', '', 0, 0),
(94, 1, 0, 'Koalajpg_933614', 'Koala.jpg', '', 0, 0),
(95, 0, 277, '1688719XXXXXXX1404011pdf_244010', '1688719', '', 0, 0),
(96, 0, 277, '1688719XXXXXXX1404011pdf_244010', '1688719', '', 0, 0),
(97, 0, 278, '1688719XXXXXXX140401pdf', '1688719', '', 0, 0),
(98, 0, 278, '1688719XXXXXXX140401pdf', '1688719', '', 0, 0),
(99, 0, 282, 'CodeofConductAblySoftdoc1pdf', 'Code of Conduct', '', 0, 0),
(100, 0, 282, 'CodeofConductAblySoftdoc1pdf', 'Code of Conduct', '', 0, 0),
(101, 0, 284, 'CodeofConductAblySoftdoc1pdf', 'Code of Conduct', '', 0, 0),
(102, 0, 284, 'CodeofConductAblySoftdoc1pdf', 'Code of Conduct', '', 0, 0),
(103, 0, 286, 'giantdesktopdevnotes1pdf', 'giant', '', 0, 0),
(104, 0, 286, 'giantdesktopdevnotes1pdf', 'giant', '', 0, 0),
(105, 0, 287, '29227031391449783ojpg', '2922703', '', 0, 0),
(106, 0, 287, '29227031391449783ojpg', '2922703', '', 0, 0),
(107, 4, 135, 'customer_profile/askgif', 'ask.gif', '', 0, 0),
(108, 0, 288, '516W5zS8Z1LSX331BO1204203200jpg', '516W5zS8Z1L._SX331_BO1,204,203,200_.jpg', '', 0, 0),
(109, 0, 288, '516W5zS8Z1LSX331BO1204203200jpg', '516W5zS8Z1L._SX331_BO1,204,203,200_.jpg', '', 0, 0),
(110, 0, 293, 'unnamedjpg', 'unnamed.jpg', '', 0, 0),
(111, 0, 293, 'unnamedjpg', 'unnamed.jpg', '', 0, 0),
(112, 3, 35, 'doc_profile/thumbnailtiffjpg', 'thumbnail-tiff.jpg', '', 0, 0),
(113, 0, 294, 'HVTecA4LicencetooperateaforklifttruckTLILIC2001AFLYERv12013INTRANETpdf', 'H', '', 0, 0),
(114, 0, 295, '1png', '1.png', '', 0, 0),
(115, 1, 125, 'giantmobiledevnotes1pdf', 'giant-mobile-devnotes (1).pdf', '', 0, 0),
(116, 1, 125, 'Issue131png', 'Issue13 (1).png', '', 0, 0),
(117, 1, 125, 'Seekerimagepng', 'Seeker image.png', '', 0, 0),
(118, 1, 136, 'YoKartTasksdetails06Oct20151docx', 'YoKart-Tasks details-06Oct2015 (1).docx', '', 0, 0),
(119, 1, 150, '1688719XXXXXXX1404011pdf_684336', '1688719-XXXXXXX-140401 (1).pdf', '', 0, 0),
(120, 1, 162, 'Issue45png', 'Issue45.png', '', 0, 0),
(121, 1, 172, '1png_244299', '1.png', '', 0, 0),
(122, 0, 339, '1688719XXXXXXX140401pdf_162024', '1688719', '', 0, 0),
(123, 0, 339, '1688719XXXXXXX140401pdf_162024', '1688719', '', 0, 0),
(124, 0, 341, 'communication1pdf', 'communication(1).pdf', '', 0, 0),
(125, 0, 344, 'adaptive0007analyticsforCFOspdf', 'adaptive', '', 0, 0),
(126, 0, 344, 'adaptive0007analyticsforCFOspdf', 'adaptive', '', 0, 0),
(127, 1, 190, 'CodeofConductAblySoftdoc1pdf_665858', 'Code of Conduct--Ably Soft.doc (1).pdf', '', 0, 0),
(128, 1, 190, '1688719XXXXXXX140401pdf_112790', '1688719-XXXXXXX-140401.pdf', '', 0, 0),
(129, 4, 148, 'customer_profile/Desertjpg_595292', 'Desert.jpg', '', 0, 0),
(130, 4, 158, 'customer_profile/Koalajpg', 'Koala.jpg', '', 0, 0),
(131, 3, 39, 'doc_profile/06jpg', '06.jpg', '', 0, 0),
(132, 0, 358, 'AartBoxxHomePageDesignQuestionnairedoc', 'AartBoxx Home_Page_Design_Questionnaire.doc', '', 0, 0),
(133, 1, 202, 'photoJPG', 'photo.JPG', '', 0, 0),
(134, 1, 202, 'orderpng', 'order.png', '', 0, 0),
(135, 1, 202, 'AartBoxxHomePageDesignQuestionnairedoc_114938', 'AartBoxx Home_Page_Design_Questionnaire.doc', '', 0, 0),
(136, 1, 202, 'boxxartv201psd', 'boxx_art_v2_01.psd', '', 0, 0),
(137, 1, 202, 'aartrar', 'aart.rar', '', 0, 0),
(138, 0, 374, 'Chrysanthemumjpg', 'Chrysanthemum.jpg', '', 0, 0),
(139, 5, 2, 'banners/20170609salebannerjpg', '20170609-salebanner.jpg', '', 0, 0),
(140, 5, 3, 'banners/', '', '', 0, 0),
(142, 5, 6, 'banners/48_homebannerjpg', 'home-banner.jpg', '', 0, 0),
(143, 6, 1, 'medical_category/27_categmore40hsvg', 'categmore-40h.svg', '', 0, 0),
(144, 6, 42, 'medical_category/42_categ1svg', 'categ1.svg', '', 0, 0),
(145, 6, 23, 'medical_category/Image format not recognized. Please try with jpg, jpeg, gif or png file.', 'categ1-40h.svg', '', 0, 0),
(146, 0, 378, 'Chrysanthemumjpg_18607', 'Chrysanthemum.jpg', '', 0, 0),
(147, 0, 0, 'Chrysanthemumjpg_18607', 'Chrysanthemum.jpg', '', 0, 0),
(148, 0, 379, 'Chrysanthemumjpg_91469', 'Chrysanthemum.jpg', '', 0, 0),
(149, 0, 380, 'Chrysanthemumjpg_283706', 'Chrysanthemum.jpg', '', 0, 0),
(150, 0, 381, 'Chrysanthemumjpg_522797', 'Chrysanthemum.jpg', '', 0, 0),
(151, 0, 416, 'Tulipsjpg_758666', 'Tulips.jpg', '', 0, 0),
(152, 0, 459, 'Chrysanthemumjpg_271386', 'Chrysanthemum.jpg', '', 0, 0),
(153, 3, 41, 'doc_profile/10974jpg', '10974.jpg', '', 0, 0),
(154, 3, 4, 'doc_profile/doctorpng', 'doctor.png', '', 0, 0),
(155, 3, 5, 'doc_profile/10974jpg_980573', '10974.jpg', '', 0, 0),
(156, 6, 46, 'medical_category/16_categ1svg', 'categ1.svg', '', 0, 0),
(157, 3, 19, 'doc_profile/imagesjpg', 'images.jpg', '', 0, 0),
(158, 6, 2, 'medical_category/categ240hsvg', 'categ2-40h.svg', '', 0, 0),
(159, 6, 12, 'medical_category/categmore40hsvg', 'categmore-40h.svg', '', 0, 0),
(160, 6, 11, 'medical_category/categall40hsvg', 'categall-40h.svg', '', 0, 0),
(161, 6, 9, 'medical_category/categ540hsvg', 'categ5-40h.svg', '', 0, 0),
(162, 6, 8, 'medical_category/categ440hsvg', 'categ4-40h.svg', '', 0, 0),
(163, 6, 7, 'medical_category/categ340hsvg', 'categ3-40h.svg', '', 0, 0),
(164, 6, 6, 'medical_category/categ240hsvg', 'categ2-40h.svg', '', 0, 0),
(165, 6, 5, 'medical_category/categ1svg', 'categ1.svg', '', 0, 0),
(166, 6, 4, 'medical_category/categ140hsvg', 'categ1-40h.svg', '', 0, 0),
(167, 0, 496, 'homebannerjpg_645214', 'home', '', 0, 0),
(168, 0, 498, 'homebannerjpg_501956', 'home', '', 0, 0),
(169, 4, 207, 'customer_profile/maninhospitalbedjpg', 'man-in-hospital-bed.jpg', '', 0, 0),
(170, 5, 8, 'banners/aajpg', 'aa.jpg', '', 0, 0),
(171, 4, 248, 'customer_profile/2jpg', '2.jpg', '', 0, 0),
(172, 3, 43, 'doc_profile/erorjpg', 'eror.jpg', '', 0, 0),
(173, 5, 9, 'banners/E0149HemantGoeljpg', 'E0149-HemantGoel.jpg', '', 0, 0),
(174, 6, 47, 'medical_category/80f539919eeac7fa8532200b36b04cjpg', '80f539919eeac7fa8532200b36b04c.jpg', '', 0, 0),
(175, 1, 31, 'WelcomeScanjpg', 'Welcome Scan.jpg', '', 0, 0),
(176, 1, 0, 'WelcomeScanjpg_486476', 'Welcome Scan.jpg', '', 0, 0),
(177, 1, 34, 'WelcomeScanjpg_991707', 'Welcome Scan.jpg', '', 0, 0),
(178, 1, 0, 'WelcomeScanjpg_802569', 'Welcome Scan.jpg', '', 0, 0),
(179, 1, 0, 'WelcomeScanjpg_540205', 'Welcome Scan.jpg', '', 0, 0),
(180, 1, 0, 'WelcomeScanjpg_531649', 'Welcome Scan.jpg', '', 0, 0),
(181, 1, 0, 'WelcomeScanjpg_648156', 'Welcome Scan.jpg', '', 0, 0),
(182, 1, 0, 'WelcomeScanjpg_156103', 'Welcome Scan.jpg', '', 0, 0),
(183, 1, 0, 'WelcomeScanjpg_173924', 'Welcome Scan.jpg', '', 0, 0),
(184, 1, 0, 'WelcomeScanjpg_528654', 'Welcome Scan.jpg', '', 0, 0),
(185, 1, 0, 'E0149HemantGoeljpg', 'E0149-HemantGoel.jpg', '', 0, 0),
(186, 1, 0, 'E0149HemantGoeljpg_976065', 'E0149-HemantGoel.jpg', '', 0, 0),
(187, 1, 0, 'bumpergiftnigeriaPNG', 'bumper gift nigeria.PNG', '', 0, 0),
(188, 1, 0, 'E0149HemantGoeljpg1510724415', 'E0149-HemantGoel.jpg', '', 0, 0),
(189, 1, 0, 'bumpergiftnigeriaPNG1510724428', 'bumper gift nigeria.PNG', '', 0, 0),
(190, 1, 0, 'E0149HemantGoeljpg1510724435', 'E0149-HemantGoel.jpg', '', 0, 0),
(191, 1, 0, 'E0149HemantGoeljpg_890941', 'E0149-HemantGoel.jpg', '', 0, 0),
(192, 1, 0, 'E0149HemantGoeljpg_982969', 'E0149-HemantGoel.jpg', '', 0, 0),
(193, 1, 35, 'E0149HemantGoeljpg_944402', 'E0149-HemantGoel.jpg', '', 0, 0),
(194, 1, 35, 'bumpergiftnigeriaPNG_461770', 'bumper gift nigeria.PNG', '', 0, 0),
(195, 1, 35, 'E0149HemantGoeljpg_8048', 'E0149-HemantGoel.jpg', '', 0, 0),
(196, 1, 35, 'bumpergiftnigeriaPNG_424725', 'bumper gift nigeria.PNG', '', 0, 0),
(197, 1, 35, 'E0149HemantGoeljpg_136274', 'E0149-HemantGoel.jpg', '', 0, 0),
(198, 1, 35, 'bumpergiftnigeriaPNG_390091', 'bumper gift nigeria.PNG', '', 0, 0),
(199, 1, 0, 'WelcomeScanjpg_823964', 'Welcome Scan.jpg', '', 0, 0),
(200, 1, 48, 'WelcomeScanjpg_192193', 'Welcome Scan.jpg', '', 0, 0),
(201, 1, 49, 'WelcomeScanjpg_700777', 'Welcome Scan.jpg', '', 0, 0),
(202, 1, 0, 'WelcomeScanjpg_181132', 'Welcome Scan.jpg', '', 0, 0),
(203, 1, 52, 'WelcomeScanjpg_67492', 'Welcome Scan.jpg', '', 0, 0),
(204, 1, 53, 'WelcomeScanjpg_891245', 'Welcome Scan.jpg', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_language_labels`
--

CREATE TABLE `tbl_language_labels` (
  `label_id` int(11) NOT NULL,
  `label_key` varchar(255) NOT NULL,
  `label_caption_en` text NOT NULL,
  `label_caption_es` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_language_labels`
--

INSERT INTO `tbl_language_labels` (`label_id`, `label_key`, `label_caption_en`, `label_caption_es`) VALUES
(1, 'L_OUR_SERVICES', 'Our Services', 'Our Services'),
(2, 'L_ASK_QUESTION', 'Ask Question', 'Ask Question'),
(3, 'L_ASK_DOCTOR', 'Ask Doctor', 'Ask Doctor'),
(4, 'L_ONLINE_ANY_QUESTION', 'Online Any Question', 'Online Any Question'),
(5, 'L_SELECT_CATEGORY', 'Select Category', 'Select Category'),
(6, 'L_MORE', 'More', 'More'),
(7, 'L_EXPERIENCED_TEAM', 'Experienced Team', 'Experienced Team'),
(8, 'L_OUR_DOCTORS', 'Our Doctors', 'Our Doctors'),
(9, 'L_VIEW_ALL_DOCTORS', 'View All Doctors', 'View All Doctors'),
(10, 'L_SPECIALTY', 'Specialty', 'Specialty'),
(11, 'L_DEGREE', 'Degree', 'Degree'),
(12, 'L_LOCATION', 'Location', 'Location'),
(13, 'L_EXPERIENCE', 'Experience', 'Experience'),
(14, 'L_RECENT_ANSWERED', 'Recent Answered', 'Recent Answered'),
(15, 'L_REALTE_TO', 'Realte To', 'Realte To'),
(16, 'L_POSTED_BY', 'Posted By', 'Posted By'),
(17, 'L_LATEST_POSTS', 'Latest Posts', 'Latest Posts'),
(18, 'L_RECENT_NEWS', 'Recent News', 'Recent News'),
(19, 'L_READ_MORE', 'Read More', 'Read More'),
(20, 'L_EXPLORE_OUR_VIDEO', 'Explore Our Video', 'Explore Our Video'),
(21, 'L_TAKE_A_TOUR_FOR_OUR_LATEST_VIDEO', 'Take a tour for our latest video', 'Take a tour for our latest video'),
(22, 'L_MENU', 'Menu', 'Menu'),
(23, 'L_LOGIN', 'Login', 'Login'),
(24, 'L_LOGIN_TO_ACCOUNT_TO_START', 'Login to account to start', 'Login to account to start'),
(25, 'L_AS_USER', 'As User', 'As User'),
(26, 'L_AS_DOCTOR', 'As Doctor', 'As Doctor'),
(27, 'L_OR', 'OR', 'OR'),
(28, 'L_ENTER_YOUR_INFORMATION', 'Enter your information', 'Enter your information'),
(29, 'L_EMAIL', 'Email', 'Email'),
(30, 'L_PASSWORD', 'Password', 'Password'),
(31, 'L_REMEMBER_ME', 'Remember Me', 'Remember Me'),
(32, 'L_FORGOT_PASSWORD', 'Forgot Password', 'Forgot Password'),
(33, 'L_THE_PROCESS_IS_VERY_SIMPLE', 'The process is very simple', 'The process is very simple'),
(34, 'L_ASK_YOUR', 'Ask your', 'Ask your'),
(35, 'L_QUESTION', 'Question', 'Question'),
(36, 'L_ASK_YOUR_CONTENT', 'Ask your content', 'Ask your content'),
(37, 'L_GET_YOUR_ANSWER', 'Get your answer', 'Get your answer'),
(38, 'L_CONTACT_US', 'Contact US', 'Contact US'),
(39, 'L_WE_SHALL_GET_IN_TOUCH_WITH_YOU_IN_NEXT_24_HOURS', 'We shall get in touch with you in next 24 Hours', 'We shall get in touch with you in next 24 Hours'),
(40, 'L_NAME', 'Name', 'Name'),
(41, 'L_FORGOT_PASSWORD?', 'Forgot Password?', 'Forgot Password?'),
(42, 'L_ENTER_THE_E-MAIL_ADDRESS_ASSOCIATED_WITH_YOUR_ACCOUNT._CLICK_SUBMIT_TO_HAVE_PASSWORD_RESET_LINK_E-MAILED_TO_YOU.', 'Enter The E-mail Address Associated With Your Account. Click Submit To Have Password Reset Link E-mailed To You.', 'Enter The E-mail Address Associated With Your Account. Click Submit To Have Password Reset Link E-mailed To You.'),
(43, 'L_BACK_TO_LOGIN', 'Back to login', 'Back to login'),
(44, 'L_CLICK_HERE', 'Click here', 'Click here'),
(45, 'L_100%_PRIVACY_PROTECTION', '100% Privacy Protection', '100% Privacy Protection'),
(46, 'L_WE_MAINTAIN_YOUR_PRIVACY_AND_DATA_CONFIDENTIALITY', 'We maintain your privacy and data confidentiality', 'We maintain your privacy and data confidentiality'),
(47, 'L_VERIFIED_DOCTORS', 'Verified Doctors', 'Verified Doctors'),
(48, 'L_ALL_DOCTORS_GO_THROUGH_A_STRINGENT_VERIFICATION_PROCESS', 'All Doctors go through a stringent verification process', 'All Doctors go through a stringent verification process'),
(49, 'L_QUICK_RESPONSES', 'Quick responses', 'Quick responses'),
(50, 'L_YOU_WILL_RECEIVE_RESPONSES_TO_YOUR_HEALTH_QUERIES_WITHIN_24_HOURS', 'You will receive responses to your health queries within 24 hours', 'You will receive responses to your health queries within 24 hours'),
(51, 'M_ERROR_PLEASE_VERIFY_YOURSELF', 'ERROR PLEASE VERIFY YOURSELF', 'ERROR PLEASE VERIFY YOURSELF'),
(52, 'L_FREQUENTLY_ASKED_QUESTIONS', 'Frequently Asked Questions', 'Frequently Asked Questions'),
(53, 'L_BROWSE_BY_TOPIC', 'Browse by Topic', 'Browse by Topic'),
(54, 'L_QUESTIONS', 'Questions', 'Questions'),
(55, 'L_VIEW_ALL', 'View All', 'View All'),
(56, 'L_ALL_MEDICAL_SERVICES', 'All Medical Services', 'All Medical Services'),
(57, 'L_FEATURED_BY_DEPARTMENT', 'Featured by Department', 'Featured by Department'),
(58, 'L_BEST_SERVICES_FOR_YOU', 'Best Services for you', 'Best Services for you'),
(59, 'L_GETMEDZ,_PROVIDED_YOU_BEST_MEDICAL_SERVICES', 'Getmedz, provided you best medical services', 'Getmedz, provided you best medical services'),
(60, 'L_NOW_AVAILABLE_24X7_FOR_ANY_MEDICAL_RELATED_QUERIES/INFORMATION', 'Now available 24X7 for any medical related queries/information', 'Now available 24X7 for any medical related queries/information'),
(61, 'L_ANSWERS', 'Answers', 'Answers'),
(62, 'L_GENDER', 'Gender', 'Gender'),
(63, 'L_EDUCTAION', 'Eductaion', 'Eductaion'),
(64, 'L_I_ENJOY_BEING_AN', 'I enjoy being an GetMedz  becasue  it is speciality primary care lorem ipsum simply dummy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', 'I enjoy being an GetMedz  becasue  it is speciality primary care lorem ipsum simply dummy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).'),
(65, 'L_BIOGRAPHY', 'Biography', 'Biography'),
(66, 'L_WORK_EXPERIENCE', 'Work Experience', 'Work Experience'),
(67, 'L_RELATED_DOCTORS', 'Related Doctors', 'Related Doctors'),
(68, 'L_HAVING SAME FUNCTIONALITY', 'Having same functionality', 'Having same functionality'),
(69, 'L_BEST_DOCTORS_FOR_YOU', 'Best Doctors for you', 'Best Doctors for you'),
(70, 'L_CHECKOUT_THE_LIST_OF_ALL_OUR_EXPRIENCED_DOCTORS_TEAM_WITH_DIFFERENT_SPECIALTY', 'Checkout the list of all our exprienced doctors team with different specialty', 'Checkout the list of all our exprienced doctors team with different specialty'),
(71, 'L_YEARS OF EXPERIENCE', 'Years of Experience', 'Years of Experience'),
(72, 'L_QUALIFIED_DOCTOR', 'QUALIFIED Doctor', 'QUALIFIED Doctor'),
(73, 'L_WE_ARE_HAVING_RELIABLE_AND_TRUSTED_TEAM', 'We are having Reliable and Trusted Team', 'We are having Reliable and Trusted Team'),
(74, 'ALL DOCTORS', '', ''),
(75, 'L_ALL_DOCTORS', 'All Doctors', 'All Doctors'),
(76, 'L_SORT_BY', 'Sort By', 'Sort By'),
(77, 'L_EXPERIENCE_ASCENDING', 'Experience Ascending', 'Experience Ascending'),
(78, 'L_EXPERIENCE_DESCENDING', 'Experience Descending', 'Experience Descending'),
(79, 'M_NO_DOCTOR_AVAILABLE', 'No Doctor Available', 'No Doctor Available'),
(80, 'L_FILTERS', 'Filters', 'Filters'),
(81, 'L_NAME_OR_KEYWORD', 'Name or Keyword', 'Name or Keyword'),
(82, 'L_SPECIALTY_OR_PROGRAM', 'Specialty or Program', 'Specialty or Program'),
(83, 'L_LOCATIONS', 'Locations', 'Locations'),
(84, 'L_LANGUAGES', 'Languages', 'Languages'),
(85, 'L_HELP_DOCTORS_TO_UNDERSTAND_YOUR_PROBLEM_BETTER', 'Help Doctors to understand your problem better', 'Help Doctors to understand your problem better'),
(86, 'L_VIEW_ATTACHMENT', 'View Attachment', 'View Attachment'),
(87, 'L_MEDICAL HISTORY', 'Medical History', 'Medical History'),
(88, 'L_ENTER_YOUR_PERSONAL_INFORMATION', 'Enter your personal information', 'Enter your personal information'),
(89, 'L_SELECT_GENDER', 'Select Gender', 'Select Gender'),
(90, 'L_SELECT_AGE', 'Select Age', 'Select Age'),
(91, 'L_WEIGHT_(IN_KGS)', 'Weight (in Kgs)', 'Weight (in Kgs)'),
(92, 'L_SELECT_LOCATION', 'Select Location', 'Select Location'),
(93, 'L_PHONE_NUMBER', 'Phone Number', 'Phone Number'),
(94, 'L_BEST_AVAILABLE_DOCTOR', 'Best Available Doctor', 'Best Available Doctor'),
(95, 'L_DOCTORS_AVAILABLE', 'Doctors Available', 'Doctors Available'),
(96, 'L_I_AGREE_TO_GETMEDZ', 'I agree to Getmedz', 'I agree to Getmedz'),
(97, 'L_TERMS_&_CONDITIONS', 'Terms & Conditions', 'Terms & Conditions'),
(98, 'L_VIEW_PROFILE', 'View Profile', 'View Profile'),
(99, 'L_PREVIOUS', 'Previous', 'Previous'),
(100, 'L_CHOOSE_PLAN_FROM_THIS_LIST', 'Choose Plan from this list', 'Choose Plan from this list'),
(101, 'L_MOST_POPULAR', 'Most Popular', 'Most Popular'),
(102, 'L_NEXT_STEP', 'Next Step', 'Next Step'),
(103, 'L_CHOOSE_YOUR_PAYMENT_METHOD', 'Choose your payment method', 'Choose your payment method'),
(104, 'L_WE_ARE_REDIRECTING_YOU!!', 'WE ARE REDIRECTING YOU!!', 'WE ARE REDIRECTING YOU!!'),
(105, 'L_PLEASE_WAIT', 'PLEASE WAIT', 'PLEASE WAIT'),
(106, 'L_STILL_WAITING', 'STILL WAITING', 'STILL WAITING'),
(107, 'M_INVALID_REQUEST', 'INVALID REQUEST', 'INVALID REQUEST'),
(108, 'L_SUPPORT', 'Support', 'Support'),
(109, 'L_YOUR_ORDER_HAS_BEEN_SUCCESSFULLY_PLACED.', 'YOUR ORDER HAS BEEN SUCCESSFULLY PLACED.', 'YOUR ORDER HAS BEEN SUCCESSFULLY PLACED.'),
(110, 'L_POST_ANOTHER_QUESTION', 'Post Another Question', 'Post Another Question'),
(111, 'L_SEARCH_TEXT', 'Search Text', 'Search Text'),
(112, 'L_SEARCH', 'Search', 'Search'),
(113, 'L_CONTRIBUTE', 'Contribute', 'Contribute'),
(114, 'L_CATEGORIES', 'Categories', 'Categories'),
(115, 'L_ARCHIVES', 'Archives', 'Archives'),
(116, 'L_RECENT_POSTS', 'Recent Posts', 'Recent Posts'),
(117, 'L_TOTAL_VIEWS', 'Total Views', 'Total Views'),
(118, 'L_AUTHOR', 'Author', 'Author'),
(119, 'L_CLICK_TO_CONTINUE..', 'Click to Continue..', 'Click to Continue..'),
(120, 'L_FIRST_NAME', 'First Name', 'First Name'),
(121, 'L_FIRST_NAME*', 'First Name*', 'First Name*'),
(122, 'L_LAST_NAME', 'Last Name', 'Last Name'),
(123, 'L_LAST_NAME*', 'Last Name*', 'Last Name*'),
(124, 'L_EMAIL_ADDRESS', 'Email Address', 'Email Address'),
(125, 'L_EMAIL_ADDRESS*', 'Email Address*', 'Email Address*'),
(126, 'L_PHONE_NO', 'Phone No', 'Phone No'),
(127, 'L_PHONE_NO.', 'Phone No.', 'Phone No.'),
(128, 'L_UPLOAD_FILE', 'Upload File', 'Upload File'),
(129, 'L_NAME*', 'Name*', 'Name*'),
(130, 'L_EMAIL*', 'Email*', 'Email*'),
(131, 'L_COMMENT', 'Comment', 'Comment'),
(132, 'L_COMMENT*', 'Comment*', 'Comment*'),
(133, 'L_NO_BLOG_POST_FOUND_WITH_SEARCH_CRITERIA!!', 'No Blog Post Found With Search Criteria!!', 'No Blog Post Found With Search Criteria!!'),
(134, 'L_TRY_TO_SEARCH_WITH_DIFFERENT_KEYWORD', 'Try To Search With Different Keyword', 'Try To Search With Different Keyword'),
(135, 'L_BACK_TO_BLOG', 'Back To Blog', 'Back To Blog'),
(136, 'L_SUBMIT', 'Submit', 'Submit'),
(137, 'L_CONTRIBUTION_FORM', 'Contribution Form', 'Contribution Form'),
(138, 'M_ERROR_FILE_SIZE_SHOULD_NOT_EXCEED_{VAR}_MB', 'ERROR FILE SIZE SHOULD NOT EXCEED {VAR} MB', 'ERROR FILE SIZE SHOULD NOT EXCEED {VAR} MB'),
(139, 'M_ERROR_VALID_FILES_FOR_BLOG_CONTRIBUTION', 'ERROR VALID FILES FOR BLOG CONTRIBUTION', 'ERROR VALID FILES FOR BLOG CONTRIBUTION'),
(140, 'L_SEE_MORE_AT', 'See more at', 'See more at'),
(141, 'L_VIEWS', 'Views', 'Views'),
(142, 'L_EXPLAIN_YOUR_MEDICAL_HISTORY_AND_SYMPTOMS', 'Explain your medical history and symptoms', 'Explain your medical history and symptoms'),
(143, 'L_FACEBOOK', 'Facebook', 'Facebook'),
(144, 'L_MY_QUESTIONS', 'My Questions', 'My Questions'),
(145, 'L_ASK_A_NEW_QUESITON', 'Ask a New Quesiton', 'Ask a New Quesiton'),
(146, 'L_USER_PROFILE', 'User Profile', 'User Profile'),
(147, 'L_LOG_OUT', 'Log Out', 'Log Out'),
(148, 'L_DASHBOARD', 'Dashboard', 'Dashboard'),
(149, 'L_MY_UNANSWERED_QUESTIONS', 'My Unanswered Questions', 'My Unanswered Questions'),
(150, 'L_MY_ANSWERED_QUESTIONS', 'My Answered Questions', 'My Answered Questions'),
(151, 'L_MY_CLOSED_QUESTIONS', 'My Closed Questions', 'My Closed Questions'),
(152, 'L_ALL_QUESTIONS', 'All Questions', 'All Questions'),
(153, 'L_EDIT_PROFILE', 'Edit Profile', 'Edit Profile'),
(154, 'L_LOGOUT', 'Logout', 'Logout'),
(155, 'L_MY_TOTAL_QUESTIONS', 'My Total Questions', 'My Total Questions'),
(156, 'L_ANSWERED_ON', 'Answered On', 'Answered On'),
(157, 'L_ACCEPT_&_REPLY', 'Accept & Reply', 'Accept & Reply'),
(158, 'L_ACCEPT_THIS_QUESTION', 'Accept this Question', 'Accept this Question'),
(159, 'L_PATIENT_FOLLOW_UP_QUESTIONS', 'Patient Follow Up Questions', 'Patient Follow Up Questions'),
(160, 'L_HOME', 'Home', 'Home'),
(161, 'L_LATEST_QUESTIONS', 'Latest Questions', 'Latest Questions'),
(162, 'L_ASKED_ON', 'Asked On', 'Asked On'),
(163, 'L_VIEW_ANSWER', 'View Answer', 'View Answer'),
(164, 'L_YOU_DO_NOT_ANSWERED_ANY_QUESTION_YET', 'You do not answered any question yet', 'You do not answered any question yet'),
(165, 'L_NO_DOCTORS_AVAILABLE', 'No Doctors Available', 'No Doctors Available'),
(166, 'L_ACCEPTED', 'ACCEPTED', 'ACCEPTED'),
(167, 'L_VIEW', 'VIEW', 'VIEW'),
(168, 'L_THIS_QUESTION_HAS_NOT_BEEN_ANSWERED_BY_YOU.', 'THIS QUESTION HAS NOT BEEN ANSWERED BY YOU.', 'THIS QUESTION HAS NOT BEEN ANSWERED BY YOU.'),
(169, 'L_REJECT_QUESTION', 'REJECT QUESTION', 'REJECT QUESTION'),
(170, 'L_VIEW_AND_REPLY', 'VIEW AND REPLY', 'VIEW AND REPLY'),
(171, 'L_UPDATE_PROFILE_PICTURE', 'Update profile picture', 'Update profile picture'),
(172, 'L_ENTER_YOUR_PROFILE_INFORMATION', 'Enter your profile information', 'Enter your profile information'),
(173, 'L_CATEGORY', 'Category', 'Category'),
(174, 'L_SUMMARY_OF_QUALIFICATION', 'Summary Of Qualification', 'Summary Of Qualification'),
(175, 'L_ADDRESS', 'Address', 'Address'),
(176, 'L_HOUSE_NUMBER', 'House Number', 'House Number'),
(177, 'L_CITY', 'City', 'City'),
(178, 'L_STATE', 'State', 'State'),
(179, 'L_PINCODE', 'PinCode', 'PinCode'),
(180, 'L_EXPERIENCE_IN_YEAR', 'Experience In Year', 'Experience In Year'),
(181, 'L_EXPERIENCE_SUMMARY', 'Experience Summary', 'Experience Summary'),
(182, 'L_MEDICAL_OR_GRADUATE_SCHOOL', 'Medical or Graduate School', 'Medical or Graduate School'),
(183, 'L_MEDICAL_DEGREE', 'Medical degree', 'Medical degree'),
(184, 'L_MEDICAL_YEAR', 'Medical Year', 'Medical Year'),
(185, 'L_LICENSE_NO', 'License No', 'License No'),
(186, 'L_MEDICAL_STATE', 'Medical State', 'Medical State'),
(187, 'L_CHANGE_PASSWORD', 'Change Password', 'Change Password'),
(188, 'L_UPDATE_PASSWORD', 'Update Password', 'Update Password'),
(189, 'L_CURRENT_PASSWORD', 'Current Password', 'Current Password'),
(190, 'L_NEW_PASSWORD', 'New Password', 'New Password'),
(191, 'L_CONFIRM_NEW_PASSWORD', 'Confirm New Password', 'Confirm New Password'),
(192, 'L_MY_ASKED_QUESTIONS', 'My Asked Questions', 'My Asked Questions'),
(193, 'L_MY_REPLIED_QUESTIONS', 'My Replied Questions', 'My Replied Questions'),
(194, 'L_MY_PENDING_QUESTIONS', 'My Pending Questions', 'My Pending Questions'),
(195, 'L_PENDING_QUESTIONS', 'Pending Questions', 'Pending Questions'),
(196, 'L_ASK_A_NEW_QUESTION', 'Ask A New Question', 'Ask A New Question'),
(197, 'L_SEARCH_BY', 'Search By', 'Search By'),
(198, 'L_TO_VIEW_DOCTOR_RESPONSE.', 'To View Doctor Response.', 'To View Doctor Response.'),
(199, 'L_RATE_THE_DOCTOR', 'Rate the Doctor', 'Rate the Doctor'),
(200, 'L_CLOSE_QUESTION_AND', 'Close Question And', 'Close Question And'),
(201, 'L_WRITE_A_REVIEW', 'Write a Review', 'Write a Review'),
(202, 'L_QUESTION_STATUS', 'Question Status', 'Question Status'),
(203, 'L_YOU_HAVE', 'You have', 'You have'),
(204, 'L_NEW_ANSWER', 'New Answer', 'New Answer'),
(205, 'L_REVIEW_FULL_QUESTION/ANSWER ', 'Review Full Question/Answer ', 'Review Full Question/Answer '),
(206, 'L_YOU_DO_NOT_HAVE_ANY_FOLLOW_UP_QUESTIONS', 'You Do not have any follow up questions', 'You Do not have any follow up questions'),
(207, 'L_MY_ACCEPTED_QUESTIONS', 'My Accepted Questions', 'My Accepted Questions'),
(208, 'L_YOU_HAVE_', 'You have', 'You have '),
(209, '', 'You do not have any question yet', ''),
(210, 'LBL_MEDICAL_CATEGORY', 'Medical Category', 'Medical Category'),
(211, 'MEDICAL QUESTION', '', ''),
(212, 'LBL_MEDICAL_QUESTION', 'Medical Question', 'Medical Question'),
(213, 'LBL_GET_YOUR_ANSWER', 'Get your answer', 'Get your answer'),
(214, 'LBL_MEDICAL_HISTORY', 'Medical History', 'Medical History'),
(215, 'LBL_NAME', 'Name', 'Name'),
(216, 'LBL_AGE', 'Age', 'Age'),
(217, 'LBL_WEIGHT_(IN_KGS)', 'Weight (in Kgs)', 'Weight (in Kgs)'),
(218, 'LBL_GENDER', 'Gender', 'Gender'),
(219, 'LBL_SELECT_STATE', 'Select State', 'Select State'),
(220, 'LBL_PHONE_NUMBER', 'Phone Number', 'Phone Number'),
(221, 'LBL_EMAIL', 'Email', 'Email'),
(222, 'LBL_NEXT_STEP', 'Next Step', 'Next Step'),
(223, 'L_YOU_DO_NOT_HAVE_ANY_QUESTION_YET', 'You do not have any question yet', 'You do not have any question yet'),
(224, 'LBL_EXPLAIN_YOUR_MEDICAL_HISTORY_AND_SYMPTOMS', 'Explain your medical history and symptoms', 'Explain your medical history and symptoms'),
(225, 'LBL_MEDICAL HISTORY', 'Medical History', 'Medical History'),
(226, 'LBL_ENTER_YOUR_PERSONAL_INFORMATION', 'Enter your personal information', 'Enter your personal information'),
(227, 'LBL_SELECT_GENDER', 'Select Gender', 'Select Gender'),
(228, 'LBL_SELECT_AGE', 'Select Age', 'Select Age'),
(229, 'LBL_SELECT_LOCATION', 'Select Location', 'Select Location'),
(230, 'LBL_I_AGREE_TO_GETMEDZ', 'I agree to Getmedz', 'I agree to Getmedz'),
(231, 'LBL_PREVIOUS', 'Previous', 'Previous'),
(232, 'DOCTOR_SELECTION', 'Selection', 'Selection'),
(233, 'LBL_SUBSCRIPTION', 'Subscription', 'Subscription'),
(234, 'L_COMMENTS', 'Comments', 'Comments'),
(235, 'LBL_FIRST_NAME', 'First Name', 'First Name'),
(236, 'LBL_LAST_NAME', 'Last Name', 'Last Name'),
(237, 'LBL_PHONE_NO.', 'Phone No.', 'Phone No.'),
(238, 'M_SUCCESS_DETAILS_SAVED', 'SUCCESS DETAILS SAVED', 'SUCCESS DETAILS SAVED'),
(239, 'L_RESET_PASSWORD', 'Reset Password', 'Reset Password'),
(240, 'LBL_ENTER_THE_NEW_PASSWORD_ASSOCIATED_WITH_YOUR_ACCOUNT._CLICK_RESET_BUTTON_TO_CHANGE_YOUR_PASSWORD.', 'Enter the new password Associated With Your Account. Click reset button to change your password.', 'Enter the new password Associated With Your Account. Click reset button to change your password.'),
(241, 'LBL_CONFIRM_PASSWORD', 'Confirm Password', 'Confirm Password'),
(242, 'L_ADD_YOUR_COMMENT', 'Add Your Comment', 'Add Your Comment'),
(243, 'LBL_NEXT', 'Next', 'Next'),
(244, 'L_YOUR_ORDER_HAS_BEEN_PLACED_SUCCESSFULLY.', 'YOUR ORDER HAS BEEN PLACED SUCCESSFULLY.', 'YOUR ORDER HAS BEEN PLACED SUCCESSFULLY.'),
(245, 'LBL_CONGRATULATIONS', 'Congratulations', 'Congratulations'),
(246, 'LBL_PAYMENT_PROCESS', 'Payment Process', 'Payment Process'),
(247, 'LBL_PAYMENT_PROCESSING', 'Payment Processing', 'Payment Processing'),
(248, 'LBL_CONFIRM_YOUR_ORDER', 'Confirm Your Order', 'Confirm Your Order'),
(249, 'LBL_ASKED_ON', 'Asked On', 'Asked On'),
(250, 'LBL_ACCEPT_&_REPLY', 'Accept & Reply', 'Accept & Reply'),
(251, 'LBL_REPLY', 'Reply', 'Reply'),
(252, 'LBL_QUESTION_HAS_BEEN_ACCEPTED_SUCCESSFULLY', 'Question has been Accepted successfully', 'Question has been Accepted successfully'),
(253, 'LBL_VIEW_THIS_QUESTION', 'View this Question', 'View this Question'),
(254, 'LBL_ACCEPT_THIS_QUESTION', 'Accept this Question', 'Accept this Question'),
(255, 'LBL_ACCEPTED', 'Accepted', 'Accepted'),
(256, 'LBL_YOU_HAVE_ALRADY_ACCEPTED_THIS_QUESTION', 'You have alrady accepted this question', 'You have alrady accepted this question'),
(257, 'LBL_VIEW_&_REPLY', 'View & Reply', 'View & Reply'),
(258, 'LBL_ESCLATE_TO_ADMIN', 'Esclate to Admin', 'Esclate to Admin'),
(259, 'LBL_ESCLATED_TO_ADMIN', 'Esclated to Admin', 'Esclated to Admin'),
(260, 'LBL_QUESTION_HAS_BEEN_ESCLATED_TO_ADMIN_SUCCESSFULLY', 'Question has been esclated to admin successfully', 'Question has been esclated to admin successfully'),
(261, 'L_YOU_DO_NOT_HAVE_ANY_UNANSWERED_ANY_QUESTION_YET', 'You do not have any unanswered any question yet', 'You do not have any unanswered any question yet'),
(262, 'LBL_PATIENT_HEALTH_ISSUE', 'Patient Health issue', 'Patient Health issue'),
(263, 'LBL_QUESTION', 'Question', 'Question'),
(264, 'LBL_ASKED_BY', 'Asked By', 'Asked By'),
(265, 'LBL_ON', 'On', 'On'),
(266, 'LBL_COMMUNICATION_THREAD', 'Communication Thread', 'Communication Thread'),
(267, 'LBL_WEIGHT', 'Weight', 'Weight'),
(268, 'LBL_MEMBER_SINCE', 'Member Since', 'Member Since'),
(269, 'LBL_ANSWERED_ON', 'Answered on', 'Answered on'),
(270, 'LBL_VIEW', 'View', 'View'),
(271, 'LBL_FOLLOWEDUP_ON', 'Followedup on', 'Followedup on'),
(272, 'LBL_QUESTION_CLOSED', 'QUESTION CLOSED', 'QUESTION CLOSED'),
(273, 'LBL_QUESTION_HAS_BEEN_REASSIGNED_TO_SOME_OTHER_DOCTOR', 'QUESTION HAS BEEN REASSIGNED TO SOME OTHER DOCTOR', 'QUESTION HAS BEEN REASSIGNED TO SOME OTHER DOCTOR'),
(274, 'LBL_INVALID_ACCESS', 'Invalid Access', 'Invalid Access'),
(275, 'LBL_CLOSED', 'Closed', 'Closed'),
(276, 'LBL_CLOSED_ON', 'Closed on', 'Closed on'),
(277, 'LBL_PLEASE_LOGIN_WITH_CUTOMER_ACCOUNT', 'Please login with cutomer account', 'Please login with cutomer account'),
(278, 'LBL_NO_QUESTIONS_FOUND', 'NO Questions Found', 'NO Questions Found');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_medical_categories`
--

CREATE TABLE `tbl_medical_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_active` tinyint(1) NOT NULL,
  `category_deleted` tinyint(1) NOT NULL,
  `category_image_path` varchar(200) NOT NULL,
  `category_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_medical_categories`
--

INSERT INTO `tbl_medical_categories` (`category_id`, `category_name`, `category_active`, `category_deleted`, `category_image_path`, `category_description`) VALUES
(1, 'General Medical', 1, 0, '27_categmore40hsvg', 'General Medical'),
(2, 'Mental Health', 1, 0, 'categ240hsvg', 'Mental Health'),
(4, 'Sexual', 1, 1, 'categ140hsvg', 'Sexual'),
(5, 'Health', 1, 0, 'categ1svg', 'Health'),
(6, 'Pediatrics', 1, 0, 'categ240hsvg', 'Pediatrics'),
(7, 'Cardiology', 1, 0, 'categ340hsvg', 'Cardiology'),
(8, 'Dental', 1, 0, 'categ440hsvg', 'Dental'),
(9, 'Dermatology', 1, 0, 'categ540hsvg', 'Dermatology'),
(10, 'OB GYN', 0, 1, '', ''),
(11, 'Urology', 1, 0, 'categall40hsvg', 'UROLOGY'),
(12, 'Other', 1, 0, 'categmore40hsvg', 'Other category'),
(13, 'Test category', 0, 1, '', ''),
(14, 'Test category', 1, 1, '', ''),
(15, 'Test category 1', 0, 1, '', ''),
(16, 'Test category', 0, 1, '', ''),
(17, 'Health', 1, 1, '', ''),
(18, 'Health', 0, 1, '', ''),
(19, 'Test category', 0, 1, '', ''),
(20, 'sda', 1, 1, '', ''),
(21, 'General', 0, 1, '', ''),
(22, 'Other', 0, 1, '', ''),
(23, 'General', 0, 1, 'Image format not recognized. Please try with jpg, jpeg, gif or png file.', 'teste test test'),
(24, 'others1fd', 0, 1, '', ''),
(25, 'astama', 1, 1, '', ''),
(26, 'de', 1, 1, '', ''),
(27, 'Demo', 1, 1, '', ''),
(28, 'dsfgdsg', 1, 1, '', ''),
(29, 'dsfgdsg', 1, 1, '', ''),
(30, 'Abhitest', 1, 1, '', ''),
(31, 'abhitest2', 1, 1, '', ''),
(32, 'dsdsd', 1, 1, '', ''),
(33, 'dsdsd', 1, 1, '', ''),
(34, 'dsdsad', 1, 1, '', ''),
(35, 'dsdsad', 1, 1, '', ''),
(36, 'dasdsadasd', 1, 1, '', ''),
(37, 'dsada', 1, 1, '', ''),
(38, 'dsddsddsdds3434', 1, 1, '', ''),
(39, 'Plant patheology', 0, 1, '', ''),
(40, 'other', 0, 1, '', ''),
(41, 'general', 1, 1, '', ''),
(42, 'general', 0, 1, '42_categ1svg', 'sss'),
(43, 'test1', 1, 1, '', ''),
(44, 'test1', 1, 1, '', ''),
(45, 'test', 0, 1, '', ''),
(46, 'sas', 1, 1, '16_categ1svg', 'ssasasasas\r\na\r\ns\r\nas'),
(47, 'new category', 1, 1, '80f539919eeac7fa8532200b36b04cjpg', 'sdfasf');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_navigations`
--

CREATE TABLE `tbl_navigations` (
  `nav_id` int(11) NOT NULL,
  `nav_name` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `nav_status` tinyint(3) DEFAULT NULL,
  `nav_ismultilevel` tinyint(1) NOT NULL,
  `nav_type` tinyint(1) NOT NULL,
  `nav_is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `tbl_navigations`
--

INSERT INTO `tbl_navigations` (`nav_id`, `nav_name`, `nav_status`, `nav_ismultilevel`, `nav_type`, `nav_is_deleted`) VALUES
(1, 'Header Navigation', 1, 0, 1, 0),
(2, 'Footer Navigation', 1, 0, 0, 0),
(4, 'Footer Our Services', 1, 0, 2, 0),
(5, 'Footer Quick Links', 1, 0, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_nav_links`
--

CREATE TABLE `tbl_nav_links` (
  `nl_id` int(11) NOT NULL,
  `nl_caption` text COLLATE latin1_general_ci NOT NULL,
  `nl_cms_page_id` int(11) NOT NULL,
  `nl_html` text COLLATE latin1_general_ci NOT NULL,
  `nl_target` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `nl_type` int(11) NOT NULL COMMENT '0->CMS page, 1->custom',
  `nl_nav_id` int(11) NOT NULL,
  `nl_parent_id` int(11) NOT NULL,
  `nl_code` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `nl_bullet_image` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `nl_login_protected` tinyint(1) NOT NULL,
  `nl_display_order` int(11) NOT NULL,
  `nl_is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `tbl_nav_links`
--

INSERT INTO `tbl_nav_links` (`nl_id`, `nl_caption`, `nl_cms_page_id`, `nl_html`, `nl_target`, `nl_type`, `nl_nav_id`, `nl_parent_id`, `nl_code`, `nl_bullet_image`, `nl_login_protected`, `nl_display_order`, `nl_is_deleted`) VALUES
(2, 'Home', 11, '{SITEROOT}', '_self', 2, 1, 0, '', '', 2, 1, 0),
(3, 'Doctors', 27, '{SITEROOT}doctors', '_self', 2, 1, 0, '', '', 2, 3, 0),
(5, 'Blog', 12, '{SITEROOT}blog', '_self', 2, 1, 0, '', '', 2, 5, 0),
(6, 'Terms of Use', 23, '', '_self', 2, 2, 0, '', '', 2, 1, 0),
(8, 'Careers', 6, '', '_self', 0, 2, 0, '', '', 0, 3, 0),
(15, 'All Services', 27, '{SITEROOT}services', '_self', 2, 4, 0, '', '', 0, 1, 0),
(18, 'Privacy Policy', 28, '', '_self', 0, 5, 0, '', '', 0, 1, 0),
(19, 'Terms & Conditions', 23, '', '_self', 0, 5, 0, '', '', 0, 2, 0),
(20, 'About us', 27, '', '_self', 0, 5, 0, '', '', 0, 3, 0),
(24, 'Services', 27, '{SITEROOT}services', '_self', 2, 1, 0, '', '', 1, 2, 0),
(25, 'Contact', 11, '{SITEROOT}site/contact', '_self', 2, 1, 0, '', '', 2, 6, 0),
(34, 'Privacy Policy', 28, '', '_self', 0, 2, 0, '', '', 2, 2, 0),
(37, 'FAQs', 27, '{SITEROOT}faqs', '_blank', 2, 1, 0, '', '', 0, 4, 0),
(38, 'All Doctors', 27, '{SITEROOT}doctors/lists', '_self', 2, 4, 0, '', '', 0, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE `tbl_orders` (
  `order_id` varchar(255) NOT NULL,
  `order_user_id` int(11) NOT NULL,
  `order_type` int(11) NOT NULL COMMENT '0=>question, 1=>Subscription',
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_net_amount` decimal(10,2) NOT NULL,
  `order_paid` tinyint(4) NOT NULL,
  `order_plan_id` int(11) NOT NULL,
  `order_comments` text NOT NULL,
  `order_admin_comments` text NOT NULL,
  `order_payment_mode` int(11) NOT NULL COMMENT '0=>Paypal,1=>subscription'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_orders`
--

INSERT INTO `tbl_orders` (`order_id`, `order_user_id`, `order_type`, `order_date`, `order_net_amount`, `order_paid`, `order_plan_id`, `order_comments`, `order_admin_comments`, `order_payment_mode`) VALUES
('AD1510634556213', 1, 1, '2017-11-14 04:42:36', '0.00', 1, 13, '', '', 0),
('AD1510634711473', 1, 1, '2017-11-14 04:45:11', '0.00', 1, 13, '', '', 0),
('AD1510634789194', 1, 1, '2017-11-14 04:46:29', '9.00', 1, 1, '', '', 0),
('AD151066137871', 1, 1, '2017-11-14 12:09:38', '0.00', 1, 13, '', '', 0),
('AD1512366911310', 2, 1, '2017-12-04 05:55:11', '0.00', 1, 13, '', '', 0),
('AD151263159713', 3, 1, '2017-12-07 07:26:37', '9.00', 0, 1, '', '', 0),
('AD1512717881187', 4, 1, '2017-12-08 07:24:41', '0.00', 1, 13, '', '', 0),
('AD1512720264985', 4, 1, '2017-12-08 08:04:24', '0.00', 1, 13, '', '', 0),
('AD1512721118126', 4, 1, '2017-12-08 08:18:38', '0.00', 1, 13, '', '', 0),
('AD1514875510197', 5, 1, '2018-01-02 06:45:10', '0.00', 1, 13, '', '', 0),
('AD1514875576230', 6, 1, '2018-01-02 06:46:16', '9.00', 1, 1, '', '', 0),
('AD1514877166385', 7, 1, '2018-01-02 07:12:46', '9.00', 1, 1, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_questions`
--

CREATE TABLE `tbl_order_questions` (
  `orquestion_id` int(11) NOT NULL,
  `orquestion_order_id` varchar(15) NOT NULL,
  `orquestion_question` text NOT NULL,
  `orquestion_med_category` int(11) NOT NULL,
  `orquestion_age` varchar(100) NOT NULL,
  `orquestion_med_history` text NOT NULL,
  `orquestion_gender` tinyint(2) NOT NULL COMMENT '1=>male 2=>female',
  `orquestion_seen_doctor` tinyint(4) NOT NULL COMMENT '0=>no ,1=>yes',
  `orquestion_state` int(11) NOT NULL,
  `orquestion_doctor_id` int(11) NOT NULL,
  `orquestion_status` int(11) NOT NULL COMMENT 'Assigned, replied, reply accepted',
  `orquestion_last_updated` datetime NOT NULL,
  `orquestion_reply_status` int(11) NOT NULL,
  `orquestion_replied_at` datetime NOT NULL,
  `orquestion_doctor_accepted_at` datetime NOT NULL,
  `orquestion_weight` varchar(100) NOT NULL,
  `orquestion_name` varchar(100) NOT NULL,
  `orquestion_phone` varchar(100) NOT NULL,
  `orquestion_asked_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_order_questions`
--

INSERT INTO `tbl_order_questions` (`orquestion_id`, `orquestion_order_id`, `orquestion_question`, `orquestion_med_category`, `orquestion_age`, `orquestion_med_history`, `orquestion_gender`, `orquestion_seen_doctor`, `orquestion_state`, `orquestion_doctor_id`, `orquestion_status`, `orquestion_last_updated`, `orquestion_reply_status`, `orquestion_replied_at`, `orquestion_doctor_accepted_at`, `orquestion_weight`, `orquestion_name`, `orquestion_phone`, `orquestion_asked_on`) VALUES
(1, 'AD1510634556213', 'Herpes 1 and 2 IgG are on the higher side. Is it a matter of concern?', 1, '18-35', 'I accidentally touched the vaginal fluid of a sex worker two and a half months ago. I had a cracked skin on my finger. It was a deep crack, but not a bleeding crack. So, I consulted a local doctor there. He gave me PEP medicines for 30 days. It was Teno-EM (Tenofovir Disoproxil Fumarate and Emtricitabine 300 mg/200 mg) and Lamivir (Lamivudine 300 mg). Five weeks later, I did an HIV 1, 2 and P24 combo test. It was negative. I repeated the same test on the ninth week. It was also negative. Please advise how conclusive these tests are. Should I go for any other conclusive test? I am in the 10th week after exposure.', 2, 0, 10, 19, 4, '0000-00-00 00:00:00', 1, '2017-11-17 01:13:00', '2017-11-14 17:39:56', '30-40', '', '324345465', '0000-00-00 00:00:00'),
(2, 'AD1510634711473', 'What is PEP therapy for HIV?', 1, '18-35', 'I had an exposure with a call girl with protection. However, during intercourse, the condom broke. I am worried about HIV. Could you please guide me regarding what kind of tests I should undertake. Also, I would like to understand how many days later I should go for the test. As on today, it has been 24 hours since exposure.', 2, 0, 10, 19, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '30-40', '', '324345465', '0000-00-00 00:00:00'),
(3, 'AD1510634789194', 'Does the consumption of raw garlic change the HIV test results in any way?', 1, '18-35', 'Hello doctor,\r\n\r\nI have a skin allergy, rashes, hives and weight loss.', 2, 0, 10, 19, 7, '2017-11-15 16:27:58', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '30-40', '', '324345465', '0000-00-00 00:00:00'),
(4, 'AD1510634789194', 'Temperature fluctuations after having sex with a CSW. Am I HIV positive?', 1, '18-35', 'I had a protected sexual encounter with a CSW. The very next day I found little white nonraised dots on the head of my penis. The dermatologist told me that it was a fungal infection and prescribed Ketoconazole cream and Fluconazole tablet. However, I have undergone HIV antibodies test 10 days later and were non-reactive. In between, the fungal infection got completely eradicated in two to three weeks. I have been recently diagnosed with diabetes two to three months ago. Two months after the sexual encounter, once again I underwent an HIV screening test, i.e., antibodies test. Once again it came as negative. As of now, I do not find any abnormalities in the functioning of the body but I have observed that my body temperature fluctuates between 98 to 99.4 degrees Celsius on a normal day and also I have felt numbness in both the knees. The uric acid is 8 and although the WBC count is 13 with normal differential counting, I do not find any difficulty in swallowing food nor do I have swollen lymph nodes. The lymphocyte count is 26 from the latest CBC reports. I need your opinion in my case.', 2, 0, 10, 19, 7, '2017-11-15 15:24:09', 1, '2017-11-15 01:26:00', '2017-11-14 11:36:16', '30-40', '', '324345465', '0000-00-00 00:00:00'),
(5, 'AD151066137871', 'Should the HIV medicines be changed after taking them for 11 years?', 1, '18-35', 'My uncle aged 54 and aunt aged 47 are using Lamivudine, Nevirapine, and Zidovudine tablets for the last 11 years. Can they continue to use or do they need a change in their medicines? My aunt has few health issues like a sore throat and loss of voice and has been suffering from a slight pain on both sides of rib area for a few years. Is this because of the above medicines? Or is to due to less work? There are no issues with my uncle. Other than the ones stated above, they have no health complications. Should they continue taking the medications? Are any tests required? Someone has told them that after 11 years of being on the above medications, they need to change them. Is that true? Do they need to change the medicines? Please provide the Information which will help them a lot.', 2, 0, 10, 19, 7, '2017-11-17 12:26:43', 1, '2017-11-15 04:03:00', '2017-11-15 15:50:13', '30-40', '', '324345465', '0000-00-00 00:00:00'),
(6, 'AD1512366911310', 'asDS', 1, '10-17', 'DSA', 2, 0, 10, 3, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '20-30', 'aSDS', '23534', '2017-12-04 11:25:00'),
(7, 'AD151263159713', 'hhuhuhijk', 1, '10-17', 'ffhfhfhfhfhfhfhfhfhfhf', 1, 0, 11, 3, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '30-40', 'a', '3456', '2017-12-07 12:56:00'),
(8, 'AD1512717881187', 'test Aman', 1, '36-45', 'glyhglhjglhglh', 1, 0, 10, 44, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '20-30', 'Aman', '3456', '2017-12-08 12:54:00'),
(9, 'AD1512720264985', 'hhhuhhh', 1, '36-45', 'nnnn', 1, 0, 10, 44, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '20-30', 'Aman', '3456777', '2017-12-08 13:34:00'),
(10, 'AD1512721118126', 'test 8 dec', 1, '36-45', 'test56', 1, 0, 10, 44, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '20-30', 'Aman', '3456', '2017-12-08 13:48:00'),
(11, 'AD1514875510197', 'Test Question', 1, '0-3', 'fgfdh', 1, 0, 5, 9, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1-10', 'Anjana', 'twetrwet', '2018-01-02 12:15:00'),
(12, 'AD1514875576230', 'Test Question', 1, '0-3', 'dasfdsafdsa', 1, 0, 5, 19, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '10-20', 'Mehtab', '5354', '2018-01-02 12:16:00'),
(13, 'AD1514877166385', 'Test', 1, '36-45', 'asda sd asd asd asda sd asd asd asda sd asd asd asda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asd\r\n\r\nasda sd asd asd asda sd asd asd asda sd asd asd asda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asd\r\n\r\nasda sd asd asd asda sd asd asd asda sd asd asd asda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asd\r\n\r\nasda sd asd asd asda sd asd asd asda sd asd asd asda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asd\r\n\r\nasda sd asd asd asda sd asd asd asda sd asd asd asda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asd\r\n\r\nasda sd asd asd asda sd asd asd asda sd asd asd asda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asd\r\n\r\nasda sd asd asd asda sd asd asd asda sd asd asd asda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asd\r\n\r\nasda sd asd asd asda sd asd asd asda sd asd asd asda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asd\r\n\r\nasda sd asd asd asda sd asd asd asda sd asd asd asda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asd\r\n\r\nasda sd asd asd asda sd asd asd asda sd asd asd asda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asd\r\n\r\nasda sd asd asd asda sd asd asd asda sd asd asd asda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asd\r\n\r\nasda sd asd asd asda sd asd asd asda sd asd asd asda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asd\r\n\r\nasda sd asd asd asda sd asd asd asda sd asd asd asda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asd\r\n\r\nasda sd asd asd asda sd asd asd asda sd asd asd asda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asd\r\n\r\nasda sd asd asd asda sd asd asd asda sd asd asd asda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asd\r\n\r\nasda sd asd asd asda sd asd asd asda sd asd asd asda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asd\r\n\r\nasda sd asd asd asda sd asd asd asda sd asd asd asda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asd\r\n\r\nasda sd asd asd asda sd asd asd asda sd asd asd asda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asd\r\n\r\nasda sd asd asd asda sd asd asd asda sd asd asd asda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asd\r\n\r\nasda sd asd asd asda sd asd asd asda sd asd asd asda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asd\r\n\r\nasda sd asd asd asda sd asd asd asda sd asd asd asda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asdasda sd asd asd', 1, 0, 10, 44, 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '20-30', 'Manveer', '1231233435 435435345 345 34534', '2018-01-02 12:42:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_subscriptions`
--

CREATE TABLE `tbl_order_subscriptions` (
  `orsubs_id` int(11) NOT NULL,
  `orsubs_order_id` varchar(15) NOT NULL,
  `orsubs_subscription_id` int(11) NOT NULL,
  `orsubs_question_allowed` int(11) NOT NULL COMMENT '0=>1 question,1=>unlimited',
  `orsubs_price` decimal(10,2) NOT NULL,
  `orsubs_duration` int(11) NOT NULL,
  `orsubs_valid_from` date NOT NULL,
  `orsubs_valid_upto` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_order_subscriptions`
--

INSERT INTO `tbl_order_subscriptions` (`orsubs_id`, `orsubs_order_id`, `orsubs_subscription_id`, `orsubs_question_allowed`, `orsubs_price`, `orsubs_duration`, `orsubs_valid_from`, `orsubs_valid_upto`) VALUES
(1, 'AD1510634556213', 13, 1, '0.00', 1, '2017-11-14', '2017-11-15'),
(2, 'AD1510634711473', 13, 1, '0.00', 1, '2017-11-14', '2017-11-15'),
(3, 'AD1510634789194', 1, 2, '9.00', 5, '2017-11-14', '2017-11-19'),
(4, 'AD151066137871', 13, 1, '0.00', 1, '2017-11-14', '2017-11-15'),
(5, 'AD1512366911310', 13, 1, '0.00', 1, '2017-12-04', '2017-12-05'),
(6, 'AD151263159713', 1, 2, '9.00', 5, '2017-12-07', '2017-12-12'),
(7, 'AD1512717881187', 13, 1, '0.00', 1, '2017-12-08', '2017-12-09'),
(8, 'AD1512720264985', 13, 1, '0.00', 1, '2017-12-08', '2017-12-09'),
(9, 'AD1512721118126', 13, 1, '0.00', 1, '2017-12-08', '2017-12-09'),
(10, 'AD1514875510197', 13, 1, '0.00', 1, '2018-01-02', '2018-01-03'),
(11, 'AD1514875576230', 1, 2, '9.00', 5, '2018-01-02', '2018-01-07'),
(12, 'AD1514877166385', 1, 2, '9.00', 5, '2018-01-02', '2018-01-07');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_transactions`
--

CREATE TABLE `tbl_order_transactions` (
  `tran_id` int(11) NOT NULL,
  `tran_order_id` varchar(15) NOT NULL,
  `tran_plan_id` int(11) NOT NULL,
  `tran_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tran_amount` decimal(10,2) NOT NULL,
  `tran_completed` tinyint(4) NOT NULL,
  `tran_real_amount` decimal(10,2) NOT NULL,
  `tran_payment_mode` int(11) NOT NULL,
  `tran_gateway_transaction_id` varchar(150) NOT NULL,
  `tran_gateway_response_data` text NOT NULL,
  `tran_admin_comments` text NOT NULL,
  `tran_declined_by_admin` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_order_transactions`
--

INSERT INTO `tbl_order_transactions` (`tran_id`, `tran_order_id`, `tran_plan_id`, `tran_time`, `tran_amount`, `tran_completed`, `tran_real_amount`, `tran_payment_mode`, `tran_gateway_transaction_id`, `tran_gateway_response_data`, `tran_admin_comments`, `tran_declined_by_admin`) VALUES
(1, 'AD1510634556213', 0, '2017-11-14 04:42:36', '0.00', 1, '0.00', 1, 'FREEPLAN-1510634556', '', '', 0),
(2, 'AD1510634711473', 0, '2017-11-14 04:45:11', '0.00', 1, '0.00', 1, 'FREEPLAN-1510634711', '', '', 0),
(3, 'AD1510634789194', 0, '2017-11-14 04:47:04', '9.00', 1, '0.00', 1, '21K31144GU713261L', 'cmd=_notify-validate&mc_gross=9.00&protection_eligibility=Eligible&address_status=confirmed&payer_id=DMTPFNVPT6X9Y&address_street=1+Main+St&payment_date=20%3A46%3A54+Nov+13%2C+2017+PST&payment_status=Completed&charset=windows-1252&address_zip=95131&first_name=fatbit&mc_fee=0.56&address_country_code=US&address_name=fatbit+buyer&notify_version=3.8&custom=&payer_status=verified&business=nishan_1297919061_biz%40dummyid.com&address_country=United+States&address_city=San+Jose&quantity=1&verify_sign=AMA-XRFWCsglr5DA--cCeSe601sMAF..mdP8tNkjCS-iarCq3Z0FVQfs&payer_email=fatbitbuyer%40dummyid.com&txn_id=21K31144GU713261L&payment_type=instant&last_name=buyer&address_state=CA&receiver_email=nishan_1297919061_biz%40dummyid.com&payment_fee=0.56&receiver_id=99AUJMEFB68RS&txn_type=web_accept&item_name=AD1510634789194&mc_currency=USD&item_number=&residence_country=US&test_ipn=1&transaction_subject=&payment_gross=9.00&ipn_track_id=b5812f97ef0f8VERIFIED', '', 0),
(4, 'AD151066137871', 0, '2017-11-14 12:09:38', '0.00', 1, '0.00', 1, 'FREEPLAN-1510661378', '', '', 0),
(5, 'AD1512366911310', 0, '2017-12-04 05:55:12', '0.00', 1, '0.00', 1, 'FREEPLAN-1512366912', '', '', 0),
(6, 'AD1512717881187', 0, '2017-12-08 07:24:41', '0.00', 1, '0.00', 1, 'FREEPLAN-1512717881', '', '', 0),
(7, 'AD1512720264985', 0, '2017-12-08 08:04:25', '0.00', 1, '0.00', 1, 'FREEPLAN-1512720265', '', '', 0),
(8, 'AD1512721118126', 0, '2017-12-08 08:18:38', '0.00', 1, '0.00', 1, 'FREEPLAN-1512721118', '', '', 0),
(9, 'AD1514875510197', 0, '2018-01-02 06:45:13', '0.00', 1, '0.00', 1, 'FREEPLAN-1514875512', '', '', 0),
(10, 'AD1514875576230', 0, '2018-01-02 06:47:00', '9.00', 1, '0.00', 1, '5X9585406F2581507', 'cmd=_notify-validate&mc_gross=9.00&protection_eligibility=Eligible&address_status=confirmed&payer_id=DMTPFNVPT6X9Y&address_street=1+Main+St&payment_date=22%3A46%3A46+Jan+01%2C+2018+PST&payment_status=Completed&charset=windows-1252&address_zip=95131&first_name=fatbit&mc_fee=0.56&address_country_code=US&address_name=fatbit+buyer&notify_version=3.8&custom=&payer_status=verified&business=nishan_1297919061_biz%40dummyid.com&address_country=United+States&address_city=San+Jose&quantity=1&verify_sign=A8EVIPRg8VXjPpn1ZsojuaA0vqAFA3eEkoWCWRVmcQIHdSuMPBmLPV.A&payer_email=fatbitbuyer%40dummyid.com&txn_id=5X9585406F2581507&payment_type=instant&last_name=buyer&address_state=CA&receiver_email=nishan_1297919061_biz%40dummyid.com&payment_fee=0.56&receiver_id=99AUJMEFB68RS&txn_type=web_accept&item_name=AD1514875576230&mc_currency=USD&item_number=&residence_country=US&test_ipn=1&transaction_subject=&payment_gross=9.00&ipn_track_id=c677280f9bb19VERIFIED', '', 0),
(11, 'AD1514877166385', 0, '2018-01-02 07:13:29', '9.00', 1, '0.00', 1, '8F028375U6999913F', 'cmd=_notify-validate&mc_gross=9.00&protection_eligibility=Eligible&address_status=confirmed&payer_id=USMTWCB5XMHR8&address_street=1+Main+St&payment_date=23%3A13%3A14+Jan+01%2C+2018+PST&payment_status=Completed&charset=windows-1252&address_zip=95131&first_name=WZY&mc_fee=0.56&address_country_code=US&address_name=WZY+Buyer&notify_version=3.8&custom=&payer_status=verified&business=nishan_1297919061_biz%40dummyid.com&address_country=United+States&address_city=San+Jose&quantity=1&verify_sign=AvhaW0DUifN7xX6fk5ErDQ53UzaHABBbSZNpDVTil5ZnhWLUQh6apMjW&payer_email=wzybuyer%40dummyid.com&txn_id=8F028375U6999913F&payment_type=instant&last_name=Buyer&address_state=CA&receiver_email=nishan_1297919061_biz%40dummyid.com&payment_fee=0.56&receiver_id=99AUJMEFB68RS&txn_type=web_accept&item_name=AD1514877166385&mc_currency=USD&item_number=&residence_country=US&test_ipn=1&transaction_subject=&payment_gross=9.00&ipn_track_id=9e09228d6716fVERIFIED', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_question_acceptance_log`
--

CREATE TABLE `tbl_question_acceptance_log` (
  `log_id` int(11) NOT NULL,
  `log_doctor_id` int(11) NOT NULL,
  `log_question_id` int(11) NOT NULL,
  `log_added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_question_acceptance_log`
--

INSERT INTO `tbl_question_acceptance_log` (`log_id`, `log_doctor_id`, `log_question_id`, `log_added_at`) VALUES
(1, 19, 1, '2017-11-14 04:43:32'),
(2, 19, 2, '2017-11-14 04:45:39'),
(3, 19, 4, '2017-11-14 04:48:01'),
(4, 19, 3, '2017-11-14 04:48:09'),
(5, 19, 4, '2017-11-14 06:06:23'),
(6, 19, 1, '2017-11-14 12:09:56'),
(7, 19, 5, '2017-11-15 10:20:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_question_assign`
--

CREATE TABLE `tbl_question_assign` (
  `qassign_id` int(11) NOT NULL,
  `qassign_question_id` int(11) NOT NULL,
  `qassign_doctor_id` int(11) NOT NULL,
  `qassign_assigned_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_question_assign`
--

INSERT INTO `tbl_question_assign` (`qassign_id`, `qassign_question_id`, `qassign_doctor_id`, `qassign_assigned_on`) VALUES
(1, 1, 19, '2017-11-14 10:12:00'),
(2, 2, 19, '2017-11-14 10:15:00'),
(3, 3, 19, '2017-11-14 10:16:00'),
(4, 4, 19, '2017-11-14 10:17:00'),
(5, 5, 19, '2017-11-14 17:39:00'),
(6, 2, 18, '2017-11-14 10:15:00'),
(7, 1, 19, '2017-11-14 10:15:00'),
(8, 6, 3, '2017-12-04 11:25:00'),
(9, 7, 3, '2017-12-07 12:56:00'),
(10, 8, 44, '2017-12-08 12:54:00'),
(11, 9, 44, '2017-12-08 13:34:00'),
(12, 10, 44, '2017-12-08 13:48:00'),
(13, 11, 9, '2018-01-02 12:15:00'),
(14, 12, 19, '2018-01-02 12:16:00'),
(15, 13, 44, '2018-01-02 12:42:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_question_replies`
--

CREATE TABLE `tbl_question_replies` (
  `reply_id` int(11) NOT NULL,
  `reply_orquestion_id` int(11) NOT NULL,
  `reply_date` datetime NOT NULL,
  `reply_by` int(11) NOT NULL COMMENT '3=>doctor, 2=>patient',
  `reply_text` text NOT NULL,
  `reply_approved` tinyint(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_question_replies`
--

INSERT INTO `tbl_question_replies` (`reply_id`, `reply_orquestion_id`, `reply_date`, `reply_by`, `reply_text`, `reply_approved`) VALUES
(1, 4, '2017-11-14 12:24:15', 4, '<p>Hello,</p>\r\n<p>Welcome to icliniq.com.</p>\r\n<ul>\r\n	<li>Firstly, if the condom had been used consistently and correctly \r\nand it did not break or slip off then the chances of acquisition of HIV \r\n(human immunodeficiency virus) or any other STI (<strong>sexually transmitted infections</strong>) <strong>is nonexistent</strong>.</li>\r\n</ul>\r\n<ul>\r\n	<li>Another reassuring point is that your preliminary test results are negative.</li>\r\n</ul>\r\n<ul>\r\n	<li>The recommendations are to get tested by <strong>fourth generation HIV</strong> rapid test at four weeks and if the result is negative get a \r\nconfirmatory HIV antibody test at three months from the last unprotected\r\n exposure.</li>\r\n</ul>\r\n<ul>\r\n	<li>Fungal infections are usually more associated with <strong>uncontrolled blood sugar levels</strong>, which you had been recently diagnosed with. Numbness could be again associated with the same.</li>\r\n</ul>\r\n<ul>\r\n	<li><strong>Having malaise</strong> or mild fever could be due to various reasons.&nbsp;</li>\r\n</ul>\r\n<ul>\r\n	<li>Your uric acid seems normal.</li>\r\n</ul>\r\n<ul>\r\n	<li>I suggest you get a <strong>confirmatory HIV antibody test</strong> at three months of the last exposure.</li>\r\n</ul>\r\n<p>I hope your query is answered.</p>', 1),
(30, 1, '2017-11-14 17:41:04', 4, '<p>Hello,</p>\r\n<p>Welcome to getmedz.com.</p>\r\n<p>I have noted your concern.</p>\r\n<ul>\r\n	<li>There was actually<strong> no need for PEP</strong> \r\n(post-exposure&nbsp;prophylaxis). The HIV virus does not enter through cracks\r\n especially if it more than a few hours old and is not freshly bleeding.</li>\r\n</ul>\r\n<ul>\r\n	<li>Nevertheless, your HIV screening tests are conclusive and <strong>you do not need any further tests</strong>.\r\n The window period of combo test (P24 antigen and HIV antibody test) is \r\ntwo to three weeks and this screening test is reliable beyond this \r\nwindow after the exposure.</li>\r\n</ul>\r\n<p>Regards.</p>', 1),
(34, 4, '2017-11-14 18:28:08', 4, 'Posting reply again with attachment', 1),
(37, 4, '2017-11-15 11:37:01', 5, 'Customer reply<br />', 1),
(38, 4, '2017-11-15 11:40:28', 5, 'Thank you<br />', 1),
(39, 4, '2017-11-15 13:26:43', 4, 'vbvbvbvbv', 1),
(40, 5, '2017-11-15 15:50:28', 4, 'Doctor Replying ont his thread', 1),
(41, 5, '2017-11-15 16:03:09', 5, 'Please let me know if \r\n<g class=\"gr_ gr_57 gr-alert gr_tiny gr_spell gr_inline_cards gr_run_anim ContextualSpelling multiReplace\" id=\"57\" data-gr-id=\"57\">i</g> need to change the medicine<br />', 1),
(42, 5, '2017-11-15 16:03:45', 4, '<span style=\"font-weight: bold;\">Yes, </span>you need to do that', 1),
(43, 1, '2017-11-15 16:59:13', 4, 'asdff', 1),
(44, 1, '2017-11-17 12:51:08', 4, 'Do you have another question?', 1),
(45, 1, '2017-11-17 12:52:17', 4, 'Another reply by me', 1),
(46, 1, '2017-11-17 12:53:48', 4, 'ok.. i am closing question', 1),
(47, 1, '2017-11-17 12:54:43', 4, 'Final Result&nbsp;', 1),
(48, 1, '2017-11-17 12:55:02', 4, 'Result', 1),
(49, 1, '2017-11-17 12:57:49', 4, 'Repky', 1),
(50, 1, '2017-11-17 13:10:41', 4, 'sdfsadf', 1),
(51, 1, '2017-11-17 13:11:09', 4, 'sfdsafd', 1),
(52, 1, '2017-11-17 13:11:39', 4, 'dfgsdgf', 1),
(53, 1, '2017-11-17 13:13:46', 4, 'dfasfd', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_question_status`
--

CREATE TABLE `tbl_question_status` (
  `qstatus_id` int(11) NOT NULL,
  `qstatus_question_id` int(11) NOT NULL,
  `qstatus_status` int(11) NOT NULL,
  `qstatus_updated_by` int(11) NOT NULL,
  `qstatus_updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_question_status`
--

INSERT INTO `tbl_question_status` (`qstatus_id`, `qstatus_question_id`, `qstatus_status`, `qstatus_updated_by`, `qstatus_updated_on`) VALUES
(1, 1, 1, 0, '2017-11-14 10:12:00'),
(2, 0, 1, 1, '2017-11-14 10:12:00'),
(3, 1, 2, 19, '2017-11-14 10:13:00'),
(4, 2, 1, 0, '2017-11-14 10:15:00'),
(5, 0, 1, 1, '2017-11-14 10:15:00'),
(6, 2, 6, 19, '2017-11-14 10:15:00'),
(7, 3, 1, 0, '2017-11-14 10:16:00'),
(8, 0, 1, 1, '2017-11-14 10:17:00'),
(9, 4, 1, 0, '2017-11-14 10:17:00'),
(10, 4, 2, 19, '2017-11-14 10:18:00'),
(11, 3, 6, 19, '2017-11-14 10:18:00'),
(12, 4, 2, 19, '2017-11-14 11:36:00'),
(13, 5, 1, 0, '2017-11-14 17:39:00'),
(14, 0, 1, 1, '2017-11-14 17:39:00'),
(15, 1, 2, 19, '2017-11-14 17:39:00'),
(16, 5, 2, 19, '2017-11-15 15:50:00'),
(17, 6, 1, 0, '2017-12-04 11:25:00'),
(18, 0, 1, 2, '2017-12-04 11:25:00'),
(19, 7, 1, 0, '2017-12-07 12:56:00'),
(20, 8, 1, 0, '2017-12-08 12:54:00'),
(21, 0, 1, 4, '2017-12-08 12:54:00'),
(22, 9, 1, 0, '2017-12-08 13:34:00'),
(23, 0, 1, 4, '2017-12-08 13:34:00'),
(24, 10, 1, 0, '2017-12-08 13:48:00'),
(25, 0, 1, 4, '2017-12-08 13:48:00'),
(26, 11, 1, 0, '2018-01-02 12:15:00'),
(27, 0, 1, 5, '2018-01-02 12:15:00'),
(28, 12, 1, 0, '2018-01-02 12:16:00'),
(29, 0, 1, 6, '2018-01-02 12:17:00'),
(30, 13, 1, 0, '2018-01-02 12:42:00'),
(31, 0, 1, 7, '2018-01-02 12:43:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_remember_me`
--

CREATE TABLE `tbl_remember_me` (
  `remember_token` varchar(50) NOT NULL,
  `remember_user_id` int(11) NOT NULL,
  `remember_user_type` int(11) NOT NULL,
  `remember_agent` varchar(160) NOT NULL,
  `remember_expiry` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_remember_me`
--

INSERT INTO `tbl_remember_me` (`remember_token`, `remember_user_id`, `remember_user_type`, `remember_agent`, `remember_expiry`) VALUES
('44ef7ad408bd2548662e839db08b7371', 35, 3, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36 OPR/33.0.1990.58', '2015-12-02 14:49:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_social_platforms`
--

CREATE TABLE `tbl_social_platforms` (
  `splatform_id` int(11) NOT NULL,
  `splatform_title` varchar(255) NOT NULL,
  `splatform_url` varchar(255) NOT NULL,
  `splatform_icon_file` varchar(255) NOT NULL,
  `splatform_status` tinyint(1) NOT NULL,
  `splatform_is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_social_platforms`
--

INSERT INTO `tbl_social_platforms` (`splatform_id`, `splatform_title`, `splatform_url`, `splatform_icon_file`, `splatform_status`, `splatform_is_deleted`) VALUES
(1, 'Facebook', 'http://www.facebook.com', '33_facebooksvg', 1, 0),
(2, 'Linked In', 'http://www.linkedin.com', 'in.svg', 1, 0),
(3, 'Twiiter', 'http://www.twitter.com', 'twittersvg', 1, 0),
(4, 'Google Plus', 'http://www.googleplus.com', 'googlesvg', 1, 0),
(5, 'Youtube', 'http://www.youtube.com', 'youtubesvg', 1, 0),
(6, 'Pinterest', 'http://www.pinterest.com', 'pinterest.svg', 1, 0),
(7, 'Instagram', 'http://www.instagram.com', 'instagram-logo.svg', 1, 1),
(8, 'tesr', 'https://www.google.co.in', 'whole-food.png', 1, 1),
(9, 'facebook1', 'http://getmedz.4demo.biz', '12_facebooksvg', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_states`
--

CREATE TABLE `tbl_states` (
  `state_id` int(11) NOT NULL,
  `state_name` varchar(100) NOT NULL,
  `state_country_id` int(11) NOT NULL,
  `state_active` tinyint(4) NOT NULL,
  `state_deleted` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_states`
--

INSERT INTO `tbl_states` (`state_id`, `state_name`, `state_country_id`, `state_active`, `state_deleted`) VALUES
(1, 'abhi', 0, 1, 1),
(2, 'Delhia', 1, 1, 1),
(3, 'Mumbai', 1, 1, 1),
(4, 'Hyderabad', 1, 1, 1),
(5, 'Himachal', 1, 1, 0),
(6, 'Solan', 1, 0, 1),
(10, 'Chandigarh', 1, 1, 0),
(11, 'Delhi', 1, 1, 0),
(12, 'Punjab', 1, 0, 1),
(15, 'th', 1, 0, 1),
(17, 'kerela', 1, 0, 1),
(18, 'ambalad', 1, 1, 1),
(26, 'punjab', 1, 1, 1),
(27, 'Punjab', 1, 0, 1),
(28, 'haryana', 1, 0, 0),
(29, 'Karnal1', 1, 1, 1),
(30, 'gfdsf', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subscriptions`
--

CREATE TABLE `tbl_subscriptions` (
  `subs_id` int(11) NOT NULL,
  `subs_name` varchar(255) NOT NULL,
  `subs_subheading` varchar(255) NOT NULL,
  `subs_price_text` varchar(50) NOT NULL,
  `subs_price_subheading` varchar(50) NOT NULL,
  `subs_question` int(11) NOT NULL,
  `subs_price` decimal(10,2) NOT NULL,
  `subs_duration` int(11) NOT NULL,
  `subs_active` int(11) NOT NULL,
  `subs_deleted` int(11) NOT NULL,
  `subs_type` tinyint(4) NOT NULL COMMENT '0=>Single,1=>Subscription',
  `subs_popular` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_subscriptions`
--

INSERT INTO `tbl_subscriptions` (`subs_id`, `subs_name`, `subs_subheading`, `subs_price_text`, `subs_price_subheading`, `subs_question`, `subs_price`, `subs_duration`, `subs_active`, `subs_deleted`, `subs_type`, `subs_popular`) VALUES
(1, 'Two Questions', '', '$9', '', 2, '9.00', 5, 1, 0, 0, 2),
(2, 'UNLIMITED Questions for 1 Month', '(Monthly Membership)', '$19.95/mo', '', 9999, '19.95', 30, 1, 0, 1, 1),
(3, '3 Months Plan', '(3 Month Membership)', '$14.95/mo', '$44.85 Today', 25, '44.85', 90, 1, 0, 1, 2),
(4, 'test', 'testtest', '12', '12', 0, '10.00', 10, 1, 1, 0, 1),
(5, 'test', 'test', 'dfg', '', 0, '0.00', 0, 1, 1, 0, 2),
(6, 'UNLIMITED Questions for 1 Month', '(Monthly Membership)', '$19.95/mo', '', 0, '19.95', 30, 1, 1, 1, 1),
(7, 'fasfafd', 'asfdas', '11/percent', '12/mont', 0, '10.00', 15, 0, 1, 1, 1),
(8, 'fhjk', '', 'fkh', '', 0, '0.00', 0, 1, 1, 0, 2),
(9, 'gsdf', 'gfsdgf', 'dsfgsdg', '', 0, '0.00', 0, 1, 1, 0, 1),
(10, '30 question  for 15 days', 'for half month', '50', '41', 45, '52.00', 15, 1, 0, 1, 1),
(11, 'zz', 'zZ', 'zz', 'zz', 0, '0.00', 0, 1, 1, 0, 2),
(12, 'test', 'test', '3', '2', 0, '2.00', 2, 1, 1, 0, 1),
(13, 'Free Subscription', 'Free for 1 questions', '0', '', 1, '0.00', 1, 1, 0, 0, 1),
(14, 'sfdas', 'fdas', '436456', '3465', 0, '3455.00', 36534, 1, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_testimonials`
--

CREATE TABLE `tbl_testimonials` (
  `testimonial_id` int(11) NOT NULL,
  `testimonial_image` varchar(255) NOT NULL,
  `testimonial_name` varchar(255) NOT NULL,
  `testimonial_address` varchar(255) NOT NULL,
  `testimonial_text` text NOT NULL,
  `testimonial_status` tinyint(1) NOT NULL,
  `testimonial_is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_testimonials`
--

INSERT INTO `tbl_testimonials` (`testimonial_id`, `testimonial_image`, `testimonial_name`, `testimonial_address`, `testimonial_text`, `testimonial_status`, `testimonial_is_deleted`) VALUES
(1, '10974jpg', 'Mr.albanja', 'Los Angeles, CA', 'The Best Shopping Experience. Very informative and buy what you see is best facility!!!', 1, 0),
(2, 'maninhospitalbedjpg', 'Levi Straus', 'Asia Pacific Division', 'Our project implementation and transition was quite smooth. Quatrro always responded well whenever there was an issue to be sorted out.Our project implementation and transition was quite smooth. Quatrro always responded well whenever there was an issue to be sorted out.\r\n\r\nOur project implementation and transition was quite smooth. Quatrro always responded well whenever there was an issue to be sorted out.', 1, 0),
(3, 'Hydrangeasjpg', 'Nathan Astle', 'Los Angeles, CA', 'Aenean sagittis lorem ut laoreet ullamcorper. Nunc tincidunt, erat vitae dapibus hendrerit, diam arcu lacinia neque, eget blandit mi odio vitae tellus.', 0, 0),
(4, 'emp_2.jpg', 'James Anderson', 'Los Angeles, CA', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque eget arcu pulvinar Lorem ipsum dolor sit amet', 0, 1),
(5, 'emp_1.jpg', 'Shane Marsh', 'New Delhi, IND', 'Fusce nec posuere felis. Nam vitae rutrum justo. Sed fringilla magna metus, nec lacinia nisi porttitor sed. Nullam ut fermentum nibh, et condimentum magna. Quisque porttitor ut sem id posuere. Aliquam sollicitudin ultrices augue quis imperdiet. Aliquam erat volutpat. Praesent eu quam ut eros tincidunt auctor.', 0, 1),
(6, 'Desertjpg', 'tesdt', 'sds', 'sdsdsd', 1, 1),
(7, 'Jellyfishjpg', 'testtt', 'dsdasd', 'sdsdsads\r\nd\r\nsad\r\nas\r\nda\r\nsd\r\nasdasd', 1, 1),
(8, '80f539919eeac7fa8532200b36b04cjpg', 'pooja', 'Mohali', 'This is my etstimonail', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tmp_orders`
--

CREATE TABLE `tbl_tmp_orders` (
  `tmp_order_date` date NOT NULL,
  `tmp_session_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_tmp_orders`
--

INSERT INTO `tbl_tmp_orders` (`tmp_order_date`, `tmp_session_id`) VALUES
('2017-11-08', '1p2ctfoqscvcafct0mg19hhp27'),
('2017-11-08', '3uu7ei1un62keotht9mst8pkt5'),
('2017-11-08', '5dt08oj1jlshi7fi3mpsln6h86'),
('2017-11-08', '5o35238ei8m693plfmof71msm2'),
('2017-11-08', '7qv6vnp0vcc1seg2ih6ht49hl0'),
('2017-11-08', '88a051js5m65e8ag2oiv1oetf7'),
('2017-11-08', '8ifcfnolq2jnj0l40g3abukh15'),
('2017-11-08', '8jb135p1npbsrn4fhabq3jt5u3'),
('2017-11-08', '9ubiqgia137h0eqi2p51jpt5e7'),
('2017-11-08', 'c6b9hbisq71ida6cu261mjhs06'),
('2017-11-08', 'c7p37hof9t64as1kt70723t9q2'),
('2017-11-08', 'd0ncng0hldck4sr779t1nqd7n4'),
('2017-11-08', 'dpjpngrl7lt5c10vkm7mt9h9l3'),
('2017-11-08', 'e2mbv7vlvf2oei3pr5gjli9on6'),
('2017-11-08', 'f6to44o5nq4arfshtbb7ra8ii7'),
('2017-11-08', 'giordf85jrj9trfku5d5fpc4j0'),
('2017-11-08', 'gjqt9l9h89hrjj7u7vs81r8ii2'),
('2017-11-08', 'hp1q20cbiu8cu7p9jp7c583sc6'),
('2017-11-08', 'hu4b1io7sgkvca1rhp26q5ith6'),
('2017-11-08', 'it5vo8vde7aphf80fn23l38ft3'),
('2017-11-08', 'je016oc8v264i7nfcurl8ioga6'),
('2017-11-08', 'kmsn6r8bs0ulfvim3tu0l5q1r1'),
('2017-11-08', 'lbbr8vscjbsd92kq3jb0mnshm2'),
('2017-11-08', 'nq5hk69p6rlhakcthu8ued8ed2'),
('2017-11-08', 'oh78gq7gsfs1d3iqu11binmke2'),
('2017-11-08', 'orlk24ct059favqucno1cpca33'),
('2017-11-08', 'p3f2995fdudiqeu6gifm0sf4h4'),
('2017-11-08', 'pl4og08lpmpv20gak8bl445jg6'),
('2017-11-08', 'r5dbabecs9ri1tro8prvbbthb2'),
('2017-11-08', 'sslu9kkl5fiehn4hrpdplbdop1'),
('2017-11-08', 'u7bkbgivd44lajtltte0smk3h6'),
('2017-11-08', 'u8d0goebdsl6q30mnu8vkf9ge0'),
('2017-11-08', 'v2isfk6os45cmbsu1nkqh1n950'),
('2017-11-08', 'vjukh91s2tvo0g3pv569a4nb00'),
('2017-11-09', '01fnt3c8b8dtec6gieadcvje51'),
('2017-11-09', '0pedma32h3084n8iell966lka3'),
('2017-11-09', '19s9skamcu6r2h1ea64968llv1'),
('2017-11-09', '1bmcv7lqtnr6cm197gsc97brk7'),
('2017-11-09', '2cdfuc6hmluonkpp6d17gs0tv5'),
('2017-11-09', '3s3ii65hrgf6b1m0qq4n9loch6'),
('2017-11-09', '4rqpl0dqe12hhhi1khgllehb37'),
('2017-11-09', '6bk5lsvsnitgkds4kul952ore1'),
('2017-11-09', '6g6qb0nlq5i51sm9q08jm815t0'),
('2017-11-09', '7en3509lic40hii8bk6n3akkh4'),
('2017-11-09', '8nd7dpfnqh5ajd3ovld7vi7435'),
('2017-11-09', '8osql5qe5jqso417a0o4m02d66'),
('2017-11-09', '8pnlercq82t7lchh3l8h3h3t12'),
('2017-11-09', '8u9mlvles8fgofee1akcqp5te3'),
('2017-11-09', 'a33s9ci29c2dmlpblvi0fg54j7'),
('2017-11-09', 'bfvkef4bcpo1ce6hlor7han2h2'),
('2017-11-09', 'bv9kk085vqusr1vhr62qk7f7i5'),
('2017-11-09', 'cqid0jqe0t3h27vovvlqb9hvb2'),
('2017-11-09', 'd0ok1p276fbeci08e23jk66tu6'),
('2017-11-09', 'ee8q7vfb1g7umsccovm5vfgdv5'),
('2017-11-09', 'epe8c63eietvqcv9q377bp1nt3'),
('2017-11-09', 'fgp00p2283kj66l3u7bgl0vk61'),
('2017-11-09', 'gibk63j5k63lcr00apof7dt365'),
('2017-11-09', 'ih2a8id9s6ur5j182p7fuoc1s4'),
('2017-11-09', 'jtn3u1iprqclggoddu8rbqc4m3'),
('2017-11-09', 'or1g18oqhs5fi3vkh5k0p8n0m5'),
('2017-11-09', 'p6p9qn4rvu71663ekgr88nuvt5'),
('2017-11-09', 'q2r6es5s856sldh2ahenu3tlj0'),
('2017-11-09', 'qit7s12v1d6aiu9uvtb74o76a6'),
('2017-11-09', 's8ajf9anl2ovl247noso89hf46'),
('2017-11-09', 'sapnfucmq9d37pll38c9g8blh6'),
('2017-11-09', 'sbdq4bdchiqjunbgvmll1on5t4'),
('2017-11-09', 't2d90e49bmrlem0or6r6gcv503'),
('2017-11-09', 'u77bodvotr9us48c6mlmnsaqk4'),
('2017-11-09', 'v22jb8fan6odgugbh68enaj0n0'),
('2017-11-09', 'v3skd7voe25kcndtqnok7vui32'),
('2017-11-09', 'vpn7o887kk7pokkkshjee1koo6'),
('2017-11-10', '1fva13ubrneo6rijdvq2rt6pj0'),
('2017-11-10', '9s6u0omefppk11skeg0pl429q4'),
('2017-11-10', 'b6o8n07981jmmv3hut529mv773'),
('2017-11-10', 'eqsgjpdf3ibr4fvetob7dj6ea2'),
('2017-11-10', 'eudo29remq4jimj8479aghif84'),
('2017-11-10', 'fpe4lu4o2j5qgffhpj684on571'),
('2017-11-10', 'hdb9sv1slhrk4t650ddlf3pkl4'),
('2017-11-10', 'mmis2sjja99j4icahrndskdgp3'),
('2017-11-10', 'olag3cde2u1h9tnq37lp27epi0'),
('2017-11-10', 'rjptjc01fp91ns99cflh4fqbp1'),
('2017-11-13', '0gc7g4gankge8j3a0hli18sjk7'),
('2017-11-13', '23m49iinghorm0j6t18e3c15q2'),
('2017-11-13', '23pqcdp69o4glfp62lmd5cmpa6'),
('2017-11-13', '2mquk8n1gf2nenoobbgd48ngl6'),
('2017-11-13', '2u358s3lmh3s8v66hb6e71ui65'),
('2017-11-13', '3kma5rqhtkabg4a158nc7nckl1'),
('2017-11-13', '3r193o0fi1np2e0kjsgqdd2lc1'),
('2017-11-13', '6eg1gcfee312aak5vmpg0juba7'),
('2017-11-13', '8c4m6iq17v4h3mv242kb9r16c3'),
('2017-11-13', 'cajqqtngk5evgcf4r17cng2ft1'),
('2017-11-13', 'ced1hl3oq7elqo3c660hdhe1u7'),
('2017-11-13', 'd9ukptsphi0lpqe791o47k9g64'),
('2017-11-13', 'du81gh6jmeoorljel079en5k96'),
('2017-11-13', 'h83jfe7cifra1bd2uct6j43e42'),
('2017-11-13', 'j64pqllvau7s2r9cetfn9247i1'),
('2017-11-13', 'k2rf0hibe54mq9au4pnbp41v25'),
('2017-11-13', 'kp6mfq36j044lg2gp51i4is6p7'),
('2017-11-13', 'ml120bhmjt9s8lre7qse4fe0p6'),
('2017-11-13', 'nbjh892f6ir6h53f4s1ma7rer4'),
('2017-11-13', 'or1om7ijiau8r7iplcvc0bsvs5'),
('2017-11-13', 'p2fmaiua5gsp1g4ee766b3r8n5'),
('2017-11-13', 'snjqqp728aelfidshl63n16ds0'),
('2017-11-13', 'u9h7h292q8pc17j78quv45q043'),
('2017-11-13', 'v0o1j07qdu8dnaeqj7odheb3s3'),
('2017-11-13', 'vmpquo4mguc1p2qiftgkfvigl0'),
('2017-11-14', '2jplb6lf795ckcv8pm9tltnt26'),
('2017-11-14', '3h0i7viresp0dldqbjp2g6n107'),
('2017-11-14', '3jmg0qcno4jc329tibde41qnm1'),
('2017-11-14', '6fnqs1dvu15akte43g7k0plap1'),
('2017-11-14', 'nqjhj5o1km7a1bsrlhmf71b1c4'),
('2017-11-14', 'qmgvrjtp670teoajputcab78b3'),
('2017-11-14', 'vpmohhpuujhkokopgvuin15p83'),
('2017-12-04', 'qr3oll8bkvsmeb01su86omkm24'),
('2017-12-07', 'edlvga33vp9j1s285bv6pcfif3'),
('2017-12-08', '753jhgejop9gu3f9au07pnjth7'),
('2017-12-08', '9av6frb25rpalfue5a72nedvi2'),
('2017-12-08', 'kfjbc3g7eme6948o6bs1b2g2l4'),
('2018-01-02', 'i3lo1s9s80aebml4ct8kg2q914'),
('2018-01-02', 'lvrhtj9rf0bpd1hkodfho9t0v4'),
('2018-01-02', 'ounho54j70tcornfckjvl06596');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `user_first_name` varchar(100) NOT NULL,
  `user_last_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_pincode` int(11) NOT NULL,
  `user_phone` varchar(100) NOT NULL,
  `user_state` int(11) NOT NULL,
  `user_age` varchar(100) NOT NULL,
  `user_weight` varchar(100) NOT NULL,
  `user_added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_active` int(11) NOT NULL,
  `user_deleted` tinyint(4) NOT NULL,
  `user_gender` tinyint(2) NOT NULL,
  `user_emoi_link` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `user_first_name`, `user_last_name`, `user_email`, `user_password`, `user_pincode`, `user_phone`, `user_state`, `user_age`, `user_weight`, `user_added_on`, `user_active`, `user_deleted`, `user_gender`, `user_emoi_link`) VALUES
(1, 'pooja', '', 'pooja@dummyid.com', '1af00814a264d77fedd879532d6d4be3', 0, '324345465', 10, '18-35', '30-40', '2017-11-14 04:42:36', 1, 0, 2, ''),
(2, 'aSDS', '', 'SDASD@DUMMYID.COM', '83e15bf7f00bd929e682394e8bca78be', 0, '23534', 10, '10-17', '20-30', '2017-12-04 05:55:11', 1, 0, 2, ''),
(3, 'a', '', 'test@test.com', 'e768dded46bc377d67ab9609013ee59f', 0, '3456', 11, '10-17', '30-40', '2017-12-07 07:26:36', 0, 0, 1, ''),
(4, 'Aman', '', 'aman@dummyid.com', '64f06420cdfa804223af230df49e6a39', 0, '3456', 10, '36-45', '20-30', '2017-12-08 07:24:41', 1, 0, 1, ''),
(5, 'Anjana', '', 'anjanana@dummyid.com', '15124ce4ecb0cc6284522478e3bcaddc', 0, 'twetrwet', 5, '0-3', '1-10', '2018-01-02 06:45:10', 1, 0, 1, ''),
(6, 'Mehtab', '', 'Mehtab@dummyid.com', '644fa911a983cb0416382ed3e9120dea', 0, '5354', 5, '0-3', '10-20', '2018-01-02 06:46:16', 1, 0, 1, ''),
(7, 'Manveer', '', 'manveerpatient@dummyid.com', '2bffdb6e209c1cfd72ec129b6eba29f0', 0, '1231233435 435435345 345 34534', 10, '36-45', '20-30', '2018-01-02 07:12:46', 1, 0, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_password_reset_requests`
--

CREATE TABLE `tbl_user_password_reset_requests` (
  `uprr_user_id` int(11) NOT NULL,
  `uprr_token` varchar(255) NOT NULL,
  `uprr_expiry` datetime NOT NULL,
  `uprr_user_type` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admin_email` (`admin_email`),
  ADD KEY `admin_id` (`admin_id`,`admin_email`);

--
-- Indexes for table `tbl_admin_password_resets_requests`
--
ALTER TABLE `tbl_admin_password_resets_requests`
  ADD PRIMARY KEY (`appr_admin_id`);

--
-- Indexes for table `tbl_banners`
--
ALTER TABLE `tbl_banners`
  ADD PRIMARY KEY (`banner_id`),
  ADD KEY `banner_position_id` (`banner_position`);

--
-- Indexes for table `tbl_blog_attached_files`
--
ALTER TABLE `tbl_blog_attached_files`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `tbl_blog_contributions`
--
ALTER TABLE `tbl_blog_contributions`
  ADD PRIMARY KEY (`contribution_id`);

--
-- Indexes for table `tbl_blog_meta_data`
--
ALTER TABLE `tbl_blog_meta_data`
  ADD PRIMARY KEY (`meta_id`);

--
-- Indexes for table `tbl_blog_post`
--
ALTER TABLE `tbl_blog_post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `tbl_blog_post_categories`
--
ALTER TABLE `tbl_blog_post_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_blog_post_category_relation`
--
ALTER TABLE `tbl_blog_post_category_relation`
  ADD UNIQUE KEY `relation_post_id` (`relation_post_id`,`relation_category_id`);

--
-- Indexes for table `tbl_blog_post_comments`
--
ALTER TABLE `tbl_blog_post_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_post_id` (`comment_post_id`);

--
-- Indexes for table `tbl_blog_post_images`
--
ALTER TABLE `tbl_blog_post_images`
  ADD PRIMARY KEY (`post_image_id`);

--
-- Indexes for table `tbl_cms_contents`
--
ALTER TABLE `tbl_cms_contents`
  ADD PRIMARY KEY (`cmsc_id`);

--
-- Indexes for table `tbl_configurations`
--
ALTER TABLE `tbl_configurations`
  ADD PRIMARY KEY (`conf_name`);

--
-- Indexes for table `tbl_content_blocks`
--
ALTER TABLE `tbl_content_blocks`
  ADD PRIMARY KEY (`block_id`);

--
-- Indexes for table `tbl_countries`
--
ALTER TABLE `tbl_countries`
  ADD PRIMARY KEY (`country_id`),
  ADD KEY `country_id` (`country_id`),
  ADD KEY `country_id_2` (`country_id`,`country_name`);

--
-- Indexes for table `tbl_degrees`
--
ALTER TABLE `tbl_degrees`
  ADD PRIMARY KEY (`degree_id`),
  ADD UNIQUE KEY `degree_name` (`degree_name`);

--
-- Indexes for table `tbl_doctors`
--
ALTER TABLE `tbl_doctors`
  ADD PRIMARY KEY (`doctor_id`),
  ADD UNIQUE KEY `doctor_email` (`doctor_email`);

--
-- Indexes for table `tbl_doctor_degrees`
--
ALTER TABLE `tbl_doctor_degrees`
  ADD PRIMARY KEY (`docdegree_id`);

--
-- Indexes for table `tbl_doctor_reviews`
--
ALTER TABLE `tbl_doctor_reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD UNIQUE KEY `review_order_id` (`review_question_id`),
  ADD KEY `review_doctor_id` (`review_doctor_id`);

--
-- Indexes for table `tbl_email_templates`
--
ALTER TABLE `tbl_email_templates`
  ADD PRIMARY KEY (`tpl_id`);

--
-- Indexes for table `tbl_faq`
--
ALTER TABLE `tbl_faq`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `tbl_faq_category`
--
ALTER TABLE `tbl_faq_category`
  ADD PRIMARY KEY (`faqcat_id`);

--
-- Indexes for table `tbl_files`
--
ALTER TABLE `tbl_files`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `tbl_language_labels`
--
ALTER TABLE `tbl_language_labels`
  ADD PRIMARY KEY (`label_id`);

--
-- Indexes for table `tbl_medical_categories`
--
ALTER TABLE `tbl_medical_categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `tbl_navigations`
--
ALTER TABLE `tbl_navigations`
  ADD PRIMARY KEY (`nav_id`);

--
-- Indexes for table `tbl_nav_links`
--
ALTER TABLE `tbl_nav_links`
  ADD PRIMARY KEY (`nl_id`);

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order_id` (`order_id`,`order_user_id`);

--
-- Indexes for table `tbl_order_questions`
--
ALTER TABLE `tbl_order_questions`
  ADD PRIMARY KEY (`orquestion_id`),
  ADD KEY `orquestion_order_id` (`orquestion_order_id`),
  ADD KEY `orquestion_id` (`orquestion_id`);

--
-- Indexes for table `tbl_order_subscriptions`
--
ALTER TABLE `tbl_order_subscriptions`
  ADD PRIMARY KEY (`orsubs_id`),
  ADD KEY `orsubs_order_id` (`orsubs_order_id`);

--
-- Indexes for table `tbl_order_transactions`
--
ALTER TABLE `tbl_order_transactions`
  ADD PRIMARY KEY (`tran_id`),
  ADD KEY `tran_order_id` (`tran_order_id`);

--
-- Indexes for table `tbl_question_acceptance_log`
--
ALTER TABLE `tbl_question_acceptance_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `tbl_question_assign`
--
ALTER TABLE `tbl_question_assign`
  ADD PRIMARY KEY (`qassign_id`);

--
-- Indexes for table `tbl_question_replies`
--
ALTER TABLE `tbl_question_replies`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `reply_orquestion_id` (`reply_orquestion_id`);

--
-- Indexes for table `tbl_question_status`
--
ALTER TABLE `tbl_question_status`
  ADD PRIMARY KEY (`qstatus_id`);

--
-- Indexes for table `tbl_remember_me`
--
ALTER TABLE `tbl_remember_me`
  ADD PRIMARY KEY (`remember_token`);

--
-- Indexes for table `tbl_social_platforms`
--
ALTER TABLE `tbl_social_platforms`
  ADD PRIMARY KEY (`splatform_id`);

--
-- Indexes for table `tbl_states`
--
ALTER TABLE `tbl_states`
  ADD PRIMARY KEY (`state_id`),
  ADD KEY `state_id` (`state_id`,`state_name`);

--
-- Indexes for table `tbl_subscriptions`
--
ALTER TABLE `tbl_subscriptions`
  ADD PRIMARY KEY (`subs_id`),
  ADD KEY `subs_id` (`subs_id`);

--
-- Indexes for table `tbl_testimonials`
--
ALTER TABLE `tbl_testimonials`
  ADD PRIMARY KEY (`testimonial_id`);

--
-- Indexes for table `tbl_tmp_orders`
--
ALTER TABLE `tbl_tmp_orders`
  ADD PRIMARY KEY (`tmp_order_date`,`tmp_session_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indexes for table `tbl_user_password_reset_requests`
--
ALTER TABLE `tbl_user_password_reset_requests`
  ADD PRIMARY KEY (`uprr_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_banners`
--
ALTER TABLE `tbl_banners`
  MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_blog_attached_files`
--
ALTER TABLE `tbl_blog_attached_files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_blog_contributions`
--
ALTER TABLE `tbl_blog_contributions`
  MODIFY `contribution_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_blog_meta_data`
--
ALTER TABLE `tbl_blog_meta_data`
  MODIFY `meta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_blog_post`
--
ALTER TABLE `tbl_blog_post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_blog_post_categories`
--
ALTER TABLE `tbl_blog_post_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_blog_post_comments`
--
ALTER TABLE `tbl_blog_post_comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_blog_post_images`
--
ALTER TABLE `tbl_blog_post_images`
  MODIFY `post_image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_cms_contents`
--
ALTER TABLE `tbl_cms_contents`
  MODIFY `cmsc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tbl_content_blocks`
--
ALTER TABLE `tbl_content_blocks`
  MODIFY `block_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_countries`
--
ALTER TABLE `tbl_countries`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_degrees`
--
ALTER TABLE `tbl_degrees`
  MODIFY `degree_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_doctors`
--
ALTER TABLE `tbl_doctors`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `tbl_doctor_degrees`
--
ALTER TABLE `tbl_doctor_degrees`
  MODIFY `docdegree_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_doctor_reviews`
--
ALTER TABLE `tbl_doctor_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `tbl_email_templates`
--
ALTER TABLE `tbl_email_templates`
  MODIFY `tpl_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_faq`
--
ALTER TABLE `tbl_faq`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_faq_category`
--
ALTER TABLE `tbl_faq_category`
  MODIFY `faqcat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_files`
--
ALTER TABLE `tbl_files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT for table `tbl_language_labels`
--
ALTER TABLE `tbl_language_labels`
  MODIFY `label_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=279;

--
-- AUTO_INCREMENT for table `tbl_medical_categories`
--
ALTER TABLE `tbl_medical_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tbl_navigations`
--
ALTER TABLE `tbl_navigations`
  MODIFY `nav_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_nav_links`
--
ALTER TABLE `tbl_nav_links`
  MODIFY `nl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tbl_order_questions`
--
ALTER TABLE `tbl_order_questions`
  MODIFY `orquestion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_order_subscriptions`
--
ALTER TABLE `tbl_order_subscriptions`
  MODIFY `orsubs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_order_transactions`
--
ALTER TABLE `tbl_order_transactions`
  MODIFY `tran_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_question_acceptance_log`
--
ALTER TABLE `tbl_question_acceptance_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_question_assign`
--
ALTER TABLE `tbl_question_assign`
  MODIFY `qassign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_question_replies`
--
ALTER TABLE `tbl_question_replies`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `tbl_question_status`
--
ALTER TABLE `tbl_question_status`
  MODIFY `qstatus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_social_platforms`
--
ALTER TABLE `tbl_social_platforms`
  MODIFY `splatform_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_states`
--
ALTER TABLE `tbl_states`
  MODIFY `state_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tbl_subscriptions`
--
ALTER TABLE `tbl_subscriptions`
  MODIFY `subs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_testimonials`
--
ALTER TABLE `tbl_testimonials`
  MODIFY `testimonial_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
