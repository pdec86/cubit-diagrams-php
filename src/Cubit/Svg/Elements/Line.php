<?php

declare(strict_types=1);

namespace CubitD\Svg\Elements;


use CubitD\Core\Components\Boundary;
use CubitD\Core\Shapes\ShapeInterface;

class Line implements ShapeInterface
{
    /**
     * @var int
     */
    private $x1;

    /**
     * @var int
     */
    private $y1;

    /**
     * @var int
     */
    private $x2;

    /**
     * @var int
     */
    private $y2;

    /**
     * Line constructor.
     * @param int $x1
     * @param int $y1
     * @param int $x2
     * @param int $y2
     */
    public function __construct(int $x1, int $y1, int $x2, int $y2)
    {
        $this->x1 = $x1;
        $this->y1 = $y1;
        $this->x2 = $x2;
        $this->y2 = $y2;
    }

    /**
     * @inheritDoc
     */
    public function getBoundaries(): Boundary
    {
        // @TODO - calculate width and height
        return new Boundary($this->x1, $this->y1, 200, 100);
    }

    /**
     * @inheritDoc
     */
    public function move(int $x, int $y): void
    {
        $this->x1 += $x;
        $this->y1 += $y;
        $this->x2 += $x;
        $this->y2 += $y;
    }

    /**
     * @inheritDoc
     */
    public function scale(float $scale): void
    {
        $this->x1 *= $scale;
        $this->y1 *= $scale;
        $this->x2 *= $scale;
        $this->y2 *= $scale;
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        return "<line x1='$this->x1' y1='$this->y1' x2='$this->x2' y2='$this->y2' stroke='black' stroke-dasharray='5, 2' />";
    }
}
