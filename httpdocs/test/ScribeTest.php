<?php
/**
 * Created by PhpStorm.
 * User: loresjoberg
 * Date: 8/2/18
 * Time: 1:59 PM
 */

use LoreSjoberg\View\TwigScribe;
use PHPUnit\Framework\TestCase;

class ScribeTest extends TestCase
{

    /** @var TwigScribe */
    private $scribe;

    public function setUp() {
        $loader = new \Twig_Loader_Filesystem(dirname(__FILE__) .'/../templates');
        $twig = new \Twig_Environment($loader);
        $this->scribe = new TwigScribe($twig);
    }
    /**
     * @throws Twig_Error_Loader
     * @throws Twig_Error_Runtime
     * @throws Twig_Error_Syntax
     */
    public function testRender()
    {
        $expected = <<<HTML
<h1>This is Test</h1>
String supplied: testString
HTML;
        $result = $this->scribe->render('test',json_encode(['string' => 'testString']));

        $this->assertEquals($expected,$result);
    }

    /**
     * @throws Twig_Error_Loader
     * @throws Twig_Error_Runtime
     * @throws Twig_Error_Syntax
     */
    public function testDisplay()
    {
        $expected = <<<HTML
<h1>This is Test</h1>
String supplied: testString
HTML;
        ob_start();

        $this->scribe->display('test',json_encode(['string' => 'testString']));
        $result = ob_get_contents();
        ob_end_clean();

        $this->assertEquals($expected,$result);
    }
}
