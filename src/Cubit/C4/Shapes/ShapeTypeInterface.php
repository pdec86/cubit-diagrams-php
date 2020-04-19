<?php

declare(strict_types=1);

namespace CubitD\C4\Shapes;


use CubitD\Core\Shapes\ShapeContainerInterface;

interface ShapeTypeInterface
{
    /**
     * @return string Shape type which is used to determine what shape to create in specific factory.
     */
    public static function getShapeType(): string;

    /**
     * @return ShapeContainerInterface Shape container for specific shape type.
     */
    public function getShapeContainer(): ShapeContainerInterface;
}
