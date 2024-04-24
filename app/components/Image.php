<?php
namespace components;

use GdImage;
use JetBrains\PhpStorm\Pure;

const FILENAME = 'number';
const HEADER_CONTENT_TYPE = 'Content-Type:image/jpeg';
const SAVEPATH = './result/net.jpg';
const QUALITY = 100;
const FONT = 'fonts/Roboto-Regular.ttf';
const FONT_SIZE = 11;

const WIDTH_BOX = 200;
const HEIGHT_BOX = FONT_SIZE * 2 + 2;
const GAP_BOX_X = 20;
const GAP_BOX_Y = HEIGHT_BOX;
const UNIT_SIZE_X = WIDTH_BOX + GAP_BOX_X;
const UNIT_SIZE_Y = HEIGHT_BOX + GAP_BOX_Y;

const PADDING_LEFT_BOX = 10;
const PADDING_LEFT_BODY = 10;
const PADDING_TOP_BODY = 10;

class Image {
    private GdImage|null $img;
    private TournamentBracket|null $tournamentBracket;
    private int $colorBlack;
    private int $colorWhite;


    public function __construct()
    {
        $this->run();
    }

    public function run() {
        while(1) {
            if (file_exists(FILENAME)) {
                $numTeams =  file_get_contents(FILENAME);
                unlink(FILENAME);

                if (!is_numeric($numTeams)) {
                    continue;
                }

                $teams = Teams::generate($numTeams);
                $this->tournamentBracket = new TournamentBracket($teams);

                $width = $this->getWidth();
                $height = $this->getHeight();

                $this->img = imagecreatetruecolor($width, $height);
                $this->colorBlack = imagecolorallocate($this->img, 0, 0, 0);
                $this->colorWhite = imagecolorallocate($this->img, 255, 255, 255);

                $this->draw();
                $this->save();
                $this->clean();
            }

            sleep(1);
        }
    }

    private function draw(): void
    {
        $width = $this->getWidth();
        $height = $this->getHeight();

        $this->img = imagecreatetruecolor($width, $height);
        $this->colorBlack = imagecolorallocate($this->img, 0, 0, 0);
        $this->colorWhite = imagecolorallocate($this->img, 255, 255, 255);

        foreach ($this->tournamentBracket->getMatches() as $round => $roundMatches) {
            $this->drawRound($round, $roundMatches);
        }
    }

    private function drawRound(int $round, array $roundMatches): void
    {
        $xCoord = static::getXCoordByRound($round);

        /** @var MatchGame $match */
        foreach ($roundMatches as $order => $match) {
            $yStartCoord = static::getYStartCoordByRow($round);
            $yCoord = static::getYCoordByRow($order) + $yStartCoord;

            $box = new Box(
                $this->img,
                $match->title,
                $match->getVsText(),
                $xCoord,
                $yCoord,
                $this->colorWhite,
                $this->colorBlack
            );

            $box->draw();
        }
    }

    private function save(): void
    {
        header(HEADER_CONTENT_TYPE);
        imagejpeg($this->img, SAVEPATH,QUALITY);
    }

    private function clean(): void
    {
        $this->img = null;
        $this->tournamentBracket = null;
    }


    #[Pure] private function getWidth(): int
    {
        return $this->tournamentBracket->getNumRounds() * UNIT_SIZE_X + PADDING_LEFT_BODY;
    }

    #[Pure] private function getHeight(): int
    {
        $countTeams = $this->tournamentBracket->getNumTeams();

        return (($countTeams / 2) + $countTeams % 2)  * UNIT_SIZE_Y + PADDING_TOP_BODY;
    }

    private static function getXCoordByRound(int $round): int
    {
        return PADDING_LEFT_BODY + (($round - 1) * UNIT_SIZE_X);
    }

    private static function getYCoordByRow(int $order): int
    {
        return PADDING_TOP_BODY + ($order * UNIT_SIZE_Y);
    }

    private static function getYStartCoordByRow(int $round): int
    {
        if ($round === 1) {
            return 0;
        } elseif ($round === 2) {
            return HEIGHT_BOX;
        }

        return (HEIGHT_BOX * (int)(bool)($round - 1)) + ((HEIGHT_BOX * ($round - 2)) * (int)(bool)($round - 1));
    }
}
