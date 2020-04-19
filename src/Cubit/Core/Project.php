<?php

declare(strict_types=1);

namespace CubitD\Core;


use CubitD\Core\Interfaces\DiagramInterface;
use CubitD\Core\Interfaces\ProjectInterface;

class Project implements ProjectInterface
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var DiagramInterface[]
     */
    private $diagramList = [];

    /**
     * @param string $title
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    /**
     * Add diagram to the project.
     * @param DiagramInterface $diagram Diagram which should be added to the project.
     */
    public function addDiagram(DiagramInterface $diagram): void
    {
        $this->diagramList[] = $diagram;
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
    public function getDiagramList(): array
    {
        return array_values($this->diagramList);
    }
}
