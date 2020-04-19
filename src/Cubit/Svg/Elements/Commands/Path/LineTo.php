<?php

declare(strict_types=1);

namespace CubitD\Svg\Elements\Commands\Path;


use CubitD\Svg\Elements\Commands\AbstractCommand;

class LineTo extends AbstractCommand
{
    /**
     * @var int|null
     */
    private $x;
    /**
     * @var int|null
     */
    private $y;
    /**
     * @var bool
     */
    private $absolute;

    /**
     * @var int|null
     */
    private $xPrim;
    /**
     * @var int|null
     */
    private $yPrim;

    public function __construct(?int $x, ?int $y, bool $absolute = true)
    {
        if (!isset($x) && !isset($y)) {
            throw new \InvalidArgumentException('You must provide at least one coordinate.');
        }

        $this->x = $x;
        $this->y = $y;
        $this->absolute = $absolute;

        $this->selfReset();
    }

    protected function selfReset(): void
    {
        $this->xPrim = $this->x;
        $this->yPrim = $this->y;
    }

    public function selfMove(int $x, int $y): void
    {
        if ($this->absolute) {
            $this->xPrim = isset($this->xPrim) ? $this->xPrim + $x : null;
            $this->yPrim = isset($this->yPrim) ? $this->yPrim + $y : null;
        }
    }

    public function selfScale(float $scale): void
    {
        if ($this->absolute) {
            $this->xPrim = isset($this->xPrim) ? (int)($this->xPrim * $scale) : null;
            $this->yPrim = isset($this->yPrim) ? (int)($this->yPrim * $scale) : null;
        }
    }

    public function selfRender(): string
    {
        $command = $this->absolute ? 'L ' : 'l ';
        if (isset($this->xPrim) && !isset($this->yPrim)) {
            $command = $this->absolute ? 'H ' : 'h ' . $this->xPrim;
        } elseif (!isset($xPrim) && isset($yPrim)) {
            $command = $this->absolute ? 'V ' : 'v ' . $this->yPrim;
        } else {
            $command .= "$this->xPrim $this->yPrim";
        }

        return $command;
    }
}
