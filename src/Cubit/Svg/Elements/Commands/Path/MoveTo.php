<?php

declare(strict_types=1);

namespace CubitD\Svg\Elements\Commands\Path;


use CubitD\Svg\Elements\Commands\AbstractCommand;

class MoveTo extends AbstractCommand
{
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

    /**
     * @var int
     */
    private $xPrim;
    /**
     * @var int
     */
    private $yPrim;

    public function __construct(int $x, int $y, bool $absolute = true)
    {
        $this->x = $x;
        $this->y = $y;
        $this->absolute = $absolute;

        $this->selfReset();
    }

    public function selfReset(): void
    {
        $this->xPrim = $this->x;
        $this->yPrim = $this->y;
    }

    public function selfMove(int $x, int $y): void
    {
        if ($this->absolute) {
            $this->xPrim += $x;
            $this->yPrim += $y;
        }
    }

    public function selfScale(float $scale): void
    {
        if ($this->absolute) {
            $this->xPrim = (int) ($this->xPrim * $scale);
            $this->yPrim = (int) ($this->yPrim * $scale);
        }
    }

    public function selfRender(): string
    {
        return ($this->absolute ? 'M ' : 'm ') . "$this->xPrim $this->yPrim";
    }
}
