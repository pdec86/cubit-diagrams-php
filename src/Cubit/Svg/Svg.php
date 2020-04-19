<?php

declare(strict_types=1);

namespace CubitD\Svg;


use CubitD\Core\Shapes\ShapeInterface;

class Svg
{
    /**
     * @var ShapeInterface[]
     */
    private $shapeList;

    /**
     * @var string|null
     */
    private $x;

    /**
     * @var string|null
     */
    private $y;

    /**
     * @var string|null
     */
    private $width;

    /**
     * @var string|null
     */
    private $height;

    /**
     * @var string|null
     */
    private $viewBox;

    public function addShape(ShapeInterface $shape): void
    {
        $this->shapeList[] = $shape;
    }

    public function setX(?string $x): Svg
    {
        $this->x = $x;
        return $this;
    }

    public function setY(?string $y): Svg
    {
        $this->y = $y;
        return $this;
    }

    public function setWidth(?string $width): Svg
    {
        $this->width = $width;
        return $this;
    }

    public function setHeight(?string $height): Svg
    {
        $this->height = $height;
        return $this;
    }

    public function setViewBox(?string $viewBox): Svg
    {
        $this->viewBox = $viewBox;
        return $this;
    }

    public function render(): string
    {
        if (empty($this->shapeList)) {
            throw new \RuntimeException('Svg has empty shapes list.');
        }

        $x = (isset($this->x)) ? 'x="' . $this->x . '"' : '';
        $y = (isset($this->y)) ? 'y="' . $this->y . '"' : '';
        $width = (isset($this->width)) ? 'width="' . $this->width . '"' : '';
        $height = (isset($this->height)) ? 'height="' . $this->height . '"' : '';
        $viewBox = (isset($this->viewBox)) ? 'viewBox="' . $this->viewBox . '"' : '';

        $render = "<svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\" $x $y $width $height $viewBox >";
        foreach ($this->shapeList as $shape) {
            $render .= ' ' . $shape->render();
        }
        $render .= '</svg>';

        return $render;
    }
}
