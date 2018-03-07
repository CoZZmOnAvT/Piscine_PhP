SELECT
	`title` AS `Title`,
	`summary` AS `Summary`
FROM
	`db_pgritsen`.`film`
WHERE
	`id_genre` IN(
	SELECT
		`id_genre`
	FROM
		`db_pgritsen`.`genre`
	WHERE
		LOWER(`name`) = 'erotic'
)
ORDER BY
	`prod_year`;