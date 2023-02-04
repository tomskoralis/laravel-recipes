<?php

namespace App\Http\Resources;

use App\Models\Recipe;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeCardResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var Recipe $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
        ];
    }
}
