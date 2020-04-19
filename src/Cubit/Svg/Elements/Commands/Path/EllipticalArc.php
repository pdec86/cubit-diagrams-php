<?php

declare(strict_types=1);

namespace CubitD\Svg\Elements\Commands\Path;


use CubitD\Svg\Elements\Commands\AbstractCommand;

class EllipticalArc extends AbstractCommand
{
    /**
     * @var int
     */
    private $rx;
    /**
     * @var int
     */
    private $ry;
    /**
     * @var int
     */
    private $xAxisRotation;
    /**
     * @var int
     */
    private $largeArcFlag;
    /**
     * @var int
     */
    private $sweepFlag;
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
    private $rxPrim;
    /**
     * @var int
     */
    private $ryPrim;
    /**
     * @var int
     */
    private $xPrim;
    /**
     * @var int
     */
    private $yPrim;

    public function __construct(int $rx, int $ry, int $xAxisRotation, int $largeArcFlag, int $sweepFlag,
                                int $x, int $y, bool $absolute = true)
    {
        $this->rx = $rx;
        $this->ry = $ry;
        $this->xAxisRotation = $xAxisRotation;
        $this->largeArcFlag = $largeArcFlag;
        $this->sweepFlag = $sweepFlag;
        $this->x = $x;
        $this->y = $y;
        $this->absolute = $absolute;

        $this->selfReset();
    }

    protected function selfReset(): void
    {
        $this->rxPrim = $this->rx;
        $this->ryPrim = $this->ry;
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
        $this->rxPrim *= $scale;
        $this->ryPrim *= $scale;
        $this->xPrim *= $scale;
        $this->yPrim *= $scale;
    }

    public function selfRender(): string
    {
        return ($this->absolute ? 'A ' : 'a ') . "$this->rxPrim,$this->ryPrim $this->xAxisRotation " .
            "$this->largeArcFlag,$this->sweepFlag $this->xPrim,$this->yPrim";
    }
}