<?php
/**
 * Created by PhpStorm.
 * User: loresjoberg
 * Date: 8/3/18
 * Time: 5:18 PM
 */

namespace LoreSjoberg\Data;

use LoreSjoberg\Logic\Color;

/**
 * Interface ColorCuratorInterface
 * @package LoreSjoberg\Data
 */
interface ColorCuratorInterface
{
    /**
     * @return Color[]|array
     */
    public function get();

    /**
     * @return Color[]|array
     */
    public function first();

    /**
     * @param bool $boolean
     * @return $this
     */
    public function asArray($boolean = true);

    /**
     * @param $value
     * @return $this
     */
    public function hex($value);

    /**
     * @param $index
     * @return $this
     */
    public function offset($index);

    /**
     * @param $count
     * @return $this
     */
    public function limit($count);

    /**
     * @param $count
     * @return $this
     */
    public function family($count);

    /**
     * @param $string
     * @return $this
     */
    public function search($string);

    /**
     * @param int $count
     * @return $this
     */
    public function random($count = 1);
}