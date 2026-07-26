<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class PostListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $except = $this->content
            |> strip_tags(...)
            |> (fn($str) => html_entity_decode($str, ENT_QUOTES | ENT_HTML5, 'UTF-8'))
            |> (fn($str) => Str::limit($str, 150));

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'author_id' => $this->author_id,
            'author' => $this->whenLoaded('author'),
            'title' => $this->title,
            'content' => $except,
            'tags' => $this->whenLoaded('tags'),
            'hidden' => $this->hidden,
            'created_at' => $this->created_at,
        ];
    }
}
