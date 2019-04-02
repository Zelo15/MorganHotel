-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2019. Ápr 02. 14:34
-- Kiszolgáló verziója: 10.1.34-MariaDB
-- PHP verzió: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `morgan`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `description` text COLLATE utf8_hungarian_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `comment`
--

INSERT INTO `comment` (`comment_id`, `event_id`, `user_id`, `name`, `picture`, `description`, `created_at`, `updated_at`) VALUES
(28, 30, 1, 'Zelovics Attila', '', 'Remélem jó lesz!!!\r\n', '2019-03-07 11:37:48', '2019-03-07 11:37:48'),
(29, 30, 1, 'Zelovics Attila', '', 'xd', '2019-03-30 11:11:19', '2019-03-30 11:11:19');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `description` text COLLATE utf8_hungarian_ci NOT NULL,
  `event_date` date NOT NULL,
  `picture` varchar(255) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `events`
--

INSERT INTO `events` (`event_id`, `title`, `description`, `event_date`, `picture`) VALUES
(30, 'Party', 'Lorem ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups.', '2019-03-24', '/Assets/Img/uploads/events/eventPicture228749.jpg');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `extraproduct`
--

CREATE TABLE `extraproduct` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `price` int(11) NOT NULL,
  `description` text COLLATE utf8_hungarian_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `extraproduct`
--

INSERT INTO `extraproduct` (`product_id`, `name`, `price`, `description`, `category_id`, `quantity`) VALUES
(1, 'chips', 400, 'chips', 2, 3),
(2, 'sör', 300, 'Magyar árpa sör (0,3l)', 1, 10),
(3, 'Sült burgonya', 500, 'Házias steak sült burgonya (1 adag)', 2, 15);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `extraproductcategory`
--

CREATE TABLE `extraproductcategory` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `extraproductcategory`
--

INSERT INTO `extraproductcategory` (`category_id`, `name`, `slug`) VALUES
(1, 'ital', 'drink'),
(2, 'étel', 'food');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `extraproductorder`
--

CREATE TABLE `extraproductorder` (
  `product_id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `extraproductorder`
--

INSERT INTO `extraproductorder` (`product_id`, `reservation_id`, `quantity`) VALUES
(1, 40, 25),
(2, 40, 14),
(2, 41, 1),
(3, 40, 34);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `guests`
--

CREATE TABLE `guests` (
  `guest_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `post_code` int(11) NOT NULL,
  `city` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `guests`
--

INSERT INTO `guests` (`guest_id`, `user_id`, `address`, `post_code`, `city`, `phone`) VALUES
(2, 1, 'kossuth lajos 70', 1234, 'kakucs', '0123456789'),
(3, 3, 'kossuth lajos 44 ', 1234, 'inárcs', '06702333394');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `moderatorstatus`
--

CREATE TABLE `moderatorstatus` (
  `moderator_status_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `moderatorstatus`
--

INSERT INTO `moderatorstatus` (`moderator_status_id`, `name`, `slug`) VALUES
(1, 'Új', 'new'),
(2, 'Rendben', 'ok'),
(3, 'Elutasítva', 'denied');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `opinions`
--

CREATE TABLE `opinions` (
  `opinion_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `body` text COLLATE utf8_hungarian_ci NOT NULL,
  `type` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `created_at` date NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `opinions`
--

INSERT INTO `opinions` (`opinion_id`, `name`, `body`, `type`, `created_at`, `status`) VALUES
(1, 'Zelovics Attila', 'OK!', 'Vendég', '2019-02-13', 2),
(3, 'Zelovics Attila', 'xd', 'Vendég', '2019-03-19', 3),
(4, 'Zelovics Attila', 'asdasd', 'Vendég', '2019-03-21', 3),
(6, 'Zelovics Attila', 'jashdgfaskjhdgfaksjhdgf', 'Vendég', '2019-03-25', 3),
(8, 'Zelovics Attila', 'Minden rendben volt! Csak ajánlani tudom a szállodát!', 'Vendég', '2019-03-25', 2);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `guest_id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `price` int(11) NOT NULL,
  `payment_status_id` int(1) NOT NULL,
  `payment_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `payment`
--

INSERT INTO `payment` (`payment_id`, `guest_id`, `reservation_id`, `name`, `price`, `payment_status_id`, `payment_date`) VALUES
(16, 2, 40, 'Zelovics Attila', 50000, 2, '2019-05-05 10:00:00'),
(17, 2, 41, 'Zelovics Attila', 100000, 1, '2019-03-28 10:00:00'),
(18, 2, 42, 'Zelovics Attila', 10000, 1, '2019-03-31 10:00:00');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `paymentstatus`
--

CREATE TABLE `paymentstatus` (
  `status_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `paymentstatus`
--

INSERT INTO `paymentstatus` (`status_id`, `name`, `slug`) VALUES
(1, 'nyitott', 'open'),
(2, 'lezárt', 'close');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `reservation`
--

CREATE TABLE `reservation` (
  `reservation_id` int(11) NOT NULL,
  `guest_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `reservation_date` datetime NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `members` int(11) NOT NULL,
  `description` text COLLATE utf8_hungarian_ci NOT NULL,
  `PIN` int(4) NOT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `guest_id`, `room_id`, `reservation_date`, `check_in`, `check_out`, `members`, `description`, `PIN`, `status_id`) VALUES
(40, 2, 1, '2019-03-24 13:57:19', '2019-03-24', '2019-05-05', 1, '                                                                                                                                                                                                                                                                                                    ', 1111, 1),
(41, 2, 3, '2019-03-27 15:17:31', '2019-03-27', '2019-03-28', 1, '', 7398, 2),
(42, 2, 2, '2019-03-28 13:55:23', '2019-03-30', '2019-03-31', 1, '', 2794, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `slug` varchar(100) COLLATE utf8_hungarian_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `role`
--

INSERT INTO `role` (`role_id`, `slug`, `name`) VALUES
(1, 'admin', 'Adminisztrátor'),
(2, 'user', 'Felhasználó'),
(3, 'guest', 'Vendég'),
(4, 'moderator', 'Moderátor');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_type_id` int(11) NOT NULL,
  `room_status_id` int(11) NOT NULL,
  `price` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `room_name` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `qualification` int(11) NOT NULL,
  `description` text COLLATE utf8_hungarian_ci NOT NULL,
  `room_picture` varchar(255) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_type_id`, `room_status_id`, `price`, `room_name`, `qualification`, `description`, `room_picture`) VALUES
(1, 3, 2, '50000', 'Luxus Szoba', 5, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.                                                                                                                        ', 'Assets/Img/uploads/rooms/RoomPicture154520.jpg'),
(2, 3, 1, '10000', 'Prémium szoba', 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.                                                ', 'Assets/Img/uploads/rooms/RoomPicture294918.jpg'),
(3, 4, 1, '100000', 'Elnöki Lakosztály', 5, 'Lorem ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups                                                                        ', 'Assets/Img/uploads/rooms/RoomPicture624323.jpg');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `roomstatus`
--

CREATE TABLE `roomstatus` (
  `room_status_id` int(11) NOT NULL,
  `room_status_name` varchar(100) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `roomstatus`
--

INSERT INTO `roomstatus` (`room_status_id`, `room_status_name`) VALUES
(1, 'Enable'),
(2, 'Disable');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `roomtype`
--

CREATE TABLE `roomtype` (
  `room_type_id` int(11) NOT NULL,
  `room_type_name` varchar(255) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `roomtype`
--

INSERT INTO `roomtype` (`room_type_id`, `room_type_name`) VALUES
(1, 'Standard'),
(2, 'Premium'),
(3, 'Luxury'),
(4, 'Balcony');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `sessions`
--

CREATE TABLE `sessions` (
  `session_id` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `sessions`
--

INSERT INTO `sessions` (`session_id`, `date`) VALUES
(1, '2019-03-31 10:45:32'),
(2, '2019-03-30 10:05:10'),
(3, '2019-03-07 22:32:02'),
(4, '2019-03-28 09:19:59'),
(6, '2019-03-21 20:30:19');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `status`
--

CREATE TABLE `status` (
  `user_status_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `status`
--

INSERT INTO `status` (`user_status_id`, `name`, `slug`) VALUES
(1, 'Aktív', 'active'),
(2, 'Inaktív', 'inactive');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `userrole`
--

CREATE TABLE `userrole` (
  `user_role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `userrole`
--

INSERT INTO `userrole` (`user_role_id`, `user_id`, `role_id`) VALUES
(1, 1, 2),
(2, 2, 1),
(3, 4, 4);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `joined` date NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `joined`, `status`) VALUES
(1, 'Zelovics Attila', 'zelo1498@gmail.com', '258c744707db71387af7d09a7a144940', '2019-02-03', 1),
(2, 'Admin', 'morganhotelinfo@gmail.com', 'e3afed0047b08059d0fada10f400c1e5', '2019-02-20', 1),
(3, 'Blahó Henriett', 'blahoh@freemail.com', '2dbcc43231543fd2c9eb5d5e63de0b70', '2019-03-07', 1),
(4, 'Moderator', 'morganhotelinfo@gmail.com', 'ca65a68e10b3c65ac897ff8b89f9f728', '2019-03-03', 1);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`);

--
-- A tábla indexei `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- A tábla indexei `extraproduct`
--
ALTER TABLE `extraproduct`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- A tábla indexei `extraproductcategory`
--
ALTER TABLE `extraproductcategory`
  ADD PRIMARY KEY (`category_id`);

--
-- A tábla indexei `extraproductorder`
--
ALTER TABLE `extraproductorder`
  ADD PRIMARY KEY (`product_id`,`reservation_id`),
  ADD KEY `guest_id` (`product_id`),
  ADD KEY `reservation_id` (`reservation_id`);

--
-- A tábla indexei `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`guest_id`),
  ADD KEY `user_id` (`user_id`);

--
-- A tábla indexei `moderatorstatus`
--
ALTER TABLE `moderatorstatus`
  ADD PRIMARY KEY (`moderator_status_id`);

--
-- A tábla indexei `opinions`
--
ALTER TABLE `opinions`
  ADD PRIMARY KEY (`opinion_id`),
  ADD KEY `status` (`status`);

--
-- A tábla indexei `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `guest_id` (`guest_id`,`reservation_id`),
  ADD KEY `reservation_id` (`reservation_id`),
  ADD KEY `payment_status_id` (`payment_status_id`);

--
-- A tábla indexei `paymentstatus`
--
ALTER TABLE `paymentstatus`
  ADD PRIMARY KEY (`status_id`);

--
-- A tábla indexei `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `guest_id` (`guest_id`,`room_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `status_id` (`status_id`);

--
-- A tábla indexei `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- A tábla indexei `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `room_type_id` (`room_type_id`,`room_status_id`),
  ADD KEY `room_status_id` (`room_status_id`);

--
-- A tábla indexei `roomstatus`
--
ALTER TABLE `roomstatus`
  ADD PRIMARY KEY (`room_status_id`);

--
-- A tábla indexei `roomtype`
--
ALTER TABLE `roomtype`
  ADD PRIMARY KEY (`room_type_id`);

--
-- A tábla indexei `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- A tábla indexei `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`user_status_id`);

--
-- A tábla indexei `userrole`
--
ALTER TABLE `userrole`
  ADD PRIMARY KEY (`user_role_id`),
  ADD KEY `user_id` (`user_id`,`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `status` (`status`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT a táblához `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT a táblához `extraproduct`
--
ALTER TABLE `extraproduct`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `extraproductcategory`
--
ALTER TABLE `extraproductcategory`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `guests`
--
ALTER TABLE `guests`
  MODIFY `guest_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `moderatorstatus`
--
ALTER TABLE `moderatorstatus`
  MODIFY `moderator_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `opinions`
--
ALTER TABLE `opinions`
  MODIFY `opinion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT a táblához `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT a táblához `paymentstatus`
--
ALTER TABLE `paymentstatus`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT a táblához `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT a táblához `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `roomstatus`
--
ALTER TABLE `roomstatus`
  MODIFY `room_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `roomtype`
--
ALTER TABLE `roomtype`
  MODIFY `room_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT a táblához `sessions`
--
ALTER TABLE `sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT a táblához `status`
--
ALTER TABLE `status`
  MODIFY `user_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `userrole`
--
ALTER TABLE `userrole`
  MODIFY `user_role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`);

--
-- Megkötések a táblához `extraproduct`
--
ALTER TABLE `extraproduct`
  ADD CONSTRAINT `extraproduct_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `extraproductcategory` (`category_id`);

--
-- Megkötések a táblához `extraproductorder`
--
ALTER TABLE `extraproductorder`
  ADD CONSTRAINT `extraproductorder_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `extraproduct` (`product_id`),
  ADD CONSTRAINT `extraproductorder_ibfk_3` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`reservation_id`);

--
-- Megkötések a táblához `guests`
--
ALTER TABLE `guests`
  ADD CONSTRAINT `guests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Megkötések a táblához `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`reservation_id`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`guest_id`) REFERENCES `reservation` (`guest_id`),
  ADD CONSTRAINT `payment_ibfk_3` FOREIGN KEY (`payment_status_id`) REFERENCES `paymentstatus` (`status_id`);

--
-- Megkötések a táblához `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`),
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`guest_id`),
  ADD CONSTRAINT `reservation_ibfk_4` FOREIGN KEY (`status_id`) REFERENCES `paymentstatus` (`status_id`);

--
-- Megkötések a táblához `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`room_status_id`) REFERENCES `roomstatus` (`room_status_id`),
  ADD CONSTRAINT `rooms_ibfk_2` FOREIGN KEY (`room_type_id`) REFERENCES `roomtype` (`room_type_id`);

--
-- Megkötések a táblához `userrole`
--
ALTER TABLE `userrole`
  ADD CONSTRAINT `userrole_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`),
  ADD CONSTRAINT `userrole_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Megkötések a táblához `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`status`) REFERENCES `status` (`user_status_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
