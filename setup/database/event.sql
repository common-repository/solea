SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;

CREATE TABLE `%tablename%` (  `id` int NOT NULL AUTO_INCREMENT,
                              `event_url` varchar(1024) NOT NULL,
                               `event_name` varchar(1024) NOT NULL,
                               `event_email` varchar(1024) NOT NULL,
                               `event_organisator_id` int DEFAULT NULL,
                               `event_treasurer_id` int DEFAULT NULL,
                               `archived`  tinyint NOT NULL DEFAULT '0',
                               `signup_allowed`  tinyint NOT NULL DEFAULT '0',
                               `last_minute_begin` date NOT NULL,
                               `registration_end` date NOT NULL,
                               `date_begin` date NOT NULL,
                               `date_end` date NOT NULL,
                               `amount_team`  decimal(8,2) DEFAULT NULL,
                               `amount_volunteer`  decimal(8,2) DEFAULT NULL,
                               `amount_participant`  decimal(8,2) DEFAULT NULL,
                               `amount_online`  decimal(8,2) DEFAULT NULL,
                               `amount_other`  decimal(8,2) DEFAULT NULL,
                               `amount_social` decimal(8,2) DEFAULT NULL,
                               `amount_reduced` decimal(8,2) DEFAULT NULL,
                               `amount_max` decimal(8,2) DEFAULT NULL,
                               `increase_amount_last_minute` decimal(8,2) DEFAULT '0.5',
                               `description_team` varchar(2048) DEFAULT NULL,
                               `description_volunteer` varchar(2048) DEFAULT NULL,
                               `description_participant` varchar(2048) DEFAULT NULL,
                               `description_other` varchar(2048) DEFAULT NULL,
                               `weekly_report` tinyint NOT NULL default '1',
                               `enable_all_eating` tinyint NOT NULL default '0',
                               `age_alcoholics` int NOT NULL DEFAULT 16,
                               `contributing_groups` TEXT NOT NULL,
                               `payment_direct` tinyint NOT NULL default '0',
                               `registration_solidarity` tinyint NOT NULL default '1',
                               `account_iban` varchar(64) DEFAULT NULL,
                               `account_owner` varchar(256) DEFAULT NULL,
                               `created_at` timestamp NULL DEFAULT NULL,
                               `updated_at` timestamp NULL DEFAULT NULL,
PRIMARY KEY  (id)

) %charset%;

ALTER TABLE `%tablename%`
    ADD PRIMARY KEY (`id`);


ALTER TABLE `%tablename%`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

COMMIT;
