<?php

namespace Modules\User\Traits;

trait HasProfilePhoto
{
    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getAvatarURLAttribute(): string
    {
        if ($this->attributes['avatarURL'] != null || $this->attributes['avatarURL'] != "") {
            return $this->attributes['avatarURL'];
        }

        return $this->defaultAvatarURL();
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     *
     * @return string
     */
    protected function defaultAvatarURL(): string
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=226520&background=E3FFE3';
    }
}
