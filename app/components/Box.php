<?php

namespace components;

use GdImage;

class Box
{
    public GdImage $img;
    public string $title;
    public string $vsText;
    public int $x1;
    public int $y1;
    public int $x2;
    public int $y2;
    public int $textX;
    public int $textY;
    public int $backgroundColor;
    public int $textColor;

    public function __construct(
        GdImage $img,
        string  $title,
        string  $vsText,
        int     $x1,
        int     $y1,
        int     $backgroundColor,
        int     $textColor,
    )
    {
        $this->img = $img;
        $this->title = $title;
        $this->vsText = $vsText;
        $this->backgroundColor = $backgroundColor;
        $this->textColor = $textColor;

        $this->x1 = $x1;
        $this->y1 = $y1;
        $this->x2 = $x1 + WIDTH_BOX;
        $this->y2 = $y1 + HEIGHT_BOX;

        $this->textX = $x1 + PADDING_LEFT_BOX;
        $this->textY = $this->y2;
    }

    public function draw(): void
    {
        $this->drawBox();
        $this->type();
    }

    private function drawBox(): void
    {
        imagefilledrectangle(
            $this->img,
            $this->x1,
            $this->y1,
            $this->x2,
            $this->y2,
            $this->backgroundColor
        );
    }

    private function type(): void
    {
        imagettftext(
            $this->img,
            FONT_SIZE,
            0,
            $this->textX,
            $this->textY,
            $this->textColor,
            FONT,
            "$this->vsText"
        );
        imagettftext(
            $this->img,
            FONT_SIZE,
            0,
            $this->textX,
            $this->textY - FONT_SIZE - 2,
            $this->textColor,
            FONT,
            "$this->title"
        );
    }
}
