<?php

namespace app\ctrl;

class api extends \core\ApiCtrl
{
    public function main()
    {
        echo '<style type="text/css">pre{font-size:32pt !important;}</style>';
        dump('前面有减号的代表还在开发,用不了');
        $api['user'] = [
            'login' => [
                '安全性' => '有',
                '请求类型' => 'GET',
                '参数需求' => [
                    'username' => 'CHAR(16) not null (用户名)',
                    'password' => 'CHAR(32) not null (加密后的密码)',
                    'time' => 'integer not null (时间戳)',
                ],
                '响应格式' => [
                    '成功的情况' => '{"result":"success","cookie":"128位长的字符串"}',
                    '失败的情况' => '{"result":"failure"}',
                ]
            ],
            'register' => [
                '安全性' => '无',
                '请求类型' => 'GET',
                '参数需求' => [
                    'username' => 'CHAR(16) not null (用户名)',
                    'password' => 'CHAR(32) not null (加密后的密码)'
                ],
                '响应格式' => [
                    '成功的情况' => '{"result":"success","cookie":"128位长的字符串"}',
                    '失败的情况' => '{"result":"failure"}',
                ]
            ]
        ];
        $api['room'] = [
            'get_all_room' => [
                '安全性' => '不需要',
                '请求类型' => 'GET',
                '参数需求' => [],
                '响应格式' => [
                    '成功的情况' => '{"result":"success","option":"[{
                        "rid":"1",
                        "title":"zhaogeniub",
                        "start_time":"2015-11-11 11:11:11",
                        "access":"1",
                        "img":"img\/gg.jpg",
                        "other_option":"other_option"
                    },...]"}'
                ]
            ],
            'get_room' => [
                '安全性' => '不需要',
                '请求类型' => 'GET',
                '参数需求' => [
                    'rid' => 'integer not null'
                ],
                '参数注释' => '                    
                rid 是 房间号,能在get_all_room中获得
                ',
                '响应格式' => [
                    '成功的情况' => '{"result":"success","option":"{obj...}"}',
                    '房间权限异常' => '{"result":"invalid room"}'
                ]
            ],
            '-add_room' => [
                '安全性' => '无',
                '请求类型' => 'GET',
                '参数需求' => [
                    'cookie' => 'CHAR(128) not null',
                    'title' => 'CHAR(32) not null',
                    'start_time' => 'integer not null',
                    'access' => 'integer not null',
                    'img' => 'CHAR(32) not null',
                    'other_option' => 'CHAR(1024)',
                ],
                '参数注释' => '
                cookie 是 创建者的cookie
                title 是 房间标题
                start_time 是 开始抽奖时间,超过这个时间就无法通过get_all_room获得这个房间(如果原来可以的话)
                        格式是YYMMDDhhmmss,比如111111111111就是2011-11-11 11:11:11
                access 是 房间访问类型
                        1:public 进入和抽奖均无条件
                        2:protected 进入无条件,抽奖需cdkey
                        3:private 不能无条件进入
                        5:over 已结束的房间
                img 是 图片的路径(还没实现,现在可用的有 "img/gg.jpg" , "img/mbws.png" 这两个)
                        后期会有api处理图片的问题
                other_option 是 其他选项,根据自己的需求放自定义数据
            ',//TODO: img还没实现
                '响应格式' => '{"result":"success"}'
            ],
            '-join_room' => [
                '安全性' => '有',
                '请求类型' => 'POST',
                '参数需求' => [
                    'cookie' => 'string not null (小饼干)',
                    'key' => 'string not null (进入房间的口令)',
                ],
                '响应格式' => '{"result":"success",...(关于房间的信息)} or {"result":"invalid cookie"} or {"result":"invalid key"}',
            ]
        ];
        $api['bullet'] = [
            '-get_bullet' => [
                '安全性' => '有',
                '请求类型' => 'GET',
                '参数需求' => [
                    'cookie' => 'string not null (小饼干)',
                    'rid' => 'integer not null (房间标识号)',
                    'start' => 'integer (开始接受的位置)'
                ],
                '响应格式' => '{"result":"success","bullet":"[obj...]"} or {"result":"invalid cookie"}',
            ],
            '-add_bullet' => [
                '安全性' => '有',
                '请求类型' => 'POST',
                '参数需求' => [
                    'cookie' => 'string not null (小饼干)',
                    'rid' => 'integer not null (房间标识号)',
                    'content' => 'CHAR(72) not null (不能超过72个字符,弹幕内容)'
                ],
                '响应格式' => '{"result":"success"} or {"result":"invalid cookie"} or {"result":"failure"}',
            ]
        ];
        $api['hottery'] = [
            '-join_hottery' => [
                '安全性' => '有',
                '请求类型' => 'GET',
                '参数需求' => [
                    'cookie' => 'string not null',
                    'rid' => 'integer not null',
                    'cdkey' => 'string'
                ],
                '响应格式' => [
                    '已经报名的情况' => '{"result":"already"}',
                    '成功的情况' => '{"result":"success"}',
                    '错误的CDKEY' => '{"result":"invalid key"}',
                    '错误的COOKIE' => '{"result":"invalid cookie"}',
                    '参数不完整' => '{"result":"failure"}'
                ]
            ]
        ];
        foreach ($api as $k => $v) {
            dump($k);
            dump($v);
        }
    }
}
