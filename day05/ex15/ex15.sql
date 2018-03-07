SELECT
	REVERSE(SUBSTR(`phone_number`, 2)) AS `rebmunenohp`
FROM
	`db_pgritsen`.`distrib`
WHERE
	`phone_number` LIKE '05%';