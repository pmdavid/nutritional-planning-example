<?php

use api\exceptions\webhook\InvalidJsonDataTypeNotFoundException;
use api\strava\Domain\StravaDeauthorizationService;
use api\strava\Domain\StravaUserAuthRepositoryInterface;

class StravaWebhookHandler
{
    private $stravaDeauthorizeService;

    public function __construct(StravaUserAuthRepositoryInterface $stravaAuthRepository)
    {
        $this->stravaDeauthorizeService = new StravaDeauthorizationService($stravaAuthRepository);
    }

    public function handleStravaEvent(array $requestData): void
    {
        switch ($requestData['object_type'])
        {
            case 'deauthorization':
                $this->stravaDeauthorizeService->webhookDeauthorize($requestData);
                break;
            default:
                throw new InvalidJsonDataTypeNotFoundException();
        }
    }
}
