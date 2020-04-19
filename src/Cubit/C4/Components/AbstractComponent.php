<?php

declare(strict_types=1);

namespace CubitD\C4\Components;


use CubitD\Core\Components\AbstractDiagramElement;
use CubitD\Core\Components\Boundary;
use CubitD\Core\Shapes\ShapeContainerInterface;
use CubitD\Core\Shapes\ShapeInterface;

abstract class AbstractComponent extends AbstractDiagramElement
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var ShapeInterface[]
     */
    private $shapes = [];

    /**
     * @var string|null
     */
    protected $description;

    public function __construct(string $name, ShapeContainerInterface $shape, ?string $description = null)
    {
        $this->name = $name;
        $this->description = $description;
        $shape->setText1($this->name);
        $shape->setText2($this->description);
        $this->shapes = array_merge($this->shapes, $shape->getShapeList());
    }

    /**
     * @inheritDoc
     */
    public function getBoundaries(): Boundary
    {
        $mainShape = reset($this->shapes);
        return $mainShape->getBoundaries();
    }

    /**
     * @inheritDoc
     */
    public function move(int $x, int $y): void
    {
        foreach ($this->shapes as $shape) {
            $shape->move($x, $y);
        }
    }

    /**
     * @inheritDoc
     */
    public function scale(float $scale): void
    {
        foreach ($this->shapes as $shape) {
            $shape->scale($scale);
        }
    }

    /**
     * @inheritDoc
     */
    public function getShapeList(): array
    {
        return $this->shapes;
    }
}
