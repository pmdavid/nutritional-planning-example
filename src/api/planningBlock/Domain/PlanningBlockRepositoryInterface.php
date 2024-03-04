<?php

interface PlanningBlockRepositoryInterface
{
    public function findBlocksByMenuPlanningIdAndWeeks(int $menuPlanningId): array;
}
