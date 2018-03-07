SELECT
	ABS(
		DATEDIFF(`last_projection`, `release_date`)
	) AS `uptime`
FROM
	`db_pgritsen`.`film`;