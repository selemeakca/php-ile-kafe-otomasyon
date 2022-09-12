-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 07 Eyl 2019, 22:39:12
-- Sunucu sürümü: 5.7.23
-- PHP Sürümü: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `ogrenci`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `anliksiparis`
--

DROP TABLE IF EXISTS `anliksiparis`;
CREATE TABLE IF NOT EXISTS `anliksiparis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `masaid` int(11) NOT NULL,
  `garsonid` int(11) NOT NULL,
  `urunid` int(11) NOT NULL,
  `urunad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `urunfiyat` float NOT NULL,
  `adet` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=220 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `anliksiparis`
--

INSERT INTO `anliksiparis` (`id`, `masaid`, `garsonid`, `urunid`, `urunad`, `urunfiyat`, `adet`) VALUES
(215, 17, 1, 45, 'Lüfer Izgara', 30, 3),
(216, 17, 1, 53, 'Köfte Menü', 9, 3),
(219, 18, 1, 12, 'Kaşarlı Tost', 5, 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `doluluk`
--

DROP TABLE IF EXISTS `doluluk`;
CREATE TABLE IF NOT EXISTS `doluluk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bos` int(11) NOT NULL DEFAULT '0',
  `dolu` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `doluluk`
--

INSERT INTO `doluluk` (`id`, `bos`, `dolu`) VALUES
(1, 16, 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `garson`
--

DROP TABLE IF EXISTS `garson`;
CREATE TABLE IF NOT EXISTS `garson` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `sifre` int(11) NOT NULL,
  `durum` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `garson`
--

INSERT INTO `garson` (`id`, `ad`, `sifre`, `durum`) VALUES
(1, 'olci', 1, 0),
(11, 'udemy', 1, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gecicigarson`
--

DROP TABLE IF EXISTS `gecicigarson`;
CREATE TABLE IF NOT EXISTS `gecicigarson` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `garsonid` int(11) NOT NULL,
  `garsonad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `adet` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `gecicigarson`
--

INSERT INTO `gecicigarson` (`id`, `garsonid`, `garsonad`, `adet`) VALUES
(1, 1, 'olci', 30);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gecicimasa`
--

DROP TABLE IF EXISTS `gecicimasa`;
CREATE TABLE IF NOT EXISTS `gecicimasa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `masaid` int(11) NOT NULL,
  `masaad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `hasilat` float NOT NULL,
  `adet` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `gecicimasa`
--

INSERT INTO `gecicimasa` (`id`, `masaid`, `masaad`, `hasilat`, `adet`) VALUES
(1, 18, 'MASA-18', 373.75, 54),
(2, 5, 'MASA-5', 199.9, 34),
(3, 1, 'MASA-1', 401.25, 37),
(4, 4, 'MASA-4', 214.5, 27),
(5, 2, 'MASA-2', 381.9, 55),
(6, 3, 'MASA-3', 685.45, 74),
(7, 9, 'MASA-9', 323.5, 40),
(8, 6, 'MASA-6', 418.6, 32),
(9, 15, 'MASA-15', 72, 6),
(10, 10, 'MASA-10', 263.39, 24),
(11, 11, 'MASA-11', 175, 14),
(12, 17, 'MASA-17', 72.5, 15),
(13, 8, 'MASA-8', 110.5, 14),
(14, 7, 'MASA-7', 109.5, 18),
(15, 14, 'MASA-14', 57.5, 9),
(16, 12, 'MASA-12', 101.5, 13),
(17, 13, 'MASA-13', 124, 16),
(18, 16, 'MASA-16', 203, 27);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `geciciurun`
--

DROP TABLE IF EXISTS `geciciurun`;
CREATE TABLE IF NOT EXISTS `geciciurun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `urunid` int(11) NOT NULL,
  `urunad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `hasilat` float NOT NULL,
  `adet` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `geciciurun`
--

INSERT INTO `geciciurun` (`id`, `urunid`, `urunad`, `hasilat`, `adet`) VALUES
(1, 23, 'Türk Kahvesi', 222, 37),
(2, 11, 'Şarap', 195.3, 7),
(3, 40, 'Ayran', 18, 9),
(4, 13, 'Karışık Tost', 231, 33),
(5, 37, 'Bol Malzeme', 216, 12),
(6, 20, 'Sahlep', 10, 2),
(7, 24, 'Çay', 76, 38),
(8, 5, 'Keşkül', 144, 12),
(9, 3, 'Su', 54, 27),
(10, 16, 'Kahvaltı', 451.52, 23),
(11, 6, 'Sütlaç', 275, 22),
(12, 28, 'Bira', 384, 32),
(13, 34, 'Fanta', 64, 16),
(14, 35, 'Sprite', 4, 1),
(15, 25, 'Sucuklu Tost', 168, 24),
(16, 30, 'Votka', 45, 1),
(17, 38, 'Köfte Burger', 204, 17),
(18, 15, 'Sade Makarna', 35.8, 4),
(19, 36, 'Profitol', 262.8, 31),
(20, 21, 'Limonata', 198, 33),
(21, 4, 'Soda', 44, 16),
(22, 32, 'Meyva Suyu - Vişne', 40, 8),
(23, 26, 'Çoban Salata', 28, 4),
(24, 7, 'Mozeralla', 121.44, 9),
(25, 27, 'Cola', 9, 3),
(26, 42, 'Mercimek Ç.', 81, 9),
(27, 41, 'Bitki Çayı', 32, 8),
(28, 43, 'Domates Ç.', 18, 2),
(29, 29, 'Nescafe', 16, 4),
(30, 49, 'Paçanga', 30, 5),
(31, 55, 'Somon Menü', 33, 3),
(32, 48, 'Kalamar', 27, 3),
(33, 46, 'Karides Güveç', 28, 2),
(34, 56, 'Ezogelin Ç.', 18, 2),
(35, 50, 'Avcı Böreği', 16, 2),
(36, 19, 'Tavuklu Ham.', 40, 5),
(37, 58, 'Adana K.', 36, 2),
(38, 60, 'Kanat', 112, 7),
(39, 44, 'Şalgam', 8, 2),
(40, 59, 'Lahmacun', 6, 1),
(41, 45, 'Lüfer Izgara', 120, 4),
(42, 17, 'Ton Balıklı', 9, 1),
(43, 61, 'Fincan Çay', 3, 1),
(44, 54, 'Nugget Menü', 16, 2),
(45, 63, 'Ada Çayı', 20, 5),
(46, 14, 'Peynirli', 44, 4),
(47, 62, 'Oralet', 3, 1),
(48, 53, 'Köfte Menü', 18, 2),
(49, 12, 'Kaşarlı Tost', 52.88, 11);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategoriler`
--

DROP TABLE IF EXISTS `kategoriler`;
CREATE TABLE IF NOT EXISTS `kategoriler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `mutfakdurum` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `kategoriler`
--

INSERT INTO `kategoriler` (`id`, `ad`, `mutfakdurum`) VALUES
(1, 'Sıcak İçecekler', 0),
(2, 'Soğuk İçecekler', 0),
(3, 'Tatlılar', 0),
(4, 'Pizzalar', 0),
(5, 'Tostlar', 0),
(6, 'Makarnalar', 0),
(7, 'Alkollü İçecekler', 0),
(8, 'Kahvaltı', 0),
(9, 'Salatalar', 0),
(10, 'Hamburgerler', 0),
(14, 'Ara Sıcak', 0),
(15, 'Çorbalar', 0),
(16, 'Balıklar', 0),
(17, 'Çocuk Menü', 0),
(18, 'Izgaralar', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `masabakiye`
--

DROP TABLE IF EXISTS `masabakiye`;
CREATE TABLE IF NOT EXISTS `masabakiye` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `masaid` int(11) NOT NULL,
  `tutar` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `masabakiye`
--

INSERT INTO `masabakiye` (`id`, `masaid`, `tutar`) VALUES
(26, 17, 60);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `masalar`
--

DROP TABLE IF EXISTS `masalar`;
CREATE TABLE IF NOT EXISTS `masalar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `durum` int(11) NOT NULL DEFAULT '0',
  `saat` int(11) NOT NULL DEFAULT '0',
  `dakika` int(11) NOT NULL DEFAULT '0',
  `rezervedurum` int(11) NOT NULL DEFAULT '0',
  `kisi` varchar(50) COLLATE utf8_turkish_ci NOT NULL DEFAULT 'bos',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `masalar`
--

INSERT INTO `masalar` (`id`, `ad`, `durum`, `saat`, `dakika`, `rezervedurum`, `kisi`) VALUES
(1, 'MASA-1', 0, 0, 0, 0, 'yok'),
(2, 'MASA-2', 0, 0, 0, 0, 'bos'),
(3, 'MASA-3', 0, 0, 0, 0, 'yok'),
(4, 'MASA-4', 0, 0, 0, 0, 'bos'),
(5, 'MASA-5', 0, 0, 0, 0, 'bos'),
(6, 'MASA-6', 0, 0, 0, 0, 'bos'),
(7, 'MASA-7', 0, 0, 0, 0, 'bos'),
(8, 'MASA-8', 0, 0, 0, 0, 'bos'),
(9, 'MASA-9', 0, 0, 0, 0, 'bos'),
(10, 'MASA-10', 0, 0, 0, 0, 'yok'),
(11, 'MASA-11', 0, 0, 0, 0, 'yok'),
(12, 'MASA-12', 0, 0, 0, 0, 'bos'),
(13, 'MASA-13', 0, 0, 0, 0, 'bos'),
(14, 'MASA-14', 0, 0, 0, 0, 'bos'),
(15, 'MASA-15', 1, 0, 0, 1, 'olci'),
(16, 'MASA-16', 0, 0, 0, 0, 'yok'),
(17, 'MASA-17', 1, 0, 0, 0, 'yok'),
(18, 'MASA-18', 1, 22, 30, 0, 'bos');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `mutfaksiparis`
--

DROP TABLE IF EXISTS `mutfaksiparis`;
CREATE TABLE IF NOT EXISTS `mutfaksiparis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `masaid` int(11) NOT NULL,
  `urunid` int(11) NOT NULL,
  `urunad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `adet` int(11) NOT NULL,
  `saat` int(11) NOT NULL DEFAULT '0',
  `dakika` int(11) NOT NULL DEFAULT '0',
  `durum` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `mutfaksiparis`
--

INSERT INTO `mutfaksiparis` (`id`, `masaid`, `urunid`, `urunad`, `adet`, `saat`, `dakika`, `durum`) VALUES
(8, 6, 7, 'Mozeralla', 5, 1, 41, 0),
(12, 2, 28, 'Bira', 30, 0, 50, 1),
(13, 9, 19, 'Tavuklu Ham.', 11, 0, 50, 0),
(14, 9, 17, 'Ton Balıklı', 1, 0, 57, 1),
(22, 5, 45, 'Lüfer Izgara', 3, 20, 52, 0),
(23, 14, 53, 'Köfte Menü', 3, 22, 21, 0),
(24, 14, 3, 'Su', 1, 22, 21, 0),
(26, 18, 12, 'Kaşarlı Tost', 3, 22, 30, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `rapor`
--

DROP TABLE IF EXISTS `rapor`;
CREATE TABLE IF NOT EXISTS `rapor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `masaid` int(11) NOT NULL,
  `garsonid` int(11) NOT NULL,
  `urunid` int(11) NOT NULL,
  `urunad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `urunfiyat` float NOT NULL,
  `adet` int(11) NOT NULL,
  `tarih` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=280 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `rapor`
--

INSERT INTO `rapor` (`id`, `masaid`, `garsonid`, `urunid`, `urunad`, `urunfiyat`, `adet`, `tarih`) VALUES
(65, 18, 10, 23, 'Türk Kahvesi', 6, 2, '2019-04-22'),
(66, 18, 10, 23, 'Türk Kahvesi', 6, 2, '2019-04-22'),
(67, 5, 11, 11, 'Şarap', 27.9, 1, '2019-04-22'),
(70, 1, 11, 40, 'Ayran', 2, 1, '2019-04-23'),
(71, 5, 10, 13, 'Karışık Tost', 7, 1, '2019-04-23'),
(72, 5, 10, 13, 'Karışık Tost', 7, 1, '2019-04-23'),
(73, 4, 1, 37, 'Bol Malzeme', 18, 1, '2019-04-23'),
(75, 2, 1, 20, 'Sahlep', 5, 1, '2019-04-23'),
(76, 1, 10, 23, 'Türk Kahvesi', 6, 1, '2019-04-24'),
(77, 1, 10, 23, 'Türk Kahvesi', 6, 1, '2019-04-24'),
(78, 2, 10, 24, 'Çay', 2, 2, '2019-04-24'),
(79, 2, 10, 24, 'Çay', 2, 2, '2019-04-24'),
(80, 2, 10, 24, 'Çay', 2, 1, '2019-04-24'),
(81, 2, 10, 24, 'Çay', 2, 1, '2019-04-24'),
(82, 2, 1, 5, 'Keşkül', 12, 2, '2019-04-24'),
(83, 2, 1, 5, 'Keşkül', 12, 2, '2019-04-24'),
(84, 2, 1, 23, 'Türk Kahvesi', 6, 2, '2019-04-24'),
(85, 2, 1, 23, 'Türk Kahvesi', 6, 2, '2019-04-24'),
(86, 2, 1, 3, 'Su', 1.5, 2, '2019-04-24'),
(87, 2, 1, 3, 'Su', 1.5, 2, '2019-04-24'),
(88, 3, 1, 37, 'Bol Malzeme', 18, 1, '2019-04-24'),
(89, 3, 1, 37, 'Bol Malzeme', 18, 1, '2019-04-24'),
(90, 9, 11, 16, 'Kahvaltı', 20, 2, '2019-04-24'),
(91, 9, 11, 24, 'Çay', 2, 2, '2019-04-24'),
(92, 3, 11, 6, 'Sütlaç', 12.5, 2, '2019-04-30'),
(93, 1, 10, 3, 'Su', 1.5, 2, '2019-04-30'),
(94, 6, 11, 23, 'Türk Kahvesi', 6, 2, '2019-04-30'),
(95, 6, 11, 13, 'Karışık Tost', 7, 1, '2019-04-30'),
(96, 6, 11, 28, 'Bira', 12, 3, '2019-04-30'),
(97, 6, 11, 11, 'Şarap', 27.9, 6, '2019-04-30'),
(98, 5, 1, 23, 'Türk Kahvesi', 6, 2, '2019-04-30'),
(99, 5, 1, 6, 'Sütlaç', 12.5, 2, '2019-04-30'),
(100, 5, 1, 34, 'Fanta', 4, 7, '2019-04-30'),
(101, 5, 1, 23, 'Türk Kahvesi', 6, 2, '2019-04-30'),
(102, 5, 1, 6, 'Sütlaç', 12.5, 2, '2019-04-30'),
(103, 5, 1, 34, 'Fanta', 4, 7, '2019-04-30'),
(104, 3, 11, 20, 'Sahlep', 5, 1, '2019-05-02'),
(105, 3, 11, 35, 'Sprite', 4, 1, '2019-05-02'),
(106, 3, 11, 25, 'Sucuklu Tost', 7, 2, '2019-05-02'),
(107, 3, 11, 6, 'Sütlaç', 12.5, 1, '2019-05-02'),
(108, 3, 11, 24, 'Çay', 2, 2, '2019-05-02'),
(109, 3, 11, 30, 'Votka', 45, 1, '2019-05-02'),
(110, 3, 11, 38, 'Köfte Burger', 12, 1, '2019-05-02'),
(111, 3, 11, 15, 'Sade Makarna', 8.95, 1, '2019-05-02'),
(112, 3, 11, 13, 'Karışık Tost', 7, 1, '2019-05-02'),
(113, 3, 11, 36, 'Profitol', 9, 2, '2019-05-02'),
(114, 3, 11, 24, 'Çay', 2, 2, '2019-05-02'),
(115, 3, 11, 21, 'Limonata', 6, 1, '2019-05-02'),
(116, 3, 11, 6, 'Sütlaç', 12.5, 1, '2019-05-02'),
(117, 3, 11, 3, 'Su', 1.5, 3, '2019-05-02'),
(118, 3, 11, 13, 'Karışık Tost', 7, 1, '2019-05-02'),
(119, 18, 11, 24, 'Çay', 2, 2, '2019-05-02'),
(120, 18, 11, 23, 'Türk Kahvesi', 6, 3, '2019-05-02'),
(121, 18, 11, 13, 'Karışık Tost', 7, 7, '2019-05-02'),
(122, 18, 11, 36, 'Profitol', 9, 4, '2019-05-02'),
(123, 18, 11, 21, 'Limonata', 6, 4, '2019-05-02'),
(124, 18, 11, 4, 'Soda', 2.75, 3, '2019-05-02'),
(125, 18, 11, 3, 'Su', 1.5, 9, '2019-05-02'),
(126, 18, 11, 32, 'Meyva Suyu - Vişne', 5, 3, '2019-05-02'),
(127, 1, 11, 26, 'Çoban Salata', 7, 1, '2019-05-02'),
(128, 1, 11, 7, 'Mozeralla', 20, 1, '2019-05-02'),
(129, 1, 11, 5, 'Keşkül', 12, 1, '2019-05-02'),
(130, 1, 11, 27, 'Cola', 3, 1, '2019-05-02'),
(131, 1, 11, 42, 'Mercimek Ç.', 9, 1, '2019-05-02'),
(132, 4, 11, 23, 'Türk Kahvesi', 6, 2, '2019-05-03'),
(133, 4, 11, 41, 'Bitki Çayı', 4, 5, '2019-05-03'),
(134, 4, 11, 43, 'Domates Ç.', 9, 2, '2019-05-03'),
(135, 4, 11, 7, 'Mozeralla', 20, 2, '2019-05-03'),
(136, 4, 11, 28, 'Bira', 12, 1, '2019-05-03'),
(137, 6, 1, 6, 'Sütlaç', 12.5, 4, '2019-05-03'),
(138, 6, 1, 23, 'Türk Kahvesi', 6, 4, '2019-05-03'),
(139, 6, 1, 38, 'Köfte Burger', 12, 2, '2019-05-03'),
(140, 2, 11, 24, 'Çay', 2, 7, '2019-05-03'),
(141, 2, 11, 13, 'Karışık Tost', 7, 3, '2019-05-03'),
(142, 2, 1, 29, 'Nescafe', 4, 4, '2019-05-03'),
(143, 15, 1, 28, 'Bira', 12, 6, '2019-05-03'),
(144, 10, 1, 15, 'Sade Makarna', 8.95, 1, '2019-05-03'),
(145, 2, 1, 49, 'Paçanga', 6, 2, '2019-05-03'),
(146, 2, 1, 55, 'Somon Menü', 11, 1, '2019-05-03'),
(147, 3, 1, 24, 'Çay', 2, 2, '2019-05-03'),
(148, 3, 1, 16, 'Kahvaltı', 20, 2, '2019-05-03'),
(149, 3, 1, 13, 'Karışık Tost', 7, 3, '2019-05-03'),
(150, 3, 1, 27, 'Cola', 3, 2, '2019-05-03'),
(151, 3, 1, 48, 'Kalamar', 9, 1, '2019-05-03'),
(152, 3, 1, 46, 'Karides Güveç', 14, 1, '2019-05-03'),
(153, 9, 1, 56, 'Ezogelin Ç.', 9, 1, '2019-05-04'),
(154, 9, 1, 42, 'Mercimek Ç.', 9, 1, '2019-05-04'),
(155, 9, 1, 50, 'Avcı Böreği', 8, 1, '2019-05-04'),
(156, 9, 1, 21, 'Limonata', 6, 3, '2019-05-04'),
(157, 9, 1, 56, 'Ezogelin Ç.', 9, 1, '2019-05-04'),
(158, 9, 1, 42, 'Mercimek Ç.', 9, 1, '2019-05-04'),
(159, 9, 1, 50, 'Avcı Böreği', 8, 1, '2019-05-04'),
(160, 9, 1, 21, 'Limonata', 6, 3, '2019-05-04'),
(161, 11, 1, 25, 'Sucuklu Tost', 7, 3, '2019-05-04'),
(162, 11, 1, 21, 'Limonata', 6, 3, '2019-05-04'),
(163, 17, 1, 26, 'Çoban Salata', 7, 2, '2019-05-04'),
(164, 8, 1, 23, 'Türk Kahvesi', 6, 2, '2019-05-04'),
(165, 8, 1, 3, 'Su', 3, 2, '2019-05-04'),
(166, 8, 1, 21, 'Limonata', 6, 1, '2019-05-04'),
(167, 8, 1, 13, 'Karışık Tost', 7, 1, '2019-05-04'),
(168, 7, 1, 38, 'Köfte Burger', 12, 2, '2019-05-04'),
(169, 7, 1, 19, 'Tavuklu Ham.', 8, 1, '2019-05-04'),
(170, 7, 1, 21, 'Limonata', 6, 3, '2019-05-04'),
(171, 14, 1, 55, 'Somon Menü', 11, 2, '2019-05-04'),
(172, 14, 1, 3, 'Su', 3, 3, '2019-05-04'),
(173, 14, 1, 6, 'Sütlaç', 12.5, 1, '2019-05-04'),
(174, 12, 1, 58, 'Adana K.', 18, 1, '2019-05-04'),
(175, 12, 1, 60, 'Kanat', 16, 1, '2019-05-04'),
(176, 12, 1, 40, 'Ayran', 2, 2, '2019-05-04'),
(177, 12, 1, 44, 'Şalgam', 4, 1, '2019-05-04'),
(178, 12, 1, 4, 'Soda', 2.75, 2, '2019-05-04'),
(179, 13, 1, 60, 'Kanat', 16, 1, '2019-05-04'),
(180, 13, 1, 58, 'Adana K.', 18, 1, '2019-05-04'),
(181, 13, 1, 59, 'Lahmacun', 6, 1, '2019-05-04'),
(182, 13, 1, 40, 'Ayran', 2, 2, '2019-05-04'),
(183, 13, 1, 44, 'Şalgam', 4, 1, '2019-05-04'),
(184, 13, 1, 3, 'Su', 3, 3, '2019-05-04'),
(185, 5, 1, 24, 'Çay', 2, 3, '2019-05-04'),
(186, 2, 1, 28, 'Bira', 12, 4, '2019-05-04'),
(187, 9, 1, 36, 'Profitol', 9, 4, '2019-05-07'),
(188, 9, 1, 21, 'Limonata', 6, 2, '2019-05-07'),
(189, 9, 1, 23, 'Türk Kahvesi', 6, 2, '2019-05-07'),
(190, 9, 1, 4, 'Soda', 2.75, 2, '2019-05-07'),
(191, 9, 1, 13, 'Karışık Tost', 7, 3, '2019-05-07'),
(192, 14, 1, 34, 'Fanta', 4, 2, '2019-05-07'),
(193, 14, 1, 21, 'Limonata', 6, 1, '2019-05-07'),
(194, 13, 1, 6, 'Sütlaç', 12.5, 2, '2019-05-07'),
(195, 13, 1, 21, 'Limonata', 6, 2, '2019-05-07'),
(196, 13, 1, 23, 'Türk Kahvesi', 6, 1, '2019-05-07'),
(197, 18, 1, 28, 'Bira', 12, 5, '2019-05-10'),
(198, 18, 1, 28, 'Bira', 12, 5, '2019-05-10'),
(199, 9, 1, 16, 'Kahvaltı', 20, 2, '2019-05-10'),
(200, 9, 1, 23, 'Türk Kahvesi', 6, 2, '2019-05-10'),
(201, 4, 1, 24, 'Çay', 2, 2, '2019-05-10'),
(202, 4, 1, 13, 'Karışık Tost', 7, 2, '2019-05-10'),
(203, 4, 1, 4, 'Soda', 2.75, 2, '2019-05-10'),
(204, 3, 1, 37, 'Bol Malzeme', 18, 3, '2019-05-10'),
(205, 3, 1, 37, 'Bol Malzeme', 18, 3, '2019-05-10'),
(206, 3, 1, 42, 'Mercimek Ç.', 9, 1, '2019-05-10'),
(207, 3, 1, 42, 'Mercimek Ç.', 9, 1, '2019-05-10'),
(208, 18, 1, 45, 'Lüfer Izgara', 30, 1, '2019-05-10'),
(209, 8, 1, 6, 'Sütlaç', 12.5, 3, '2019-05-10'),
(210, 8, 11, 17, 'Ton Balıklı', 9, 1, '2019-05-10'),
(211, 12, 11, 23, 'Türk Kahvesi', 6, 3, '2019-05-13'),
(212, 12, 11, 28, 'Bira', 12, 3, '2019-05-13'),
(213, 7, 11, 32, 'M. Suyu - Vişne', 5, 5, '2019-05-13'),
(214, 7, 11, 4, 'Soda', 2.75, 2, '2019-05-13'),
(215, 7, 11, 24, 'Bardak Çay', 2, 2, '2019-05-13'),
(216, 7, 11, 61, 'Fincan Çay', 3, 1, '2019-05-13'),
(217, 16, 11, 54, 'Nugget Menü', 8, 2, '2019-05-13'),
(218, 16, 11, 21, 'Limonata', 6, 2, '2019-05-13'),
(219, 16, 11, 3, 'Su', 3, 1, '2019-05-13'),
(220, 16, 11, 38, 'Köfte Burger', 12, 2, '2019-05-13'),
(221, 16, 11, 5, 'Keşkül', 12, 2, '2019-05-13'),
(222, 16, 11, 21, 'Limonata', 6, 2, '2019-05-13'),
(223, 4, 1, 49, 'Paçanga', 6, 2, '2019-05-13'),
(224, 4, 1, 60, 'Kanat', 16, 3, '2019-05-13'),
(225, 4, 1, 40, 'Ayran', 2, 2, '2019-05-13'),
(226, 4, 1, 26, 'Çoban Salata', 7, 1, '2019-05-13'),
(227, 18, 11, 19, 'Tavuklu Ham.', 8, 4, '2019-05-13'),
(228, 2, 11, 16, 'Kahvaltı', 20, 2, '2019-05-13'),
(229, 1, 1, 36, 'Profitol', 9, 4, '2019-05-13'),
(230, 1, 11, 16, 'Kahvaltı', 20, 9, '2019-05-13'),
(231, 16, 11, 25, 'Sucuklu Tost', 7, 6, '2019-05-13'),
(232, 8, 11, 49, 'Paçanga', 6, 1, '2019-05-13'),
(233, 17, 11, 41, 'Ihlamur', 4, 3, '2019-05-13'),
(234, 17, 11, 63, 'Ada Çayı', 4, 2, '2019-05-13'),
(235, 9, 11, 14, 'Peynirli', 11, 1, '2019-05-14'),
(236, 9, 11, 21, 'Limonata', 6, 2, '2019-05-14'),
(237, 8, 11, 36, 'Profitol', 9, 3, '2019-05-14'),
(238, 2, 11, 6, 'Sütlaç', 12.5, 4, '2019-05-14'),
(239, 10, 11, 62, 'Oralet', 3, 1, '2019-05-14'),
(240, 10, 11, 63, 'Ada Çayı', 4, 1, '2019-05-14'),
(241, 16, 11, 25, 'Sucuklu Tost', 7, 3, '2019-05-14'),
(242, 13, 11, 28, 'Bira', 12, 2, '2019-05-14'),
(243, 10, 10, 23, 'Türk Kahvesi', 6, 2, '2019-05-14'),
(244, 11, 10, 28, 'Bira', 12, 3, '2019-05-14'),
(245, 1, 10, 36, 'Profitol', 9, 4, '2019-05-14'),
(246, 1, 10, 42, 'Mercimek Ç.', 9, 1, '2019-05-14'),
(247, 2, 10, 42, 'Mercimek Ç.', 9, 3, '2019-05-14'),
(248, 16, 10, 13, 'Karışık Tost', 7, 7, '2019-05-14'),
(249, 9, 10, 53, 'Köfte Menü', 9, 2, '2019-05-14'),
(250, 9, 10, 21, 'Limonata', 6, 2, '2019-05-14'),
(251, 10, 10, 45, 'Lüfer Izgara', 30, 3, '2019-05-14'),
(252, 10, 10, 48, 'Kalamar', 9, 2, '2019-05-14'),
(253, 10, 10, 46, 'Karides Güveç', 14, 1, '2019-05-14'),
(254, 3, 10, 38, 'Köfte Burger', 12, 10, '2019-05-14'),
(255, 3, 10, 12, 'Kaşarlı Tost', 5, 10, '2019-05-14'),
(256, 3, 10, 25, 'Sucuklu Tost', 7, 10, '2019-05-14'),
(257, 2, 11, 15, 'Sade Makarna', 8.95, 2, '2019-05-14'),
(258, 2, 11, 21, 'Limonata', 6, 2, '2019-05-14'),
(259, 1, 1, 4, 'Soda', 2.75, 3, '2019-05-16'),
(260, 5, 11, 24, 'Bardak Çay', 2, 4, '2019-05-16'),
(261, 5, 11, 13, 'Karışık Tost', 7, 2, '2019-05-16'),
(262, 10, 11, 5, 'Keşkül', 12, 5, '2019-05-16'),
(263, 11, 11, 16, 'Kahvaltı', 20, 5, '2019-05-16'),
(264, 7, 11, 14, 'Peynirli', 11, 2, '2019-05-16'),
(265, 6, 1, 60, 'Kanat', 16, 2, '2019-05-16'),
(266, 6, 1, 40, 'Ayran', 2, 2, '2019-05-16'),
(267, 17, 1, 36, 'Profitol', 9, 3, '2019-08-21'),
(268, 17, 1, 4, 'Soda', 2.75, 2, '2019-08-21'),
(269, 17, 1, 24, 'Bardak Çay', 2, 3, '2019-08-21'),
(270, 1, 1, 37, 'Bol Malzeme', 18, 3, '2019-08-23'),
(271, 1, 1, 63, 'Ada Çayı', 4, 2, '2019-08-23'),
(272, 2, 1, 36, 'Profitol', 9, 2, '2019-08-23'),
(273, 1, 1, 24, 'Bardak Çay', 2, 1, '2019-09-04'),
(274, 6, 1, 14, 'Peynirli', 11, 1, '2019-09-07'),
(275, 6, 1, 7, 'Mozeralla', 10.24, 5, '2019-09-07'),
(276, 10, 1, 36, 'Profitol', 5.76, 5, '2019-09-07'),
(277, 10, 1, 12, 'Kaşarlı Tost', 2.88, 1, '2019-09-07'),
(278, 10, 1, 7, 'Mozeralla', 10.24, 1, '2019-09-07'),
(279, 10, 1, 16, 'Kahvaltı', 11.52, 1, '2019-09-07');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler`
--

DROP TABLE IF EXISTS `urunler`;
CREATE TABLE IF NOT EXISTS `urunler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `katid` int(11) NOT NULL,
  `ad` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `fiyat` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `urunler`
--

INSERT INTO `urunler` (`id`, `katid`, `ad`, `fiyat`) VALUES
(3, 2, 'Su', 3),
(4, 2, 'Soda', 2.75),
(5, 3, 'Keşkül', 12),
(6, 3, 'Sütlaç', 12.5),
(7, 4, 'Mozeralla', 20),
(11, 7, 'Şarap', 27.9),
(12, 5, 'Kaşarlı Tost', 5),
(13, 5, 'Karışık Tost', 7),
(14, 6, 'Peynirli', 11),
(15, 6, 'Sade Makarna', 8.95),
(16, 8, 'Kahvaltı', 20),
(17, 9, 'Ton Balıklı', 9),
(18, 9, 'Sezar Salata', 8),
(19, 10, 'Tavuklu Ham.', 8),
(20, 1, 'Sahlep', 5),
(21, 2, 'Limonata', 6),
(23, 1, 'Türk Kahvesi', 6),
(24, 1, 'Bardak Çay', 2),
(25, 5, 'Sucuklu Tost', 7),
(26, 9, 'Çoban Salata', 7),
(27, 2, 'Cola', 3),
(28, 7, 'Bira', 12),
(29, 1, 'Nescafe', 4),
(30, 7, 'Votka', 45),
(31, 2, 'M. Suyu - Şeftali', 5),
(32, 2, 'M. Suyu - Vişne', 5),
(33, 2, 'M. Suyu - Kayısı', 5),
(34, 2, 'Fanta', 4),
(35, 2, 'Sprite', 4),
(36, 3, 'Profitol', 9),
(37, 4, 'Bol Malzeme', 18),
(38, 10, 'Köfte Burger', 12),
(39, 6, 'Kıymalı Makarna', 9),
(40, 2, 'Ayran', 2),
(41, 1, 'Ihlamur', 4),
(42, 15, 'Mercimek Ç.', 9),
(43, 15, 'Domates Ç.', 9),
(44, 2, 'Şalgam', 4),
(45, 16, 'Lüfer Izgara', 30),
(46, 16, 'Karides Güveç', 14),
(47, 16, 'Balık Çorbası', 7),
(48, 16, 'Kalamar', 9),
(49, 14, 'Paçanga', 6),
(50, 14, 'Avcı Böreği', 8),
(51, 14, 'Humus', 6),
(52, 14, 'Mücver', 6),
(53, 17, 'Köfte Menü', 9),
(54, 17, 'Nugget Menü', 8),
(55, 17, 'Somon Menü', 11),
(56, 15, 'Ezogelin Ç.', 9),
(57, 15, 'Yayla Ç.', 9),
(58, 18, 'Adana K.', 18),
(59, 18, 'Lahmacun', 6),
(60, 18, 'Kanat', 16),
(61, 1, 'Fincan Çay', 3),
(62, 1, 'Oralet', 3),
(63, 1, 'Ada Çayı', 4);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yonetim`
--

DROP TABLE IF EXISTS `yonetim`;
CREATE TABLE IF NOT EXISTS `yonetim` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kulad` varchar(40) COLLATE utf8_turkish_ci NOT NULL,
  `sifre` varchar(40) COLLATE utf8_turkish_ci NOT NULL,
  `yetki` int(11) NOT NULL DEFAULT '0',
  `aktif` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `yonetim`
--

INSERT INTO `yonetim` (`id`, `kulad`, `sifre`, `yetki`, `aktif`) VALUES
(3, 'olcay', '021c6cd3a69730ac97d0b65576a9004f', 1, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
