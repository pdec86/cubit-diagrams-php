<?php

declare(strict_types=1);

namespace CubitD\Core\Layouts;


use CubitD\Core\Components\Boundary;
use CubitD\Core\Components\DiagramElementCoordinate;
use CubitD\Core\Components\DiagramElementInterface;
use CubitD\Core\Interfaces\DiagramInterface;

class SimpleLayoutGenerator implements LayoutGeneratorInterface
{
    /**
     * @inheritDoc
     */
    public function generate(DiagramInterface $diagram): void
    {
        /** @var DiagramElementCoordinate[] $coordinateRelations */
        $coordinateRelations = [];
        $coordinateSourceTarget = [];
        foreach ($diagram->getDiagramElementList() as $item) {
            foreach ($item->getCoordinateRelations() as $coordinateRelation) {
                $coordinateRelations[] = $coordinateRelation;
                $coordinateSourceTarget[] = [
                    'source' => $coordinateRelation->getSource(),
                    'target' => $coordinateRelation->getTarget()
                ];
            }
        }

        $this->checkCircularReferences($coordinateSourceTarget);

        /** @var DiagramElementCoordinate[] $coordinateRelations */
        $coordinateRelationsHandled = [];
        foreach ($coordinateRelations as $coordinateRelation) {
            $newX = 0;
            $newY = 0;
            $newTargetX = 0;
            $newTargetY = 0;
            $sourceBoundaries = $coordinateRelation->getSource()->getBoundaries();
            $targetBoundaries = $coordinateRelation->getTarget()->getBoundaries();

            switch ($coordinateRelation->getRelation()) {
                case DiagramElementCoordinate::LEFT_OF:
                    list($newX, $newY, $newTargetX, $newTargetY) =
                        $this->handleLeftOf($sourceBoundaries, $targetBoundaries);
                    break;

                case DiagramElementCoordinate::TOP_OF:
                    list($newX, $newY, $newTargetX, $newTargetY) =
                        $this->handleTopOf($sourceBoundaries, $targetBoundaries);
                    break;

                case DiagramElementCoordinate::RIGHT_OF:
                    list($newX, $newY, $newTargetX, $newTargetY) =
                        $this->handleRightOf($sourceBoundaries, $targetBoundaries);
                    break;

                case DiagramElementCoordinate::BOTTOM_OF:
                    list($newX, $newY, $newTargetX, $newTargetY) =
                        $this->handleBottomOf($sourceBoundaries, $targetBoundaries);
                    break;
            }

            $this->applyTransformation($coordinateRelation, $coordinateRelationsHandled, $newX, $newY,
                $newTargetX, $newTargetY);

            $coordinateRelationsHandled[] = $coordinateRelation;
        }
    }

    private function checkCircularReferences(array $coordinateSourceTarget): void
    {
        foreach ($coordinateSourceTarget as $pairOuter) {
            foreach ($coordinateSourceTarget as $pairInner) {
                if ($pairOuter['source'] == $pairInner['target'] && $pairOuter['target'] == $pairInner['source']) {
                    throw new \RuntimeException(SimpleLayoutGenerator::class . ' cannot handle circular references.');
                }
            }
        }
    }

    private function handleLeftOf(Boundary $sourceBoundaries, Boundary $targetBoundaries): array
    {
        $newX = 0;
        $newY = 0;
        $newTargetX = 0;
        $newTargetY = 0;
        if ($sourceBoundaries->getX() + $sourceBoundaries->getWidth() > $targetBoundaries->getX()) {
            $newX = $targetBoundaries->getX() - $sourceBoundaries->getWidth() - $sourceBoundaries->getX();
            if ($sourceBoundaries->getX() + $newX < 0) {
                $newX = -$sourceBoundaries->getX();
                $newTargetX = -$newX + $sourceBoundaries->getWidth();
            }
        }
        if ($sourceBoundaries->getY() != $targetBoundaries->getY()) {
            $newY = $targetBoundaries->getY() - $sourceBoundaries->getY();
        }

        return [$newX, $newY, $newTargetX, $newTargetY];
    }

    private function handleTopOf(Boundary $sourceBoundaries, Boundary $targetBoundaries): array
    {
        $newX = 0;
        $newY = 0;
        $newTargetX = 0;
        $newTargetY = 0;
        if ($sourceBoundaries->getY() + $sourceBoundaries->getHeight() > $targetBoundaries->getY()) {
            $newY = $targetBoundaries->getY() - $sourceBoundaries->getHeight() - $sourceBoundaries->getY();
            if ($sourceBoundaries->getY() + $newY < 0) {
                $newY = -($sourceBoundaries->getY());
                $newTargetY = -$newY + $sourceBoundaries->getHeight();
            }
        }
        if ($sourceBoundaries->getX() != $targetBoundaries->getX()) {
            $newX = $targetBoundaries->getX() - $sourceBoundaries->getX();
        }

        return [$newX, $newY, $newTargetX, $newTargetY];
    }

    private function handleRightOf(Boundary $sourceBoundaries, Boundary $targetBoundaries): array
    {
        $newX = 0;
        $newY = 0;
        $newTargetX = 0;
        $newTargetY = 0;
        if ($sourceBoundaries->getX() < $targetBoundaries->getX() + $targetBoundaries->getWidth()) {
            $newX = $targetBoundaries->getX() + $targetBoundaries->getWidth() - $sourceBoundaries->getX();
        }
        if ($sourceBoundaries->getY() != $targetBoundaries->getY()) {
            $newY = $targetBoundaries->getY() - $sourceBoundaries->getY();
        }

        return [$newX, $newY, $newTargetX, $newTargetY];
    }

    private function handleBottomOf(Boundary $sourceBoundaries, Boundary $targetBoundaries): array
    {
        $newX = 0;
        $newY = 0;
        $newTargetX = 0;
        $newTargetY = 0;
        if ($targetBoundaries->getY() + $targetBoundaries->getHeight() > $sourceBoundaries->getY()) {
            $newY = $targetBoundaries->getY() + $targetBoundaries->getHeight() - $sourceBoundaries->getY();
        }
        if ($sourceBoundaries->getX() != $targetBoundaries->getX()) {
            $newX = $targetBoundaries->getX() - $sourceBoundaries->getX();
        }

        return [$newX, $newY, $newTargetX, $newTargetY];
    }

    /**
     * @param DiagramElementCoordinate $coordinateRelation
     * @param DiagramElementCoordinate[] $coordinateRelationsHandled
     * @param float $newX
     * @param float $newY
     * @param float $newTargetX
     * @param float $newTargetY
     */
    private function applyTransformation(DiagramElementCoordinate $coordinateRelation, array $coordinateRelationsHandled,
                                         float $newX, float $newY, float $newTargetX, float $newTargetY): void
    {
        if (!empty($newX) || !empty($newY)) {
            $coordinateRelation->getSource()->move((int)$newX, (int)$newY);
        }
        $this->applyRecursiveTransformation($coordinateRelation->getTarget(), $coordinateRelation->getSource(),
            $coordinateRelationsHandled, $newTargetX, $newTargetY);
    }

    /**
     * @param DiagramElementInterface $target
     * @param DiagramElementInterface $source
     * @param DiagramElementCoordinate[] $coordinateRelationsHandled
     * @param float $newTargetX
     * @param float $newTargetY
     */
    private function applyRecursiveTransformation(DiagramElementInterface $target, DiagramElementInterface $source,
                                                  array $coordinateRelationsHandled, float $newTargetX,
                                                  float $newTargetY): void
    {
        if (!empty($newTargetX) || !empty($newTargetY)) {
            $target->move((int)$newTargetX, (int)$newTargetY);
            foreach ($coordinateRelationsHandled as $coordinateRelationFix) {
                if ($coordinateRelationFix->getTarget() === $target
                    && $coordinateRelationFix->getSource() !== $source) {
                    $coordinateRelationFix->getSource()->move((int)$newTargetX, (int)$newTargetY);
                }

                if ($coordinateRelationFix->getSource() === $target) {
                    $this->applyRecursiveTransformation($coordinateRelationFix->getTarget(),
                        $coordinateRelationFix->getSource(), $coordinateRelationsHandled, $newTargetX, $newTargetY);
                }
            }
        }
    }
}
