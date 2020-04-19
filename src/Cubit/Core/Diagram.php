<?php

declare(strict_types=1);

namespace CubitD\Core;


use CubitD\Core\Components\DiagramElementInterface;
use CubitD\Core\Interfaces\DiagramInterface;

class Diagram implements DiagramInterface
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var DiagramElementInterface[]
     */
    private $elementList = [];

    /**
     * @param string $title
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    /**
     * Add element to the diagram.
     * @param DiagramElementInterface $element Diagram element which should be added to the diagram.
     */
    public function addElement(DiagramElementInterface $element): void
    {
        $this->elementList[] = $element;
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @inheritDoc
     */
    public function scale(float $factor): void
    {
        foreach ($this->elementList as $diagramElement) {
            $diagramElement->scale($factor);
        }
    }

    /**
     * @inheritDoc
     */
    public function getDiagramElementList(): \Generator
    {
        yield from $this->elementList;
    }
}
