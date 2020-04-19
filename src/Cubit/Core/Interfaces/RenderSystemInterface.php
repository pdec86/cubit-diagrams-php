<?php

declare(strict_types=1);

namespace CubitD\Core\Interfaces;


use CubitD\Core\Renderers\DiagramRendererInterface;
use CubitD\Core\Shapes\ShapeFactoryInterface;

interface RenderSystemInterface
{
    public function getShapeFactory(): ShapeFactoryInterface;

    public function getDiagramRenderer(): DiagramRendererInterface;
}
