-- Add the new column
-- TODO: Possibly add index
ALTER TABLE `films`
ADD COLUMN `incrementor` INT(12) UNSIGNED NOT NULL DEFAULT '0' AFTER `edit`;

-- Create our incrementor
SET @i = 0;

-- Add our incrementor to the data
UPDATE `films`
SET `incrementor` = (@i := @i + 1)
ORDER BY `films`.`date_create` ASC';
