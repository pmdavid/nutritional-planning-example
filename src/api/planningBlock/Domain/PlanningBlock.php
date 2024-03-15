<?php

namespace api\planningBlock\Domain;

use api\menuPlanning\Domain\MenuRecipe;

final class PlanningBlock
{
    protected $table = 'planning_block';
    /* Some extra ORM settings
    ...
    */

    private $id;
    private $suitability;
    private $menuRecipeId;

    public function __construct(int $id, string $suitability, int $menuRecipeId)
    {
        $this->id           = $id;
        $this->suitability  = $suitability;
        $this->menuRecipeId = $menuRecipeId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSuitability(): string
    {
        return $this->suitability;
    }

    public function getMenuRecipeModel(): MenuRecipe
    {
        return $this->hasOne(MenuRecipe::class, ['menu_recipe_id' => 'menu_recipe_id']); // Example on Yii2 framework
    }
}

