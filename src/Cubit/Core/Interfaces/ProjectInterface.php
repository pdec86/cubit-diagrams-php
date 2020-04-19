<?php

declare(strict_types=1);

namespace CubitD\Core\Interfaces;


interface ProjectInterface
{
    /**
     * @return string The project title.
     */
    public function getTitle(): string;

    /**
     * @return DiagramInterface[] List of available diagrams.
     */
    public function getDiagramList(): array;
}
