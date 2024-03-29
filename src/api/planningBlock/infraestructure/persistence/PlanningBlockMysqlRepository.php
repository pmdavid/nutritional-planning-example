<?php


namespace api\planningBlock\infraestructure\persistence;


use api\planningBlock\Domain\PlanningBlock;
use api\planningBlock\infraestructure\BaseRepository;
use PlanningBlockRepositoryInterface;

class PlanningBlockMysqlRepository extends BaseRepository implements PlanningBlockRepositoryInterface
{
    public function findBlocksByMenuPlanningIdAndWeeks(int $menuPlanningId): array
    {
        return PlanningBlock::find()
            ->innerJoin('MenuRecipe', 'MenuRecipe.menu_recipe_id = PlanificationBlock.menu_recipe_id')
            ->where([
                'MenuRecipe.menu_planning_id' => $menuPlanningId,
            ])
            ->all();
    }
}
