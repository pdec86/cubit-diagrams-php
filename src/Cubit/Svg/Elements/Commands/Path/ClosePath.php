<?php

declare(strict_types=1);

namespace CubitD\Svg\Elements\Commands\Path;


use CubitD\Svg\Elements\Commands\AbstractCommand;

class ClosePath extends AbstractCommand
{
    protected function selfReset(): void
    {
    }

    public function selfMove(int $x, int $y): void
    {
    }

    public function selfScale(float $scale): void
    {
    }

    public function selfRender(): string
    {
        return 'Z';
    }
}
