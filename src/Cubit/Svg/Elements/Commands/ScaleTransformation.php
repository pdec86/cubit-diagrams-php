<?php

declare(strict_types=1);

namespace CubitD\Svg\Elements\Commands;


class ScaleTransformation
{
    /**
     * @var float
     */
    private $scale;

    public function __construct(float $scale)
    {
        $this->scale = $scale;
    }

    /**
     * @return float
     */
    public function getScale(): float
    {
        return $this->scale;
    }
}
