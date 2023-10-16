<?php

namespace Modules\Authentication\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Subscription\Transformers\SubscriptionResource;

class AuthenticateUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name'  => $this->name,
            'username'  => $this->username,
            'email' => $this->email,
            'gender' => $this->gender,
            'phoneNumber' => $this->phoneNumber,
            'birthdate' => $this->birthdate,
            'email_verified_at' => $this->email_verified_at,
            'phone_number_verified_at' => $this->phone_number_verified_at,
            'timezone' => $this->timezone,
            'language' => $this->language,
            'status' => $this->status,
            'town' => $this->town,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'profile_image' => $this->avatarURL,
            'fcm_token' => $this->fcm_token,
            'level' => $this->level,
            'speciality' => $this->speciality,
            'school' => $this->school,
            'domain' => $this->domains,
            'subscriptions' => SubscriptionResource::collection($this->subscriptions),

//            'roles' => $this->userRoles(),
//            'permissions' => $this->userPermissions(),
        ];
    }
}
