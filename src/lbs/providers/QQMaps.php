<?php
/**
 * 腾讯地图WebService API
 * @link http://open.map.qq.com/webservice_v1/index.html
 */
namespace lbs\providers;

class QQMaps
{
    private $conf = array();

    public function __construct($conf)
    {
        if (!isset($conf['key']) || empty($conf['key'])) {
            throw new Exception('need conf: key');
        }
        $this->conf = $conf;
    }
    
    public function code($address)
    {
        $uri = 'http://apis.map.qq.com/ws/geocoder/v1?address=' . urlencode($address) . '&output=json&key=' . $this->conf['key'];
        $http = new \HTTPRequest($uri, HTTP_METH_GET);
        $http->send();
        $code = $http->getResponseCode();
        if ($code != 200) {
            throw new Exception('http error', $code);
        }

        $r = json_decode($http->getResponseBody(), true);
        if (!isset($r['result']['location']['lat'])) {
            throw new Exception($r['message'], $r['status']);
        }

        return $r['result']['location'];
    }

    public function decode(
        $point = array(
            'lat' => null,
            'lng' => null,
        )
    ) {
        $uri = 'http://apis.map.qq.com/ws/geocoder/v1?location=' . $point['lat'] . ',' . $point['lng'] . '&output=json&key=' . $this->conf['key'];
        $http = new \HTTPRequest($uri, HTTP_METH_GET);
        $http->send();
        $code = $http->getResponseCode();
        if ($code != 200) {
            throw new Exception('http error', $code);
        }

        $r = json_decode($http->getResponseBody(), true);
        if (!isset($r['result']['address'])) {
            throw new Exception($r['message'], $r['status']);
        }

        return array(
            'address' => $r['result']['address'],
        );
    }
}
