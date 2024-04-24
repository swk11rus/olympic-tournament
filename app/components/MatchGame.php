<?php

namespace components;

class MatchGame
{
    public string $title;
    public string $team1;
    public string $team2;

    public function __construct(string $title, string $team1, string $team2)
    {
        $this->title = $title;
        $this->team1 = $team1;
        $this->team2 = $team2;
    }

    public function getVsText(): string
    {
        return sprintf("[%s vs. %s]", $this->team1, $this->team2);
    }
}