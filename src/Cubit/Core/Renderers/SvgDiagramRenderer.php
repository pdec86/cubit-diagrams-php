<?php

declare(strict_types=1);

namespace CubitD\Core\Renderers;


use CubitD\Core\Interfaces\DiagramInterface;
use CubitD\Core\Layouts\LayoutGeneratorInterface;
use CubitD\Svg\Elements\Line;
use CubitD\Svg\Svg;

class SvgDiagramRenderer implements DiagramRendererInterface
{
    public function render(DiagramInterface $diagram, ?LayoutGeneratorInterface $generator): string
    {
        $svg = new Svg();
        $diagram->getTitle();

        if (isset($generator)) {
            $generator->generate($diagram);
        }

        $maxX = 0;
        $maxY = 0;
        $shapes = [];
        foreach ($diagram->getDiagramElementList() as $item) {
            $boundaries = $item->getBoundaries();
            $maxX = max($maxX, $boundaries->getX() + $boundaries->getWidth());
            $maxY = max($maxY, $boundaries->getY() + $boundaries->getHeight());
            foreach ($item->getShapeList() as $shape) {
                $shapes[] = $shape;
            }

            $uses = $item->getUsesList();
            foreach ($uses as $element) {
                $elementBoundaries = $element->getBoundaries();
                $x1 = (int) ($boundaries->getX() + $boundaries->getWidth() / 2);
                $y1 = (int) ($boundaries->getY() + $boundaries->getHeight() / 2);
                $x2 = (int) ($elementBoundaries->getX() + $elementBoundaries->getWidth() / 2);
                $y2 = (int) ($elementBoundaries->getY() + $elementBoundaries->getHeight() / 2);
                $line = new Line($x1, $y1, $x2, $y2);
                $svg->addShape($line);
            }
        }

        foreach ($shapes as $shape) {
            $svg->addShape($shape);
        }

        $svg->setViewBox("0 0 $maxX $maxY");
        $svg->setWidth(2 * $maxX . 'px');
        $svg->setHeight(2 * $maxY . 'px');

        return $svg->render();
    }
}
