-- Rename `genres` table to be consistent with other table names
RENAME TABLE `genres` TO `films_genre_categories`;

-- Remove the primary genre indicator (it is not respected)
ALTER TABLE `films_genre`
  DROP COLUMN `is_primary`;

-- Remove unused tables
DROP TABLE `films_tags`;
DROP TABLE `films_ratings`;

-- Remove user's IP addresses and the date of this rating
ALTER TABLE `films_user_rate_votes`
  DROP COLUMN `user_ip`,
  DROP COLUMN `rating_date`;

-- Remove the ID that links a film's individual rating
-- back to the the person who rated it
ALTER TABLE `films_user_rate`
  DROP COLUMN `banned_id`;

-- Film review date was never stored to begin with,
-- they are all '0000-00-00 00:00:000'
ALTER TABLE `films_reviews`
  DROP COLUMN `addeddate`;

-- Add an index to the film title to improve lookup
ALTER TABLE `films`
ADD INDEX `title` (`title`);

-- Remove unused and/or useless columns
ALTER TABLE `films`
  DROP COLUMN `img_poster`,
  DROP COLUMN `img_frame`,
  DROP COLUMN `time_reviewed`,
  DROP COLUMN `rate_over`,
  DROP COLUMN `rate_story`,
  DROP COLUMN `rate_ani`,
  DROP COLUMN `rate_cine`,
  DROP COLUMN `rate_fx`,
  DROP COLUMN `rate_sound`,
  DROP COLUMN `rate_music`,
  DROP COLUMN `warn_sex`,
  DROP COLUMN `warn_lang`,
  DROP COLUMN `warn_vio`,
  DROP COLUMN `warn_desc`,
  DROP COLUMN `date_post`,
  DROP COLUMN `date_edit`,
  DROP COLUMN `keywords`,
  DROP COLUMN `edit`;

-- Decrease the film length column size to be sensible
-- and rename the column to be spelled correctly
ALTER TABLE `films`
  ALTER `lenth` DROP DEFAULT;
ALTER TABLE `films`
  CHANGE COLUMN `lenth` `length` MEDIUMINT(8) UNSIGNED NOT NULL AFTER `date_create`;

-- Revise the links table to be more sensible
ALTER TABLE `films_links`
  ALTER `film_id` DROP DEFAULT,
  ALTER `link` DROP DEFAULT,
  ALTER `link_desc` DROP DEFAULT;
ALTER TABLE `films_links`
  CHANGE COLUMN `id` `id` INT(20) UNSIGNED NOT NULL AUTO_INCREMENT FIRST,
  CHANGE COLUMN `film_id` `film_id` INT(12) UNSIGNED NOT NULL AFTER `id`,
  CHANGE COLUMN `link` `link` VARCHAR(255) NOT NULL AFTER `film_id`,
  CHANGE COLUMN `link_desc` `label` VARCHAR(255) NOT NULL AFTER `link`;

