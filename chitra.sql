-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2014 at 03:29 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `chitra`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_info`
--

CREATE TABLE IF NOT EXISTS `account_info` (
  `user_id` int(11) NOT NULL,
  `amount_due` float NOT NULL,
  `oil_reserve` float NOT NULL,
  `oil_shipped` float NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_info`
--

INSERT INTO `account_info` (`user_id`, `amount_due`, `oil_reserve`, `oil_shipped`) VALUES
(1, 0, 0, 0),
(2, 8237.4, 70, 50),
(3, 753.4, 45, 0),
(4, 0, 0, 0),
(5, 0, 10, 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `all_clients`
--
CREATE TABLE IF NOT EXISTS `all_clients` (
`user_id` int(11)
,`user_type` int(11)
,`login_name` varchar(30)
,`password` varchar(30)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `all_traders`
--
CREATE TABLE IF NOT EXISTS `all_traders` (
`user_id` int(11)
,`user_type` int(11)
,`login_name` varchar(30)
,`password` varchar(30)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `all_transactions`
--
CREATE TABLE IF NOT EXISTS `all_transactions` (
);
-- --------------------------------------------------------

--
-- Table structure for table `associated_with`
--

CREATE TABLE IF NOT EXISTS `associated_with` (
  `client_id` int(11) NOT NULL,
  `trader_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `associated_with`
--

INSERT INTO `associated_with` (`client_id`, `trader_id`, `level_id`) VALUES
(2, 1, 1),
(3, 1, 2),
(5, 4, 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `gold_level_clients`
--
CREATE TABLE IF NOT EXISTS `gold_level_clients` (
`first_name` varchar(30)
,`last_name` varchar(30)
,`client_id` int(11)
,`trader_id` int(11)
,`level` varchar(10)
);
-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE IF NOT EXISTS `level` (
  `level_id` int(11) NOT NULL,
  `level` varchar(10) NOT NULL,
  `comm_in_oil` int(11) NOT NULL,
  `comm_in_cash` int(11) NOT NULL,
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`level_id`, `level`, `comm_in_oil`, `comm_in_cash`) VALUES
(1, 'silver', 10, 20),
(2, 'gold', 5, 10);

-- --------------------------------------------------------

--
-- Stand-in structure for view `monthly_transactions`
--
CREATE TABLE IF NOT EXISTS `monthly_transactions` (
`monthname` varchar(9)
,`totaltransactions` bigint(21)
);
-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE IF NOT EXISTS `payment_details` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `dop` date DEFAULT NULL,
  `doa` date DEFAULT NULL,
  UNIQUE KEY `payment_id` (`payment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `payment_details`
--

INSERT INTO `payment_details` (`payment_id`, `trans_id`, `client_id`, `dop`, `doa`) VALUES
(1, 1, 5, '2014-12-02', '2014-12-02'),
(2, 2, 2, '2014-12-02', NULL),
(3, 3, 2, '2014-12-02', NULL),
(4, 5, 2, NULL, NULL),
(5, 6, 2, NULL, NULL),
(6, 7, 3, '2014-12-02', '2014-12-02'),
(7, 8, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_transaction`
--

CREATE TABLE IF NOT EXISTS `payment_transaction` (
  `payment_id` int(11) NOT NULL,
  `amt_paid` float NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_transaction`
--

INSERT INTO `payment_transaction` (`payment_id`, `amt_paid`) VALUES
(1, 763.4),
(2, 1486.8),
(3, 2250.2),
(4, 0),
(5, 0),
(6, 2621.9),
(7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `user_id` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `street` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `state` varchar(30) NOT NULL,
  `zip_code` int(5) NOT NULL,
  `phone_no` int(11) NOT NULL,
  `cell_no` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`user_id`, `email`, `first_name`, `last_name`, `street`, `city`, `state`, `zip_code`, `phone_no`, `cell_no`) VALUES
(1, 'purva', 'Purva', 'Dahake', '2600 Waterview Pkwy #3535', 'Richardson', 'Texas', 75080, 2147483647, 1234567899),
(2, 'shilpa', 'Shilpa', 'Buddhadev', '2600 Waterview Pkwy #3535', 'Richardson', 'Texas', 75080, 2147483647, 1234567899),
(3, 'mayuri', 'Mayuri', 'Kini', '2600 Waterview Pkwy #3535', 'Richardson', 'Texas', 75080, 2147483647, 1234567899),
(4, 'chitra', 'Chitra', 'Hariharan', '2600 Waterview Pkwy #3535', 'Richardson', 'Texas', 75080, 2147483647, 1234567899),
(5, 'ankita', 'Ankita', 'Kawde', '2600 Waterview Pkwy #3535', 'Richardson', 'Texas', 75080, 2147483647, 1234567899);

-- --------------------------------------------------------

--
-- Stand-in structure for view `silver_level_clients`
--
CREATE TABLE IF NOT EXISTS `silver_level_clients` (
`first_name` varchar(30)
,`last_name` varchar(30)
,`client_id` int(11)
,`trader_id` int(11)
,`level` varchar(10)
);
-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `trans_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `trans_type` varchar(5) NOT NULL,
  `trans_fee` float NOT NULL,
  `oil_requested` float NOT NULL,
  `comm_amt` float NOT NULL,
  `comm_type` varchar(5) NOT NULL,
  `total_amt` float NOT NULL,
  `total_oil` float NOT NULL,
  `dor` date NOT NULL,
  `doa` date NOT NULL,
  `shipped` varchar(3) NOT NULL,
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`trans_id`, `client_id`, `trans_type`, `trans_fee`, `oil_requested`, `comm_amt`, `comm_type`, `total_amt`, `total_oil`, `dor`, `doa`, `shipped`) VALUES
(1, 5, 'Buy', 743.4, 10, 20, 'Cash', 763.4, 10, '2014-11-20', '2014-11-21', 'No'),
(2, 2, 'Buy', 1486.8, 20, 0, 'Oil', 1486.8, 10, '2014-11-22', '2014-11-22', 'No'),
(3, 2, 'Buy', 2230.2, 30, 20, 'Cash', 2250.2, 30, '2014-11-23', '2014-11-23', 'No'),
(4, 2, 'sell', 0, 10, 0, ' ', 0, 10, '2014-12-02', '2014-12-02', ''),
(5, 2, 'sell', 0, 30, 0, '', 0, 30, '2014-12-02', '2014-12-02', ''),
(6, 2, 'buy', 3717, 50, 20, 'Cash', 3737, 50, '2014-12-02', '2014-12-02', 'Yes'),
(7, 3, 'Buy', 2601.9, 35, 20, 'Cash', 2621.9, 35, '2014-11-02', '2014-11-02', 'No'),
(8, 3, 'Buy', 743.4, 10, 10, 'Cash', 753.4, 10, '2014-12-02', '2014-12-02', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type` int(11) NOT NULL,
  `login_name` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `login_name` (`login_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_type`, `login_name`, `password`) VALUES
(1, 2, 'purva', 'purvadahake'),
(2, 1, 'shilpa', 'shilpabuddhadev'),
(3, 1, 'mayuri', 'mayurikini'),
(4, 2, 'chitra', 'chitrahariharan'),
(5, 1, 'ankita', 'ankitakawde'),
(6, 3, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Structure for view `all_clients`
--
DROP TABLE IF EXISTS `all_clients`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `all_clients` AS select `user`.`user_id` AS `user_id`,`user`.`user_type` AS `user_type`,`user`.`login_name` AS `login_name`,`user`.`password` AS `password` from `user` where (`user`.`user_type` = 1);

-- --------------------------------------------------------

--
-- Structure for view `all_traders`
--
DROP TABLE IF EXISTS `all_traders`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `all_traders` AS select `user`.`user_id` AS `user_id`,`user`.`user_type` AS `user_type`,`user`.`login_name` AS `login_name`,`user`.`password` AS `password` from `user` where (`user`.`user_type` = 2);

-- --------------------------------------------------------

--
-- Structure for view `all_transactions`
--
DROP TABLE IF EXISTS `all_transactions`;
-- in use(#1356 - View 'chitra.all_transactions' references invalid table(s) or column(s) or function(s) or definer/invoker of view lack rights to use them)

-- --------------------------------------------------------

--
-- Structure for view `gold_level_clients`
--
DROP TABLE IF EXISTS `gold_level_clients`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `gold_level_clients` AS select `p`.`first_name` AS `first_name`,`p`.`last_name` AS `last_name`,`a`.`client_id` AS `client_id`,`a`.`trader_id` AS `trader_id`,`l`.`level` AS `level` from ((`profile` `p` join `associated_with` `a` on((`p`.`user_id` = `a`.`client_id`))) join `level` `l` on((`l`.`level_id` = `a`.`level_id`))) where (`l`.`level` like 'gold');

-- --------------------------------------------------------

--
-- Structure for view `monthly_transactions`
--
DROP TABLE IF EXISTS `monthly_transactions`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `monthly_transactions` AS select monthname(`transaction`.`dor`) AS `monthname`,count(0) AS `totaltransactions` from `transaction` where ((`transaction`.`dor` > '2014-12-01') and (`transaction`.`dor` < '2014-12-31')) group by monthname(`transaction`.`dor`);

-- --------------------------------------------------------

--
-- Structure for view `silver_level_clients`
--
DROP TABLE IF EXISTS `silver_level_clients`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `silver_level_clients` AS select `p`.`first_name` AS `first_name`,`p`.`last_name` AS `last_name`,`a`.`client_id` AS `client_id`,`a`.`trader_id` AS `trader_id`,`l`.`level` AS `level` from ((`profile` `p` join `associated_with` `a` on((`p`.`user_id` = `a`.`client_id`))) join `level` `l` on((`l`.`level_id` = `a`.`level_id`))) where (`l`.`level` like 'silver');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_info`
--
ALTER TABLE `account_info`
  ADD CONSTRAINT `account_info_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `associated_with`
--
ALTER TABLE `associated_with`
  ADD CONSTRAINT `associated_with_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
