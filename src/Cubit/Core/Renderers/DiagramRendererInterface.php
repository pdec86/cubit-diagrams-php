<?php

declare(strict_types=1);

namespace CubitD\Core\Renderers;


use CubitD\Core\Interfaces\DiagramInterface;
use CubitD\Core\Layouts\LayoutGeneratorInterface;

interface DiagramRendererInterface
{
    public function render(DiagramInterface $diagram, ?LayoutGeneratorInterface $generator): string;
}
