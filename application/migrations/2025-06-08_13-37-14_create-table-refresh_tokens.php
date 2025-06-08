<?php

class _2025_06_08_13_37_14_create_table_refresh_tokens 
{
    public static function up()
    {
        return "CREATE TABLE `refresh_tokens` (
        `token` varchar(128) COLLATE latin1_bin NOT NULL,
        `user_id` int(10) UNSIGNED NULL,
        `user_agent` varchar(32) COLLATE latin1_bin NOT NULL,
        `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY `token_user_agent` (`token`,`user_agent`),
        KEY `user_id` (`user_id`),
        KEY `updated` (`updated`),
        CONSTRAINT `refresh_tokens_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;";
    }

    public static function down()
    {
        return "DROP TABLE `refresh_tokens`";
    }
}
