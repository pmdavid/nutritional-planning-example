<?php declare(strict_types=1);

namespace api\events;

class MenuPlanningUpdated extends DomainEvent
{
    public function __construct(
        string  $uuid,
        int     $menuPlanningId,
        string  $athleteUuid,
        string  $mode
    )
    {
        $body = json_encode([
            'uuid'                  => $uuid,
            'menuPlanningId'        => $menuPlanningId,
            'athleteUuid'           => $athleteUuid,
            'mode'                  => $mode
        ]);

        parent::__construct($uuid, $body);
    }

    public function name(): string
    {
        return 'event.menu_planning_updated';
    }
}
