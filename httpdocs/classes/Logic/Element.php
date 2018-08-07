<?php
/**
 * Created by PhpStorm.
 * User: loresjoberg
 * Date: 8/3/18
 * Time: 10:17 AM
 */

namespace LoreSjoberg\Logic;

use LoreSjoberg\Data\ColorCuratorInterface;
use LoreSjoberg\View\ScribeInterface;

/**
 * Class Element
 * @package LoreSjoberg\Logic
 */
class Element
{
    /**
     * @var ScribeInterface
     */
    private $scribe;
    /**
     * @var ColorCuratorInterface
     */
    private $curator;
    /**
     * @var int
     */
    private $pageSize = 12;
    /**
     * @var array
     */
    private $data = [];

    /**
     * Element constructor.
     * @param ScribeInterface $scribe
     * @param ColorCuratorInterface $curator
     */
    public function __construct(ScribeInterface $scribe, ColorCuratorInterface $curator)
    {
        $this->scribe = $scribe;
        $this->curator = $curator;
        $this->data['baseUrl'] = $this->getBaseUrl();
    }

    /**
     *
     */
    public function layout()
    {
        print $this->scribe->render('layout', json_encode($this->data));
    }

    /**
     * @param $hex
     */
    public function detailView($hex)
    {
        if ($hex === 'random') {
            $this->data['mainColor'] = $this->curator->random(1)->asArray()->first();
        } else {
            $this->data['mainColor'] = $this->curator->hex($hex)->asArray()->first();
        }
        print $this->scribe->render('detail-view', json_encode($this->data));
    }


    /**
     * @param int $page
     */
    public function allColors($page = 1)
    {
        $total = count($this->curator->get());
        $this->renderOverview($page, $total);
    }


    /**
     * @param $family
     * @param int $page
     */
    public function colorFamily($family, $page = 1)
    {
        $total = count($this->curator->family($family)->get());
        $this->data['family'] = $family;
        $this->renderOverview($page, $total);
    }

    /**
     * @param $string
     * @param int $page
     */
    public function colorSearch($string, $page = 1)
    {
        $total = count($this->curator->search($string)->get());
        $this->renderOverview($page, $total);
    }

    /**
     * @param $page
     * @param $total
     */
    private function getListData($page, $total)
    {
        $offset = ($page * $this->pageSize) - $this->pageSize;
        $this->data['pages'] = ceil($total / 12);
        $this->data['page'] = ceil(($offset + 12) / 12);
        $this->data['colors'] = $this->curator->offset($offset)->limit($this->pageSize)->asArray()->get();
    }

    /**
     * @param $page
     * @param $total
     */
    private function renderOverview($page, $total): void
    {
        $this->getListData($page, $total);
        print $this->scribe->render('color-overview', json_encode($this->data));
    }

    private function getBaseUrl() {


        $url = $_SERVER['REQUEST_URI'] ?? ''; //returns the current URL

        $parts = explode('/',$url);
        $dir = $_SERVER['SERVER_NAME'] ?? '';
        for ($i = 0; $i < count($parts) - 1; $i++) {
            $dir .= $parts[$i] . "/";
        }
        return '//' . $dir;
    }
}