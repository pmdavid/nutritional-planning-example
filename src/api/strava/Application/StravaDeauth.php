<?php

use api\strava\Domain\StravaAPIClientInterface;
use api\strava\Domain\StravaDeauthorizationService;
use api\strava\Domain\StravaUserAuthRepositoryInterface;

class StravaDeauth
{
    private $stravaDeauthorizationService;

    public function __construct(StravaUserAuthRepositoryInterface $stravaAuthRepository, StravaAPIClientInterface $stravaAPIClient)
    {
        $this->stravaDeauthorizationService = new StravaDeauthorizationService($stravaAuthRepository, $stravaAPIClient);
    }

    public function deauthorize(int $athleteId): void
    {
        $this->stravaDeauthorizationService->deauthorize($athleteId);
    }
}
