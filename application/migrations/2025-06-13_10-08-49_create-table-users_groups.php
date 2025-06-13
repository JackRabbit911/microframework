<?php

class _2025_06_13_10_08_49_create_table_users_groups 
{
    public static function up()
    {
        return "CREATE TABLE `users_groups` (
        `user_id` int(10) unsigned NOT NULL,
        `group_id` int(10) unsigned NOT NULL,
        `role` tinyint NOT NULL,
        `status` tinyint NULL,
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
        FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE
        ) ENGINE='InnoDB' COLLATE 'latin1_bin';";
    }

    public static function down()
    {
        return "DROP TABLE `users_groups`";
    }
}
