-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 24 Lis 2021, 19:06
-- Wersja serwera: 10.4.17-MariaDB
-- Wersja PHP: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `wypozyczalnia`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `model` varchar(32) COLLATE utf8_polish_ci NOT NULL,
  `brand` varchar(32) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `cars`
--

INSERT INTO `cars` (`id`, `model`, `brand`) VALUES
(1, 'Bugatti', 'Chiron'),
(2, 'Bugatti', 'Veyron'),
(3, 'Bugatti', 'Divo'),
(4, 'Bugatti', 'Centodieci'),
(5, 'Bugatti', 'La Voiture Noire'),
(6, 'Koenigsegg', 'Regera'),
(7, 'Bugatti', 'Divo'),
(8, 'Bugatti', 'Divo');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `id_car` int(11) NOT NULL,
  `color` varchar(32) COLLATE utf8_polish_ci NOT NULL,
  `year` year(4) NOT NULL,
  `acceleration` float NOT NULL,
  `gearbox` enum('AUTOMAT','MANUAL') COLLATE utf8_polish_ci NOT NULL,
  `places` int(11) NOT NULL,
  `description` text COLLATE utf8_polish_ci NOT NULL,
  `price` int(11) NOT NULL,
  `img` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `offers`
--

INSERT INTO `offers` (`id`, `id_car`, `color`, `year`, `acceleration`, `gearbox`, `places`, `description`, `price`, `img`) VALUES
(1, 1, 'blue', 2020, 2.4, 'AUTOMAT', 2, 'Fastest car in 2019', 10000, 'https://autodius.com/wp-content/uploads/2020/03/bugatti-chiron-2020-pur-sport.jpg'),
(2, 2, 'black', 2015, 2.5, 'AUTOMAT', 2, 'Hypercar produced by the French brand Bugatti in 2005–2015.', 8000, 'https://wokolmotoryzacji.pl/wp-content/uploads/2021/06/no.-48-bugatti-veyron-super-sport-for-sale-1.jpg'),
(3, 3, 'black-blue', 2019, 2.5, 'AUTOMAT', 2, 'Hypercar produced under the French brand Bugatti since 2019.', 12000, 'https://image.winudf.com/v2/image1/Y29tLm1lbWVuZy5DYXIuQmVzdEJ1Z2F0dGlEaXZvd2FsbHBhcGVyX3NjcmVlbl8wXzE1NDU3NTMwNjFfMDQw/screen-0.jpg?fakeurl=1&type=.jpg'),
(4, 4, 'white', 2020, 2.4, 'AUTOMAT', 2, 'Limited production mid-engine sports car produced by French automotive manufacturer Bugatti.', 15000, 'https://wallpaperaccess.com/full/2450715.jpg'),
(5, 5, 'black', 2021, 2.5, 'AUTOMAT', 2, 'The only copy in the world', 50000, 'https://www.bugatti.com/fileadmin/_processed_/sei/p326/se-image-b2cbb849049ad1c523a00f5428a9382b.jpg'),
(6, 6, 'red', 2016, 2.8, 'AUTOMAT', 2, 'The Koenigsegg Regera is a limited production, plug-in hybrid grand touring sports car manufactured by Swedish automotive manufacturer Koenigsegg.', 10000, 'https://www.supercars.net/blog/wp-content/uploads/2016/08/wp2208077.jpg'),
(7, 3, 'black-red', 2020, 2.4, 'AUTOMAT', 2, 'Modified bugatti divo with more power', 14000, 'https://images.hdqwalls.com/wallpapers/bugatti-divo-red-performance-ac.jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rentals`
--

CREATE TABLE `rentals` (
  `id` int(11) NOT NULL,
  `id_reservation` int(11) NOT NULL,
  `acceptTime` datetime NOT NULL DEFAULT current_timestamp(),
  `qrCode` text COLLATE utf8_polish_ci NOT NULL,
  `daysLeft` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `rentals`
--

INSERT INTO `rentals` (`id`, `id_reservation`, `acceptTime`, `qrCode`, `daysLeft`) VALUES
(35, 78, '2021-11-21 12:49:25', 'https://www.google.pl/search?q=Bugatti+Divo', 7);

--
-- Wyzwalacze `rentals`
--
DELIMITER $$
CREATE TRIGGER `banning` AFTER UPDATE ON `rentals` FOR EACH ROW UPDATE users INNER JOIN reservations ON reservations.id_user=users.id INNER JOIN rentals ON NEW.id_reservation=reservations.id SET banned=1 WHERE NEW.daysLeft < 0 AND users.permiss='client'
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_offer` int(11) NOT NULL,
  `reservTime` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('accepted','declined','waiting') COLLATE utf8_polish_ci NOT NULL DEFAULT 'waiting',
  `endPrice` int(11) NOT NULL,
  `resStart` date NOT NULL,
  `resTime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `reservations`
--

INSERT INTO `reservations` (`id`, `id_user`, `id_offer`, `reservTime`, `status`, `endPrice`, `resStart`, `resTime`) VALUES
(78, 1, 7, '2021-11-21 12:49:21', 'accepted', 126000, '2021-11-21', 9);

--
-- Wyzwalacze `reservations`
--
DELIMITER $$
CREATE TRIGGER `Archiving` AFTER DELETE ON `reservations` FOR EACH ROW INSERT INTO reservations_arch(id_user, id_offer, reservTime, status, endPrice, resStart, resTime) VALUES(OLD.id_user, OLD.id_offer, OLD.reservTime, OLD.status, OLD.endPrice, OLD.resStart, OLD.resTime)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reservations_arch`
--

CREATE TABLE `reservations_arch` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_offer` int(11) NOT NULL,
  `reservTime` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('accepted','declined','waiting') COLLATE utf8_polish_ci NOT NULL DEFAULT 'waiting',
  `endPrice` int(11) NOT NULL,
  `resStart` date NOT NULL,
  `resTime` int(11) NOT NULL,
  `actionTime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `reservations_arch`
--

INSERT INTO `reservations_arch` (`id`, `id_user`, `id_offer`, `reservTime`, `status`, `endPrice`, `resStart`, `resTime`, `actionTime`) VALUES
(1, 18, 4, '2021-11-20 20:25:25', 'declined', 45000, '2021-11-21', 3, '2021-11-21 12:47:41'),
(2, 1, 7, '2021-11-21 12:43:49', 'accepted', 182000, '2021-11-15', 13, '2021-11-21 12:47:42');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(32) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `permiss` enum('client','mod','admin') COLLATE utf8_polish_ci NOT NULL DEFAULT 'client',
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `createTime` datetime NOT NULL DEFAULT current_timestamp(),
  `banned` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `email`, `permiss`, `active`, `createTime`, `banned`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@ms.pl', 'admin', 1, '2021-11-12 14:04:25', 0),
(2, 'mod', 'ad148a3ca8bd0ef3b48c52454c493ec5', 'mod@ms.pl', 'mod', 1, '2021-11-12 18:59:39', 0),
(3, 'a', '0cc175b9c0f1b6a831c399e269772661', 'a@a.com', 'client', 1, '2021-11-12 16:49:09', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_car` (`id_car`);

--
-- Indeksy dla tabeli `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_reservation` (`id_reservation`);

--
-- Indeksy dla tabeli `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_car` (`id_offer`);

--
-- Indeksy dla tabeli `reservations_arch`
--
ALTER TABLE `reservations_arch`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_car` (`id_offer`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `login` (`login`) USING BTREE;

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `rentals`
--
ALTER TABLE `rentals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT dla tabeli `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT dla tabeli `reservations_arch`
--
ALTER TABLE `reservations_arch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_ibfk_1` FOREIGN KEY (`id_car`) REFERENCES `cars` (`id`);

--
-- Ograniczenia dla tabeli `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `rentals_ibfk_1` FOREIGN KEY (`id_reservation`) REFERENCES `reservations` (`id`);

--
-- Ograniczenia dla tabeli `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`id_offer`) REFERENCES `offers` (`id`);

DELIMITER $$
--
-- Zdarzenia
--
CREATE DEFINER=`root`@`localhost` EVENT `timeSimulation` ON SCHEDULE EVERY 10 SECOND STARTS '2021-11-19 22:50:06' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE rentals SET rentals.daysLeft=rentals.daysLeft - 1$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
