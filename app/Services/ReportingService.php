<?php

namespace App\Services;

use App\User;
use App\Season;

class ReportingService {
    public function GetReports($seasonId) {
        $userIDs = User::get(['id'])->pluck('id');
        $season = Season::find($seasonId);

        $userScores = array_map(function($userID) use ($season) {
            $user = User::find($userID);
            $score = $season->getUserTotalScore($user);

            return [
                'id'    => $user['id'],
                'name'  => $user['name'],
                'score' => $score
            ];
        }, $userIDs->toArray());

        return $userScores;
    }
}