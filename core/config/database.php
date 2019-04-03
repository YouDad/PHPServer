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
                username CHAR(16) PRIMARY KEY,
                pass_md5 CHAR(32) NOT NULL,
                level INTEGER,
                phone_number CHAR(20),
                email CHAR(32)
            );",
        'hottery_room'=>
            "hottery_room (
                rid INTEGER PRIMARY KEY AUTO_INCREMENT,
                title CHAR(32) NOT NULL,
                start_time TIMESTAMP  NOT NULL,
                access TINYINT NOT NULL,
                img CHAR(32),
                other_option VARCHAR(1024)
            );",
        'hottery_cookie'=>
            "hottery_cookie (
                uid INTEGER PRIMARY KEY REFERENCES hottery_uid(uid) ON DELETE CASCADE,
                cookie CHAR(128) NOT NULL,
                valid_time INTEGER NOT NULL
            );",
        'hottery_uid'=>
            "hottery_uid (
                uid INTEGER PRIMARY KEY AUTO_INCREMENT,
                openid CHAR(40),
                username CHAR(16) REFERENCES hottery_user(username) ON DELETE CASCADE
            );",
        'hottery_bullet'=>
            "hottery_bullet (
                bid INTEGER PRIMARY KEY AUTO_INCREMENT,
                uid INTEGER NOT NULL REFERENCES hottery_uid(uid) ON DELETE CASCADE,
                rid INTEGER NOT NULL REFERENCES hottery_room(rid) ON DELETE CASCADE,
                time TIMESTAMP NOT NULL,
                content CHAR(72) NOT NULL
            );",
        'hottery_history'=>
            "hottery_history (
                hid INTEGER PRIMARY KEY AUTO_INCREMENT,
                uid INTEGER NOT NULL REFERENCES hottery_uid(uid) ON DELETE CASCADE,
                rid INTEGER NOT NULL REFERENCES hottery_room(rid) ON DELETE CASCADE,
                type TINYINT NOT NULL,
                time TIMESTAMP NOT NULL
            );",
        'hottery_got'=>
            "hottery_got (
                hid INTEGER NOT NULL REFERENCES hottery_history(hid) ON DELETE CASCADE,
                pid INTEGER NOT NULL REFERENCES hottery_(id) ON DELETE CASCADE,
                time TIMESTAMP NOT NULL
            );",
        'hottery_prize'=>
            "hottery_prize (
                pid INTEGER PRIMARY KEY AUTO_INCREMENT,
                rid INTEGER NOT NULL REFERENCES hottery_room(rid) ON DELETE CASCADE,
                name CHAR(32) NOT NULL,
                prob FLOAT,
                img CHAR(32),
                number INTEGER NOT NULL
            );",
        'hottery_cdkey'=>
            "hottery_cdkey (
                kid INTEGER PRIMARY KEY AUTO_INCREMENT,
                rid INTEGER NOT NULL REFERENCES hottery_room(rid) ON DELETE CASCADE,
                cdkey CHAR(8) NOT NULL
            );",
    ],
);