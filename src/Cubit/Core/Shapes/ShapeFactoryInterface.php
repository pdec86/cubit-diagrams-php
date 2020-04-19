<?php

declare(strict_types=1);

namespace CubitD\Core\Shapes;


interface ShapeFactoryInterface
{
    public function create(string $type): ShapeContainerInterface;
}
