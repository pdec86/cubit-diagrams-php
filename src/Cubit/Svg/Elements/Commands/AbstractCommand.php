<?php

declare(strict_types=1);

namespace CubitD\Svg\Elements\Commands;


abstract class AbstractCommand implements CommandInterface
{
    /**
     * @var MoveTransformation[]
     */
    protected $moveActions = [];
    /**
     * @var ScaleTransformation[]
     */
    protected $scaleActions = [];

    public function move(int $x, int $y): void
    {
        $this->moveActions[] = new MoveTransformation($x, $y);
    }

    public function scale(float $scale): void
    {
        $this->scaleActions[] = new ScaleTransformation($scale);
    }

    public function render(): string
    {
        $this->selfTransform();
        return $this->selfRender();
    }

    protected function selfTransform(): void
    {
        $this->selfReset();

        foreach ($this->scaleActions as $scaleAction) {
            $this->selfScale($scaleAction->getScale());
        }

        foreach ($this->moveActions as $moveAction) {
            $this->selfMove($moveAction->getX(), $moveAction->getY());
        }
    }

    abstract protected function selfReset(): void;

    abstract protected function selfScale(float $scale): void;

    abstract protected function selfMove(int $x, int $y): void;

    abstract protected function selfRender(): string;
}
