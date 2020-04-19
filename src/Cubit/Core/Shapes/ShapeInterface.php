<?php

declare(strict_types=1);

namespace CubitD\Core\Shapes;


use CubitD\Core\Interfaces\Common\BoundaryInterface;
use CubitD\Core\Interfaces\Common\TransformInterface;

interface ShapeInterface extends BoundaryInterface, TransformInterface
{
    /**
     * @return string String containing rendered shape.
     */
    public function render(): string;
}
