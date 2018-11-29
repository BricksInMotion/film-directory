-- Add the new column
ALTER TABLE `films`
ADD COLUMN `incrementor` INT(12) UNSIGNED NOT NULL DEFAULT '0' AFTER `edit`;

-- Add an index to improve lookup
ALTER TABLE `films`
ADD INDEX `incrementor` (`incrementor`);

-- Create our incrementor
SET @i = 0;

-- Add our incrementor to the data
UPDATE `films`
SET `incrementor` = (@i := @i + 1)
ORDER BY `films`.`date_create` ASC;
