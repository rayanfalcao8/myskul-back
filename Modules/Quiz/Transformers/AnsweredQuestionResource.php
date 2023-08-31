<?php

namespace Modules\Quiz\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AnsweredQuestionResource extends JsonResource
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
            'theme' => $this->theme,
            'ok' => (bool)$this->pivot->ok
        ];
    }
}
