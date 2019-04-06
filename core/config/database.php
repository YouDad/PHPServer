<?php
return [
    'DSN' => 'mysql:host=localhost;dbname=test',
    'USERNAME' => 'root',
    'PASSWORD' => 'mArIaDb@Ixv',
    'DATABASE' => 'hottery',
    'CREATE_DATABASE' => 'CREATE DATABASE IF NOT EXISTS hottery CHARACTER SET utf8;',
    'TABLE_DEFINE' => [
        'hottery_user' =>
            "hottery_user (
                username     char(16) not null
                    primary key,
                pass_md5     char(32) not null,
                level        int      null,
                phone_number char(20) null,
                email        char(32) null
            );",
        'hottery_room' =>
            "hottery_room (
                rid          int auto_increment
                    primary key,
                title        char(32)                            not null,
                start_time   timestamp default CURRENT_TIMESTAMP not null on update CURRENT_TIMESTAMP,
                access       tinyint                             not null,
                img          char(32)                            null,
                other_option varchar(1024)                       null
            );",
        'hottery_cookie' =>
            "hottery_cookie (
                uid        int       not null
                    primary key,
                cookie     char(128) not null,
                valid_time int       not null
            );",
        'hottery_uid' =>
            "hottery_uid (
                uid      int auto_increment
                    primary key,
                openid   char(40) null,
                username char(16) null,
                constraint username_user
                    foreign key (username) references hottery_user (username)
                        on update cascade on delete cascade
            );",
        'hottery_bullet' =>
            "hottery_bullet (
                bid     int auto_increment
                    primary key,
                uid     int                                 not null,
                rid     int                                 not null,
                time    timestamp default CURRENT_TIMESTAMP not null on update CURRENT_TIMESTAMP,
                content char(72)                            not null
            );",
        'hottery_history' =>
            "hottery_history (
                hid  int auto_increment
                    primary key,
                uid  int                                 not null,
                rid  int                                 not null,
                type tinyint                             not null,
                time timestamp default CURRENT_TIMESTAMP not null on update CURRENT_TIMESTAMP,
                constraint rid_history
                    foreign key (rid) references hottery_room (rid)
                        on update cascade on delete cascade,
                constraint uid_history
                    foreign key (uid) references hottery_uid (uid)
                        on update cascade on delete cascade
            );",
        'hottery_got' =>
            "hottery_got (
                hid  int                                 not null
                    primary key,
                pid  int                                 not null,
                time timestamp default CURRENT_TIMESTAMP not null on update CURRENT_TIMESTAMP,
                constraint hid_got
                    foreign key (hid) references hottery_history (hid)
                        on update cascade on delete cascade,
                constraint pid_got
                    foreign key (pid) references hottery_prize (pid)
                        on update cascade on delete cascade
            );",
        'hottery_prize' =>
            "hottery_prize (
                pid    int auto_increment
                    primary key,
                rid    int       not null,
                name   char(32)  not null,
                award  char(128) null,
                number int       not null,
                prob   float     null,
                img    char(32)  null,
                constraint rid
                    foreign key (rid) references hottery_room (rid)
                        on update cascade on delete cascade
            );",
        'hottery_cdkey' =>
            "hottery_cdkey (
                kid   int auto_increment
                    primary key,
                rid   int     not null,
                cdkey char(8) not null,
                constraint rid_cdkey
                    foreign key (rid) references hottery_room (rid)
                        on update cascade on delete cascade
            );",
    ],
];