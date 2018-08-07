<?php
/**
 * Created by PhpStorm.
 * User: loresjoberg
 * Date: 8/2/18
 * Time: 2:14 PM
 */

use LoreSjoberg\Logic\Color;
use OzdemirBurak\Iris\Color\Hex;
use PHPUnit\Framework\TestCase;

class ColorTest extends TestCase
{

    /** @var Color */
    private $color;

    public function setUp() {
        /** @var Hex|\Mockery\MockInterface $hex */
        $hex = Mockery::mock(Hex::class);
        $hex->shouldReceive('__toString')->andReturn('#4682b4');
        $hex->shouldReceive('lighten')->with(5)->andReturn('#5793c5');
        $hex->shouldReceive('lighten')->with(10)->andReturn('#68a4d6');
        $hex->shouldReceive('lighten')->with(0)->andReturn('#68a4d6');
        $hex->shouldReceive('darken')->with(5)->andReturn('#3571a3');
        $hex->shouldReceive('darken')->with(10)->andReturn('#246092');
        $this->color = new Color($hex, 'steelblue', 'blue');
    }

//    public function testGetFamily()
//    {
//        $this->assertEquals('blue', $this->color->getFamily());
//    }
//
//    public function testGetName()
//    {
//        $this->assertEquals('steelblue', $this->color->getName());
//    }
//
//    public function testGetHex()
//    {
//        $this->assertEquals('#4682b4', $this->color->getHex());
//    }

//    /**
//     * @throws \OzdemirBurak\Iris\Exceptions\InvalidColorException
//     */
//    public function testGetTints() {
//        $expected = <<<JSON
//[{"hex":"#68a4d6","name":"steelblue+20%","family":"blue"},
//{"hex":"#5793c5","name":"steelblue+10%","family":"blue"},
//{"hex":"#4682b4","name":"steelblue","family":"blue"},
//{"hex":"#3571a3","name":"steelblue-10%","family":"blue"},
//{"hex":"#246092","name":"steelblue-20%","family":"blue"}]
//JSON;
//
//        $this->assertEquals(json_decode($expected, JSON_OBJECT_AS_ARRAY), $this->color->getTints());
//    }

    /**
     * @throws \OzdemirBurak\Iris\Exceptions\InvalidColorException
     */
    public function testToArray() {
        $expected = <<<JSON
[{"hex":"#68a4d6","name":"steelblue10","family":"blue"},
{"hex":"#5793c5","name":"steelblue5","family":"blue"},
{"hex":"#68a4d6","name":"steelblue","family":"blue"},
{"hex":"#3571a3","name":"steelblue-5","family":"blue"},
{"hex":"#246092","name":"steelblue-10","family":"blue"}]
JSON;
        $array = $this->color->toArray(false);
        $this->assertEquals(['hex' => '#4682b4','name' => 'steelblue', 'family' => 'blue'], $array);
        $array = $this->color->toArray();
        $this->assertEquals(json_decode($expected, JSON_OBJECT_AS_ARRAY), $array['tints']);
        $this->assertEquals(['#4682b4','steelblue','blue'], [$array['hex'], $array['name'], $array['family']]);
    }

    /**
     * @throws \OzdemirBurak\Iris\Exceptions\InvalidColorException
     */
    public function testToJson() {
        $this->assertEquals(json_encode(['hex' => '#4682b4','name' => 'steelblue', 'family' => 'blue']), $this->color->toJson(false));
    }
}
