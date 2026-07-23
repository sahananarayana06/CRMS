-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2026 at 08:36 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crimedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `ID` int(10) NOT NULL,
  `AdminName` varchar(200) DEFAULT NULL,
  `UserName` varchar(200) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `AdminName`, `UserName`, `MobileNumber`, `Email`, `Password`, `AdminRegdate`) VALUES
(1, 'admin', 'admin', 7760373717, 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', '2026-03-12 12:54:44');

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `ID` int(10) NOT NULL,
  `CategoryName` varchar(200) DEFAULT NULL,
  `CatDes` mediumtext DEFAULT NULL,
  `AddDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`ID`, `CategoryName`, `CatDes`, `AddDate`) VALUES
(1, 'Personal Crimes', 'Personal Crimes – “Offenses against the Person”: These are crimes that result in physical or mental harm to another person. Personal crimes include:\r\nAssault \r\nBattery\r\nFalse Imprisonment\r\nKidnapping\r\nHomicide – crimes such as first and second degree murder, involuntary manslaughter, and vehicular homicide\r\nRape, statutory rape, sexual assault, and other offenses of a sexual nature', '2026-02-15 06:34:00'),
(2, 'Property Crimes', 'Property Crimes – “Offenses against Property”: These are crimes that do not necessarily involve harm to another person. Instead, they involve an interference with another person’s right to use or enjoy their property. Property crimes include:\r\nLarceny (theft)\r\nRobbery (theft by force) – Note: this is also considered a personal crime since it results in physical and mental harm.\r\nBurglary (penalties for burglary)\r\nArson\r\nEmbezzlement\r\nForgery\r\nFalse pretenses\r\nReceipt of stolen goods.', '2026-02-15 06:34:00'),
(3, 'Inchoate Crimes ', 'Inchoate Crimes – “Inchoate” translates into “incomplete”, meaning crimes that were begun, but not completed. This requires that a person take a substantial step to complete a crime, as opposed to just “intend” to commit a crime. Inchoate crimes include:\r\nAttempt – any crime that is attempted like “attempted robbery”\r\nSolicitation\r\nConspiracy', '2026-02-15 06:34:00'),
(4, 'Statutory Crimes ', 'Statutory Crimes – A violation of a specific state or federal statute and can involve either property offenses or personal offense. Statutory crimes include:\r\nAlcohol-related crimes such as drunk driving (DUI)\r\nSelling alcohol to a minor.', '2026-02-15 06:34:00'),
(5, 'sexual assault', 'illegal sexual contact that usually involves force upon a person without consent or is inflicted upon a person who is incapable of giving consent (as because of age or physical or mental incapacity) or who places the assailant (such as a doctor) in a position of trust or authority', '2026-02-15 06:34:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblcomplaint`
--

CREATE TABLE `tblcomplaint` (
  `ID` int(10) NOT NULL,
  `ComplaintNo` varchar(120) DEFAULT NULL,
  `UserID` int(50) DEFAULT NULL,
  `PoliceStationId` int(11) DEFAULT NULL,
  `PoliceStation` varchar(200) DEFAULT NULL,
  `ComplaintType` varchar(200) DEFAULT NULL,
  `ComplaintDetails` mediumtext DEFAULT NULL,
  `ContactNumber` bigint(10) DEFAULT NULL,
  `Address` mediumtext DEFAULT NULL,
  `DateofComplaint` timestamp NULL DEFAULT current_timestamp(),
  `Remark` varchar(200) DEFAULT NULL,
  `Status` varchar(50) DEFAULT 'Pending',
  `RemarkDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcomplaint`
--

INSERT INTO `tblcomplaint` (`ID`, `ComplaintNo`, `UserID`, `PoliceStationId`, `PoliceStation`, `ComplaintType`, `ComplaintDetails`, `ContactNumber`, `Address`, `DateofComplaint`, `Remark`, `Status`, `RemarkDate`) VALUES
(1, '402345239', 1, 1, 'Venoor Police Stations', 'Personal Crimes', 'My phone was stolen ', 7760373717, '1-234 Amruth Nivas main road Venoor ', '2026-04-15 11:12:17', 'You are requested to visit the police station tomorrow regarding your complaint. Further action will be taken after your visit. Our team will contact you for any additional information if required.\r\n', 'Approved', '2026-04-15 15:50:01'),
(2, '793487520', 1, 2, 'Moodbidri Police Stations ', 'Personal Crimes', 'My laptop was stolen', 7760373717, 'NA', '2026-04-15 11:19:08', 'We can investigate this case . For further information visit our police station tomorrow.\r\n', 'Rejected', '2026-04-15 16:24:08'),
(3, '665956703', 1, 2, 'Moodbidri Police Stations ', 'Personal Crimes', 'My laptop was stolen', 7760373717, 'NA', '2026-04-15 11:23:51', 'You are requested to visit the police station tomorrow regarding your complaint. Further action will be taken after your visit. Our team will contact you for any additional information if required.\r\n', 'Approved', '2026-04-15 16:23:02'),
(4, '341167871', 1, 1, 'Venoor Police Stations', 'Property Crimes', 'N/A', 9110674722, 'Aldur', '2026-04-29 05:20:48', 'N/A', 'Approved', '2026-04-29 05:22:12'),
(5, '956120849', 3, 1, 'Venoor Police Stations', 'Inchoate Crimes ', 'N/A', 9345444356, 'trhhrjngfvce', '2026-04-29 05:31:27', 'N/A', 'Rejected', '2026-04-29 05:32:21'),
(6, '105001679', 3, 1, 'Venoor Police Stations', 'Inchoate Crimes ', 'N/A', 9345444356, 'trhhrjngfvce', '2026-04-29 05:32:37', NULL, 'Pending', NULL);

-- --------------------------------------------------------

-- Table structure for table `tblcriminal`
--

CREATE TABLE `tblcriminal` (
  `ID` int(10) NOT NULL,
  `CriminalID` varchar(50) DEFAULT NULL,
  `PoliceID` int(10) DEFAULT NULL,
  `PoliceStationId` int(11) DEFAULT NULL,
  `PoliceStation` varchar(200) DEFAULT NULL,
  `CatName` varchar(100) DEFAULT NULL,
  `CrimeDate` varchar(200) DEFAULT NULL,
  `CrimeTime` varchar(200) DEFAULT NULL,
  `Prison` varchar(200) DEFAULT NULL,
  `Court` varchar(200) DEFAULT NULL,
  `Name` varchar(200) DEFAULT NULL,
  `ContactNumber` bigint(10) DEFAULT NULL,
  `Height` varchar(50) DEFAULT NULL,
  `Weight` varchar(50) DEFAULT NULL,
  `DateofBirth` varchar(200) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Address` mediumtext DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `State` varchar(200) DEFAULT NULL,
  `Country` varchar(200) DEFAULT NULL,
  `Zipcode` int(10) DEFAULT NULL,
  `Photo` varchar(200) DEFAULT NULL,
  `RecordDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcriminal`
--

INSERT INTO `tblcriminal` (`ID`, `CriminalID`, `PoliceID`, `PoliceStationId`, `PoliceStation`, `CatName`, `CrimeDate`, `CrimeTime`, `Prison`, `Court`, `Name`, `ContactNumber`, `Height`, `Weight`, `DateofBirth`, `Email`, `Address`, `City`, `State`, `Country`, `Zipcode`, `Photo`, `RecordDate`) VALUES
(1, '709388428', 1, 1, 'Venoor Police Stations', 'Personal Crimes', '2026-02-25', '15:18', 'Sub Jail', 'Supreme Court', 'Sakshi', 9684545623, '168cm', '80Kg', '2001-01-12', '', '1-534 NA', 'Venoor', 'Karnataka', 'India', 201017, '156d95c846f4e4d760455514d726b03a1772893080.png', '2026-03-07 19:48:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblfir`
--

CREATE TABLE `tblfir` (
  `ID` int(10) NOT NULL,
  `FIRNo` varchar(120) DEFAULT NULL,
  `UserID` int(50) DEFAULT NULL,
  `PoliceStationId` int(11) DEFAULT NULL,
  `PoliceStation` varchar(200) DEFAULT NULL,
  `CrimeType` varchar(200) DEFAULT NULL,
  `NameAccused` varchar(200) DEFAULT NULL,
  `NameApplicants` varchar(200) DEFAULT NULL,
  `ParentageApplicant` varchar(200) DEFAULT NULL,
  `ContactNumber` bigint(10) DEFAULT NULL,
  `Address` mediumtext DEFAULT NULL,
  `RelationAccused` varchar(200) DEFAULT NULL,
  `PurposeofFIR` varchar(200) DEFAULT NULL,
  `DateofFIR` timestamp NULL DEFAULT current_timestamp(),
  `Remark` varchar(200) DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `RemarkDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `SectionofLaw` varchar(200) NOT NULL,
  `InvestigationOfficer` varchar(200) NOT NULL,
  `InvestigationDetail` mediumtext NOT NULL,
  `ChargesheetDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `CNRNumber` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblfir`
--

INSERT INTO `tblfir` (`ID`, `FIRNo`, `UserID`, `PoliceStationId`, `PoliceStation`, `CrimeType`, `NameAccused`, `NameApplicants`, `ParentageApplicant`, `ContactNumber`, `Address`, `RelationAccused`, `PurposeofFIR`, `DateofFIR`, `Remark`, `Status`, `RemarkDate`, `SectionofLaw`, `InvestigationOfficer`, `InvestigationDetail`, `ChargesheetDate`, `CNRNumber`) VALUES
(1, '482448703', 1, 1, 'Venoor Police Stations', 'Statutory Crimes ', 'Sakshi ', 'Sahana Narayana', 'NA', 9568452653, 'A 123 Block C Marody', 'No Relation', 'Cybercrime', '2026-03-06 15:12:11', 'Case completed', 'Charge Sheet Completed', '2026-04-21 16:16:34', 'Section 405', 'Mr. Sandeep', 'This is a cybercrime ', '2026-04-21 16:16:34', NULL),
(2, '828531740', 2, 2, 'Moodbidri Police Stations ', 'Property Crimes', 'XYZ', 'ABC ', 'NA', 8656423595, '1-658 Unknown ', 'Brother', 'Property  case', '2026-03-07 18:35:06', 'NA', 'Charge Sheet Completed', '2026-02-07 17:31:32', 'SECTION 405', 'Mr. Sandeep', 'A company gives ₹50,000 to an employee to deposit in the bank, but the employee keeps the money.', '2026-03-07 18:49:21', NULL),
(3, '594903510', 2, 1, 'Venoor Police Stations', 'Personal Crimes', 'ABC', 'XYZ', 'NA', 952631452, 'A 1234 XYZ Society.', 'No Relation', 'Personal Crime', '2026-03-12 11:41:58', 'Fir is approved', 'Approved', '2026-02-07 17:31:36', '', '', '', '2026-03-12 11:42:54', NULL),
(12, '432435294', 3, 1, 'Venoor Police Stations', 'Personal Crimes', 'Soujanya', 'Varshitha', 'NA', 8965562122, 'Moodbidri', 'Classmate', 'Personal crime', '2026-04-01 05:37:45', 'rejected', 'Cancelled', '2026-04-01 05:59:21', '', '', '', '2026-04-01 05:59:21', NULL),
(13, '502703067', 1, 1, 'Venoor Police Stations', 'Property Crimes', 'Tom', 'Jerry', 'Tuffy', 9865422365, 'NA', 'Frenemy', 'Property crime', '2026-04-02 17:00:03', 'Accepted', 'Approved', '2026-04-22 04:33:01', '', '', '', '2026-04-22 04:33:01', NULL),
(14, '168555899', 1, 2, 'Moodbidri Police Stations ', 'Personal Crimes', 'Oggy', 'Joe', 'Marky', 8659589633, 'NA', 'NA', 'Personal crime', '2026-04-02 17:05:35', NULL, NULL, NULL, '', '', '', NULL, NULL),
(15, '420081284', 4, 3, 'Karkala Police Stations ', 'Property Crimes', 'Tommy', 'Chuckie', 'NA', 8564523645, 'NA', 'Friends', 'Property crime', '2026-04-02 17:10:40', NULL, NULL, NULL, '', '', '', NULL, NULL),
(16, '486027469', 16, 4, 'Puttur Police Stations', 'Personal Crimes', 'Sahana Narayana', 'Narayana', 'NA', 7760373717, 'Marody', 'Daughter', 'Personal crime', '2026-04-12 14:50:39', NULL, NULL, NULL, '', '', '', NULL, NULL),
(17, '384439647', 16, 4, 'Puttur Police Stations', 'Property Crimes', 'Unknown', 'Sahana Narayana', 'NA', 7760373717, 'Marody', 'Classmate', 'Property crime', '2026-04-12 14:59:00', NULL, NULL, NULL, '', '', '', NULL, NULL),
(18, '668451669', 1, 1, 'Venoor Police Stations', 'Property Crimes', 'Sourav', 'soujanya ', 'NA', 9480201031, 'Vagar Road', 'NA', 'Property crime', '2026-04-29 05:24:32', 'N/A', 'Approved', '2026-04-29 05:25:29', '', '', '', '2026-04-29 05:25:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblpolice`
--

CREATE TABLE `tblpolice` (
  `ID` int(10) NOT NULL,
  `PoliceStationId` int(11) DEFAULT NULL,
  `PoliceStationName` varchar(200) DEFAULT NULL,
  `PID` varchar(20) DEFAULT NULL,
  `Name` varchar(200) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Address` mediumtext DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  `JoiningDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblpolice`
--

INSERT INTO `tblpolice` (`ID`, `PoliceStationId`, `PoliceStationName`, `PID`, `Name`, `MobileNumber`, `Email`, `Address`, `Password`, `JoiningDate`) VALUES
(1, 1, 'Venoor Police Stations', 'CNTD01', 'Mr. Sandeep', 8425365410, 'sandeep@gmail.in', '12/1 Venoor 110001', '202cb962ac59075b964b07152d234b70', '2026-03-02 23:31:23'),
(2, 2, 'Moodbidri Police Stations ', 'LNPSD123', 'Ms.Sahana', 8425365410, 'sahana@gmail.in', '12/2 Moodbidri ', '81dc9bdb52d04dc20036dbd8313ed055', '2026-03-02 23:31:23'),
(3, 3, 'Karkala Police Station ', 'GZBU0111', 'Mr.Bean', 8425365410, 'Bean@gmail.com', '12/3 Karkala ', '81dc9bdb52d04dc20036dbd8313ed055', '2026-03-02 23:31:23'),
(4, 4, 'Puttur Police Station', 'RCPS34', 'Ms. Aruna', 8685425410, 'aruna@gmail.com', '12/4 Puttur ', '81dc9bdb52d04dc20036dbd8313ed055', '2026-03-02 23:31:23'),
(5, 5, 'Kadaba Police Station', 'SOAR21', 'Ms. Soujanya', 8685425411, 'soujanyaar21@gmail.com', '12/5 Kadaba ', '81dc9bdb52d04dc20036dbd8313ed055', '2026-03-02 23:31:23'),
(6, 6, 'Mangalore South Police Station', 'MRSP64', 'Ms. Varshitha', 8685425412, 'varshitha@gmail.com', '12/6 Mangalore South ', '81dc9bdb52d04dc20036dbd8313ed055', '2026-03-02 23:31:23'),
(7, 7, 'Mangalore Rural Police Station', 'PGTE90', 'Ms. Shrenika', 8685425420, 'shrenika@gmail.com', '12/7 Mangalore Rural ', '81dc9bdb52d04dc20036dbd8313ed055', '2026-03-02 23:31:23'),
(8, 8, 'Ullal Police Station', 'PARA45', 'Ms. Praneetha', 8685425414, 'praneetha@gmail.com', '12/8 Ullal ', '81dc9bdb52d04dc20036dbd8313ed055', '2026-03-02 23:31:23'),
(9, 9, 'Kankanady Town Police Station', 'NSGO30', 'Ms. Sakshi', 8685425415, 'sakshi@gmail.com', '12/9 Kankanady ', '81dc9bdb52d04dc20036dbd8313ed055', '2026-03-02 23:31:23'),
(10, 10, 'Kadri Police Station', 'CRPF89', 'Mr. Sourav', 8685425416, 'sourav@gmail.com', '12/10 Kadri ', '81dc9bdb52d04dc20036dbd8313ed055', '2026-03-02 23:31:23'),
(11, 11, 'Barke Police Station', 'SSCGD93', 'Mr. Rohith', 8685425413, 'ro45@gmail.com', '12/11 Barke ', '81dc9bdb52d04dc20036dbd8313ed055', '2026-03-02 23:31:23'),
(12, 12, 'Mangalore North Police Station', 'SSBA56', 'Mr. Dhoni', 868542549, 'mahi@gmail.com', '12/12 Mangalore North ', '81dc9bdb52d04dc20036dbd8313ed055', '2026-03-02 23:31:23'),
(13, 13, 'Urwa Police Station', 'CDSR21', 'Mr. Virat', 8685425440, 'virat@gmail.com', '12/1 Urwa ', '81dc9bdb52d04dc20036dbd8313ed055', '2026-03-02 23:31:23'),
(14, 14, 'Kavoor Police Station', 'NDAA30', 'Ms. Ashu', 8685425490, 'ashu@gmail.com', '12/2 Kavoor ', '81dc9bdb52d04dc20036dbd8313ed055', '2026-03-02 23:31:23'),
(15, 15, 'Surathkal Police Station', 'HDGS74', 'Mr. Vikram', 8685425480, 'vikram@gmail.com', '12/3 Surathkal ', '81dc9bdb52d04dc20036dbd8313ed055', '2026-03-02 23:31:23'),
(16, 16, 'Panambur Police Station', 'KAHD34', 'Mr. Mohith', 8685455410, 'mohith@gmail.com', '12/4 Panambur ', '81dc9bdb52d04dc20036dbd8313ed055', '2026-03-02 23:31:23'),
(17, 17, 'Bantwal Police Station', 'JKMH55', 'Mr. Anuj', 8685425610, 'anuj@gmail.com', '12/5 Bantwal ', '81dc9bdb52d04dc20036dbd8313ed055', '2026-03-02 23:31:23'),
(18, 18, 'Dharmasthala Police Station', 'KTMJ23', 'Mr. Sam', 8685475410, 'sam@gmail.com', '12/6 Dharmasthala ', '81dc9bdb52d04dc20036dbd8313ed055', '2026-03-02 23:31:23'),
(19, 10, 'Mulki Police Station', 'ODKF31', 'Mr. Amar Preet', 8685425510, 'Amar@gmail.com', '12/7 Mulki ', '81dc9bdb52d04dc20036dbd8313ed055', '2026-03-02 23:31:23'),
(20, 20, 'Belthangady Police Station', 'SHDK54', 'Mr. Karambir', 8685525410, 'karambir@gmail.com', '12/8 Belthangady ', '81dc9bdb52d04dc20036dbd8313ed055', '2026-03-02 23:31:23'),
(21, 21, 'CEN Crime Police Station', 'NECA786', 'Mr. Rawath', 8685522410, 'raw@gmail.com', '12/9 Mangaluru ', '81dc9bdb52d04dc20036dbd8313ed055', '2026-03-02 23:31:23'),
(22, 22, 'City Crime Branch (CCB) Mangaluru', 'BCAI656', 'Ms. Avani', 8485525410, 'avani@gmail.com', '12/10 Mangaluru ', '81dc9bdb52d04dc20036dbd8313ed055', '2026-03-02 23:31:23'),
(23, 23, 'Mangaluru Traffic Police Stations', 'SHGR855', 'Ms. Vyomika', 8686525410, 'yavu@gmail.com', '12/11 Mangaluru ', '81dc9bdb52d04dc20036dbd8313ed055', '2026-03-02 23:31:23');

-- --------------------------------------------------------

--
-- Table structure for table `tblpolicestation`
--

CREATE TABLE `tblpolicestation` (
  `id` int(11) NOT NULL,
  `PoliceStationName` varchar(255) DEFAULT NULL,
  `PoliceStationCode` varchar(200) DEFAULT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblpolicestation`
--

INSERT INTO `tblpolicestation` (`id`, `PoliceStationName`, `PoliceStationCode`, `PostingDate`) VALUES
(1, 'Venoor Police Stations', 'CDPS01', '2026-02-12 17:58:02'),
(2, 'Moodbidri Police Stations ', 'LND09', '2026-02-12 17:58:02'),
(3, 'Karkala Police Stations ', 'GZBUP0111', '2026-02-12 17:58:02'),
(4, 'Puttur Police Stations', 'RCPSD212', '2026-02-12 17:58:02'),
(5, 'Kadaba Police Stations', 'KPSM001', '2026-02-12 17:58:02'),
(6, 'Mangalore South Police Stations ', 'MSPS454', '2026-02-12 17:58:02'),
(7, 'Mangalore Rural Police Stations ', 'MRPS847', '2026-02-12 17:58:02'),
(8, 'Ullal Police Stations', 'USPS86', '2026-02-12 17:58:02'),
(9, 'Kankanady Police Stations', 'KPS845', '2026-02-12 17:58:02'),
(10, 'Kadri Police Stations ', 'KPSR574', '2026-02-12 17:58:02'),
(11, 'Barke Police Stations ', 'BPST937', '2026-02-12 17:58:02'),
(12, 'Mangalore North Police Stations', 'MNPS873', '2026-02-12 17:58:02'),
(13, 'Urwa Police Stations', 'UPSB191', '2026-02-12 17:58:02'),
(14, 'Kavoor Police Stations ', 'KPSP181', '2026-02-12 17:58:02'),
(15, 'Surathkal Police Stations ', 'SUPS909', '2026-02-12 17:58:02'),
(16, 'Panambur Police Stations', 'PAPS788', '2026-02-12 17:58:02'),
(17, 'Bantwal Police Stations', 'BNPS404', '2026-02-12 17:58:02'),
(18, 'Dharmasthala Police Stations ', 'DPS620', '2026-02-12 17:58:02'),
(19, 'Mulki Police Stations ', 'MPST867', '2026-02-12 17:58:02'),
(20, 'Belthangady Police Stations', 'BPSA675', '2026-02-12 17:58:02'),
(21, 'CEN Crime Police Station', 'CENP213', '2026-02-12 17:58:02'),
(22, 'City Crime Branch (CCB) Mangaluru', 'CCBM302', '2026-02-12 17:58:02'),
(23, 'Mangaluru Traffic Police Stations', 'MTPS038', '2026-02-12 17:58:02');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `ID` int(10) NOT NULL,
  `FullName` varchar(200) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  `RegDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_verified` int(11) DEFAULT 0,
  `OTPCode` varchar(10) DEFAULT NULL,
  `OTPExpires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`ID`, `FullName`, `MobileNumber`, `Email`, `Password`, `RegDate`, `is_verified`, `OTPCode`, `OTPExpires`) VALUES
(1, 'Sahana', 1425362514, 'sahananarayana21@gmail.com', 'dadd871103c799cfb96536b4fad9d6f2', '2026-03-25 14:17:22', 1, NULL, NULL),
(3, 'Mr.Bean', 6856558522, 'bean@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '2026-04-01 05:35:14', 1, NULL, NULL),
(13, 'CR', 7760373717, 'yashodha94830@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '2026-04-04 15:59:30', 1, NULL, NULL),
(17, 'Aruna', 7760373717, 'crmssysyem5@gmail.com', '96a77d0ec11a25890a5f676d6480b3ad', '2026-04-13 08:43:07', 1, NULL, NULL),
(19, 'Aruna', 8861768375, 'arunanaik3107@gmail.com', '4bf4bef42cee1082f6b15eb79fbbfe4d', '2026-04-13 08:57:08', 1, NULL, NULL),
(20, 'Soujanya', 9480201031, 'soujanyapoojary80@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '2026-04-22 04:23:18', 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcomplaint`
--
ALTER TABLE `tblcomplaint`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcriminal`
--
ALTER TABLE `tblcriminal`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblfir`
--
ALTER TABLE `tblfir`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblpolice`
--
ALTER TABLE `tblpolice`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblpolicestation`
--
ALTER TABLE `tblpolicestation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblcomplaint`
--
ALTER TABLE `tblcomplaint`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblcriminal`
--
ALTER TABLE `tblcriminal`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblfir`
--
ALTER TABLE `tblfir`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tblpolice`
--
ALTER TABLE `tblpolice`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblpolicestation`
--
ALTER TABLE `tblpolicestation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

COMMIT;

