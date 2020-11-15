-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : Dim 15 nov. 2020 à 14:57
-- Version du serveur :  8.0.22-0ubuntu0.20.04.2
-- Version de PHP : 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données : `jam_admin`
--

-- --------------------------------------------------------

--
-- Structure de la table `invitation`
--

CREATE TABLE IF NOT EXISTS `invitation` (
                                            `id` int NOT NULL AUTO_INCREMENT,
                                            `user_id` int DEFAULT NULL,
                                            `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                            `role_id` int NOT NULL,
                                            `timestamp` bigint NOT NULL,
                                            PRIMARY KEY (`id`),
                                            UNIQUE KEY `email` (`email`),
                                            KEY `user_id` (`user_id`),
                                            KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
                                            `id` int NOT NULL AUTO_INCREMENT,
                                            `role_id` int NOT NULL,
                                            `route` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                            `user_id` int DEFAULT NULL,
                                            `timestamp` bigint NOT NULL,
                                            PRIMARY KEY (`id`),
                                            KEY `role_id` (`role_id`),
                                            KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pitch_mail`
--

CREATE TABLE IF NOT EXISTS `pitch_mail` (
                                            `id` int NOT NULL AUTO_INCREMENT,
                                            `lang` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                            `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                                            `subject` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                            `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                            `button_text` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                            `button_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                                            `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                            `updater_id` int NOT NULL,
                                            PRIMARY KEY (`id`),
                                            KEY `updater_id` (`updater_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `prospect`
--

CREATE TABLE IF NOT EXISTS `prospect` (
                                          `id` int NOT NULL AUTO_INCREMENT,
                                          `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                          `model_id` int DEFAULT NULL,
                                          `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                          `contact_email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                          `contact_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                          `mail_subject` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                          `mail_content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                          `creator_id` int NOT NULL,
                                          `assigned_id` int DEFAULT NULL,
                                          `status` enum('pending','negotiating','to_remind','accepted','declined','incomplete') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                          `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                          PRIMARY KEY (`id`),
                                          UNIQUE KEY `name` (`name`),
                                          KEY `assigned_id` (`assigned_id`),
                                          KEY `model_id` (`model_id`) USING BTREE,
                                          KEY `creator_id` (`creator_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
                                      `id` int NOT NULL AUTO_INCREMENT,
                                      `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                      `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                      `theme` enum('danger','warning','success','info','primary','secondary') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                      PRIMARY KEY (`id`),
                                      UNIQUE KEY `slug` (`slug`),
                                      UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
                                      `id` int NOT NULL AUTO_INCREMENT,
                                      `jam_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                      `role_id` int NOT NULL,
                                      `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                      `firstname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                      `lastname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                      `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
                                      `reg_timestamp` bigint NOT NULL,
                                      PRIMARY KEY (`id`),
                                      KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `invitation`
--
ALTER TABLE `invitation`
    ADD CONSTRAINT `invitation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
    ADD CONSTRAINT `invitation_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `permission`
--
ALTER TABLE `permission`
    ADD CONSTRAINT `permission_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `permission_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Contraintes pour la table `pitch_mail`
--
ALTER TABLE `pitch_mail`
    ADD CONSTRAINT `pitch_mail_ibfk_1` FOREIGN KEY (`updater_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `prospect`
--
ALTER TABLE `prospect`
    ADD CONSTRAINT `prospect_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `prospect_ibfk_2` FOREIGN KEY (`assigned_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
    ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
