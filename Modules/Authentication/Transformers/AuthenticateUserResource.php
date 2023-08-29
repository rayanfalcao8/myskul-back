<?php

namespace Modules\Authentication\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'roles' => $this->userRoles(),
            'permissions' => $this->userPermissions(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'profile_image' => $this->avatarURL,
        ];
    }
}
