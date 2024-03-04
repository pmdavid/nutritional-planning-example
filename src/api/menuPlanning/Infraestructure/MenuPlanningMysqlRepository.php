<?php

namespace api\menuPlanning\Infraestructure;

use api\menuPlanning\Domain\MenuPlanning;
use api\menuPlanning\Domain\MenuPlanningRepositoryInterface;

class MenuPlanningMysqlRepository implements MenuPlanningRepositoryInterface
{
    public function findLastActiveByAthleteId(int $athleteId): ?MenuPlanning
    {
        return MenuPlanning::find()
            ->where(['athlete_id' => $athleteId ])
            ->one();
    }
}
