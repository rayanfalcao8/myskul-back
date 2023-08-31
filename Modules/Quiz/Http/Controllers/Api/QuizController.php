<?php

namespace Modules\Quiz\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\Quiz\Entities\UserTheme;
use Modules\Quiz\Transformers\QuizResource;

class QuizController extends CoreController
{
    public function index(Request $request)
    {
        return $this->successResponse("Got quiz list", [
            'quizzes' => QuizResource::collection(UserTheme::all())
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

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
