<?php
namespace Base\Factories;
require_once __DIR__.'/../../vendor/autoload.php';

use Base\Factories\Factory;
use Base\Models\Meal;
use Base\Repositories\RecipeRepository;

class MealFactory extends Factory {

    private $recipeRepository;

    public function __construct($recipeRepository){
        $this->recipeRepository = $recipeRepository;

    }

    /**
     * Instantiate Meal
     * @param  array $mealArray     Array of data for a meal
     * @return Meal                 A meal object
     */
    public function make($mealArray):Meal
    {
        $recipe = $this->recipeRepository->find($mealArray['recipeId']);

        $newMeal = new Meal($recipe,$mealArray['date'],$mealArray['scaleFactor']);
        if(isset($mealArray['id'])){
            $newMeal->setId($mealArray['id']);
        }

        return $newMeal;
    }

}
