<?php

namespace api\events;

use api\athlete\Domain\Athlete;
use api\events\MenuPlanningUpdated;
use api\menuPlanning\Domain\MenuPlanning;

class MenuPlanningEventBuilder
{
    public function buildEvent(MenuPlanning $menuPlanning, Athlete $athlete, string $mode): MenuPlanningUpdated
    {
        return new MenuPlanningUpdated(
            $menuPlanning->getUuid(),
            $menuPlanning->getId(),
            $athlete->getUuid(),
            $mode
        );
    }
}

