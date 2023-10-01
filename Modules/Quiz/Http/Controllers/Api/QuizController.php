<?php

namespace Modules\Quiz\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\Quiz\Entities\Theme;
use Modules\Quiz\Entities\UserAnswer;
use Modules\Quiz\Entities\UserTheme;
use Modules\Quiz\Transformers\AnsweredQuestionResource;
use Modules\Quiz\Transformers\QuizResource;
use Modules\Quiz\Transformers\QuizzesResource;

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
            'quizzes' => QuizzesResource::collection($request->user()->themes->merge(Theme::with('quiz','questions','speciality','level','category')->where('free', true)->get()))
        ]);
    }

    public function getByCategory(Request $request, $id)
    {
        return $this->successResponse("Got category quiz list", [
            'quizzes' => QuizzesResource::collection(
                Theme::with('quiz','questions','speciality','level','category')->where('category_id', $id)->get()
            )
        ]);
    }

    public function store(Request $request)
    {
        if($request->first){
            $data = array_filter([
                'done' => true,
                'score' => $request->score,
                'theme_id' => $request->theme_id,
                'user_id' => $request->user()->id,
            ]);
            $quiz = UserTheme::create($data);

            foreach ($request->answers as $answer) {

                UserAnswer::create([
                    'ok' => $answer['status'],
                    'question_id' => $answer['question_id'],
                    'user_id' => $request->user()->id,
                ]);
            }
        } else {
            $data = array_filter([
                'score' => $request->score,
            ]);

            $quiz = UserTheme::query()->where(['theme_id' => $request->theme_id,
                'user_id' => $request->user()->id])->first();

            $quiz->update($data);

            foreach ($request->answers as $answer) {
                UserAnswer::query()->where(['question_id' => $answer['question_id'],
                    'user_id' => $request->user()->id])->update([
                        'ok' => $answer['status'],
                    ]);
            }
        }

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
