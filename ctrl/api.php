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
                    'username' => 'CHAR(16) not null',
                    'password' => 'CHAR(32) not null',
                    'time' => 'INTEGER not null',
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
                    'username' => 'CHAR(16) not null',
                    'password' => 'CHAR(32) not null',
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
                    '成功的情况' => '{"result":"success","option":"[{
                        "rid":"1",
                        "title":"zhaogeniub",
                        "start_time":"2015-11-11 11:11:11",
                        "access":"1",
                        "img":"img\/gg.jpg",
                        "other_option":"other_option"
                    },...]"}',
                ],
            ],
            'add_img' => [
                '安全性' => '',
                '请求类型' => 'POST',
                '参数需求' => '使用form表单',
                '参数说明' => '需要实现的话与后端面对面交流',
            ],
            '-add_prize' => [
                '安全性' => '有',
                '请求类型' => 'POST',
                '参数需求' => [
                    'cookie' => 'CHAR(128) not null',
                    'rid' => 'INTEGER not null',
                ],
                '参数说明' => [
                    'cookie' => '创建者的cookie',
                    'rid' => '房间号,从add_room中获得',
                ],
                '响应格式' => [
                    '成功的情况' => '{"result":"success"}',
                    '创建者cookie失效' => '{"result":"invalid cookie"}',
                    '房间权限异常' => '{"result":"invalid room"}',
                ],
            ],
            '-del_prize'=>[
                '安全性' => '有',
                '请求类型' => 'POST',
                '参数需求' => [
                    'cookie' => 'CHAR(128) not null',
                    'rid' => 'INTEGER not null',
                    'pid' => 'INTEGER not null',
                ],
                '参数说明' => [
                    'cookie' => '创建者的cookie',
                    'rid' => '房间号,从get_room中获得',
                    'pid' => '奖项号,从get_room中获得',
                ],
                '响应格式' => [
                    '成功的情况' => '{"result":"success"}',
                    '创建者cookie失效' => '{"result":"invalid cookie"}',
                    '房间权限异常' => '{"result":"invalid room"}',
                    '无效的奖项号' => '{"result":"invalid prize"}',
                ],
            ],
            '-add_room' => [
                '安全性' => '无',
                '请求类型' => 'GET',
                '参数需求' => [
                    'cookie' => 'CHAR(128) not null',
                    'title' => 'CHAR(32) not null',
                    'start_time' => 'INTEGER not null',
                    'access' => 'INTEGER not null',
                    'img' => 'CHAR(32) not null',
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
                        '5:over 已结束的房间 无法创建这样的房间,即user.level>4',
                    ],
                    'img' => [
                        '图片的路径 比如"img/gg.jpg"',
                        '使用upload_image处理图片的问题',
                    ],
                    'other_option' => '其他选项,根据自己的需求放自定义数据',
                ],
                '响应格式' => [
                    '成功的情况' => '{"result":"success"}',
                    '创建者cookie失效' => '{"result":"invalid cookie"}',
                    '标题过长' => '{"result":"invalid title"}',
                    '非法的开始时间' => '{"result":"invalid start_time"}',
                    '权限不足的情况' => '{"result":"invalid access"}',
                    '图片路径不正确' => '{"result":"invalid img"}',
                    '附加信息过多' => '{"result":"invalid other_option"}',
                ],
            ],
            '-get_room' => [
                '安全性' => '不需要',
                '请求类型' => 'GET',
                '参数需求' => [
                    'rid' => 'INTEGER not null',
                ],
                '参数说明' => [
                    'rid' => '房间号,能在get_all_room中获得',
                ],
                '响应格式' => [
                    '成功的情况' => '{"result":"success","option":"{obj...}"}',
                    '房间权限异常' => '{"result":"invalid room"}'
                ],
            ],
            '-join_room' => [
                '安全性' => '有',
                '请求类型' => 'GET',
                '参数需求' => [
                    'cookie' => 'CHAR(128) not null',
                    'cdkey' => 'CHAR(8) not null',
                ],
                '参数说明' => [
                    'cookie' => '加入者cookie',
                    'cdkey' => '进入房间的邀请码',
                ],
                '响应格式' => [
                    '成功的情况' => '{"result":"success",{房间的信息}}',
                    '加入者cookie失效' => '{"result":"invalid cookie"}',
                    '标题过长' => '{"result":"invalid key"}',
                ],
            ]
        ];
        $api['bullet'] = [
            '-get_bullet' => [
                '安全性' => '有',
                '请求类型' => 'GET',
                '参数需求' => [
                    'cookie' => 'string not null (小饼干)',
                    'rid' => 'INTEGER not null (房间标识号)',
                    'start' => 'INTEGER (开始接受的位置)'
                ],
                '响应格式' => '{"result":"success","bullet":"[obj...]"} or {"result":"invalid cookie"}',
            ],
            '-add_bullet' => [
                '安全性' => '有',
                '请求类型' => 'POST',
                '参数需求' => [
                    'cookie' => 'string not null (小饼干)',
                    'rid' => 'INTEGER not null (房间标识号)',
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
                    'rid' => 'INTEGER not null',
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
            '-get_pending_history' => [
                '安全性' => '有',
                '请求类型' => 'GET',
                '参数需求' => [
                    'cookie' => 'string not null',
                ],
                '响应格式' => [
                    '成功的情况' => '{"result":"success","rid":"INTEGER","title":"CHAR(32)"}',
                    '错误的COOKIE' => '{"result":"invalid cookie"}',
                ]
            ],
            '-get_over_history' => [
                '安全性' => '有',
                '请求类型' => 'GET',
                '参数需求' => [
                    'cookie' => 'string not null',
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
                    'cookie' => 'string not null',
                ],
                '响应格式' => [
                    '成功的情况' => '{"result":"success","rid":"INTEGER","pid":"INTEGER"}',
                    '错误的COOKIE' => '{"result":"invalid cookie"}',
                ]
            ],
        ];
        foreach ($api as $k => $v) {
            dump($k);
            dump($v);
        }
    }
}
