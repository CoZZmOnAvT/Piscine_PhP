SELECT
	COUNT(*) AS `nb_short-films`
FROM
	`db_pgritsen`.`film`
WHERE
	`duration` <= 42;