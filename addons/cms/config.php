<?php

return [
    [
        'name'    => 'system_user_id',
        'title'   => '平台会员ID',
        'type'    => 'string',
        'content' => [
        ],
        'value'   => '1',
        'rule'    => 'required',
        'msg'     => '',
        'tip'     => '用于统计平台收入的会员ID',
        'ok'      => '',
        'extend'  => ''
    ],
    [
        'name'    => 'sitename',
        'title'   => '站点名称',
        'type'    => 'string',
        'content' =>
            [],
        'value'   => '我的CMS网站',
        'rule'    => 'required',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'title',
        'title'   => '首页标题',
        'type'    => 'string',
        'content' =>
            [],
        'value'   => '',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'keywords',
        'title'   => '首页关键字',
        'type'    => 'string',
        'content' =>
            [],
        'value'   => '',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'description',
        'title'   => '首页描述',
        'type'    => 'string',
        'content' =>
            [],
        'value'   => '',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'theme',
        'title'   => '皮肤',
        'type'    => 'string',
        'content' =>
            [],
        'value'   => 'default',
        'rule'    => 'required',
        'msg'     => '',
        'tip'     => '请确保addons/cms/view有相应的目录',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'qrcode',
        'title'   => '公众号二维码',
        'type'    => 'image',
        'content' =>
            [],
        'value'   => '/assets/addons/cms/img/qrcode.png',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'wxapp',
        'title'   => '小程序二维码',
        'type'    => 'image',
        'content' =>
            [],
        'value'   => '/assets/addons/cms/img/qrcode.png',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'donateimage',
        'title'   => '打赏图片',
        'type'    => 'image',
        'content' =>
            [],
        'value'   => '/assets/addons/cms/img/qrcode.png',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '打赏图片，请使用300*300的图片',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'default_archives_img',
        'title'   => '文档默认图片',
        'type'    => 'image',
        'content' =>
            [],
        'value'   => '/assets/addons/cms/img/noimage.jpg',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'default_channel_img',
        'title'   => '栏目默认图片',
        'type'    => 'image',
        'content' =>
            [],
        'value'   => '/assets/addons/cms/img/noimage.jpg',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'default_block_img',
        'title'   => '区块默认图片',
        'type'    => 'image',
        'content' =>
            [],
        'value'   => '/assets/addons/cms/img/noimage.jpg',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'default_page_img',
        'title'   => '单页默认图片',
        'type'    => 'image',
        'content' =>
            [],
        'value'   => '/assets/addons/cms/img/noimage.jpg',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'default_special_img',
        'title'   => '专题默认图片',
        'type'    => 'image',
        'content' =>
            [],
        'value'   => '/assets/addons/cms/img/noimage.jpg',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'domain',
        'title'   => '绑定二级域名前缀',
        'type'    => 'string',
        'content' =>
            [],
        'value'   => '',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'downloadtype',
        'title'   => '下载类型字典',
        'type'    => 'array',
        'content' =>
            [],
        'value'   =>
            [
                'baidu' => '百度网盘',
                'local' => '本地',
                'other' => '其它',
            ],
        'rule'    => 'required',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'archivesratio',
        'title'   => '付费文章分成',
        'type'    => 'string',
        'content' => [
        ],
        'value'   => '1:0',
        'rule'    => 'required',
        'msg'     => '',
        'tip'     => '平台:文章作者 <br>请保证两者相加为1',
        'ok'      => '',
        'extend'  => ''
    ],
    [
        'name'    => 'score',
        'title'   => '获取积分设置',
        'type'    => 'array',
        'content' => [

        ],
        'value'   => [
            'postarchives' => 0,
            'postcomment'  => 0,
        ],
        'rule'    => 'required',
        'msg'     => '',
        'tip'     => '如果问题或评论被删除则会扣除相应的积分',
        'ok'      => '',
        'extend'  => ''
    ],
    [
        'name'    => 'limitscore',
        'title'   => '限定积分设置',
        'type'    => 'array',
        'content' => [

        ],
        'value'   => [
            'postarchives' => 0,
            'postcomment'  => 0,
        ],
        'rule'    => 'required',
        'msg'     => '',
        'tip'     => '必须达到相应的积分限制条件才可以操作',
        'ok'      => '',
        'extend'  => ''
    ],
    [
        'name'    => 'userpage',
        'title'   => '会员个人主页',
        'type'    => 'radio',
        'content' => [

            '1' => '开启',
            '0' => '关闭',
        ],
        'value'   => 1,
        'rule'    => 'required',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '是否开启会员个人主页功能',
        'extend'  => ''
    ],
    [
        'name'    => 'rewrite',
        'title'   => '伪静态',
        'type'    => 'array',
        'content' =>
            [],
        'value'   =>
            [
                'index/index'    => '/cms/$',
                'archives/index' => '/cms/a/[:diyname]',
                'tags/index'     => '/cms/t/[:name]',
                'page/index'     => '/cms/p/[:diyname]',
                'search/index'   => '/cms/s',
                'channel/index'  => '/cms/c/[:diyname]',
                'diyform/index'  => '/cms/d/[:diyname]',
                'special/index'  => '/cms/special/[:diyname]',
                'user/index'     => '/u/[:id]',
            ],
        'rule'    => 'required',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'wxappid',
        'title'   => '小程序AppID',
        'type'    => 'string',
        'content' =>
            [],
        'value'   => '小程序AppID',
        'rule'    => 'required',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'wxappsecret',
        'title'   => '小程序AppSecret',
        'type'    => 'string',
        'content' =>
            [],
        'value'   => '小程序AppSecret',
        'rule'    => 'required',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'ispaylogin',
        'title'   => '支付是否需要登录',
        'type'    => 'radio',
        'content' =>
            [
                1 => '是',
                0 => '否',
            ],
        'value'   => '0',
        'rule'    => 'required',
        'msg'     => '',
        'tip'     => '支付时是否需要登录',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'isarchivesaudit',
        'title'   => '发布文章审核',
        'type'    => 'radio',
        'content' =>
            [
                '1'  => '全部审核',
                '0'  => '无需审核',
                '-1' => '仅含有过滤词时审核',
            ],
        'value'   => '1',
        'rule'    => 'required',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'iscommentaudit',
        'title'   => '发表评论审核',
        'type'    => 'radio',
        'content' =>
            [
                '1'  => '全部审核',
                '0'  => '无需审核',
                '-1' => '仅含有过滤词时审核',
            ],
        'value'   => '-1',
        'rule'    => 'required',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'audittype',
        'title'   => '审核方式',
        'type'    => 'radio',
        'content' =>
            [
                'local'    => '本地',
                'baiduyun' => '百度云',
            ],
        'value'   => 'local',
        'rule'    => 'required',
        'msg'     => '',
        'tip'     => '如果启用百度云，请输入百度云AI平台应用的AK和SK',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'nlptype',
        'title'   => '分词方式',
        'type'    => 'radio',
        'content' =>
            [
                'local'    => '本地',
                'baiduyun' => '百度云',
            ],
        'value'   => 'local',
        'rule'    => 'required',
        'msg'     => '',
        'tip'     => '如果启用百度云，请输入百度云AI平台应用的AK和SK',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'aip_appid',
        'title'   => '百度AI平台应用Appid',
        'type'    => 'string',
        'content' => [],
        'value'   => '',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '百度云AI开放平台应用AppId',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'aip_apikey',
        'title'   => '百度AI平台应用Apikey',
        'type'    => 'string',
        'content' => [],
        'value'   => '',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '百度云AI开放平台应用ApiKey',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'aip_secretkey',
        'title'   => '百度AI平台应用Secretkey',
        'type'    => 'string',
        'content' => [],
        'value'   => '',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '百度云AI开放平台应用Secretkey',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'apikey',
        'title'   => 'ApiKey',
        'type'    => 'string',
        'content' =>
            [],
        'value'   => '',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '用于调用API接口时写入数据权限控制<br>可以为空',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'archiveseditmode',
        'title'   => '文档编辑模式',
        'type'    => 'radio',
        'content' =>
            [
                'addtabs' => '新选项卡',
                'dialog'  => '弹窗',
            ],
        'value'   => 'dialog',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '在添加或编辑文档时的操作方式',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'auditnotice',
        'title'   => '审核通知',
        'type'    => 'radio',
        'content' =>
            [
                'none'     => '无需通知',
                'dinghorn' => '钉钉小喇叭',
                'vbot'     => '企业微信通知',
            ],
        'value'   => 'none',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '如需启用审核通知，务必在插件市场安装对应的插件',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'noticetemplateid',
        'title'   => '消息模板ID',
        'type'    => 'text',
        'content' =>
            [],
        'value'   => '1',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '当启用审核通知时，消息通知的模板ID',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'channelallocate',
        'title'   => '栏目授权',
        'type'    => 'radio',
        'content' =>
            [
                1 => '开启',
                0 => '关闭',
            ],
        'value'   => 0,
        'rule'    => '',
        'msg'     => '',
        'tip'     => '开启后可以单独给管理员分配可管理的内容栏目',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'conactqq',
        'title'   => '联系我们QQ',
        'type'    => 'string',
        'content' =>
            [],
        'value'   => '',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '合作伙伴和友情链接的联系QQ',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => 'autolinks',
        'title'   => '关键字链接',
        'type'    => 'array',
        'content' =>
            [],
        'value'   =>
            [
                '服务器' => 'https://www.fastadmin.net/go/aliyun',
                '阿里云' => 'https://www.fastadmin.net/go/aliyun',
            ],
        'rule'    => 'required',
        'msg'     => '',
        'tip'     => '对应的关键字将会自动加上链接',
        'ok'      => '',
        'extend'  => '',
    ],
    [
        'name'    => '__tips__',
        'title'   => '温馨提示',
        'type'    => 'string',
        'content' =>
            [],
        'value'   => '1.如果需要将CMS绑定到首页,请移除伪静态中的<b>cms/</b><br>
                      2.默认CMS不包含富文本编辑器插件，请在<a href="https://www.fastadmin.net/store.html?category=16" target="_blank">插件市场</a>按需要安装<br>
                      3.如果需要启用付费阅读或付费下载,请务必安装<a href="https://www.fastadmin.net/store/epay.html" target="_blank">微信支付宝</a>整合插件<br>
                      4.如需启用审核通知，请在插件市场安装<a href="https://www.fastadmin.net/store/dinghorn.html" target="_blank">钉钉</a>或<a href="https://www.fastadmin.net/store/vbot.html" target="_blank">微信</a>通知插件',
        'rule'    => '',
        'msg'     => '',
        'tip'     => '',
        'ok'      => '',
        'extend'  => '',
    ]
];