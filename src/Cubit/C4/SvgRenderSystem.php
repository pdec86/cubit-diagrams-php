<?php

declare(strict_types=1);

namespace CubitD\C4;


use CubitD\C4\Shapes\ShapeTypeInterface;
use CubitD\C4\Shapes\Svg\SvgActorShape;
use CubitD\C4\Shapes\Svg\SvgShapeFactory;
use CubitD\Core\Interfaces\RenderSystemInterface;
use CubitD\Core\Renderers\DiagramRendererInterface;
use CubitD\Core\Renderers\SvgDiagramRenderer;
use CubitD\Core\Shapes\ShapeFactoryInterface;

class SvgRenderSystem implements RenderSystemInterface
{
    /**
     * @var ShapeFactoryInterface
     */
    private $shapeFactory;

    /**
     * @var DiagramRendererInterface
     */
    private $diagramRenderer;

    public function __construct()
    {
        $this->shapeFactory = new SvgShapeFactory();
        $this->diagramRenderer = new SvgDiagramRenderer();

        $this->shapeFactory->addShapeType(new SvgActorShape());
    }

    public function addShapeType(ShapeTypeInterface $shapeType): void
    {
        $this->shapeFactory->addShapeType($shapeType);
    }

    public function getShapeFactory(): ShapeFactoryInterface
    {
        return $this->shapeFactory;
    }

    public function getDiagramRenderer(): DiagramRendererInterface
    {
        return $this->diagramRenderer;
    }
}
