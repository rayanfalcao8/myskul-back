<?php

namespace Modules\Quiz\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\Quiz\Transformers\LeaderResource;
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
            ->map(function ($user) use ($request) {
                $user->score = $user->score(isset($request->theme_id) ? $request->theme_id : null, $request->period);
                return $user;
            })
            ->sortByDesc(function ($user) {
                return $user['score'];
            })->values();
        $me = $users->search(function($user) use ($request) {
            return $user->id === $request->user()->id;
        });
        return $this->successResponse("Got leaderboard", [
            'leaderboard' => LeaderResource::collection($users),
            'position' =>  $me + 1,
            'user' => new LeaderResource($users[$me]),
        ]);
    }
    public function score(Request $request) {
        $questions = $request->user()->answers;
        return $this->successResponse("Got user score", [
            'score' => $request->user()->score(isset($request->theme_id) ? $request->theme_id : null),
            'quiz' => $request->user()->themes->count(),
            'questions' => $questions->count(),
            'correct' => $questions->filter(function ($item) {
                return $item->pivot->ok == true;
            })->count(),
            'wrong' => $questions->filter(function ($item) {
                return $item->pivot->ok == false;
            })->count()

        ]);
    }
}
