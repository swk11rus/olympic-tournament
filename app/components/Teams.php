<?php

namespace components;

class Teams
{
    public static function generate(int $numberTeams): array
    {
        return array_map(fn($team) => "Team $team", range(1, $numberTeams));
    }
}