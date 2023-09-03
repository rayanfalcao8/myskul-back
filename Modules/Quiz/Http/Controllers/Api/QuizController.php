<?php

namespace Modules\Quiz\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\Quiz\Entities\UserTheme;
use Modules\Quiz\Transformers\AnsweredQuestionResource;
use Modules\Quiz\Transformers\QuizResource;
use Modules\User\Entities\User;

class QuizController extends CoreController
{
    public function index(Request $request)
    {
        return $this->successResponse("Got quiz list", [
            'quizzes' => QuizResource::collection(UserTheme::paginate(10))
        ]);
    }

    public function getByUser(Request $request)
    {
        return $this->successResponse("Got user quiz list", [
            'quizzes' => QuizResource::collection($request->user()->quizzes)
        ]);
    }

    public function store(Request $request)
    {
        $data = array_filter([
            'done' => true,
            'score' => $request->score,
            'theme_id' => $request->theme_id,
            'user_id' => $request->user()->id,
        ]);

        $quiz = UserTheme::create($data);

        return $this->successResponse('User answered quiz', [
            'quiz' => new QuizResource($quiz)
        ]);
    }

    public function show($id)
    {
        return $this->successResponse('User answered quiz', [
            'quiz' => new QuizResource(UserTheme::find($id))
        ]);
    }

    public function update(Request $request, $id)
    {
        $quiz = UserTheme::find($id);
        $data = array_filter([
            'done' => true,
            'score' => $request->score,
            'theme_id' => $request->theme_id,
            'user_id' => $request->user()->id,
        ]);

        $quiz->update($data);

        return $this->successResponse('User updated quiz', [
            'quiz' => new QuizResource($quiz)
        ]);
    }

    public function getAnsweredQuestions(Request $request)
    {
        return $this->successResponse("User answered questions", [
            'answers' => AnsweredQuestionResource::collection($request->user()->answers
                            ->when($request->theme_id, function ($query, $theme_id) {
                                return $query->where('theme_id', $theme_id);
                            })
                            ->when($request->question_id, function ($query, $question_id) {
                                return $query->where('id', $question_id);
                            }))
        ]);
    }
}
