<?php

class _2025_06_08_10_54_21_create_table_migrations
{
    public static function up()
    {
        return "CREATE TABLE `migrations` (
        `name` varchar(128) COLLATE latin1_bin NOT NULL,
        PRIMARY KEY `name` (`name`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin";
    }

    public static function down()
    {
        return "DROP TABLE `migrations`";
    }
}
