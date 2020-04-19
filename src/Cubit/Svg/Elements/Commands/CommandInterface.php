<?php


namespace CubitD\Svg\Elements\Commands;


interface CommandInterface
{
    public function move(int $x, int $y): void;

    public function scale(float $scale): void;

    public function render(): string;
}
