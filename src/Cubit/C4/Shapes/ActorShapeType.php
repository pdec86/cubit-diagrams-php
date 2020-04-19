<?php


namespace CubitD\C4\Shapes;


abstract class ActorShapeType implements ShapeTypeInterface
{
    /**
     * @inheritDoc
     */
    public static function getShapeType(): string
    {
        return 'Actor';
    }
}
