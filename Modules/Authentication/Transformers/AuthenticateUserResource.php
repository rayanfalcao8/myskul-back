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
            'email' => $this->email,
            'phone_number' => $this->phoneNumber,
            'account_type' => $this->account_type,
            'timezone' => $this->timezone,
            'email_verified_at' => $this->email_verified_at,
            'roles' => $this->roles,
            'permissions' => $this->roles()
                ->with('permissions')
                ->get()
                ->pluck('permissions')
                ->collapse(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
