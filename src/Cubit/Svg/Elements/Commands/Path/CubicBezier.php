<?php

declare(strict_types=1);

namespace CubitD\Svg\Elements\Commands\Path;


use CubitD\Svg\Elements\Commands\AbstractCommand;

class CubicBezier extends AbstractCommand
{
    /**
     * @var int|null
     */
    private $x1;
    /**
     * @var int|null
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
     * @var int
     */
    private $x;
    /**
     * @var int
     */
    private $y;
    /**
     * @var bool
     */
    private $absolute;

    public function __construct(?int $x1, ?int $y1, int $x2, int $y2, int $x, int $y, bool $absolute = true)
    {
        $this->x1 = $x1;
        $this->y1 = $y1;
        $this->x2 = $x2;
        $this->y2 = $y2;
        $this->x = $x;
        $this->y = $y;
        $this->absolute = $absolute;
    }

    protected function selfReset(): void
    {
        // TODO: Implement selfReset() method.
    }

    public function selfMove(int $x, int $y): void
    {
        if ($this->absolute) {
            $this->x1 = isset($this->x1) ? (int) ($this->x1 + $x) : null;
            $this->y1 = isset($this->y1) ? (int) ($this->y1 + $y) : null;
            $this->x2 = (int) ($this->x2 + $x);
            $this->y2 = (int) ($this->y2 + $y);
            $this->x = (int) ($this->x + $x);
            $this->y = (int) ($this->y + $y);
        }
    }

    public function selfScale(float $scale): void
    {
        if ($this->absolute) {
            $this->x1 = isset($this->x1) ? (int) ($this->x1 * $scale) : null;
            $this->y1 = isset($this->y1) ? (int) ($this->y1 * $scale) : null;
            $this->x2 = (int) ($this->x2 * $scale);
            $this->y2 = (int) ($this->y2 * $scale);
            $this->x = (int) ($this->x * $scale);
            $this->y = (int) ($this->y * $scale);
        }
    }

    public function selfRender(): string
    {
        $command = $this->absolute ? 'S ' : 's ';
        if (isset($this->x1) && isset($this->y1)) {
            $command = $this->absolute ? 'C ' : 'c ';
            $command .= "$this->x1,$this->y1 ";
        }
        $command .= "$this->x2,$this->y2 $this->x,$this->y";

        return $command;
    }
}