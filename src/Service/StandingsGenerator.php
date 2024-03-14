<?php

namespace App\Service;

class StandingsGenerator
{
    private int $gamesPerDay = 3;

    public function generateStandings(array $teams): array
    {
        $teamsCount = count($teams);
        $members = 2 ** $teamsCount;

        $teamPairs = [];
        for ($i = 0; $i < $members; $i++) {
            $binaryString = sprintf('%0'.$teamsCount.'b', $i);

            $rivals = [];
            for ($j = 0; $j < $teamsCount; $j++) {
                if ('1' === $binaryString[$j]) {
                    $rivals[$j] = $teams[$j];
                }
            }

            if (count($rivals) === 2) {
                $teamPairs[] = $rivals;
            }
        }

        return $this->sortStandings($teamPairs);
    }

    private function sortStandings(array $teamPairs): array
    {
        $teamsCount = count($teamPairs);
        $daysCount = (int)round($teamsCount/$this->gamesPerDay, PHP_ROUND_HALF_UP);
        $i = 1;
        $standings = [];
        $date = new \DateTime();
        while ($i <= $daysCount) {
            $k = 1;
            $teamsListForDay = [];
            foreach ($teamPairs as $key => $teamPair) {
                if ($k > $this->gamesPerDay) {
                    break;
                }
                if (true === $this->isPairIntersectPerDay($teamsListForDay, $teamPair)) {
                    continue;
                }

                $teamsListForDay[] = $teamPair;
                unset($teamPairs[$key]);
                $k++;
            }
            $standings[$date->format('Y-m-d')] = $teamsListForDay;
            $date->modify('+1 day');
            $i++;
        }

        return $standings;
    }

    private function isPairIntersectPerDay(array $teamsListForDay, array $teamPair): bool
    {
        $intersect = false;
        foreach ($teamsListForDay as $teamForDay) {
            if (!empty(array_intersect_key($teamForDay, $teamPair))) {
                $intersect = true;
                break;
            }
        }

        return $intersect;
    }
}