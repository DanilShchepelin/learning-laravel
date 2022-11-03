<?php

namespace App\Http\Resources;

class ArticleResource extends Resource
{

//    public function toShortForm(): array
//    {
//        return [
//            'id' => $this->id,
//            'title' => $this->title,
//            'text' => $this->text,
//            'author' => new UserResource($this->whenLoaded('author'), self::FULL_FORM),
//            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
//        ];
//    }

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'text' => $this->text,
            'article_photo_path' => $this->article_photo_path,
            'announcement' => $this->announcement,
            'slug' => $this->slug,
//            'author' => new UserResource($this->whenLoaded('author'), self::FULL_FORM),
            'author' => new UserResource($this->whenLoaded('author')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
        ];
    }
}
