<?php

namespace Modules\Quiz\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class QuizResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'done' => $this->done,
            'score' => $this->score,
            'theme_id' => $this->theme_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'user' => $this->user,
            'theme' => $this->theme,
            'questions' => QuestionResource::collection($this->questions)
        ];
    }
}
