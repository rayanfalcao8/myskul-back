<?php

namespace Modules\Quiz\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'name' => $this->name,
            'justification' => $this->justification,
            'points' => $this->points,
            'next_id' => $this->next_id,
            'theme_id' => $this->theme_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'answers' => $this->answers,
            'theme' => $this->theme
        ];
    }
}
