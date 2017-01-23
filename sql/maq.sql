-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2017 at 05:42 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maq`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notifications`
--

CREATE TABLE `tbl_notifications` (
  `fld_notification_id` int(11) NOT NULL,
  `fld_user_id` int(11) NOT NULL,
  `fld_read` int(11) NOT NULL,
  `fld_message` text NOT NULL,
  `fld_subject` varchar(255) NOT NULL,
  `fld_date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fld_date_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_notifications`
--

INSERT INTO `tbl_notifications` (`fld_notification_id`, `fld_user_id`, `fld_read`, `fld_message`, `fld_subject`, `fld_date_created`, `fld_date_updated`) VALUES
(1, 1, 1, 'testing', 'New quiz', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 5, 1, 'A quiz from your section has landed and it needs to be answered.\n                    The schedule starts on 2017-01-01T01:00 until 2017-01-01T01:00.\n                    <a href="/maq/section_quiz_view.php?id=4"><strong>View Quiz</strong></a>', 'Quiz has landed!', '2017-01-15 15:41:45', '0000-00-00 00:00:00'),
(3, 5, 1, 'A quiz from your section has landed and it needs to be answered.\r\n                    The schedule starts on 2017-01-Sun 01:00:00 until 2017-01-Mon 00:00:00.\r\n                    <a href="/maq/section_quiz_view.php?id=5"><strong>View Quiz</strong></a>', 'Quiz has landed!', '2017-01-15 16:02:02', '0000-00-00 00:00:00'),
(4, 5, 1, 'A quiz from your section has landed and it needs to be answered.\r\n                    The schedule starts on 2017-01-Sun 01:00:00 until 2017-03-Wed 01:00:00.\r\n                    <a href="/maq/section_quiz_view.php?id=6"><strong>View Quiz</strong></a>', 'Quiz has landed!', '2017-01-16 21:30:58', '0000-00-00 00:00:00'),
(5, 5, 1, 'A quiz from your section has landed and it needs to be answered.\r\n                    The schedule starts on 2017-01-Wed 01:00:00 until 2017-01-Tue 01:00:00.\r\n                    <a href="/maq/section_quiz_view.php?id=7"><strong>View Quiz</strong></a>', 'Quiz has landed!', '2017-01-18 23:08:13', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_profiles`
--

CREATE TABLE `tbl_profiles` (
  `fld_profile_id` int(11) NOT NULL,
  `fld_first_name` varchar(150) DEFAULT NULL,
  `fld_middle_name` varchar(150) DEFAULT NULL,
  `fld_last_name` varchar(150) DEFAULT NULL,
  `fld_gender` varchar(20) DEFAULT NULL,
  `fld_contact_no` varchar(45) DEFAULT NULL,
  `fld_address` longtext,
  `fld_course` varchar(45) DEFAULT NULL,
  `fld_student_id` varchar(45) DEFAULT NULL,
  `fld_year_level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_profiles`
--

INSERT INTO `tbl_profiles` (`fld_profile_id`, `fld_first_name`, `fld_middle_name`, `fld_last_name`, `fld_gender`, `fld_contact_no`, `fld_address`, `fld_course`, `fld_student_id`, `fld_year_level`) VALUES
(1, 'joel', 'lagman', 'garcia', 'male', '', '', NULL, '8976543', NULL),
(2, 'joel', 'lagman', 'garcia', 'male', '', '', NULL, '123457', NULL),
(3, 'joel', 'lagman', 'garcia', 'male', '', '', NULL, '213123', NULL),
(4, 'joel', 'lagman', 'garcia', 'male', '', '', NULL, '8276327362', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quizzes`
--

CREATE TABLE `tbl_quizzes` (
  `fld_quiz_id` int(11) NOT NULL,
  `fld_title` varchar(150) DEFAULT NULL,
  `fld_subject_id` int(11) NOT NULL,
  `fld_instruction` text NOT NULL,
  `fld_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_quizzes`
--

INSERT INTO `tbl_quizzes` (`fld_quiz_id`, `fld_title`, `fld_subject_id`, `fld_instruction`, `fld_user_id`) VALUES
(1, 'ewqertyu', 1, '', 0),
(2, 'ewqertyu', 1, '', 0),
(3, 'ewqertyu', 1, '', 0),
(4, 'eqweqweqwe', 2, 'qweqe', 0),
(5, 'updated', 3, 'gaggaga', 0),
(6, 'something to test on', 3, 'qehqiuwehqiueghiuqgweiuegbfisdf', 2),
(7, 'testing image', 3, '', 2),
(8, 'trestretreojnijrniufshiufdh', 3, '', 2),
(9, 'wqeqweqeqwe', 3, '', 2),
(10, 'qweqwewqe', 3, 'qweqwe', 2),
(11, 'qwerwtyjkl;', 3, 'lythdrgsfdg', 2),
(12, 'ertghjgfdsa', 3, 'dfghjg', 2),
(13, 'weqrtyuklkjhgf', 3, 'sdrtfyuijhh', 2),
(14, 'mt', 3, '', 2),
(15, 'wqeqweqweqwe', 3, 'weqqeqwe', 2),
(16, 'treytrhtrhretera', 3, 'wqewqe', 2),
(17, 'treytrhtrhretera', 3, 'wqewqe', 2),
(18, 'qweqtrylnjklhg', 3, 'fdgdfdf', 2),
(19, 'qweqtrylnjklhg', 3, 'fdgdfdf', 2),
(20, 'ewqtytiuyut', 3, 'rteewr', 2),
(21, 'ewqeqweqwe', 3, 'eqweqw', 2),
(22, 'ewqeqweqwe', 3, 'eqweqw', 2),
(23, 'wertyjkjdfs', 3, 'fdsfsdf', 2),
(24, 'qeweyttjer', 3, 'eqw', 2),
(25, 'etyuiytuerw', 3, 'qwe', 2),
(26, 'etyuiytuerw', 3, 'qwe', 2),
(27, 'etyuiytuerw', 3, 'qwe', 2),
(28, 'etyuiytuerw', 3, 'qwe', 2),
(29, 'dqweqweqwe', 3, 'qweweqeqwe', 2),
(30, 'yerwtyuioplkuytr', 3, 'yughhfy', 2),
(31, 'rettrtenijhetjh', 3, '', 2),
(32, 'EXAMPLE01', 3, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quiz_questions`
--

CREATE TABLE `tbl_quiz_questions` (
  `fld_quiz_question_id` int(11) NOT NULL,
  `fld_question` longtext,
  `fld_category` varchar(45) DEFAULT NULL,
  `fld_quiz_id` int(11) NOT NULL,
  `fld_video` varchar(255) DEFAULT NULL,
  `fld_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_quiz_questions`
--

INSERT INTO `tbl_quiz_questions` (`fld_quiz_question_id`, `fld_question`, `fld_category`, `fld_quiz_id`, `fld_video`, `fld_image`) VALUES
(1, 'qweqweqweqwe', 'tf', 4, '', ''),
(2, 'rtyfty', 'sa', 4, '', ''),
(4, 'qweqwe', 'tf', 5, '', ''),
(5, 'eqweqwe', 'mc', 5, '', ''),
(6, 'testing this question', 'mc', 4, '', ''),
(7, 'wow so much wow', 'mc', 6, '', ''),
(8, 'treu ba', 'tf', 6, '', ''),
(9, 'eqwertyuererwer', 'cb', 8, NULL, NULL),
(10, 'ertyiuokuyt', 'cb', 9, NULL, NULL),
(11, 'wqeqweqwewqe', 'cb', 10, NULL, NULL),
(12, 'ewqeqweqwe', 'sa', 11, NULL, NULL),
(13, 'eqweqweqweqwe', 'mc', 12, NULL, NULL),
(14, 'ewstyukujhrg', 'mc', 13, NULL, '1484490960_q4t1ulzu.jpg'),
(15, 'testing mt', 'cb', 14, NULL, NULL),
(16, 'tyuioiuytre', 'cb', 15, NULL, NULL),
(17, 'rwerwerwerer', 'cb', 16, NULL, NULL),
(18, 'rwerwerwerer', 'cb', 17, NULL, NULL),
(19, 'eqwrtyuiiuouyitytr', 'cb', 18, NULL, NULL),
(20, 'eqwrtyuiiuouyitytr', 'cb', 19, NULL, NULL),
(21, 'riouyt', 'cb', 20, NULL, NULL),
(22, 'ewqrtyiuytrter', 'cb', 21, NULL, NULL),
(23, 'ewqrtyiuytrter', 'cb', 22, NULL, NULL),
(24, 'ertyuiopuytre', 'mt', 23, NULL, NULL),
(25, '[Duterte] is the President of the Philippines', 'fb', 24, NULL, NULL),
(26, '[Duterte] is the President of the Philippines', 'fb', 25, NULL, NULL),
(27, '[Duterte] is the President of the Philippines', 'fb', 26, NULL, NULL),
(28, '[Duterte] is the President of the Philippines', 'fb', 27, NULL, NULL),
(29, '[Duterte] is the President of the Philippines', 'fb', 28, NULL, NULL),
(30, '[Duterte] is the [President] of the Philippines', 'fb', 29, NULL, NULL),
(31, '[Duterte] is the [President] of the Philippines.', 'fb', 30, NULL, NULL),
(32, '[Duterte] is the [President] of the Philippines', 'fb', 31, NULL, NULL),
(33, 'match this type', 'mt', 32, NULL, '1484573296_q4t1ulzu.jpg'),
(34, 'what is the most beautiful thing in the world', 'cb', 32, NULL, NULL),
(35, '[Duterte] is the [President] of the Philippines', 'fb', 32, NULL, NULL),
(36, 'multiple choice', 'mc', 31, NULL, NULL),
(37, 'what is qjeiojqiwoejqweiqe', 'sa', 31, NULL, NULL),
(38, 'is it true?', 'tf', 31, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quiz_question_answers`
--

CREATE TABLE `tbl_quiz_question_answers` (
  `fld_quiz_question_answer_id` int(11) NOT NULL,
  `fld_answer` longtext,
  `fld_correct` int(11) DEFAULT NULL,
  `fld_quiz_question_id` int(11) NOT NULL,
  `fld_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_quiz_question_answers`
--

INSERT INTO `tbl_quiz_question_answers` (`fld_quiz_question_answer_id`, `fld_answer`, `fld_correct`, `fld_quiz_question_id`, `fld_order`) VALUES
(1, 'true', 1, 1, 0),
(2, 'rtsyhjygfk', 1, 2, 0),
(3, 'ftdser', 1, 2, 0),
(4, 'rtyudxdrt', 1, 2, 0),
(5, 'yuioph;kjgfdxt', 0, 4, 0),
(6, 'tseryiol;uippuiyiftydxt', 1, 4, 0),
(7, 'ryftcyioi;jbkfxdgzser', 0, 4, 0),
(8, 'true', 1, 4, 0),
(9, 'wqewtyu', 1, 5, 0),
(10, 'hgfhgdsf', 0, 5, 0),
(11, 'fdgkjl;lkjhgf', 0, 5, 0),
(12, 'adam', 1, 6, 0),
(13, 'coolaide', 0, 6, 0),
(14, 'cancer', 0, 6, 0),
(15, 'lol', 0, 6, 0),
(16, 'answe1', 0, 7, 0),
(17, 'answer2', 0, 7, 0),
(18, 'answer3', 0, 7, 0),
(19, 'true', 1, 8, 0),
(20, 'Array', 1, 9, 0),
(21, 'Array', 1, 9, 0),
(22, 'Array', 1, 9, 0),
(23, 'Array', 1, 10, 0),
(24, 'Array', 1, 10, 0),
(25, 'Array', 1, 10, 0),
(26, 'Array', 1, 11, 0),
(27, 'ewqeqw', 1, 12, 0),
(28, 'qeqweqwe', 1, 12, 0),
(29, 'Array', 1, 15, 0),
(30, 'Array', 1, 15, 0),
(31, 'Array', 1, 15, 0),
(32, 'Array', 1, 15, 0),
(33, 'Array', 1, 16, 0),
(34, 'Array', 1, 16, 0),
(35, 'Array', 1, 16, 0),
(36, 'Array', 1, 20, 0),
(37, 'Array', 1, 20, 0),
(38, 'Array', 1, 20, 0),
(39, 'Array', 1, 20, 0),
(40, '1', 1, 24, 0),
(41, '1', 1, 24, 0),
(42, '2', 1, 24, 1),
(43, '2', 1, 24, 1),
(44, '3', 1, 24, 2),
(45, '4', 1, 24, 2),
(46, '[Duterte]', 1, 29, 0),
(47, 'Duterte', 1, 30, 0),
(48, 'President', 1, 30, 0),
(49, 'Array', 1, 31, 0),
(50, 'Array', 1, 31, 0),
(51, 'Duterte', 1, 32, 0),
(52, 'President', 1, 32, 1),
(53, '1', 1, 33, 0),
(54, '1', 1, 33, 0),
(55, '2', 1, 33, 1),
(56, '2', 1, 33, 1),
(57, '3', 1, 33, 2),
(58, '3', 1, 33, 2),
(59, '4', 1, 33, 3),
(60, '4', 1, 33, 3),
(61, 'me', 0, 34, 0),
(62, 'you', 1, 34, 0),
(63, 'Duterte', 1, 35, 0),
(64, 'President', 1, 35, 1),
(65, 'wqwewq', 0, 36, 0),
(66, 'otkspoerjpoej', 0, 36, 0),
(67, 'psdfjioshgidhg', 1, 36, 0),
(68, 'nigga', 1, 37, 0),
(69, 'true', 1, 38, 0),
(70, 'this is tqweqwke', 1, 39, 0),
(71, 'peoitnergnoignwi', 0, 39, 0),
(72, '2i4tj34ithgflh,fphkd[h', 0, 39, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_registration_codes`
--

CREATE TABLE `tbl_registration_codes` (
  `fld_registration_code_id` int(11) NOT NULL,
  `fld_code` varchar(255) NOT NULL,
  `fld_date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fld_status` int(11) NOT NULL,
  `fld_section_id` int(11) NOT NULL,
  `fld_role` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_registration_codes`
--

INSERT INTO `tbl_registration_codes` (`fld_registration_code_id`, `fld_code`, `fld_date_created`, `fld_status`, `fld_section_id`, `fld_role`) VALUES
(1, '5adb97ea53', '2017-01-07 01:38:08', 1, 1, 'student'),
(2, '87bcd003840f', '2017-01-07 01:42:10', 1, 1, 'student'),
(3, 'e5fa50d78a8c', '2017-01-07 01:42:10', 0, 1, 'student'),
(4, '88422ee5f379', '2017-01-07 01:42:10', 0, 1, 'student'),
(5, '39afe57134e3', '2017-01-07 01:42:11', 0, 1, 'student'),
(6, '232ea4a7cdc4', '2017-01-07 01:42:11', 0, 1, 'student'),
(7, '273efd5a6bbc', '2017-01-07 01:42:11', 0, 1, 'student'),
(8, '7b8ec4cf7a2d', '2017-01-07 01:42:11', 0, 1, 'student'),
(9, 'd0524e9cebd6', '2017-01-07 01:42:11', 0, 1, 'student'),
(10, '186781445389', '2017-01-07 01:42:11', 0, 1, 'student'),
(11, '596addb82c26', '2017-01-07 01:42:11', 0, 1, 'student'),
(12, 'b618e42d9f9e', '2017-01-07 01:42:26', 0, 1, 'student'),
(13, 'be2998ae4b91', '2017-01-07 01:42:26', 0, 1, 'student'),
(14, '845cf6a0a6d7', '2017-01-07 01:42:26', 0, 1, 'student'),
(15, 'db6a9f20d616', '2017-01-07 01:42:26', 0, 1, 'student'),
(16, '5fdb00abaf86', '2017-01-07 01:42:26', 0, 1, 'student');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rooms`
--

CREATE TABLE `tbl_rooms` (
  `fld_room_id` int(11) NOT NULL,
  `fld_name` varchar(45) DEFAULT NULL,
  `fld_status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_rooms`
--

INSERT INTO `tbl_rooms` (`fld_room_id`, `fld_name`, `fld_status`) VALUES
(1, 'P402', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_schedules`
--

CREATE TABLE `tbl_schedules` (
  `fld_schedule_id` int(11) NOT NULL,
  `fld_time_start` time DEFAULT NULL,
  `fld_time_end` time DEFAULT NULL,
  `fld_day` varchar(45) DEFAULT NULL,
  `fld_section_id` int(11) NOT NULL,
  `fld_room_id` int(11) NOT NULL,
  `fld_subject_id` int(11) NOT NULL,
  `fld_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_schedules`
--

INSERT INTO `tbl_schedules` (`fld_schedule_id`, `fld_time_start`, `fld_time_end`, `fld_day`, `fld_section_id`, `fld_room_id`, `fld_subject_id`, `fld_user_id`) VALUES
(2, '13:00:00', '14:00:00', 'M', 1, 1, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sections`
--

CREATE TABLE `tbl_sections` (
  `fld_section_id` int(11) NOT NULL,
  `fld_name` varchar(150) DEFAULT NULL,
  `fld_year_level` int(11) DEFAULT NULL,
  `fld_course` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_sections`
--

INSERT INTO `tbl_sections` (`fld_section_id`, `fld_name`, `fld_year_level`, `fld_course`) VALUES
(1, 'HOPES', 1, 'ABM');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_section_quizzes`
--

CREATE TABLE `tbl_section_quizzes` (
  `fld_section_quiz_id` int(11) NOT NULL,
  `fld_section_id` int(11) NOT NULL,
  `fld_quiz_id` int(11) NOT NULL,
  `fld_start_on` datetime DEFAULT NULL,
  `fld_end_on` datetime DEFAULT NULL,
  `fld_status` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_section_quizzes`
--

INSERT INTO `tbl_section_quizzes` (`fld_section_quiz_id`, `fld_section_id`, `fld_quiz_id`, `fld_start_on`, `fld_end_on`, `fld_status`) VALUES
(5, 1, 6, '2017-01-01 01:00:00', '2017-01-20 00:00:00', '1'),
(6, 1, 32, '2017-01-01 01:00:00', '2017-03-01 01:00:00', '1'),
(7, 1, 31, '2017-01-18 01:00:00', '2017-01-31 01:00:00', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_section_quiz_student_answers`
--

CREATE TABLE `tbl_section_quiz_student_answers` (
  `fld_section_quiz_student_answer_id` int(11) NOT NULL,
  `fld_answer` varchar(45) DEFAULT NULL,
  `fld_date_answered` datetime DEFAULT CURRENT_TIMESTAMP,
  `fld_section_quiz_id` int(11) NOT NULL,
  `fld_section_student_id` int(11) NOT NULL,
  `fld_correct` int(1) NOT NULL,
  `fld_quiz_question_id` int(11) NOT NULL,
  `fld_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_section_quiz_student_answers`
--

INSERT INTO `tbl_section_quiz_student_answers` (`fld_section_quiz_student_answer_id`, `fld_answer`, `fld_date_answered`, `fld_section_quiz_id`, `fld_section_student_id`, `fld_correct`, `fld_quiz_question_id`, `fld_order`) VALUES
(1, 'test\r\n\r\n', '2017-01-11 19:41:46', 1, 1, 0, 2, 0),
(4, 'true', '2017-01-11 20:17:39', 1, 1, 1, 1, 0),
(10, 'adam', '2017-01-11 22:34:46', 1, 1, 1, 6, 0),
(11, 'answe1', '2017-01-16 21:24:25', 5, 1, 0, 7, 0),
(12, 'true', '2017-01-16 21:24:33', 5, 1, 1, 8, 0),
(15, 'duterte', '2017-01-17 22:07:11', 6, 1, 1, 35, 0),
(16, 'president', '2017-01-17 22:07:11', 6, 1, 1, 35, 1),
(17, 'hello world', '2017-01-18 23:08:58', 7, 1, 0, 37, 0),
(18, 'otkspoerjpoej', '2017-01-18 23:09:00', 7, 1, 0, 36, 0),
(19, 'false', '2017-01-18 23:09:03', 7, 1, 0, 38, 0),
(20, 'duterte', '2017-01-18 23:09:17', 7, 1, 1, 32, 0),
(21, 'president', '2017-01-18 23:09:17', 7, 1, 1, 32, 1),
(22, 'this is tqweqwke', '2017-01-18 23:13:03', 7, 1, 1, 39, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_section_quiz_summaries`
--

CREATE TABLE `tbl_section_quiz_summaries` (
  `fld_section_quiz_summary_id` int(11) NOT NULL,
  `fld_total_questions` int(11) DEFAULT NULL,
  `fld_date_summarized` datetime DEFAULT CURRENT_TIMESTAMP,
  `fld_section_quiz_id` int(11) NOT NULL,
  `fld_section_student_id` int(11) NOT NULL,
  `fld_score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_section_quiz_summaries`
--

INSERT INTO `tbl_section_quiz_summaries` (`fld_section_quiz_summary_id`, `fld_total_questions`, `fld_date_summarized`, `fld_section_quiz_id`, `fld_section_student_id`, `fld_score`) VALUES
(2, 3, '2017-01-11 22:34:46', 1, 1, 2),
(3, 2, '2017-01-16 21:24:33', 5, 1, 1),
(4, 5, '2017-01-18 23:09:17', 7, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_section_students`
--

CREATE TABLE `tbl_section_students` (
  `fld_section_student_id` int(11) NOT NULL,
  `fld_section_id` int(11) NOT NULL,
  `fld_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_section_students`
--

INSERT INTO `tbl_section_students` (`fld_section_student_id`, `fld_section_id`, `fld_user_id`) VALUES
(1, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_section_teachers`
--

CREATE TABLE `tbl_section_teachers` (
  `tbl_section_teacher_id` int(11) NOT NULL,
  `fld_user_id` int(11) NOT NULL,
  `fld_section_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_section_teachers`
--

INSERT INTO `tbl_section_teachers` (`tbl_section_teacher_id`, `fld_user_id`, `fld_section_id`) VALUES
(1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subjects`
--

CREATE TABLE `tbl_subjects` (
  `fld_subject_id` int(11) NOT NULL,
  `fld_name` varchar(100) DEFAULT NULL,
  `fld_description` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_subjects`
--

INSERT INTO `tbl_subjects` (`fld_subject_id`, `fld_name`, `fld_description`) VALUES
(2, 'Math1', 'Mathematical'),
(3, 'Math', 'Mathematical');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `fld_user_id` int(11) NOT NULL,
  `fld_username` varchar(45) DEFAULT NULL,
  `fld_password` varchar(45) DEFAULT NULL,
  `fld_last_login` datetime DEFAULT NULL,
  `fld_role` varchar(45) DEFAULT NULL,
  `fld_profile_id` int(11) NOT NULL,
  `fld_joined` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fld_registration_code_id` int(25) NOT NULL,
  `fld_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`fld_user_id`, `fld_username`, `fld_password`, `fld_last_login`, `fld_role`, `fld_profile_id`, `fld_joined`, `fld_registration_code_id`, `fld_status`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '2017-01-18 20:11:18', 'admin', 0, '2016-12-20 21:58:34', 0, 0),
(2, 'teacher', '8d788385431273d11e8b43bb78f3aa41', '2017-01-18 23:15:13', 'teacher', 1, '2017-01-05 21:41:26', 0, 0),
(3, 'student', 'cd73502828457d15655bbd7a63fb0bc8', '2017-01-15 01:03:50', 'student', 2, '2017-01-07 11:02:41', 1, 0),
(4, 'student1', '5e5545d38a68148a2d5bd5ec9a89e327', NULL, 'student', 3, '2017-01-07 11:13:55', 1, 0),
(5, 'student2', '213ee683360d88249109c2f92789dbc3', '2017-01-18 23:08:21', 'student', 4, '2017-01-07 11:15:10', 2, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  ADD PRIMARY KEY (`fld_notification_id`);

--
-- Indexes for table `tbl_profiles`
--
ALTER TABLE `tbl_profiles`
  ADD PRIMARY KEY (`fld_profile_id`);

--
-- Indexes for table `tbl_quizzes`
--
ALTER TABLE `tbl_quizzes`
  ADD PRIMARY KEY (`fld_quiz_id`);

--
-- Indexes for table `tbl_quiz_questions`
--
ALTER TABLE `tbl_quiz_questions`
  ADD PRIMARY KEY (`fld_quiz_question_id`);

--
-- Indexes for table `tbl_quiz_question_answers`
--
ALTER TABLE `tbl_quiz_question_answers`
  ADD PRIMARY KEY (`fld_quiz_question_answer_id`);

--
-- Indexes for table `tbl_registration_codes`
--
ALTER TABLE `tbl_registration_codes`
  ADD PRIMARY KEY (`fld_registration_code_id`),
  ADD UNIQUE KEY `fld_code` (`fld_code`);

--
-- Indexes for table `tbl_rooms`
--
ALTER TABLE `tbl_rooms`
  ADD PRIMARY KEY (`fld_room_id`);

--
-- Indexes for table `tbl_schedules`
--
ALTER TABLE `tbl_schedules`
  ADD PRIMARY KEY (`fld_schedule_id`);

--
-- Indexes for table `tbl_sections`
--
ALTER TABLE `tbl_sections`
  ADD PRIMARY KEY (`fld_section_id`);

--
-- Indexes for table `tbl_section_quizzes`
--
ALTER TABLE `tbl_section_quizzes`
  ADD PRIMARY KEY (`fld_section_quiz_id`);

--
-- Indexes for table `tbl_section_quiz_student_answers`
--
ALTER TABLE `tbl_section_quiz_student_answers`
  ADD PRIMARY KEY (`fld_section_quiz_student_answer_id`);

--
-- Indexes for table `tbl_section_quiz_summaries`
--
ALTER TABLE `tbl_section_quiz_summaries`
  ADD PRIMARY KEY (`fld_section_quiz_summary_id`);

--
-- Indexes for table `tbl_section_students`
--
ALTER TABLE `tbl_section_students`
  ADD PRIMARY KEY (`fld_section_student_id`);

--
-- Indexes for table `tbl_section_teachers`
--
ALTER TABLE `tbl_section_teachers`
  ADD PRIMARY KEY (`tbl_section_teacher_id`);

--
-- Indexes for table `tbl_subjects`
--
ALTER TABLE `tbl_subjects`
  ADD PRIMARY KEY (`fld_subject_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`fld_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  MODIFY `fld_notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_profiles`
--
ALTER TABLE `tbl_profiles`
  MODIFY `fld_profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_quizzes`
--
ALTER TABLE `tbl_quizzes`
  MODIFY `fld_quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `tbl_quiz_questions`
--
ALTER TABLE `tbl_quiz_questions`
  MODIFY `fld_quiz_question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `tbl_quiz_question_answers`
--
ALTER TABLE `tbl_quiz_question_answers`
  MODIFY `fld_quiz_question_answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `tbl_registration_codes`
--
ALTER TABLE `tbl_registration_codes`
  MODIFY `fld_registration_code_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `tbl_rooms`
--
ALTER TABLE `tbl_rooms`
  MODIFY `fld_room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_schedules`
--
ALTER TABLE `tbl_schedules`
  MODIFY `fld_schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_sections`
--
ALTER TABLE `tbl_sections`
  MODIFY `fld_section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_section_quizzes`
--
ALTER TABLE `tbl_section_quizzes`
  MODIFY `fld_section_quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tbl_section_quiz_student_answers`
--
ALTER TABLE `tbl_section_quiz_student_answers`
  MODIFY `fld_section_quiz_student_answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `tbl_section_quiz_summaries`
--
ALTER TABLE `tbl_section_quiz_summaries`
  MODIFY `fld_section_quiz_summary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `tbl_section_students`
--
ALTER TABLE `tbl_section_students`
  MODIFY `fld_section_student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_section_teachers`
--
ALTER TABLE `tbl_section_teachers`
  MODIFY `tbl_section_teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_subjects`
--
ALTER TABLE `tbl_subjects`
  MODIFY `fld_subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `fld_user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
