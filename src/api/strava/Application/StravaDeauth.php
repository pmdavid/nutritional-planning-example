<?php

use api\strava\Domain\StravaDeauthorizationService;
use api\strava\Domain\StravaUserAuthRepositoryInterface;

class StravaDeauth
{
    private $stravaDeauthorizationService;

    public function __construct(StravaUserAuthRepositoryInterface $stravaAuthRepository)
    {
        $this->stravaDeauthorizationService = new StravaDeauthorizationService($stravaAuthRepository);
    }

    public function deauthorize(int $athleteId): void
    {
        $this->stravaDeauthorizationService->deauthorize($athleteId);
    }
}
