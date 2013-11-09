-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Sam 09 Novembre 2013 à 23:59
-- Version du serveur: 5.5.25
-- Version de PHP: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données: `whiiya`
--

-- --------------------------------------------------------

--
-- Structure de la table `audios`
--

CREATE TABLE `audios` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `word_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  `language_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  `file` varchar(255) CHARACTER SET utf32 NOT NULL,
  `user_id` int(10) NOT NULL,
  PRIMARY KEY (`word_id`,`language_id`,`user_id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `audios`
--

INSERT INTO `audios` (`id`, `word_id`, `language_id`, `file`, `user_id`) VALUES
(2, '1', '1', '', 1),
(1, '1', '2', '', 1),
(3, '2', '2', '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `credits`
--

CREATE TABLE `credits` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `amount` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `credits`
--

INSERT INTO `credits` (`id`, `user_id`, `amount`) VALUES
(1, 1, 11);

-- --------------------------------------------------------

--
-- Structure de la table `history`
--

CREATE TABLE `history` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `word_id` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `description` varchar(255) NOT NULL,
  `flag` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `languages`
--

INSERT INTO `languages` (`id`, `code`, `description`, `flag`) VALUES
(1, 'EN', 'English', 'usa.png'),
(2, 'FR', 'français', 'france.png');

-- --------------------------------------------------------

--
-- Structure de la table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `audio_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `rating` int(1) NOT NULL,
  PRIMARY KEY (`id`,`audio_id`,`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `ratings`
--

INSERT INTO `ratings` (`id`, `audio_id`, `user_id`, `rating`) VALUES
(1, 1, 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `language_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;


-- --------------------------------------------------------

--
-- Structure de la table `words`
--

CREATE TABLE `words` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `word` varchar(255) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `words`
--

INSERT INTO `words` (`id`, `word`, `date_added`) VALUES
(1, 'Hello', '2013-11-08 14:28:08'),
(2, 'Bread', '2013-11-08 14:28:08');
