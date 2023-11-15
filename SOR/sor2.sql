-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Paź 18, 2023 at 07:32 PM
-- Wersja serwera: 10.4.28-MariaDB
-- Wersja PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sor2`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dyspozytorzy`
--

CREATE TABLE `dyspozytorzy` (
  `id` int(11) NOT NULL,
  `imie` varchar(512) DEFAULT NULL,
  `nazwisko` varchar(512) DEFAULT NULL,
  `stanowisko` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dyspozytorzy`
--

INSERT INTO `dyspozytorzy` (`id`, `imie`, `nazwisko`, `stanowisko`) VALUES
(1, 'Piotr', 'Nowak', 'A'),
(2, 'Jack', 'Sparrow', 'B'),
(3, 'Nikodem', 'Tadzikiewicz', 'C'),
(4, 'Janusz', 'Bosak', 'D');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lekarze`
--

CREATE TABLE `lekarze` (
  `id` int(11) NOT NULL,
  `imie` varchar(512) DEFAULT NULL,
  `nazwisko` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lekarze`
--

INSERT INTO `lekarze` (`id`, `imie`, `nazwisko`) VALUES
(1, 'Jan', 'Nowakowski'),
(2, 'Krzysztof', 'Kowalski'),
(3, 'Janina', 'Mikołajczyk'),
(4, 'Maks', 'Mirek'),
(5, 'Jakub', 'Czapczyk');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ratownicy`
--

CREATE TABLE `ratownicy` (
  `id` int(11) NOT NULL,
  `imie` varchar(512) DEFAULT NULL,
  `nazwisko` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratownicy`
--

INSERT INTO `ratownicy` (`id`, `imie`, `nazwisko`) VALUES
(1, 'Jan', 'Kowalski'),
(2, 'Izabela', 'Nowak'),
(3, 'Piotr', 'Trzela'),
(4, 'Jarek', 'Poselski'),
(5, 'Patryk', 'Turas');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zgloszenia`
--

CREATE TABLE `zgloszenia` (
  `id` int(11) NOT NULL,
  `dataZdarzenia` date DEFAULT NULL,
  `zgloszenie_lekarz` int(11) DEFAULT NULL,
  `zgloszenie_ratownik` int(11) DEFAULT NULL,
  `zgloszenie_dyspozytor` int(11) DEFAULT NULL,
  `opis` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zgloszenia`
--

INSERT INTO `zgloszenia` (`id`, `dataZdarzenia`, `zgloszenie_lekarz`, `zgloszenie_ratownik`, `zgloszenie_dyspozytor`, `opis`) VALUES
(23, '2023-10-18', 1, 1, 1, 'ewqewq'),
(24, '2023-10-20', 1, 1, 1, 'ewqewq'),
(25, '2023-10-22', 1, 1, 1, 'ewqeq'),
(26, '2023-10-24', 1, 1, 1, 'ewq'),
(27, '2023-08-07', 1, 1, 1, 'weq'),
(28, '2023-08-08', 2, 2, 1, 'Zgon'),
(29, '2023-08-09', 3, 3, 1, 'sadsa'),
(31, '2023-08-11', 1, 1, 1, 'sadsa'),
(32, '2023-08-12', 3, 3, 1, 'weaw'),
(33, '2023-08-13', 1, 1, 1, 'ewqewq');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `dyspozytorzy`
--
ALTER TABLE `dyspozytorzy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `lekarze`
--
ALTER TABLE `lekarze`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `ratownicy`
--
ALTER TABLE `ratownicy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `zgloszenia`
--
ALTER TABLE `zgloszenia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `zgloszenie_lekarz` (`zgloszenie_lekarz`),
  ADD KEY `zgloszenie_ratownik` (`zgloszenie_ratownik`),
  ADD KEY `zgloszenie_dyspozytor` (`zgloszenie_dyspozytor`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dyspozytorzy`
--
ALTER TABLE `dyspozytorzy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lekarze`
--
ALTER TABLE `lekarze`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ratownicy`
--
ALTER TABLE `ratownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `zgloszenia`
--
ALTER TABLE `zgloszenia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `zgloszenia`
--
ALTER TABLE `zgloszenia`
  ADD CONSTRAINT `zgloszenia_ibfk_1` FOREIGN KEY (`zgloszenie_lekarz`) REFERENCES `lekarze` (`id`),
  ADD CONSTRAINT `zgloszenia_ibfk_2` FOREIGN KEY (`zgloszenie_ratownik`) REFERENCES `ratownicy` (`id`),
  ADD CONSTRAINT `zgloszenia_ibfk_3` FOREIGN KEY (`zgloszenie_dyspozytor`) REFERENCES `dyspozytorzy` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
