<?php

namespace Modules\Quiz\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class QuizzesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $data = $this->quiz->where('user_id', $request->user()->id)->first();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'free' => $this->free,
            'score' => $data->score,
            'done' => $data->done,
            'category_id' => $this->category_id,
            'level_id' => $this->level_id,
            'speciality_id' => $this->speciality_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'nb_questions' => $this->questions->count(),
            'speciality' => $this->speciality,
            'level' => $this->level,
            'category' => $this->category,
        ];
    }
}
