<?php

namespace LoreSjoberg\Logic;

use OzdemirBurak\Iris\Color\Hex;
use OzdemirBurak\Iris\Exceptions\InvalidColorException;


class Color
{

    private $name;
    private $hex;
    /**
     * @var string
     */
    private $family;

    /**
     * Color constructor.
     *
     * @param Hex $hex
     * @param string $name
     * @param string $family
     */
    public function __construct(Hex $hex, $name, $family = '')
    {
        $this->name = $name;
        $this->hex = $hex;
        $this->family = $family;
    }

    private function getName()
    {
        return $this->name;
    }

    private function getHex()
    {
        return (string)$this->hex;
    }

    private function getFamily()
    {
        return $this->family;
    }

    /**
     * @param bool $include_tints
     * @return string
     * @throws \OzdemirBurak\Iris\Exceptions\InvalidColorException
     */
    public function toJson($include_tints = true)
    {
        return json_encode($this->toArray($include_tints));
    }

    /**
     * @param bool $include_tints
     * @return array
     */
    public function toArray($include_tints = true)
    {
        $array = [
            'hex' => $this->getHex(),
            'name' => $this->getName(),
            'family' => $this->getFamily(),
        ];
        if ($include_tints) {
            $array['tints'] = $this->getTints();
        }

        return $array;
    }

    /**
     * @return array
     */
    private function getTints()
    {
        $values = [
            10, 5, 0, -5, -10
        ];

        $tints = [];

        foreach ($values as $value) {
            $name = $this->getName();

            if ($value) {
                $name = $name . $value;
            }

            $tints[] = new Color($this->tint($value), $name, $this->getFamily());
        }

        foreach ($tints as &$tint) {
            $tint = $tint->toArray(false);
        }

        return $tints;
    }

    /**
     * @param $value
     * @return Hex
     */
    private function tint($value): Hex
    {
        try {
            if ($value < 0) {
                return new Hex($this->hex->darken(abs($value)));
            }
            return new Hex($this->hex->lighten($value));
        } catch (InvalidColorException $e) {
            print "Error generating tints";
            exit;
        }
    }
}