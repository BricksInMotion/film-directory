-- Add an index to the film title to improve lookup
ALTER TABLE `films`
ADD INDEX `title` (`title`);
