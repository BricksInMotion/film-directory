-- Add the new column
ALTER TABLE `films`
ADD COLUMN `is_reborn_film` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `incrementor`;
