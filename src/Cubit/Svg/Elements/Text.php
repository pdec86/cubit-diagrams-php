<?php

declare(strict_types=1);

namespace CubitD\Svg\Elements;


use CubitD\Core\Components\Boundary;
use CubitD\Core\Shapes\ShapeInterface;

class Text implements ShapeInterface
{
    /**
     * @var string
     */
    private $text;

    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

    /**
     * @var int
     */
    private $fontSize;

    /**
     * @var string
     */
    private $fontStyle;

    /**
     * @var string
     */
    private $fontColor;

    /**
     * @var int|null
     */
    private $textLength;

    /**
     * Text constructor.
     * @param string $text
     * @param int $x
     * @param int $y
     * @param int $fontSize
     * @param int|null $textLength
     * @param string $fontStyle
     * @param string $fontColor
     */
    public function __construct(string $text, int $x, int $y, int $fontSize, ?int $textLength,
                                string $fontStyle = 'sans-serif', string $fontColor = '#ffffff')
    {
        $this->text = $text;
        $this->x = $x;
        $this->y = $y;
        $this->fontSize = $fontSize;
        $this->textLength = $textLength;
        $this->fontStyle = $fontStyle;
        $this->fontColor = $fontColor;
    }

    /**
     * @inheritDoc
     */
    public function getBoundaries(): Boundary
    {
        // @TODO - calculate width and height
        return new Boundary($this->x, $this->y, 200, 100);
    }

    /**
     * @inheritDoc
     */
    public function move(int $x, int $y): void
    {
        $this->x += $x;
        $this->y += $y;
    }

    /**
     * @inheritDoc
     */
    public function scale(float $scale): void
    {
        $this->x *= $scale;
        $this->y *= $scale;
        $this->fontSize *= $scale;
        $this->textLength *= $scale;
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $style = "font: {$this->fontSize}px $this->fontStyle;";
        $textLength = isset($this->textLength) ? "textLength='$this->textLength'" : '';
        $lengthAdjust = !empty($textLength) ? "lengthAdjust='spacingAndGlyphs'" : '';
        return "<text x='$this->x' y='$this->y' fill='$this->fontColor' $textLength $lengthAdjust "
            . " style='$style'>$this->text</text>";
    }
}
