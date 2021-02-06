CREATE DATABASE IF NOT EXISTS `itpendent` DEFAULT CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
USE `itpendent`;

CREATE TABLE IF NOT EXISTS `record`
(
    `id`           int(11)      NOT NULL AUTO_INCREMENT,
    `artist`       varchar(255) NOT NULL,
    `title`        varchar(255) NOT NULL,
    `release_type` varchar(30)  NOT NULL,
    `release_year` int(11)      NOT NULL,
    PRIMARY KEY (`id`)
);

INSERT INTO `record` (`id`, `artist`, `title`, `release_type`, `release_year`)
VALUES (null, 'Artist_1', 'Title_1', 'cd', 2001),
       (null, 'Artist_2', 'Title_2', 'vinyl', 2002),
       (null, 'Artist_3', 'Title_3', 'mp3', 2003),
       (null, 'Artist_4', 'Title_4', 'cd', 2004);

CREATE TABLE IF NOT EXISTS `track`
(
    `id`         int(11)      NOT NULL AUTO_INCREMENT,
    `record_id` int(11)      NOT NULL,
    `title`      varchar(255) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`record_id`) REFERENCES `record` (id)
);

INSERT INTO `track` (`id`, `record_id`, `title`)
VALUES (null, 1, 'Track_1'),
       (null, 1, 'Track_2'),
       (null, 1, 'Track_3'),
       (null, 1, 'Track_4'),
       (null, 2, 'Track_1'),
       (null, 2, 'Track_2'),
       (null, 2, 'Track_3'),
       (null, 2, 'Track_4'),
       (null, 3, 'Track_1'),
       (null, 3, 'Track_2'),
       (null, 3, 'Track_3'),
       (null, 3, 'Track_4'),
       (null, 4, 'Track_1'),
       (null, 4, 'Track_2'),
       (null, 4, 'Track_3'),
       (null, 4, 'Track_4');
