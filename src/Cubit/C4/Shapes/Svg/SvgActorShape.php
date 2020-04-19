<?php

declare(strict_types=1);

namespace CubitD\C4\Shapes\Svg;


use CubitD\C4\Shapes\ActorShapeType;
use CubitD\Core\Shapes\ShapeContainerInterface;
use CubitD\Svg\Elements\Path;
use CubitD\Svg\Elements\Text;

class SvgActorShape extends ActorShapeType implements ShapeContainerInterface
{
    /**
     * @var string
     */
    private $color;

    /**
     * @var string|null
     */
    private $text1;

    /**
     * @var string|null
     */
    private $text2;

    public function __construct(?string $color = null)
    {
        $this->color = $color ?? '#3333aa';
    }

    /**
     * @inheritDoc
     */
    public function setText1(?string $text): void
    {
        $this->text1 = $text;
    }

    /**
     * @inheritDoc
     */
    public function setText2(?string $text): void
    {
        $this->text2 = $text;
    }

    /**
     * @inheritDoc
     */
    public function getShapeList(): array
    {
        $out = [];
        $shape = new Path(200, 100);
        $shape->moveTo(25, 90);
        $shape->lineTo(25, 60);
        $shape->ellipticalArc(5, 5, 0, 0, 0, -5, 0, false);
        $shape->lineTo(20, 80);
        $shape->ellipticalArc(10, 30, 0, 0, 1, -10, 0, false);
        $shape->lineTo(10, 35);
        $shape->ellipticalArc(10, 10, 0, 0, 1, 5, -5, false);
        $shape->lineTo(95, 30);
        $shape->ellipticalArc(10, 10, 0, 0, 1, 0, -20, false);
        $shape->ellipticalArc(10, 10, 0, 0, 1, 0, 20, false);
        $shape->lineTo(175, 30);
        $shape->ellipticalArc(10, 10, 0, 0, 1, 5, 5, false);
        $shape->lineTo(180, 80);
        $shape->ellipticalArc(10, 30, 0, 0, 1, -10, 0, false);
        $shape->lineTo(170, 60);
        $shape->ellipticalArc(5, 5, 0, 0, 0, -5, 0, false);
        $shape->lineTo(165, 90);
        $shape->closePath();
        $shape->setFill($this->color);
        $out[] = $shape;

        if (isset($this->text1)) {
            $fontSize = 12;
            $length = \mb_strlen($this->text1, 'UTF-8');
            $x = (int) (100 - ($length / 2 * $fontSize / 2));
            $textLength = null;
            if ($x < 30) {
                $x = 30;
                $textLength = 120;
            }
            $out[] = new Text($this->text1, $x, 45, $fontSize, $textLength);
        }

        if (isset($this->text2)) {
            $fontSize = 8;
            $length = \mb_strlen($this->text2, 'UTF-8');
            $x = (int) (100 - ($length / 2 * $fontSize / 2));
            $textLength = null;
            if ($x < 30) {
                $x = 30;
                $textLength = 130;
            }
            $out[] = new Text($this->text2, $x, 80, $fontSize, $textLength);
        }

        return $out;
    }

    /**
     * @inheritDoc
     */
    public function getShapeContainer(): ShapeContainerInterface
    {
        return new self();
    }
}
