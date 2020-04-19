<?php

declare(strict_types=1);

namespace SimpleBank\Shapes;


use CubitD\C4\Shapes\ShapeTypeInterface;

abstract class CloudShapeType implements ShapeTypeInterface
{
    /**
     * @inheritDoc
     */
    public static function getShapeType(): string
    {
        return 'MyCloud';
    }
}
