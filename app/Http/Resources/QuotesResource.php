<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuotesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'author' => $this['author'],
            'content' => $this['content'],
            /**
             * The content of category.
             * @var array
             */
            'category' => $this['category'],
        ];
    }
}
