<?php

namespace api\nutritionalArchitecture;

use api\nutritionalArchitecture\Domain\RecipeNutritionalArchitectureRepositoryInterface;

class RecipeNutritionalArchitectureMysqlRepository implements RecipeNutritionalArchitectureRepositoryInterface
{
    public function create(array $items): void
    {
        $sql = 'INSERT INTO MenuRecipeNutritionalArchitecture (
                  recipe_id, 
                  planning_id, 
                  p, 
                  hc, 
                  g, 
                  kcal,
                  created_at, 
                  updated_at) VALUES '
            . implode(',', $items);

        $query = \Yii::$app->getDb()->createCommand($sql);
        $query->execute();
    }
}
