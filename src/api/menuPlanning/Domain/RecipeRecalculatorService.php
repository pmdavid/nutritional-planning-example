<?php
namespace src\api\planning\Domain;

use api\menuPlanning\Domain\MenuRecipe;
use api\nutritionalArchitecture\Domain\MenuRecipeNutritionalArchitectureCreator;
use api\nutritionalArchitecture\Domain\RecipeNutritionalArchitectureRepositoryInterface;

class RecipeRecalculatorService
{
    private $newMenuRecipeNutritionalArchitectures = [];
    private $menuRecipeNutritionalArchitectureCreator;

    public function __construct(RecipeNutritionalArchitectureRepositoryInterface $recipeNutritionalArchitectureRepository)
    {
        $this->menuRecipeNutritionalArchitectureCreator = new MenuRecipeNutritionalArchitectureCreator($recipeNutritionalArchitectureRepository);
    }

    public function clearBulkItems(): void
    {
        $this->newMenuRecipeNutritionalArchitectures = [];
    }

    private function addNewNutritionalArcToBulk(MenuRecipe $menuRecipe, array $recipeRecalculatedData): void
    {
        $this->newMenuRecipeNutritionalArchitectures[] = [
            'recipe_id'                 => $menuRecipe->getRecipeId(),
            'planification_id'           => $menuRecipe->getMenuPlanningId(),
            'p'                         => $recipeRecalculatedData["macros"]['p'],
            'hc'                        => $recipeRecalculatedData["macros"]['h'],
            'g'                         => $recipeRecalculatedData["macros"]['g'],
            'kcal'                      => $recipeRecalculatedData["macros"]['total_kcal'],
        ];
    }

    public function updateAllMenuRecipeNutritionalArchitectures(): void
    {
        if (empty($this->newMenuRecipeNutritionalArchitectures)) {
            return;
        }

        $this->menuRecipeNutritionalArchitectureCreator->createBulk($this->newMenuRecipeNutritionalArchitectures);
    }

    public function recalculateMenuRecipeBySuitability(MenuRecipe $menuRecipe, MenuRecipe $originalMenuRecipe, int $suitableKcal): void
    {
        // Some irrelevant calculations about the recipe, services deleted to simplify the project
        $recipeRecalculated = $this->recipeIngredientsRecalculatorService->realculateBySuitableKcal($menuRecipe, $suitableKcal);
        $recipeRecalculated = $this->recipeMacronutrientsRecalculatorServices->realculateBySuitableKcal($recipeRecalculated, $suitableKcal);

        $this->updateRecipeData($recipeRecalculated, $originalMenuRecipe);
    }

    /*
     * Adding data to the bulk to later save the data in a single INSERT
     */
    private function updateRecipeData(array $recipeRecalculated, MenuRecipe $originalMenuRecipe): void
    {
        $this->addNewNutritionalArcToBulk($originalMenuRecipe, $recipeRecalculated['recipe']);

        // ... Other possible bulks
    }
}
