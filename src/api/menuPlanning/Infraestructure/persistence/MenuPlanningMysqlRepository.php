<?php

namespace api\menuPlanning\Infraestructure\persistence;

use api\menuPlanning\Domain\MenuPlanning;
use api\menuPlanning\Domain\MenuPlanningRepositoryInterface;

/*
 * IMPORTANT: Using a framework, we would obviously use the ORM here (Doctrine, Eloquent...) to handle the persistence.
 * Example with Doctrine:
 *  class DoctrineMenuPlanningRepository extends DoctrineRepository implements MenuPlanningRepositoryInterface
 *
 */
class MenuPlanningMysqlRepository implements MenuPlanningRepositoryInterface
{
    public function findLastActiveByAthleteId(int $athleteId): ?MenuPlanning
    {
        return MenuPlanning::find()
            ->where(['athlete_id' => $athleteId ])
            ->one();
    }
}
