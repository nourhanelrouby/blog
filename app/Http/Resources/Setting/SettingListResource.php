<?php

namespace App\Http\Resources\Setting;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,      // auto-translated
            'content'   => $this->content,   // auto-translated
            'address'   => $this->address,   // auto-translated

            'logo'      => url('storage/' . $this->logo),
            'favicon'   => url('storage/' . $this->favicon),
            'facebook'  => $this->facebook,
            'instagram' => $this->instagram,
            'twitter'   => $this->twitter,
            'linkedin'  => $this->linkedin,
            'phone'     => $this->phone,
            'email'     => $this->email,
        ];
    }
}
