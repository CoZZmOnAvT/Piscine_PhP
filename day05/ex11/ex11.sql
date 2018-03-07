SELECT
	UPPER(
		`db_pgritsen`.`user_card`.`last_name`
	) AS `NAME`,
	`db_pgritsen`.`user_card`.`first_name` AS `first_name`,
	`db_pgritsen`.`subscription`.`price` AS `price`
FROM
	`db_pgritsen`.`user_card`
INNER JOIN `db_pgritsen`.`member` ON
	`db_pgritsen`.`user_card`.`id_user` = `db_pgritsen`.`member`.`id_user_card`
INNER JOIN `db_pgritsen`.`subscription` ON
	`db_pgritsen`.`member`.`id_sub` = `db_pgritsen`.`subscription`.`id_sub`
WHERE
	`db_pgritsen`.`subscription`.`price` > 42
ORDER BY `NAME` ASC, `first_name` ASC;