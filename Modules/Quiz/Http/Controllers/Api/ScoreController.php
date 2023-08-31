<?php

namespace Modules\Quiz\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\User\Entities\User;

class ScoreController extends CoreController
{
    public function leaderboard(Request $request) {
        return $this->successResponse("Got leaderboard", [
            'leaderboard' => User::query()
                ->when($request->level_id, function ($query) use ($request) {
                    return $query->where('level_id', $request->level_id);
                })
                ->when($request->speciality_id, function ($query) use ($request) {
                    return $query->where('speciality_id', $request->speciality_id);
                })
                ->get()->map(function ($user) {
                    return [
                        'user' => $user,
                        'score' => $user->score(),
                    ];
                })->sortByDesc(function ($user) {
                    return $user['score'];
                })
        ]);
    }
    public function score(Request $request) {
        return $this->successResponse("Got user score", [
            'score' =>$request->user()
                ->score(isset($request->theme_id) ? $request->theme_id : null)
        ]);
    }
}
