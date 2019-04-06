<?php

namespace app\ctrl;

class api extends \core\ApiCtrl
{
    public function main()
    {
        $api['user'] = [
            'login' => [
                '安全性' => '有',
                '请求类型' => 'GET',
                '参数需求' => [
                    'username' => 'CHAR(16) NOT NULL',
                    'password' => 'CHAR(32) NOT NULL',
                    'time' => 'INTEGER NOT NULL',
                ],
                '参数说明' => [
                    'username' => '用户名',
                    'password' => '加密后的密码',
                    'time' => '发送时的时间',
                ],
                '响应格式' => [
                    '成功的情况' => '{"result":"success","cookie":"CHAR(128)"}',
                    '失败的情况' => '{"result":"failure"}',
                ],
            ],
            'register' => [
                '安全性' => '无',
                '请求类型' => 'GET',
                '参数需求' => [
                    'username' => 'CHAR(16) NOT NULL',
                    'password' => 'CHAR(32) NOT NULL',
                ],
                '参数说明' => [
                    'username' => '用户名',
                    'password' => '加密后的密码',
                ],
                '响应格式' => [
                    '成功的情况' => '{"result":"success","cookie":"CHAR(128)"}',
                    '失败的情况' => '{"result":"failure"}',
                ],
            ],
            '-register_by_email' => [
                '安全性' => '有',
            ],
        ];
        $api['room'] = [
            'get_all_room' => [
                '安全性' => '不需要',
                '请求类型' => 'GET',
                '参数需求' => [],
                '响应格式' => [
                    '成功的情况' => '{"result":"success",other...}',
                ],
                '响应样例(成功)' => ["result" => "success", "option" => [["rid" => "13", "title" => "zhaogeniub", "start_time" => "2019-05-01 12:00:00", "access" => "1", "img" => "gg.jpg", "other_option" => ""], ["rid" => "16", "title" => "zhaogeniub", "start_time" => "2019-04-05 19:18:57", "access" => "1", "img" => "mbws.png", "other_option" => "1"], ["rid" => "17", "title" => "zhaogeniub", "start_time" => "2019-04-05 19:18:57", "access" => "2", "img" => "mbws.png", "other_option" => "1"], ["rid" => "19", "title" => "zhaogeniub", "start_time" => "2015-12-11 11:11:11", "access" => "1", "img" => "mbws.png", "other_option" => "1"], ["rid" => "20", "title" => "zhaogeniub", "start_time" => "2015-12-11 11:11:11", "access" => "1", "img" => "mbws.png", "other_option" => "1"], ["rid" => "21", "title" => "\u662d\u54e5\u725b\u903c", "start_time" => "2019-05-01 12:12:12", "access" => "1", "img" => "_RainbowCatRainbowCatRainbowCat_", "other_option" => ""], ["rid" => "22", "title" => "zgnb", "start_time" => "2019-05-02 13:13:13", "access" => "2", "img" => "aa7a8af6a6ce8728565136de0902684b", "other_option" => ""], ["rid" => "23", "title" => "zxc", "start_time" => "2019-05-05 05:05:05", "access" => "1", "img" => "_RainbowCatRainbowCatRainbowCat_", "other_option" => ""]]],
            ],
            'add_img' => [
                '安全性' => '',
                '请求类型' => 'POST',
                '参数需求' => '使用form表单',
                '参数说明' => '需要实现的话与后端面对面交流',
            ],
            'add_prize' => [
                '安全性' => '有',
                '请求类型' => 'POST',
                '参数需求' => [
                    'cookie' => 'CHAR(128) NOT NULL',
                    'rid' => 'INTEGER NOT NULL',
                    'name' => 'CHAR(32) NOT NULL',
                    'award' => 'CHAR(128) NOT NULL',
                    'number' => 'INTEGER NOT NULL',
                    'prob' => 'FLOAT',
                    'img' => 'CHAR(32)',
                ],
                '参数说明' => [
                    'cookie' => '创建者的cookie',
                    'rid' => '房间号,从add_room中获得',
                    'name' => '奖项名("一等奖")',
                    'award' => '奖品名("刘昭x1")',
                    'number' => '奖项的数量(1)',
                    'prob' => '奖项的概率(人选奖时)',
                    'img' => '奖品图片地址(gg.jpg),应该由api获得',
                ],
                '响应格式' => [
                    '成功的情况' => '{"result":"success"}',
                    '创建者cookie失效' => '{"result":"invalid cookie"}',
                    '无效的图片' => '{"result":"invalid img"}',
                    '其他情况' => '{"result":"failure"}',
                ],
            ],
            'del_prize' => [
                '安全性' => '有',
                '请求类型' => 'POST',
                '参数需求' => [
                    'cookie' => 'CHAR(128) NOT NULL',
                    'rid' => 'INTEGER NOT NULL',
                    'pid' => 'INTEGER NOT NULL',
                ],
                '参数说明' => [
                    'cookie' => '创建者的cookie',
                    'rid' => '房间号,从get_room中获得',
                    'pid' => '奖项号,从get_room中获得',
                ],
                '响应格式' => [
                    '成功的情况' => '{"result":"success"}',
                    '创建者cookie失效' => '{"result":"invalid cookie"}',
                    '无效的奖项号' => '{"result":"invalid prize"}',
                    '其他情况' => '{"result":"failure"}',
                ],
            ],
            'add_room' => [
                '安全性' => '有',
                '请求类型' => 'POST',
                '参数需求' => [
                    'cookie' => 'CHAR(128) NOT NULL',
                    'title' => 'CHAR(32) NOT NULL',
                    'start_time' => 'INTEGER NOT NULL',
                    'access' => 'INTEGER NOT NULL',
                    'img' => 'CHAR(32) NOT NULL',
                    'other_option' => 'CHAR(1024)',
                ],
                '参数说明' => [
                    'cookie' => '创建者的cookie',
                    'title' => '房间标题,注意,不得超过32个字符',
                    'start_time' => [
                        '开始抽奖时间,超过这个时间就无法通过get_all_room获得这个房间(如果原来可以的话)',
                        '格式是YYMMDDhhmmss,比如111111111111就是2011-11-11 11:11:11',
                        '注意,不要小于当前时间,必须比提交请求的时间大才可以',
                    ],
                    'access' => [
                        '房间访问类型:',
                        '1:public 进入和抽奖均无条件, 需要user.level>=2',
                        '2:protected 进入无条件,抽奖需cdkey 需要user.level>=2',
                        '3:private 不能无条件进入 需要user.level>=3',
                    ],
                    'img' => '图片的路径 比如"gg.jpg",使用add_img处理图片的问题',
                    'other_option' => '其他选项,根据自己的需求放自定义数据',
                ],
                '响应格式' => [
                    '成功的情况' => '{"result":"success","rid":"INTEGER"}',
                    '创建者cookie失效' => '{"result":"invalid cookie"}',
                    '标题过长' => '{"result":"invalid title"}',
                    '非法的开始时间' => '{"result":"invalid start_time"}',
                    '权限不足的情况' => '{"result":"invalid access"}',
                    '图片路径不正确' => '{"result":"invalid img"}',
                    '附加信息过多' => '{"result":"invalid other_option"}',
                ],
            ],
            'get_room' => [
                '安全性' => '不需要',
                '请求类型' => 'GET',
                '参数需求' => [
                    'rid' => 'INTEGER NOT NULL',
                ],
                '参数说明' => [
                    'rid' => '房间号,能在get_all_room中获得',
                ],
                '响应格式' => [
                    '成功的情况' => '{"result":"success",other...}',
                    '房间权限异常' => '{"result":"invalid room"}',
                ],
                '响应样例(成功)' => ["result" => "success", "rid" => "23", "title" => "zxc", "start_time" => "2019-05-05 05:05:05", "access" => "1", "img" => "_RainbowCatRainbowCatRainbowCat_", "other_option" => "", "prize" => [["pid" => "4", "rid" => "23", "name" => "\u4e09\u7b49\u5956", "award" => "100\u5186", "number" => "10", "prob" => null, "img" => null], ["pid" => "5", "rid" => "23", "name" => "\u4e8c\u7b49\u5956", "award" => "\u4e00\u4e07\u5186", "number" => "2", "prob" => null, "img" => "7115b20afb48e91ed5ffef28ca46efb2"], ["pid" => "6", "rid" => "23", "name" => "\u4e00\u7b49\u5956", "award" => "\u534e\u4e3a\u7b14\u8bb0\u672c", "number" => "1", "prob" => null, "img" => "24f7aa630795400a5a2dd05fddf98f7d"]]],
            ],
            'join_room' => [
                '安全性' => '有',
                '请求类型' => 'GET',
                '参数需求' => [
                    'cookie' => 'CHAR(128) NOT NULL',
                    'cdkey' => 'CHAR(8) NOT NULL',
                ],
                '参数说明' => [
                    'cookie' => '加入者cookie',
                    'cdkey' => '进入私有房间的邀请码',
                ],
                '响应格式' => [
                    '成功的情况' => '{"result":"success",房间的信息...}',
                    '加入者cookie失效' => '{"result":"invalid cookie"}',
                    '无效的cdkey' => '{"result":"invalid cdkey"}',
                ],
            ],
        ];
        $api['bullet'] = [
            '-get_bullet' => [
                '安全性' => '有',
                '请求类型' => 'GET',
                '参数需求' => [
                    'cookie' => 'string NOT NULL (小饼干)',
                    'rid' => 'INTEGER NOT NULL (房间标识号)',
                    'start' => 'INTEGER (开始接受的位置)'
                ],
                '响应格式' => '{"result":"success","bullet":"[obj...]"} or {"result":"invalid cookie"}',
            ],
            '-add_bullet' => [
                '安全性' => '有',
                '请求类型' => 'POST',
                '参数需求' => [
                    'cookie' => 'string NOT NULL (小饼干)',
                    'rid' => 'INTEGER NOT NULL (房间标识号)',
                    'content' => 'CHAR(72) NOT NULL (不能超过72个字符,弹幕内容)'
                ],
                '响应格式' => '{"result":"success"} or {"result":"invalid cookie"} or {"result":"failure"}',
            ]
        ];
        $api['hottery'] = [
            '-join_hottery' => [
                '安全性' => '有',
                '请求类型' => 'GET',
                '参数需求' => [
                    'cookie' => 'string NOT NULL',
                    'rid' => 'INTEGER NOT NULL',
                    'cdkey' => 'string',
                ],
                '响应格式' => [
                    '已经报名的情况' => '{"result":"already"}',
                    '成功的情况' => '{"result":"success"}',
                    '错误的CDKEY' => '{"result":"invalid key"}',
                    '错误的COOKIE' => '{"result":"invalid cookie"}',
                    '参数不完整' => '{"result":"failure"}',
                ]
            ]
        ];
        $api['history'] = [
            'get_pending_history' => [
                '安全性' => '有',
                '请求类型' => 'GET',
                '参数需求' => [
                    'cookie' => 'string NOT NULL',
                ],
                '响应格式' => [
                    '成功的情况' => '{"result":"success","rid":"INTEGER","title":"CHAR(32)"}',
                    '错误的COOKIE' => '{"result":"invalid cookie"}',
                ]
            ],
            'get_over_history' => [
                '安全性' => '有',
                '请求类型' => 'GET',
                '参数需求' => [
                    'cookie' => 'string NOT NULL',
                ],
                '响应格式' => [
                    '成功的情况' => '{"result":"success","rid":"INTEGER","title":"CHAR(32)"}',
                    '错误的COOKIE' => '{"result":"invalid cookie"}',
                ]
            ],
            '-get_got_history' => [
                '安全性' => '有',
                '请求类型' => 'GET',
                '参数需求' => [
                    'cookie' => 'string NOT NULL',
                ],
                '响应格式' => [
                    '成功的情况' => '{"result":"success","rid":"INTEGER","pid":"INTEGER"}',
                    '错误的COOKIE' => '{"result":"invalid cookie"}',
                ]
            ],
        ];
        if (!isset($_POST['json'])) {
            echo '<style type="text/css">pre{font-size:32pt !important;}</style>';
            dump('前面有减号的代表还在开发,用不了');
            foreach ($api as $k => $v) {
                dump($k);
                dump($v);
            }
            return null;
        }
        return $api;
    }
}
