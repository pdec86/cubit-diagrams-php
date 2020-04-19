<?php

declare(strict_types=1);

namespace CubitD\Core\Shapes;


interface ShapeContainerInterface
{
    /**
     * @param string|null $text Text to be set in first position.
     */
    public function setText1(?string $text): void;

    /**
     * @param string|null $text Text to be set in second position.
     */
    public function setText2(?string $text): void;

    /**
     * @return ShapeInterface[] Created shape which is used in renderers.
     */
    public function getShapeList(): array;
}
