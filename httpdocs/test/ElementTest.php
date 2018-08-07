<?php
/**
 * Created by PhpStorm.
 * User: loresjoberg
 * Date: 8/5/18
 * Time: 3:54 PM
 */

use LoreSjoberg\Data\ColorCuratorInterface;
use LoreSjoberg\Logic\Element;
use LoreSjoberg\View\ScribeInterface;
use PHPUnit\Framework\TestCase;

class ElementTest extends TestCase
{

    /** @var ScribeInterface|\Mockery\MockInterface */
    private $scribe;

    /** @var ColorCuratorInterface|\Mockery\MockInterface */
    private $curator;

    /** @var Element */
    private $element;

    public function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        $this->scribe = Mockery::mock(ScribeInterface::class);
        $this->scribe->shouldIgnoreMissing();
        $this->curator = Mockery::mock(ColorCuratorInterface::class);
        $this->curator->shouldReceive('get')->andReturn(10);
        $this->curator->shouldReceive('offset')->andReturnSelf();
        $this->curator->shouldReceive('limit')->andReturnSelf();
        $this->curator->shouldReceive('asArray')->andReturnSelf();
        $this->element = new Element($this->scribe, $this->curator);
    }

    public function testAllColors()
    {

        $this->element->allColors(1);
        $this->addToAssertionCount(1);

    }

    public function testColorFamily()
    {
        $this->curator->shouldReceive('family')->andReturnSelf();
        $this->element->colorFamily('blue',1);
        $this->addToAssertionCount(1);
    }


    public function testColorSearch()
    {
        $this->curator->shouldReceive('search')->andReturnSelf();
        $this->element->colorSearch('ff',1);
        $this->addToAssertionCount(1);

    }

    public function testDetailView()
    {
        $this->curator->shouldReceive('hex')->andReturnSelf();
        $this->curator->shouldReceive('first')->andReturn('foo');
        $this->element->detailView('ffffff');
        $this->addToAssertionCount(1);
    }

    public function testLayout()
    {
        $this->element->layout();
        $this->addToAssertionCount(1);
    }
}
