-- Add an index to the film title to improve lookup
ALTER TABLE `films`
ADD INDEX `title` (`title`);

-- TODO: Purge unused columns

-- TODO: Rename `genre` table to `film_genre` to be consistent
