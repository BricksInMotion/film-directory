-- Create a new table to store forum topic links
CREATE TABLE IF NOT EXISTS `films_topics` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `film_id` INT(12) UNSIGNED NOT NULL,
  `topic_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB;

-- Using data from the forums_topics table, populate the new table
INSERT INTO `films_topics` (`film_id`, `topic_id`)
SELECT `film_id`, `id`
FROM `forums_topics`
WHERE `forums_topics`.`film_id` IS NOT NULL;
