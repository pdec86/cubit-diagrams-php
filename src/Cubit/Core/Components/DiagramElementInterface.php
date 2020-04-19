<?php

declare(strict_types=1);

namespace CubitD\Core\Components;


use CubitD\Core\Interfaces\Common\BoundaryInterface;
use CubitD\Core\Interfaces\Common\TransformInterface;
use CubitD\Core\Shapes\ShapeInterface;

interface DiagramElementInterface extends BoundaryInterface, TransformInterface
{
    /**
     * Set other diagram element which is used by this one.
     * @param DiagramElementInterface $element Other diagram element.
     */
    public function uses(DiagramElementInterface $element): void;

    /**
     * Return list of other diagram elements, which this element uses.
     * @return DiagramElementInterface[] List of used diagram elements.
     */
    public function getUsesList(): array;

    /**
     * Set position to left of other diagram element.
     * @param DiagramElementInterface $element Other diagram element.
     */
    public function toLeftOf(DiagramElementInterface $element): void;

    /**
     * Set position to top of other diagram element.
     * @param DiagramElementInterface $element Other diagram element.
     */
    public function toTopOf(DiagramElementInterface $element): void;

    /**
     * Set position to right of other diagram element.
     * @param DiagramElementInterface $element Other diagram element.
     */
    public function toRightOf(DiagramElementInterface $element): void;

    /**
     * Set position to bottom of other diagram element.
     * @param DiagramElementInterface $element Other diagram element.
     */
    public function toBottomOf(DiagramElementInterface $element): void;

    /**
     * Return the coordinate relations of current diagram element to other diagram elements.
     * @return \Generator|DiagramElementCoordinate[] Coordinate relations.
     */
    public function getCoordinateRelations(): \Generator;

    /**
     * @return ShapeInterface[] Shapes for rendered element.
     */
    public function getShapeList(): array;
}
