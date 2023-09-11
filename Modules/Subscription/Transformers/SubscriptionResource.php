<?php

namespace Modules\Subscription\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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
            'user_id' => $this->user_id,
            'abonnementType_id' => $this->abonnementType_id,
            'transactionID' => $this->transactionID,
            'buyerPhoneNumber' => $this->buyerPhoneNumber,
            'level_id' => $this->level_id,
            'speciality_id' => $this->speciality_id,
            'createdAt' => $this->createdAt,
            'expireAt' => $this->expireAt,
            'domain_id' => $this->domain_id,
            'domain' => $this->domain,
            'speciality' => $this->speciality,
            'level' => $this->level
        ];
    }
}
