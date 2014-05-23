<?php
namespace lbs;

class Geo
{
    private $provider;

    public function __construct($provider,
        $conf = array(
            'key' => null,
            'lang' => 'zh-Hans',
        )
    ) {
        switch($provider) {
            case 'qq':
            case 'tencent':
                $this->provider = new providers\QQMaps($conf);
                break;
            case 'google':
            default:
                $this->provider = new providers\GoogleMaps($conf);
                break;
        }
    }
    
    /**
     * 地址解析：地址转坐标
     */
    public function code($address)
    {
        return $this->provider->code($address);
    }

    /**
     * 逆地址解析：坐标转地址
     */
    public function decode(
        $point = array(
            'lat' => null,
            'lng' => null,
        )
    ) {
        return $this->provider->decode($point);
    }
}
