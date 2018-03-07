SELECT
	`last_name`,
	`first_name`,
	DATE_FORMAT(`birthdate`, "%Y-%m-%d") AS `birthdate`
FROM
	`db_pgritsen`.`user_card`
WHERE
	YEAR(`birthdate`) = 1989;