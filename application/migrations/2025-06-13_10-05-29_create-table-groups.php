<?php

class _2025_06_13_10_05_29_create_table_groups 
{
    public static function up()
    {
        return "CREATE TABLE `groups` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `name` varchar(128) NOT NULL,
        `info` json NULL
        ) ENGINE='InnoDB';";
    }

    public static function down()
    {
        return "DROP TABLE `groups`";
    }
}
