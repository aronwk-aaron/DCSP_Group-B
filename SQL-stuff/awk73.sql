-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2017 at 12:32 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `awk73`
--

-- --------------------------------------------------------

--
-- Table structure for table `lab5_users`
--

CREATE TABLE `lab5_users` (
  `forename` varchar(32) NOT NULL,
  `surname` varchar(32) NOT NULL,
  `type` varchar(10) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lab5_users`
--

INSERT INTO `lab5_users` (`forename`, `surname`, `type`, `username`, `password`) VALUES
('Super', 'User', 'admin', 'admin', '6e8204c0862ec8abecb49762f0899554'),
('Bill', 'Smith', 'user', 'bsmith', '32aa0c466818e1ccba25b8793db98c94'),
('Pauline', 'Jones', 'user', 'pjones', '53eb1f29c1f8a132441a4fad1d6f667d');

-- --------------------------------------------------------

--
-- Table structure for table `nb_carts`
--

CREATE TABLE `nb_carts` (
  `cartID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nb_carts`
--

INSERT INTO `nb_carts` (`cartID`, `userID`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `nb_history`
--

CREATE TABLE `nb_history` (
  `orderNum` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nb_history`
--

INSERT INTO `nb_history` (`orderNum`, `userID`) VALUES
(1, 1),
(2, 1),
(3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `nb_inventory`
--

CREATE TABLE `nb_inventory` (
  `bookID` int(11) NOT NULL AUTO_INCREMENT,
  `isbn` char(13) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `author` varchar(128) DEFAULT NULL,
  `publisher` varchar(128) DEFAULT NULL,
  `genre` varchar(128) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `inStock` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nb_inventory`
--

INSERT INTO `nb_inventory` (`bookID`, `isbn`, `title`, `author`, `publisher`, `genre`, `price`, `quantity`, `inStock`) VALUES
(1, '1234567891011', 'Origin: A Novel', 'Dan Brown', 'Doubleday', 'Fiction', 15, 12, 1),
(2, '1110987654321', 'Easy Spanish Step-By-Step', 'Barbara Bregstein', 'McGraw-Hill Education', 'Educational', 10, 18, 1),
(3, '1346792581110', 'Deception Point', 'Dan Brown', 'Atria Books', 'Fiction', 17, 8, 1),
(4, '8527419633164', 'The Catcher in the Rye', 'J.D. Salinger', 'Brown and Company', 'Fiction', 9, 20, 1),
(5, '7945863212315', 'In Cold Blood', 'Truman Capote', 'Random House', 'Non-Fiction', 15, 5, 1),
(6, '1973468252589', 'Silent Spring', 'Rachel Carson', 'Houghton Mifflin', 'Non-Fiction', 10, 13, 1),
(7, '9789469132558', 'Romeo and Juliet', 'William Shakespeare', 'Unknown', 'Play', 19, 20, 1),
(8, '3521468769545', 'The Old Curiosity Shop', 'Charles Dickens', 'Chapman And Hall', 'Fiction', 7, 3, 1),
(9, '6584791325222', 'Fifty Shades of Grey', 'E. L. James', 'Vintage Books', 'Romance', 19, 12, 1),
(10, '9996663332154', 'Pride and Prejudice', 'Jane Austen', 'Whitehall', 'Romance', 15, 25, 1);

-- --------------------------------------------------------

--
-- Table structure for table `nb_rentprice`
--

CREATE TABLE `nb_rentprice` (
  `rentPrice` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nb_rentprice`
--

INSERT INTO `nb_rentprice` (`rentPrice`) VALUES
(2);

-- --------------------------------------------------------

--
-- Table structure for table `nb_usercarts`
--

CREATE TABLE `nb_usercarts` (
  `cartID` int(11) NOT NULL,
  `bookID` int(11) NOT NULL,
  `isRent` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nb_usercarts`
--

INSERT INTO `nb_usercarts` (`cartID`, `bookID`, `isRent`) VALUES
(1, 1, 0),
(1, 3, 0),
(1, 4, 0),
(2, 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `nb_userhistory`
--

CREATE TABLE `nb_userhistory` (
  `orderNum` int(11) NOT NULL,
  `bookID` int(11) NOT NULL,
  `datePurch` date DEFAULT NULL,
  `dueDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nb_userhistory`
--

INSERT INTO `nb_userhistory` (`orderNum`, `bookID`, `datePurch`, `dueDate`) VALUES
(1, 3, '2017-02-14', NULL),
(1, 7, '2017-02-14', NULL),
(2, 6, '2017-05-12', NULL),
(3, 2, '2017-02-14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `nb_userstable`
--

CREATE TABLE `nb_userstable` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(30) DEFAULT NULL,
  `firstName` varchar(25) DEFAULT NULL,
  `lastName` varchar(25) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `zipCode` int(9) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `isAdmin` tinyint(1) DEFAULT NULL,
  `loggedIn` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nb_userstable`
--

INSERT INTO `nb_userstable` (`userID`, `userName`, `firstName`, `lastName`, `password`, `address`, `city`, `state`, `isAdmin`, `loggedIn`) VALUES
(1, 'pjones', 'first', 'last', '53eb1f29c1f8a132441a4fad1d6f667d', '123 test street', 'Testville', 'New Test', 0, 0),
(2, 'bsmith', 'firsty', 'lasty', '32aa0c466818e1ccba25b8793db98c94', '321 test road', 'Testoppolis', 'Testa', 0, 0),
(3, 'admin', 'Admin', 'Admin', '6e8204c0862ec8abecb49762f0899554', '111 Admin', 'Adminville', 'New Admin', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lab5_users`
--
ALTER TABLE `lab5_users`
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `nb_carts`
--
ALTER TABLE `nb_carts`
  ADD PRIMARY KEY (`cartID`,`userID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `nb_history`
--
ALTER TABLE `nb_history`
  ADD PRIMARY KEY (`orderNum`,`userID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `nb_inventory`
--
ALTER TABLE `nb_inventory`
  ADD PRIMARY KEY (`bookID`);

--
-- Indexes for table `nb_rentprice`
--
ALTER TABLE `nb_rentprice`
  ADD PRIMARY KEY (`rentPrice`);

--
-- Indexes for table `nb_usercarts`
--
ALTER TABLE `nb_usercarts`
  ADD PRIMARY KEY (`cartID`,`bookID`),
  ADD KEY `bookID` (`bookID`);

--
-- Indexes for table `nb_userhistory`
--
ALTER TABLE `nb_userhistory`
  ADD PRIMARY KEY (`orderNum`,`bookID`),
  ADD KEY `bookID` (`bookID`);

--
-- Indexes for table `nb_userstable`
--
ALTER TABLE `nb_userstable`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nb_carts`
--
ALTER TABLE `nb_carts`
  MODIFY `cartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `nb_history`
--
ALTER TABLE `nb_history`
  MODIFY `orderNum` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `nb_inventory`
--
ALTER TABLE `nb_inventory`
  MODIFY `bookID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `nb_userstable`
--
ALTER TABLE `nb_userstable`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `nb_carts`
--
ALTER TABLE `nb_carts`
  ADD CONSTRAINT `nb_carts_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `nb_userstable` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `nb_history`
--
ALTER TABLE `nb_history`
  ADD CONSTRAINT `nb_history_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `nb_userstable` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `nb_usercarts`
--
ALTER TABLE `nb_usercarts`
  ADD CONSTRAINT `nb_usercarts_ibfk_1` FOREIGN KEY (`cartID`) REFERENCES `nb_carts` (`cartID`) ON DELETE CASCADE,
  ADD CONSTRAINT `nb_usercarts_ibfk_2` FOREIGN KEY (`bookID`) REFERENCES `nb_inventory` (`bookID`);

--
-- Constraints for table `nb_userhistory`
--
ALTER TABLE `nb_userhistory`
  ADD CONSTRAINT `nb_userhistory_ibfk_1` FOREIGN KEY (`orderNum`) REFERENCES `nb_history` (`orderNum`) ON DELETE CASCADE,
  ADD CONSTRAINT `nb_userhistory_ibfk_2` FOREIGN KEY (`bookID`) REFERENCES `nb_inventory` (`bookID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
