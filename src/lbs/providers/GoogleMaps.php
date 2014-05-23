<?php
/**
 * Google Maps API 网络服务
 * @link https://developers.google.com/maps/documentation/geocoding/index
 */
namespace lbs\providers;

class GoogleMaps
{
    private $conf = array();

    public function __construct(
        $conf = array(
            'lang' => 'zh-Hans',
        )
    ) {
        $this->conf = $conf;
    }
    
    public function code($address)
    {
        $uri = 'http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=' . urlencode($address);
        $http = new \HTTPRequest($uri, HTTP_METH_GET);
        $http->send();
        $code = $http->getResponseCode();
        if ($code != 200) {
            throw new Exception('http error', $code);
        }

        $r = json_decode($http->getResponseBody(), true);
        if (!isset($r['results'][0]['geometry']['location']['lat'])) {
            throw new Exception($r['status'], -1);
        }
        return $r['results'][0]['geometry']['location'];
    }

    public function decode(
        $point = array(
            'lat' => null,
            'lng' => null,
        )
    ) {
        $uri = 'http://maps.googleapis.com/maps/api/geocode/json?sensor=false&latlng=' .  $point['lat'] . ',' . $point['lng'];
        $http = new \HTTPRequest($uri, HTTP_METH_GET);
        if(isset($this->conf['lang'])) {
            $http->addHeaders(
                array(
                    'Accept-Language' => $this->conf['lang'],
                )
            );
        }
        $http->send();
        $code = $http->getResponseCode();
        if ($code != 200) {
            throw new Exception('http error', $code);
        }

        $r = json_decode($http->getResponseBody(), true);
        if (!isset($r['results'][0]['formatted_address'])) {
            throw new Exception($r['status'], -1);
        }

        return array(
            'address' => $r['results'][0]['formatted_address'],
        );
    }
}
