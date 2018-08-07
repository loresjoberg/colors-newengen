<?php

use LoreSjoberg\Data\ColorCurator;
use LoreSjoberg\Logic\Color;
use PHPUnit\Framework\TestCase;

class ColorCuratorTest extends TestCase
{

    /** @var ColorCurator */
    private $colors;

    public function setUp() {
        $colorDb = file_get_contents(dirname(__FILE__) . '/../data/database.json');
        $this->colors = new ColorCurator($colorDb);
    }


    public function testGetAll()
    {
        $result = $this->colors->get();
        $this->assertInstanceOf(Color::class, $result[0]);
        $this->assertGreaterThan(100, count($result));
    }


    public function testGetWithOffset()
    {
        $result = $this->colors->get();
        $fifth = $result[4];
        $result = $this->colors->offset(4)->get();
        $first = $result[0];
        $this->assertEquals($fifth, $first);
    }


    public function testGetWithLength()
    {
        $result = $this->colors->limit(6)->get();
        $this->assertEquals(6, count($result));
    }


    public function testGetWithOffsetAndLength()
    {
        $result = $this->colors->get();
        $slice = array_slice($result, 3, 4);
        $result = $this->colors->offset(3)->limit(4)->get();
        $this->assertEquals($slice, $result);
    }

    public function testGetByHex()
    {
        $result = $this->colors->hex('#7fff00')->asArray()->get();
        $this->assertEquals('chartreuse', $result[0]['name']);
    }

    public function testGetByFamily()
    {
        /** @var Color[] $result */
        $result = $this->colors->family('Red')->get();
        $correct = true;
        foreach ($result as $color) {
            if ($color->toArray(false)['family'] !== 'red') {
                $correct = false;
            }
        }
        $this->assertTrue($correct);
    }


    public function testGetRandom()
    {
        $result = $this->colors->random()->get();
        $this->assertInstanceOf(Color::class, $result[0]);
    }


    public function testSearch()
    {
        $result = $this->colors->search('ff')->get();
        $this->assertGreaterThan(10, count($result));
        $this->assertInstanceOf(Color::class, $result[0]);
    }
}
