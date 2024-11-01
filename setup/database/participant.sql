SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `%tablename%` (
                                                    `id` int NOT NULL AUTO_INCREMENT,
                                                    `event_id` int NOT NULL,
                                                    `participant_group` ENUM('participant','volunteer', 'team', 'other', 'online') NOT NULL DEFAULT 'participant',
                                                    `firstname` varchar(128) NOT NULL,
                                                    `lastname` varchar(128) NOT NULL,
                                                    `nickname` varchar(256) DEFAULT NULL,
                                                    `local_group` int NOT NULL,
                                                    `birthday` date DEFAULT NULL,
                                                    `contact_person` varchar(256) DEFAULT NULL,
                                                    `street` varchar(128) DEFAULT NULL,
                                                    `number` varchar(8) DEFAULT NULL,
                                                    `zip` varchar(10) DEFAULT NULL,
                                                    `city` varchar(128) DEFAULT NULL,
                                                    `email_1` varchar(512) NOT NULL,
                                                    `email_2` varchar(512) DEFAULT NULL,
                                                    `telefon_1` varchar(512) NOT NULL,
                                                    `telefon_2` varchar(512) DEFAULT NULL,
                                                    `swimming_permission` enum('complete','partial','none','') NOT NULL DEFAULT 'none',
                                                    `allergies` varchar(2048) NOT NULL,
                                                    `intolerances` varchar(2048) NOT NULL,
                                                    `medication` varchar(2048) NOT NULL,
                                                    `eating_habit` enum('all','vegetarian','vegan') NOT NULL DEFAULT 'vegetarian',
                                                    `foto_socialmedia` tinyint NOT NULL DEFAULT '0',
                                                    `foto_print` tinyint NOT NULL DEFAULT '0',
                                                    `foto_webseite` tinyint NOT NULL DEFAULT '0',
                                                    `foto_partner` tinyint NOT NULL DEFAULT '0',
                                                    `foto_intern` tinyint NOT NULL DEFAULT '0',
                                                    `notices` varchar(2048) NOT NULL,
                                                    `amount` decimal(8,2) NOT NULL DEFAULT '0',
                                                    `amount_paid` decimal(8,2) NOT NULL DEFAULT '0',
                                                    `arrival` date DEFAULT NULL,
                                                    `arrival_eating` int NOT NULL,
                                                    `departure` date DEFAULT NULL,
                                                    `departure_eating` int NOT NULL,
                                                    `date_unregister` DATETIME DEFAULT NULL,
                                                    `created_at` timestamp NULL DEFAULT NULL,
                                                    `updated_at` timestamp NULL DEFAULT NULL,
PRIMARY KEY  (id)
) %charset%;


ALTER TABLE `%tablename%`
    ADD PRIMARY KEY (`id`);


ALTER TABLE `%tablename%`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

COMMIT;
