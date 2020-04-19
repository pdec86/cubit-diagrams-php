<?php

declare(strict_types=1);

namespace CubitD\Core\Interfaces\Common;


interface TransformInterface
{
    /**
     * @param int $x New X position on diagram.
     * @param int $y New Y position on diagram.
     */
    public function move(int $x, int $y): void;

    /**
     * @param float $scale Factor which is used to calculate new dimensions.
     */
    public function scale(float $scale): void;
}
