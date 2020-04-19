<?php

declare(strict_types=1);

namespace CubitD\Core\Interfaces;


use CubitD\Core\Components\DiagramElementInterface;

interface DiagramInterface
{
    /**
     * @return string The diagram title.
     */
    public function getTitle(): string;

    /**
     * @param float $factor Factor which is used to scale the diagram.
     */
    public function scale(float $factor): void;

    /**
     * @return \Generator|DiagramElementInterface[] List of elements on the diagram.
     */
    public function getDiagramElementList(): \Generator;
}
