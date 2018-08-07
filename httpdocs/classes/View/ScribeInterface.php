<?php
/**
 * Created by PhpStorm.
 * User: loresjoberg
 * Date: 8/2/18
 * Time: 2:56 PM
 */

namespace LoreSjoberg\View;

interface ScribeInterface
{
    /**
     * @param string $template
     * @param string $jsonData
     */
    public function display($template, $jsonData = '');

    /**
     * @param string $template
     * @param string $jsonData
     * @return string
     */
    public function render($template, $jsonData = '');
}