-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jul 31, 2015 at 02:50 PM
-- Server version: 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `angrymemory`
--

-- --------------------------------------------------------

--
-- Table structure for table `Foods`
--

CREATE TABLE `Foods` (
  `ID` int(11) NOT NULL,
  `Name` varchar(20) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `FoodsUsersExperience`
--

CREATE TABLE `FoodsUsersExperience` (
  `ID` int(11) NOT NULL,
  `Food` int(11) NOT NULL,
  `User` int(11) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TummyReaction` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `FoodsUsersXref`
--

CREATE TABLE `FoodsUsersXref` (
  `ID` int(11) NOT NULL,
  `Food` int(11) NOT NULL,
  `User` varchar(40) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TummyReactions`
--

CREATE TABLE `TummyReactions` (
  `ID` int(11) NOT NULL,
  `Description` varchar(20) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `TummyReactions`
--

INSERT INTO `TummyReactions` (`ID`, `Description`) VALUES
(0, 'All good'),
(3, 'Bloating'),
(4, 'Cramps'),
(5, 'Diarrhea'),
(1, 'Nausea'),
(6, 'Pain'),
(2, 'Vomiting');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `LoginID` varchar(30) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Foods`
--
ALTER TABLE `Foods`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `FoodsUsersExperience`
--
ALTER TABLE `FoodsUsersExperience`
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `FoodsUsersXref`
--
ALTER TABLE `FoodsUsersXref`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `TummyReactions`
--
ALTER TABLE `TummyReactions`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Description` (`Description`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `LoginID` (`LoginID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Foods`
--
ALTER TABLE `Foods`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `FoodsUsersExperience`
--
ALTER TABLE `FoodsUsersExperience`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=124;
--
-- AUTO_INCREMENT for table `FoodsUsersXref`
--
ALTER TABLE `FoodsUsersXref`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `TummyReactions`
--
ALTER TABLE `TummyReactions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
