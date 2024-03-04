<?php

namespace src\api\menuPlanning\Domain;

use api\athlete\Domain\Athlete;
use api\menuPlanning\Domain\MenuPlanning;
use api\menuPlanning\Domain\MenuRecipe;
use api\nutritionalArchitecture\Domain\RecipeNutritionalArchitectureRepositoryInterface;
use api\planningBlock\Domain\PlanningBlock;
use PlanningBlockRepositoryInterface;
use src\api\planning\Domain\RecipeRecalculatorService;

class VarietyModeApplicatorService
{
    private $recipeRecalculatorService;
    private $planningBlockRepository;

    public function __construct(PlanningBlockRepositoryInterface $planningBlockRepository, RecipeNutritionalArchitectureRepositoryInterface $recipeNutritionalArchitectureRepository)
    {
        $this->planningBlockRepository    = $planningBlockRepository;
        $this->recipeRecalculatorService  = new RecipeRecalculatorService($recipeNutritionalArchitectureRepository);
    }

    public function applyVarietyMode(Athlete $athlete, MenuPlanning $menuPlanning): void
    {
        // Obtains the current blocks (meals) whose data must be updated in order to apply the new varied recipes.
        $blocksToUpdate = $this->planningBlockRepository->findBlocksByMenuPlanningIdAndWeeks($menuPlanning->getId());

        // Update the recipes of the blocks with the new varied recipes.
        $this->setVarietyRecipes($athlete, $blocksToUpdate);
    }

    private function setVarietyRecipes(Athlete $athlete, array $blocksToUpdate): void
    {
        $this->recipeRecalculatorService->clearBulkItems();

        // Start BULK process, saving the data
        $this->updateBlocksWithNewRecipes($athlete, $blocksToUpdate);

        // Finish BULK process: The data dump to DDBB is executed in one single INSERT
        $this->recipeRecalculatorService->updateAllMenuRecipeNutritionalArchitectures();
    }

    private function updateBlocksWithNewRecipes(Athlete $athlete, array $blocksToUpdate)
    {
        foreach ($blocksToUpdate as $blockToUpdate) {
            $this->setIndividualRecipeVariety($athlete, $blockToUpdate);
        }
    }

    private function setIndividualRecipeVariety(Athlete $athlete, PlanningBlock $blockToUpdate)
    {
        $alternativeRecipe = $this->getAlternativeRecipeByBlock($athlete, $blockToUpdate);

        $this->recalculateMenuRecipeByBlock($alternativeRecipe, $blockToUpdate);
    }

    /**
     * Recalculates kcal, macronutrients and other information based on the new recipe.
     */
    private function recalculateMenuRecipeByBlock(MenuRecipe $alternativeRecipe, PlanningBlock $blockToUpdate): void
    {
        $blockSuitability = $blockToUpdate->getSuitability();
        $this->recipeRecalculatorService->recalculateMenuRecipeBySuitability($alternativeRecipe, $blockToUpdate->getMenuRecipeModel(), $blockSuitability['kcal_recipe']);
    }

    private function getAlternativeRecipeByBlock(Athlete $athlete, PlanningBlock $planningBlock): ?MenuRecipe
    {
        // Process irrelevant to the example. Gets an alternative recipe to the existing one.
    }
}
