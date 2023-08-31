<?php

namespace Modules\Quiz\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\User\Entities\User;

class ScoreController extends CoreController
{
    public function leaderboard(Request $request) {
        $users = User::query()
            ->when($request->level_id, function ($query) use ($request) {
                return $query->where('level_id', $request->level_id);
            })
            ->when($request->speciality_id, function ($query) use ($request) {
                return $query->where('speciality_id', $request->speciality_id);
            })
            ->get()
            ->map(function ($user) {
                $user->score = $user->score();
                return $user;
            })
            ->sortByDesc(function ($user) {
                return $user['score'];
            })->values();
        return $this->successResponse("Got leaderboard", [
            'leaderboard' => $users,
            'position' => $users->search(function($user) use ($request) {
                return $user->id === $request->user()->id;
            }) + 1,
        ]);
    }
    public function score(Request $request) {
        return $this->successResponse("Got user score", [
            'score' =>$request->user()
                ->score(isset($request->theme_id) ? $request->theme_id : null)
        ]);
    }
}
