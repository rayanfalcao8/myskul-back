<?php

namespace Modules\Quiz\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class PropositionResource extends JsonResource
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'isCorrect' => (bool)$this->pivot->isCorrect,
        ];
    }
}
