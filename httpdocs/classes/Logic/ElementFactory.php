<?php
/**
 * Created by PhpStorm.
 * User: loresjoberg
 * Date: 8/3/18
 * Time: 10:23 AM
 */

namespace LoreSjoberg\Logic;


use LoreSjoberg\Data\ColorCurator;
use LoreSjoberg\View\TwigScribe;
use Twig_Environment;
use Twig_Loader_Filesystem;

/**
 * Class ElementFactory
 * @package LoreSjoberg\Logic
 */
class ElementFactory
{
    /**
     * @return Element
     */
    public static function create() {
        $loader = new Twig_Loader_Filesystem(dirname(__FILE__) . '/../../templates');
        $twig = new Twig_Environment($loader);
        $colorDb = file_get_contents(dirname(__FILE__) . '/../../data/database.json');
        return new Element(new TwigScribe($twig), new ColorCurator($colorDb));
    }
}