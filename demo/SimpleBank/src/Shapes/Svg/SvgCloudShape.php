<?php

declare(strict_types=1);

namespace SimpleBank\Shapes\Svg;


use CubitD\Core\Shapes\ShapeContainerInterface;
use CubitD\Svg\Elements\Path;
use CubitD\Svg\Elements\Text;
use SimpleBank\Shapes\CloudShapeType;

class SvgCloudShape extends CloudShapeType implements ShapeContainerInterface
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
        $this->color = $color ?? '#7777ff';
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
        $shape->ellipticalArc(5, 5, 0, 0, 1, 20, 75);
        $shape->ellipticalArc(15, 15, 0, 0, 1, 20, 60);
        $shape->ellipticalArc(15, 15, 0, 0, 1, 35, 40);
        $shape->ellipticalArc(20, 20, 0, 0, 1, 55, 30);
        $shape->ellipticalArc(40, 40, 0, 0, 1, 95, 30);
        $shape->ellipticalArc(80, 80, 0, 0, 1, 155, 30);
        $shape->ellipticalArc(20, 20, 0, 0, 1, 175, 40);
        $shape->ellipticalArc(20, 20, 0, 0, 1, 180, 60);
        $shape->ellipticalArc(20, 20, 0, 0, 1, 180, 80);
        $shape->ellipticalArc(40, 40, 0, 0, 1, 155, 85);
        $shape->ellipticalArc(80, 80, 0, 0, 1, 125, 90);
        $shape->ellipticalArc(80, 80, 0, 0, 1, 85, 90);
        $shape->ellipticalArc(60, 60, 0, 0, 1, 40, 90);
        $shape->ellipticalArc(20, 20, 0, 0, 1, 25, 90);
        $shape->closePath();
        $shape->setFill($this->color);
        $out[] = $shape;

        if (isset($this->text1)) {
            $fontSize = 12;
            $length = \mb_strlen($this->text1, 'UTF-8');
            $x = (int) 105 - ($length / 2 * $fontSize / 2);
            $textLength = null;
            if ($x < 40) {
                $x = 40;
                $textLength = 120;
            }
            $out[] = new Text($this->text1, $x, 45, $fontSize, $textLength);
        }

        if (isset($this->text2)) {
            $fontSize = 8;
            $length = \mb_strlen($this->text2, 'UTF-8');
            $x = (int) (100 - ($length / 2 * $fontSize / 2));
            $textLength = null;
            if ($x < 25) {
                $x = 25;
                $textLength = 150;
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
