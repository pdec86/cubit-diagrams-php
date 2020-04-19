<?php

declare(strict_types=1);

namespace CubitD\Core\Interfaces\Common;


use CubitD\Core\Components\Boundary;

interface BoundaryInterface
{
    /**
     * @return Boundary Boundary in which diagram element will be rendered.
     */
    public function getBoundaries(): Boundary;
}
