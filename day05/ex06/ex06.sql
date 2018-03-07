SELECT
	`title`,
	`summary`
FROM
	`db_pgritsen`.`film`
WHERE
	LOWER(`summary`) LIKE '%vincent%'
ORDER BY
	`id_film` ASC;