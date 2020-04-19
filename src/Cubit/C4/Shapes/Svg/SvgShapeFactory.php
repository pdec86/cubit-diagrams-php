<?php

declare(strict_types=1);

namespace CubitD\C4\Shapes\Svg;


use CubitD\C4\Shapes\ShapeTypeInterface;
use CubitD\Core\Shapes\ShapeContainerInterface;
use CubitD\Core\Shapes\ShapeFactoryInterface;

class SvgShapeFactory implements ShapeFactoryInterface
{
    /**
     * @var ShapeTypeInterface[]
     */
    private $shapeTypes = [];

    public function addShapeType(ShapeTypeInterface $shapeType): void
    {
        $this->shapeTypes[] = $shapeType;
    }

    public function create(string $type): ShapeContainerInterface
    {
        foreach ($this->shapeTypes as $shapeType) {
            if (strcmp($shapeType::getShapeType(), $type) == 0) {
                return $shapeType->getShapeContainer();
            }
        }

        throw new \RuntimeException('Unknown shape type');
    }
}
