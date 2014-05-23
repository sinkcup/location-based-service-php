<?php
require_once __DIR__ . '/vendor/autoload.php';
$conf = array(
    'key'  => 'OB4BZ-D4W3U-B7VVO-4PJWW-6TKDJ-WPB77',
    'lang' => 'zh-Hant',
);

$geo = new \lbs\Geo('qq', $conf);
$address = '北京市海淀区彩和坊路海淀西大街74号';
$r = $geo->code($address);
var_export($r);
