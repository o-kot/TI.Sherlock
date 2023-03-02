-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 17 Paź 2017, 01:00
-- Wersja serwera: 10.1.26-MariaDB
-- Wersja PHP: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `rezerwacje`
--
CREATE DATABASE IF NOT EXISTS `rezerwacje` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `rezerwacje`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `hotele`
--

CREATE TABLE IF NOT EXISTS `hotele` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `hotele`
--

INSERT INTO `hotele` (`ID`, `nazwa`) VALUES
(1, 'Das Hotel Sherlock Holmes'),
(2, 'Parkhotel du Sauvage'),
(3, 'Hotel Adler Central');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `hotele_pokoje`
--

CREATE TABLE IF NOT EXISTS `hotele_pokoje` (
  `pokoj_id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `ilosc` int(11) NOT NULL,
  KEY `hotel_id` (`hotel_id`),
  KEY `pokoj_id` (`pokoj_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `hotele_pokoje`
--

INSERT INTO `hotele_pokoje` (`pokoj_id`, `hotel_id`, `ilosc`) VALUES
(1, 1, 3),
(2, 1, 2),
(3, 2, 3),
(4, 2, 2),
(5, 3, 3),
(6, 3, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE IF NOT EXISTS `klienci` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `imie` varchar(30) NOT NULL,
  `nazwisko` varchar(100) NOT NULL,
  `telefon` varchar(12) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `telefon` (`telefon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pokoje`
--

CREATE TABLE IF NOT EXISTS `pokoje` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `typ` varchar(50) NOT NULL,
  `cena` decimal(9,2) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `pokoje`
--

INSERT INTO `pokoje` (`ID`, `typ`, `cena`) VALUES
(1, '2 os', '738.00'),
(2, '3 os', '1107.00'),
(3, '2 os', '1098.00'),
(4, '3 os', '1647.00'),
(5, '2 os', '554.00'),
(6, '3 os', '831.00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rezerwacje`
--

CREATE TABLE IF NOT EXISTS `rezerwacje` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `pokoj_id` int(11) NOT NULL,
  `klient_id` int(11) NOT NULL,
  `czy_dostawka` tinyint(1) NOT NULL,
  `data_od` date NOT NULL,
  `data_do` date NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `klient_id` (`klient_id`),
  KEY `pokoj_id` (`pokoj_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `hotele_pokoje`
--
ALTER TABLE `hotele_pokoje`
  ADD CONSTRAINT `hotele_pokoje_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotele` (`ID`),
  ADD CONSTRAINT `hotele_pokoje_ibfk_2` FOREIGN KEY (`pokoj_id`) REFERENCES `pokoje` (`ID`);

--
-- Ograniczenia dla tabeli `rezerwacje`
--
ALTER TABLE `rezerwacje`
  ADD CONSTRAINT `rezerwacje_ibfk_1` FOREIGN KEY (`klient_id`) REFERENCES `klienci` (`ID`),
  ADD CONSTRAINT `rezerwacje_ibfk_2` FOREIGN KEY (`pokoj_id`) REFERENCES `pokoje` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
