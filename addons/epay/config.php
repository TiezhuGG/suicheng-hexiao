<?php

return array (
  0 => 
  array (
    'name' => 'wechat',
    'title' => '微信',
    'type' => 'array',
    'content' => 
    array (
    ),
    'value' => 
    array (
      'appid' => 'wxd6f30cb38ce4a273',
      'app_id' => 'wxd6f30cb38ce4a273',
      'app_secret' => 'e9d427abc1055d862a79cec774e67307',
      'miniapp_id' => 'wxd6f30cb38ce4a273',
      'mch_id' => '1551765591',
      'key' => 'ntglml0giyfjfnqxrub4mzaoim22yqsb',
      'notify_url' => '/addons/epay/api/notifyx/type/wechat',
      'cert_client' => '/epay/certs/apiclient_cert.pem',
      'cert_key' => '/epay/certs/apiclient_key.pem',
      'log' => '1',
    ),
    'rule' => '',
    'msg' => '',
    'tip' => '微信参数配置',
    'ok' => '',
    'extend' => '',
  ),
  1 => 
  array (
    'name' => 'alipay',
    'title' => '支付宝',
    'type' => 'array',
    'content' => 
    array (
    ),
    'value' => 
    array (
      'app_id' => '',
      'notify_url' => '/addons/epay/api/notifyx/type/alipay',
      'return_url' => '/addons/epay/api/returnx/type/alipay',
      'ali_public_key' => '',
      'private_key' => '',
      'log' => 1,
    ),
    'rule' => 'required',
    'msg' => '',
    'tip' => '支付宝参数配置',
    'ok' => '',
    'extend' => '',
  ),
  2 => 
  array (
    'name' => '__tips__',
    'title' => '温馨提示',
    'type' => 'array',
    'content' => 
    array (
    ),
    'value' => '请注意微信支付证书路径位于/addons/epay/certs目录下，请替换成你自己的证书<br>appid：APP的appid<br>app_id：公众号的appid<br>app_secret：公众号的secret<br>miniapp_id：小程序ID<br>mch_id：微信商户ID<br>key：微信商户支付的密钥',
    'rule' => '',
    'msg' => '',
    'tip' => '微信参数配置',
    'ok' => '',
    'extend' => '',
  ),
);
