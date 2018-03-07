SELECT *
FROM
	`db_pgritsen`.`distrib`
WHERE
	(
		`id_distrib` = 42 OR(
			`id_distrib` >= 62 AND `id_distrib` <= 90
		)
	) OR LOWER(`name`) REGEXP '^[^y]*[y]{1}[^y]*[y]{1}[^y]*$'
LIMIT 2, 5;