<?php

declare(strict_types=1);

namespace CubitD\Core\Components;


abstract class AbstractDiagramElement implements DiagramElementInterface
{
    /**
     * @var DiagramElementInterface[]
     */
    protected $usesList = [];

    /**
     * @var DiagramElementCoordinate[]
     */
    protected $coordinateRelations = [];

    /**
     * @inheritDoc
     */
    public function uses(DiagramElementInterface $element): void
    {
        $this->usesList[] = $element;
    }

    /**
     * @inheritDoc
     */
    public function toLeftOf(DiagramElementInterface $element): void
    {
        $this->coordinateRelations[] = new DiagramElementCoordinate($this, $element, DiagramElementCoordinate::LEFT_OF);
    }

    /**
     * @inheritDoc
     */
    public function toTopOf(DiagramElementInterface $element): void
    {
        $this->coordinateRelations[] = new DiagramElementCoordinate($this, $element, DiagramElementCoordinate::TOP_OF);
    }

    /**
     * @inheritDoc
     */
    public function toRightOf(DiagramElementInterface $element): void
    {
        $this->coordinateRelations[] = new DiagramElementCoordinate($this, $element, DiagramElementCoordinate::RIGHT_OF);
    }

    /**
     * @inheritDoc
     */
    public function toBottomOf(DiagramElementInterface $element): void
    {
        $this->coordinateRelations[] = new DiagramElementCoordinate($this, $element, DiagramElementCoordinate::BOTTOM_OF);
    }

    /**
     * @inheritDoc
     */
    public function getCoordinateRelations(): \Generator
    {
        yield from $this->coordinateRelations;
    }

    /**
     * @inheritDoc
     */
    public function getUsesList(): array
    {
        return array_values($this->usesList);
    }
}
