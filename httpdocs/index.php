<?php

use LoreSjoberg\Logic\ElementFactory;

require_once dirname(__FILE__) . '/vendor/autoload.php';

$element = ElementFactory::create();
$element->layout();