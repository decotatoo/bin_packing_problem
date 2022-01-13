<?php

namespace App\BoxPacker;

use App\Entity\Master;
use DVDoug\BoxPacker\Box;
use JsonSerializable;

class TestBox implements Box, JsonSerializable
{
    private $master;

    public function __construct(Master $master)
    {
        $this->master = $master;
    }

    /**
     * Reference for box type (e.g. SKU or description).
     */
    public function getReference(): string
    {
        return $this->master->getRef();
    }

    /**
     * Outer width in mm.
     */
    public function getOuterWidth(): int
    {
        return $this->master->getOutW();
    }

    /**
     * Outer length in mm.
     */
    public function getOuterLength(): int
    {
        return $this->master->getOutL();
    }

    /**
     * Outer depth in mm.
     */
    public function getOuterDepth(): int
    {
        return $this->master->getOutD();
    }

    /**
     * Empty weight in g.
     */
    public function getEmptyWeight(): int
    {
        return $this->master->getBaseWeight();
    }

    /**
     * Inner width in mm.
     */
    public function getInnerWidth(): int
    {
        return $this->master->getInW();
    }

    /**
     * Inner length in mm.
     */
    public function getInnerLength(): int
    {
        return $this->master->getInL();
    }

    /**
     * Inner depth in mm.
     */
    public function getInnerDepth(): int
    {
        return $this->master->getInD();
    }

    /**
     * Max weight the packaging can hold in g.
     */
    public function getMaxWeight(): int
    {
        return $this->master->getMaxWeight();
    }

    public function jsonSerialize()
    {
        return [
            'reference' => $this->getReference(),
            'outer_width' => $this->getOuterWidth(),
            'outer_length' => $this->getOuterLength(),
            'outer_depth' => $this->getOuterDepth(),
            'empty_weight' => $this->getEmptyWeight(),
            'inner_width' => $this->getInnerWidth(),
            'inner_length' => $this->getInnerLength(),
            'inner_depth' => $this->getInnerDepth(),
            'max_weight' => $this->getMaxWeight(),
            'inner_volume' => $this->getInnerVolume(),
            'outer_volume' => $this->getOuterVolume(),
        ];
    }

    public function getInnerVolume(): int
    {
        return $this->getInnerWidth() * $this->getInnerLength() * $this->getInnerDepth();
    }

    public function getOuterVolume(): int
    {
        return $this->getOuterWidth() * $this->getOuterLength() * $this->getOuterDepth();
    }
}
