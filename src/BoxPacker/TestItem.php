<?php

namespace App\BoxPacker;

use App\Entity\Unit;
use DVDoug\BoxPacker\Item;
use JsonSerializable;

class TestItem implements Item, JsonSerializable
{
    private Unit $unit;

    public function __construct(Unit $unit) {
        $this->unit = $unit;
    }

    public function getUnit(): Unit {
        return $this->unit;
    }

    /**
     * Item SKU etc.
     */
    public function getDescription(): string
    {
        return $this->unit->getName() ?? $this->unit->getRef();
    }

    /**
     * Item width in mm.
     */
    public function getWidth(): int
    {
        return $this->unit->getW();
    }

    /**
     * Item length in mm.
     */
    public function getLength(): int
    {
        return $this->unit->getL();
    }

    /**
     * Item depth in mm.
     */
    public function getDepth(): int
    {
        return $this->unit->getH();
    }

    /**
     * Item weight in g.
     */
    public function getWeight(): int
    {
        return $this->unit->getWeight();
    }

    /**
     * Possible item rotations allowed. One of the ROTATION_* constants.
     */
    public function getAllowedRotations(): int
    {
        return self::ROTATION_BEST_FIT;
    }

    public function jsonSerialize()
    {
        return [
            'description' => $this->getDescription(),
            'width' => $this->getWidth(),
            'length' => $this->getLength(),
            'depth' => $this->getDepth(),
            'weight' => $this->getWeight(),
            'allowedRotations' => $this->getAllowedRotations(),
        ];
    }
}
