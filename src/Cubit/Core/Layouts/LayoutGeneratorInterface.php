<?php

declare(strict_types=1);

namespace CubitD\Core\Layouts;


use CubitD\Core\Interfaces\DiagramInterface;

interface LayoutGeneratorInterface
{
    public function generate(DiagramInterface $diagram): void;
}
