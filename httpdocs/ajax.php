<?php

use LoreSjoberg\Logic\ElementFactory;

require_once dirname(__FILE__) . '/vendor/autoload.php';

get_things_started();

function get_things_started()
{

    $template = $_POST['template'] ?? '';
    $page = $_POST['page'] ?? 1;
    $element = ElementFactory::create();

    if ($template === 'all-colors') {
        $element->allColors($page);
    } elseif ($template === 'detail-view') {
        $element->detailView($_POST['hex']);
    } elseif ($template === 'color-family') {
        $element->colorFamily($_POST['family'], $page);
    } elseif ($template === 'color-search') {
        $element->colorSearch($_POST['searchString'], $page);
    }
    exit;
}

