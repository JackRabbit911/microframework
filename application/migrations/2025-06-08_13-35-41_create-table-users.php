<?php

class _2025_06_08_13_35_41_create_table_users
{
    public static function up()
    {
        return "CREATE TABLE `users` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(128) NOT NULL,
        `email` varchar(128) NOT NULL,
        `phone` decimal(11,0) DEFAULT NULL,
        `dob` date DEFAULT NULL,
        `sex` tinyint(1) unsigned DEFAULT NULL,
        `info` json DEFAULT NULL,
        `password` varchar(128) DEFAULT NULL,
        `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `email` (`email`),
        UNIQUE KEY `phone` (`phone`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    }

    public static function down()
    {
        return "DROP TABLE `users`";
    }
}
