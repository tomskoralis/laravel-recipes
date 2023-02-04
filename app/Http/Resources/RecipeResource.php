<?php

namespace App\Http\Resources;

use App\Models\Recipe;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    public function toArray($request): array
    {
        /** @var Recipe $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'instructions' => $this->instructions,
            'ingredients' => IngredientResource::collection(
                $this->ingredients()->get()
            ),
            'image' => $this->image,
            'created_at' => $this->created_at->format('d/m/Y G:i') . ' UTC',
        ];
    }
}
