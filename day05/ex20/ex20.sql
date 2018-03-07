SELECT
    `db_pgritsen`.`film`.`id_genre` AS `id_genre`,
    `db_pgritsen`.`genre`.`name` AS `name_genre`,
    `db_pgritsen`.`film`.`id_distrib` AS `id_distrib`,
    `db_pgritsen`.`distrib`.`name` AS `name_distrib`,
    `db_pgritsen`.`film`.`title` AS `title_film`
FROM
    `db_pgritsen`.`film`
LEFT JOIN `db_pgritsen`.`genre` ON
    `db_pgritsen`.`film`.`id_genre` = `db_pgritsen`.`genre`.`id_genre`
LEFT JOIN `db_pgritsen`.`distrib` ON
    `db_pgritsen`.`film`.`id_distrib` = `db_pgritsen`.`distrib`.`id_distrib`;