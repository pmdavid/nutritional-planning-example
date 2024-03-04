<?php

namespace api\menuPlanning\Domain;

interface MenuPlanningRepositoryInterface
{
    public function findLastActiveByAthleteId(int $athleteId): ?MenuPlanning;
}
