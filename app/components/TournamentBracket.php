<?php

namespace components;

class TournamentBracket
{
    private array $teams;
    private array $matches;

    public function __construct($teams)
    {
        $this->teams = $teams;
        $this->matches = [];
        $this->generateMatches();
    }

    public function generateMatches()
    {
        $teams = $this->teams;

        $matchCounter = 1;

        for ($round = 1; $round <= $this->getNumRounds(); $round++) {
            $nextRoundTeams = [];


            while (count($teams) > 1) {
                $team1 = array_shift($teams);
                $team2 = array_shift($teams);

                $this->matches[$round][] = new MatchGame(
                    "Матч $matchCounter",
                    $team1,
                    $team2,
                );

                $nextRoundTeams[] = "Winner $matchCounter";
                $matchCounter++;
            }

            $teams = array_merge($nextRoundTeams, $teams);
        }
    }

    public function getMatches(): array
    {
        return $this->matches;
    }

    public function getNumRounds(): int
    {
        return (int)ceil(log(count($this->teams), 2));
    }

    public function getNumTeams(): int
    {
        return count($this->teams);
    }
}