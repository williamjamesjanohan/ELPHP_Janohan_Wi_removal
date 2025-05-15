<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends BaseController
{
    /**
     * Display a listing of recipes.
     */
    public function index()
    {
        $recipes = Recipe::with('user')->get();

        if ($recipes->isEmpty()) {
            return $this->sendResponse([], 'No recipes found.');
        }

        return $this->sendResponse($recipes, 'Recipes retrieved successfully.');
    }

    /**
     * Store a newly created recipe.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ingredients' => 'required|string',
            'instructions' => 'required|string',
        ]);

        $recipe = Auth::user()->recipes()->create($validated);

        return $this->sendResponse($recipe, 'Recipe created successfully.');
    }

    /**
     * Display the specified recipe.
     *
     * @param mixed $id
     */
    public function show($id)
    {
        $recipe = Recipe::with('user')->find($id);

        if (!$recipe) {
            return $this->sendError('Not Found', ['error' => 'Recipe not found.'], 404);
        }

        return $this->sendResponse($recipe, 'Recipe retrieved successfully.');
    }

    /**
     * Update the specified recipe.
     *
     * @param mixed $id
     */
    public function update(Request $request, $id)
    {
        $recipe = Recipe::find($id);

        if (!$recipe) {
            return $this->sendError('Not Found', ['error' => 'Recipe not found.'], 404);
        }

        if ($recipe->user_id !== Auth::id()) {
            return $this->sendError('Unauthorized', ['error' => 'You are not allowed to update this recipe.'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ingredients' => 'required|string',
            'instructions' => 'required|string',
        ]);

        $recipe->update($validated);

        return $this->sendResponse($recipe, 'Recipe updated successfully.');
    }

    /**
     * Remove the specified recipe.
     *
     * @param mixed $id
     */
    public function destroy($id)
    {
        $recipe = Recipe::find($id);

        if (!$recipe) {
            return $this->sendError('Not Found', ['error' => 'Recipe not found.'], 404);
        }

        if ($recipe->user_id !== Auth::id()) {
            return $this->sendError('Unauthorized', ['error' => 'You are not allowed to delete this recipe.'], 403);
        }

        $recipe->delete();

        return $this->sendResponse([], 'Recipe deleted successfully.');
    }
}
