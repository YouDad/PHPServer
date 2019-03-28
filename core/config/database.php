<?php
return array(
    'DSN' => 'mysql:host=localhost;dbname=test',
    'USERNAME' => 'root',
    'PASSWORD' => 'mArIaDb@Ixv',
    'DATABASE' => 'hottery',
    'CREATE_TABLE' => 'CREATE TABLE IF NOT EXISTS ',
    'CREATE_DATABASE' => 'CREATE DATABASE IF NOT EXISTS hottery CHARACTER SET utf8;',
    'TABLE_DEFINE' => [
        'hottery_user' =>
            "hottery_user (
              uid INTEGER PRIMARY KEY,
              username CHAR(16),
              pass_md5 CHAR(32)
            );",
    ],
);