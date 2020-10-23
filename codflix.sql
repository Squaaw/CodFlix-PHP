-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 25, 2020 at 06:09 PM
-- Server version: 5.7.24
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `codflix`
--

DROP DATABASE IF EXISTS `codflix`;
CREATE DATABASE `codflix` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `codflix`;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`id`, `name`) VALUES
(1, 'Action'),
(2, 'Horreur'),
(3, 'Science-Fiction'),
(4, 'Fantastique');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `finish_date` datetime DEFAULT NULL,
  `watch_duration` int(11) NOT NULL DEFAULT '0' COMMENT 'in seconds'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `release_date` date NOT NULL,
  `summary` longtext NOT NULL,
  `trailer_url` varchar(100) NOT NULL,
  `poster_url` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `genre_id`, `title`, `type`, `status`, `release_date`, `summary`, `trailer_url`, `poster_url`) VALUES
(1, 1, 'Mission: Impossible', 'film', 'publié', '1996-10-23', 'An American agent, under false suspicion of disloyalty, must discover and expose the real spy without the help of his organization.', 'Ohws8y572KE', 'https://fr.web.img6.acsta.net/pictures/188/630/18863006_20130730124823207.jpg'),
(2, 2, 'The Demon Inside', 'film', 'publié', '2020-06-22', 'Après trois années passées en prison pour la mort d’un enfant lors d’une séance d’exorcisme qui a mal tournée, le Père Lambert cherche sa rédemption auprès de Joel, un jeune père de famille qui soupçonne son fils d’être possédé...', 'xoNBu_p8LZI', 'https://fr.web.img6.acsta.net/pictures/20/02/12/17/00/3510234.jpg'),
(3, 3, 'Star Wars : Episode V - L\'Empire contre-attaque', 'film', 'publié', '1980-08-20', 'Malgré la destruction de l\'Etoile Noire, l\'Empire maintient son emprise sur la galaxie, et poursuit sans relâche sa lutte contre l\'Alliance rebelle. Basés sur la planète glacée de Hoth, les rebelles essuient un assaut des troupes impériales. Parvenus à s\'échapper, la princesse Leia, Han Solo, Chewbacca et C-3P0 se dirigent vers Bespin, la cité des nuages gouvernée par Lando Calrissian, ancien compagnon de Han. Suivant les instructions d\'Obi-Wan Kenobi, Luke Skywalker se rend quant à lui vers le système de Dagobah, planète marécageuse où il doit recevoir l\'enseignement du dernier maître Jedi, Yoda. Apprenant l\'arrestation de ses compagnons par les stormtroopers de Dark Vador après la trahison de Lando, Luke décide d\'interrompre son entraînement pour porter secours à ses amis et affronter le sombre seigneur Sith...', '_y-xlGOuVaE', 'https://fr.web.img4.acsta.net/medias/nmedia/00/02/44/28/empire.jpg'),
(4, 1, 'La Casa de Papel', 'série', 'en cours', '2017-05-02', 'Huit voleurs font une prise d\'otages dans la Maison royale de la Monnaie d\'Espagne, tandis qu\'un génie du crime manipule la police pour mettre son plan à exécution.', 'https://www.youtube.com/embed/hMANIarjT50', 'https://media.senscritique.com/media/000018935876/source_big/La_Casa_de_Papel.jpg'),
(5, 3, 'Star Wars: L\'Ascension de Skywalker', 'film', 'publié', '2019-12-18', 'The surviving members of the resistance face the First Order once again, and the legendary conflict between the Jedi and the Sith reaches its peak bringing the Skywalker saga to its end. ', 'pHgwf2eMFnA', 'https://fr.web.img6.acsta.net/pictures/19/10/22/10/17/3326733.jpg'),
(6, 4, 'Stranger Things', 'série', 'en cours', '2016-07-15', 'A Hawkins, en 1983 dans l\'Indiana. Lorsque Will Byers disparaît de son domicile, ses amis se lancent dans une recherche semée d’embûches pour le retrouver. Dans leur quête de réponses, les garçons rencontrent une étrange jeune fille en fuite. Les garçons se lient d\'amitié avec la demoiselle tatouée du chiffre \"11\" sur son poignet et au crâne rasé et découvrent petit à petit les détails sur son inquiétante situation. Elle est peut-être la clé de tous les mystères qui se cachent dans cette petite ville en apparence tranquille…', 'https://www.youtube.com/embed/mnd7sFt5c3A', 'https://fr.web.img3.acsta.net/pictures/19/01/03/10/42/0987125.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `serie`
--

CREATE TABLE `serie` (
  `id` int(11) NOT NULL,
  `media_id` int(11) NOT NULL,
  `season` int(2) NOT NULL,
  `episode` int(3) NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `summary` longtext NOT NULL,
  `stream_url` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `serie`
--

INSERT INTO `serie` (`id`, `media_id`, `season`, `episode`, `title`, `summary`, `stream_url`) VALUES
(1, 4, 1, 1, 'Efectuar lo acordado', 'The Professor recruits a young female robber and seven other criminals for a grand heist, targeting the Royal Mint of Spain.', 'https://www.youtube.com/embed/GuIvzozPVak'),
(2, 4, 1, 2, 'Imprudencias letales', 'Hostage negotiator Raquel makes initial contact with the Professor. One of the hostages is a crucial part of the thieves\' plans.', 'https://www.youtube.com/embed/SGoE-OLKUzg'),
(3, 4, 2, 1, 'Se acabaron las máscaras', 'The police finds the house where The Professor has planned everything. Tokyo and Berlin are fighting about how to proceed.', 'https://www.youtube.com/embed/6HI7nL_-fgc'),
(4, 4, 2, 2, 'La cabeza del plan', 'Tokyo is questioned by the police. The Professor and Raquel\'s ex-husband are getting into a fight.', 'https://www.youtube.com/embed/Z0JxxcZHuw8'),
(5, 6, 1, 1, 'Chapter One: The Vanishing of Will Byers', 'At the U.S. Dept. of Energy an unexplained event occurs. Then when a young Dungeons and Dragons playing boy named Will disappears after a night with his friends, his mother Joyce and the town of Hawkins are plunged into darkness.', 'https://www.youtube.com/embed/CKtq-bZgS8I'),
(6, 6, 1, 2, 'Chapter Two: The Weirdo on Maple Street', 'Mike hides the mysterious girl in his house. Joyce gets a strange phone call.', 'https://www.youtube.com/embed/uTnmPO2e21A'),
(7, 6, 1, 3, 'Chapter Three: Holly, Jolly', 'An increasingly concerned Nancy looks for Barb and finds out what Jonathan\'s been up to. Joyce is convinced Will is trying to talk to her.', 'https://www.youtube.com/embed/Bef89OEsksM'),
(8, 6, 2, 1, 'Chapter One: MADMAX', 'As the town preps for Halloween, a high-scoring rival shakes things up at the arcade, and a skeptical Hopper inspects a field of rotting pumpkins.', 'https://www.youtube.com/embed/R1ZXOOLMJ8s'),
(9, 6, 2, 2, 'Chapter Two: Trick or Treat, Freak', 'After Will sees something terrible on trick-or-treat night, Mike wonders whether Eleven\'s still out there. Nancy wrestles with the truth about Barb.', 'https://www.youtube.com/embed/mwSiCR4VfcI'),
(10, 6, 3, 1, 'Chapter One: Suzie, Do You Copy?', 'Summer brings new jobs and budding romance. But the mood shifts when Dustin\'s radio picks up a Russian broadcast, and Will senses something is wrong.', 'https://www.youtube.com/embed/b9EkMc79ZSU');

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(254) NOT NULL,
  `password` varchar(80) NOT NULL,
  `active` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favorites_user_id_fk_user_id` (`user_id`),
  ADD KEY `favorites_media_id_fk_media_id` (`media_id`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `history_user_id_fk_media_id` (`user_id`),
  ADD KEY `history_media_id_fk_media_id` (`media_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_genre_id_fk_genre_id` (`genre_id`) USING BTREE;

--
-- Indexes for table `serie`
--
ALTER TABLE `serie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `serie_media_id_fk_media_id` (`media_id`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id`),
  ADD KEY `token_user_id_fk_user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `serie`
--
ALTER TABLE `serie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `token`
--
ALTER TABLE `token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_media_id_fk_media_id` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_media_id_fk_media_id` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `history_user_id_fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_genre_id_b1257088_fk_genre_id` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`);

--
-- Constraints for table `serie`
--
ALTER TABLE `serie`
  ADD CONSTRAINT `serie_media_id_fk_media_id` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `token_user_id_fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
