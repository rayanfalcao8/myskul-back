<?php

namespace Modules\Quiz\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Http\Controllers\Api\CoreController;
use Modules\Quiz\Entities\Question;
use Modules\Quiz\Transformers\QuestionResource;

class QuestionController extends CoreController
{
    public function index()
    {
        return $this->successResponse("got all questions successfully", [
            'questions' => QuestionResource::collection(Question::all())
        ]);
    }

    public function getByTheme($id)
    {
        return $this->successResponse("got all theme questions successfully", [
            'questions' => QuestionResource::collection(Question::where('theme_id', $id)->get())
        ]);
    }

    public function show($id)
    {
        return $this->successResponse("got question successfully", [
            'question' => new QuestionResource(Question::findOrFail($id))
        ]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
