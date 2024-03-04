<?php

namespace api\menuPlanning\Domain;

final class MenuRecipe extends ORMName
{
    protected $table = 'menu_recipe';
    //* Some extra orm settings */

    private $id;
    private $recipeId;
    private $menuPlanningId;

    public function __construct(int $id, string $mode)
    {
        $this->id             = $id;
        $this->recipeId       = $id;
        $this->menuPlanningId = $mode;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRecipeId(): int
    {
        return $this->recipeId;
    }

    public function getMenuPlanningId(): int
    {
        return $this->menuPlanningId;
    }

}

