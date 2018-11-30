-- Add an index to the film title to improve lookup
ALTER TABLE `films`
ADD INDEX `title` (`title`);

-- Rename `genres` table to be consistent with other table names
RENAME TABLE `genres` TO `films_all_genres`;

-- Remove unused tables
DROP TABLE `films_tags`;
DROP TABLE `films_ratings`;

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
  DROP COLUMN `warn_desc`,
  DROP COLUMN `date_edit`,
  DROP COLUMN `edit`;

-- Remove the primary genre indicator (it is not respected)
-- ALTER TABLE `films_genre`
--   DROP COLUMN `is_primary`;
