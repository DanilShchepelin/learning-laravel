<?php

namespace App\Http\Resources;

class UserResource extends Resource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'biography' => $this->biography,
            'slug' => $this->slug,
        ];
    }

//    public function toShortForm(): array
//    {
//        return [
//            'id' => $this->id,
//            'name' => $this->name,
//            'email' => $this->email,
//        ];
//    }


}
