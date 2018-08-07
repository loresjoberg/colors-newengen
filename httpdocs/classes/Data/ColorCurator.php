<?php


namespace LoreSjoberg\Data;


use LoreSjoberg\Logic\Color;
use OzdemirBurak\Iris\Color\Hex;
use OzdemirBurak\Iris\Exceptions\InvalidColorException;

/**
 * Class ColorCurator
 * @package LoreSjoberg\Data
 */
class ColorCurator implements ColorCuratorInterface
{


    /**
     * @var array
     */
    private $request = [
        'search' => null,
        'family' => null,
        'hex' => null,
        'offset' => 0,
        'limit' => null,
        'random' => null,
        'asArray' => false
    ];

    /**
     * @var mixed
     */
    private $colors;

    /**
     * @var
     */
    private $found;


    /**
     * ColorCurator constructor.
     * @param $colorJson
     */
    public function __construct($colorJson)
    {
        $this->colors = json_decode($colorJson, JSON_OBJECT_AS_ARRAY);
    }

    /**
     * @return Color[]|array
     */
    public function get()
    {
        $this->filter();

        if ($this->request['asArray']) {
            $this->colorsToArray();
        }

        return $this->found;
    }

    /**
     * @return Color|array
     */
    public function first()
    {
        return $this->get()[0];
    }

    /**
     *
     */
    private function filter(): void
    {

        $this->found = $this->colors;

        $this->filterByHex();
        $this->filterBySearch();
        $this->filterByFamily();
        $this->reindex();

        $this->slice();
        $this->filterRandomly();


        foreach ($this->found as &$color) {
            $color = $this->makeColor($color);
        }
    }

    /**
     *
     */
    private function filterRandomly(): void
    {
        if (!$this->request['random']) {
            return;
        }
        shuffle($this->found);
        $this->found = array_slice($this->found, 0, $this->request['random']);
    }

    /**
     *
     */
    private function filterByHex(): void
    {
        if (!$this->request['hex']) {
            return;
        }
        foreach ($this->found as $color) {
            if ($color['hex'] === $this->request['hex']) {
                $this->found = [$color];
                return;
            }
        }
    }

    /**
     *
     */
    private function filterBySearch(): void
    {
        if (!$this->request['search']) {
            return;
        }

        foreach ($this->found as $index => $color) {
            if (!$this->found($this->request['search'], $color)) {
                unset($this->found[$index]);
            }
        }
    }

    /**
     *
     */
    private function filterByFamily(): void
    {
        if (!$this->request['family']) {
            return;
        }
        /** @var Color $color */
        foreach ($this->found as $index => $color) {
            if (strtolower($color['family']) !== strtolower($this->request['family'])) {
                unset($this->found[$index]);
            }
        }

    }

    /**
     *
     */
    private function slice(): void
    {
        $this->found = array_slice($this->found, $this->request['offset'], $this->request['limit']);
    }

    /**
     *
     */
    private function reindex(): void
    {
        $this->found = array_values($this->found);
    }


    /**
     *
     */
    private function colorsToArray()
    {
        /** @var Color $color */
        foreach ($this->found as &$color) {
            $color = $color->toArray();
        }
    }

    /**
     * @param bool $boolean
     * @return $this
     */
    public function asArray($boolean = true)
    {
        $this->request['asArray'] = $boolean;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function hex($value)
    {
        $this->request['hex'] = $value;
        return $this;
    }

    /**
     * @param $index
     * @return $this
     */
    public function offset($index)
    {
        $this->request['offset'] = $index;
        return $this;
    }

    /**
     * @param $count
     * @return $this
     */
    public function limit($count)
    {
        $this->request['limit'] = $count;
        return $this;

    }

    /**
     * @param $count
     * @return $this
     */
    public function family($count)
    {
        $this->request['family'] = $count;
        return $this;

    }

    /**
     * @param $string
     * @return $this
     */
    public function search($string)
    {
        $this->request['search'] = $string;
        return $this;

    }

    /**
     * @param int $count
     * @return $this
     */
    public function random($count = 1)
    {
        $this->request['random'] = $count;
        return $this;

    }

    /**
     * @param $color
     * @return Color
     */
    private function makeColor($color): Color
    {
        try {
            return new Color(new Hex($color['hex']), $color['name'], $color['family']);
        } catch (InvalidColorException $e) {
            print "<div>Error creating color list</div>";
            exit;
        }
    }


    /**
     * @param $string
     * @param $color
     * @return bool
     */
    private function found($string, $color): bool
    {
        $string = strtolower($string);
        return (strpos(strtolower($color['family']), $string) !== false) ||
            (strpos(strtolower($color['name']), $string) !== false) ||
            (strpos(strtolower($color['hex']), $string) !== false);
    }


}