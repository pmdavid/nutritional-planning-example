<?php


namespace api\nutritionalArchitecture\Domain;


class MenuRecipeNutritionalArchitectureCreator
{
    private $recipeNutritionalArchitectureRepository;

    public function __construct(RecipeNutritionalArchitectureRepositoryInterface $recipeNutritionalArchitectureRepository)
    {
        $this->recipeNutritionalArchitectureRepository = $recipeNutritionalArchitectureRepository;
    }

    public function createBulk(array $menuRecipeNutritionalArchitectures): void
    {
        $items = [];

        foreach ($menuRecipeNutritionalArchitectures as $menuRecipeNutritionalArchitecture) {
            $key = $this->getKeyByFields($menuRecipeNutritionalArchitecture);
            $items[$key] = $this->getRecipeNutritionalArchitectureSqlByFields($menuRecipeNutritionalArchitecture);
        }

        $this->recipeNutritionalArchitectureRepository->create($items);
    }

    private function getKeyByFields(array $recipeNutritionalArchitecture): string
    {
        return $recipeNutritionalArchitecture['recipe_id'];
    }

    private function getRecipeNutritionalArchitectureSqlByFields(array $menuRecipeNutritionalArchitecture): string
    {
        return '(' . $menuRecipeNutritionalArchitecture['recipe_id'] . ','
            . $menuRecipeNutritionalArchitecture['planning_id'] . ','
            . $menuRecipeNutritionalArchitecture['p'] . ','
            . $menuRecipeNutritionalArchitecture['hc'] . ','
            . $menuRecipeNutritionalArchitecture['g'] . ','
            . $menuRecipeNutritionalArchitecture['kcal'] . ',NOW(),NOW())';
    }
}
