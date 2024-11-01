SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;


CREATE TABLE `%tablename%` (
                                 `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
                                 `name` varchar(256)  NOT NULL,
                                 `email` varchar(1024) NOT NULL,
                                 `members_email` varchar(1024) NOT NULL,
                                 `zip` varchar(16) NOT NULL,
                                 `city` varchar(128) NOT NULL,
                                 PRIMARY KEY  (id)
) %charset%;

ALTER TABLE `%tablename%`
    ADD PRIMARY KEY (`id`);


ALTER TABLE `%tablename%`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

COMMIT;