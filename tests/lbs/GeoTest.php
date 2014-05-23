<?php
require_once __DIR__ . '/../autoload.php';
class GeoTest extends PHPUnit_Framework_TestCase
{
    private $geoQQ;
    private $geoGoogle;

    public function setUp()
    {
        $conf = array(
            'key' => 'OB4BZ-D4W3U-B7VVO-4PJWW-6TKDJ-WPB77',
        );
        $this->geoQQ = new \lbs\Geo('qq', $conf);
    }

    public function testCode()
    {
        echo __FUNCTION__ . "\n";
        $r = $this->geoQQ->code('北京市海淀区彩和坊路海淀西大街74号');
        var_export($r);
        $this->assertEquals(true, is_numeric($r['lat']));
        
        try {
            $r = $this->geoQQ->code('一个');
            var_export($r);
            $this->assertEquals(true, is_numeric($r['lat']));
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            var_dump($e->getCode());
        }
    }

    public function testDecode()
    {
        echo __FUNCTION__ . "\n";
        $point = array (
            'lng' => 116.306735,
            'lat' => 39.982951,
        );
        $r = $this->geoQQ->decode($point);
        var_export($r);
        $this->assertEquals(true, isset($r['address']));
        
        try {
            $point = array (
                'lng' => 116.306735,
                'lat' => 139.982951,
            );
            $r = $this->geoQQ->decode($point);
            var_export($r);
            $this->assertEquals(true, isset($r['address']));
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            var_dump($e->getCode());
        }
    }
}
