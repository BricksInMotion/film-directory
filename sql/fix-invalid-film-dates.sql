-- Define a new date to indicate an invalid film date
SET @unknown_date = '1900-01-01';

-- Update all the invalid dates
UPDATE `films`
SET `date_create` = @unknown_date
WHERE YEAR(`films`.`date_create`) = 0;
