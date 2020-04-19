<?php

declare(strict_types=1);

namespace CubitD\Svg\Elements;


use CubitD\Core\Components\Boundary;
use CubitD\Core\Shapes\ShapeInterface;
use CubitD\Svg\Elements\Commands\CommandInterface;
use CubitD\Svg\Elements\Commands\Path\ClosePath;
use CubitD\Svg\Elements\Commands\Path\CubicBezier;
use CubitD\Svg\Elements\Commands\Path\EllipticalArc;
use CubitD\Svg\Elements\Commands\Path\LineTo;
use CubitD\Svg\Elements\Commands\Path\MoveTo;
use CubitD\Svg\Elements\Commands\Path\QuadraticBezier;

class Path implements ShapeInterface
{
    /**
     * @var CommandInterface[]
     */
    private $commandList = [];

    /**
     * @var string|null
     */
    private $fill;

    /**
     * @var string|null
     */
    private $stroke;

    /**
     * @var int|null
     */
    private $strokeWidth;

    private $xStart = 0;
    private $yStart = 0;
    private $xEnd;
    private $yEnd;

    private $xStartPrim;
    private $yStartPrim;
    private $xEndPrim;
    private $yEndPrim;

    /**
     * Path constructor.
     * @param int $maxWidth
     * @param int $maxHeight
     */
    public function __construct(int $maxWidth, int $maxHeight)
    {
        $this->xEnd = $this->xStart + $maxWidth;
        $this->yEnd = $this->yStart + $maxHeight;

        $this->xStartPrim = $this->xStart;
        $this->xEndPrim = $this->xEnd;
        $this->yStartPrim = $this->yStart;
        $this->yEndPrim = $this->yEnd;
    }

    public function moveTo(int $x, int $y, bool $absolute = true): Path
    {
        $this->commandList[] = new MoveTo($x, $y, $absolute);
        return $this;
    }

    public function lineTo(?int $x, ?int $y, bool $absolute = true): Path
    {
        $this->commandList[] = new LineTo($x, $y, $absolute);
        return $this;
    }

    public function cubicBezier(?int $x1, ?int $y1, int $x2, int $y2, int $x, int $y, bool $absolute = true): Path
    {
        $this->commandList[] = new CubicBezier($x1, $y1, $x2, $y2, $x, $y, $absolute);
        return $this;
    }

    public function quadraticBezier(?int $x1, ?int $y1, int $x, int $y, bool $absolute = true): Path
    {
        $this->commandList[] = new QuadraticBezier($x1, $y1, $x, $y, $absolute);
        return $this;
    }

    public function ellipticalArc(int $rx, int $ry, int $xAxisRotation, int $largeArcFlag, int $sweepFlag,
                                  int $x, int $y, bool $absolute = true): Path
    {
        $this->commandList[] = new EllipticalArc($rx, $ry, $xAxisRotation, $largeArcFlag, $sweepFlag,
            $x, $y, $absolute);
        return $this;
    }

    public function closePath(): Path
    {
        $this->commandList[] = new ClosePath();
        return $this;
    }

    public function setFill(?string $fill): Path
    {
        $this->fill = $fill;
        return $this;
    }

    public function setStroke(?string $stroke): Path
    {
        $this->stroke = $stroke;
        return $this;
    }

    public function setStrokeWidth(?int $strokeWidth): Path
    {
        $this->strokeWidth = $strokeWidth;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getBoundaries(): Boundary
    {
        return new Boundary($this->xStartPrim,
            $this->yStartPrim,
            $this->xEndPrim - $this->xStartPrim,
            $this->yEndPrim - $this->yStartPrim);
    }

    /**
     * @inheritDoc
     */
    public function move(int $x, int $y): void
    {
        foreach ($this->commandList as $command) {
            $command->move($x, $y);
        }

        $this->xStartPrim += $x;
        $this->xEndPrim += $x;
        $this->yStartPrim += $y;
        $this->yEndPrim += $y;
    }

    /**
     * @inheritDoc
     */
    public function scale(float $scale): void
    {
        foreach ($this->commandList as $command) {
            $command->scale($scale);
        }

        $this->xStartPrim *= $scale;
        $this->xEndPrim *= $scale;
        $this->yStartPrim *= $scale;
        $this->yEndPrim *= $scale;
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        if (empty($this->commandList)) {
            throw new \RuntimeException('Path has empty commands list.');
        }

        $fill = (isset($this->fill)) ? 'fill="' . $this->fill . '"' : '';
        $stroke = (isset($this->stroke)) ? 'stroke="' . $this->stroke . '"' : '';
        $strokeWidth = (isset($this->strokeWidth)) ? 'stroke-width="' . $this->strokeWidth . '"' : '';

        $commands = '';
        foreach ($this->commandList as $command) {
            $commands .= $command->render() . ' ';
        }

        return "<path d=\"$commands\" $fill $stroke $strokeWidth />";
    }

    public function __clone()
    {
        $commandListTmp = $this->commandList;
        $this->commandList = [];
        foreach ($commandListTmp as $command) {
            $this->commandList[] = clone $command;
        }
    }
}
