<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeCardResource;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RecipesController extends Controller
{
    private const RECIPES_PER_PAGE = 20;

    public function index(): AnonymousResourceCollection
    {
        $recipes = Recipe::orderByDesc('id')
            ->paginate(self::RECIPES_PER_PAGE);

        return RecipeCardResource::collection($recipes);
    }

    public function show(Recipe $recipe): RecipeResource
    {
        return new RecipeResource($recipe);
    }

    public function store(Request $request): RecipeResource
    {
//        $ingredients = $request->get('ingredients');
//        if (!$this->areIngredientsValid($ingredients)) {
//            return response()->json([
//                'message' => 'Recipe must have at least 1 ingredient and each ingredient must have a name and amount!',
//            ], 400);
//        }

        $recipe = (new Recipe())->fill([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'instructions' => $request->get('instructions'),
            'image' => $request->get('image'),
        ]);
        $recipe->save();

        $recipe->ingredients()->createMany($request->get('ingredients'));

        return new RecipeResource($recipe);
    }

    public function update(Recipe $recipe, Request $request): RecipeResource
    {
//        $ingredients = $request->get('ingredients');
//        if (!$this->areIngredientsValid($ingredients)) {
//            return response()->json([
//                'message' => 'Recipe must have at least 1 ingredient and each ingredient must have a name and amount!',
//            ], 400);
//        }

        $recipe = $recipe->fill([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'instructions' => $request->get('instructions'),
            'image' => $request->get('image'),
        ]);
        $recipe->save();

        $recipe->ingredients()->delete();
        $recipe->ingredients()->createMany($request->get('ingredients'));

        return new RecipeResource($recipe);
    }

    public function destroy(Recipe $recipe): JsonResponse
    {
        $recipe->ingredients()->delete();
        $recipe->delete();

        return response()->json([], 204);
    }

//    private function areIngredientsValid($ingredients): bool
//    {
//        if (!$ingredients || count($ingredients) === 0) {
//            return false;
//        }
//
//        foreach ($ingredients as $ingredient) {
//            if (
//                !isset($ingredient['name']) ||
//                !$ingredient['name'] ||
//                !isset($ingredient['amount']) ||
//                !$ingredient['amount']
//            ) {
//                return false;
//            }
//        }
//        return true;
//    }
}
