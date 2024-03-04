<?php

namespace api\strava\Domain;

use api\strava\Domain\StravaUserAuthRepositoryInterface;
use Yii;

class StravaDeauthorizationService
{
    private $stravaAuthRepository;
    private $stravaAPIClient;

    public function __construct(StravaUserAuthRepositoryInterface $stravaAuthRepository, StravaAPIClientInterface $stravaAPIClient = null)
    {
        $this->stravaAuthRepository     = $stravaAuthRepository;
        $this->stravaAPIClient          = $stravaAPIClient;
    }

    /**
     * Case of deauth performed by the user from Strava, where we get the callback from the webhook and we apply
     * the deauth on our platform (auth deletion on out auth table)
     */
    public function webhookDeauthorize(array $data): void
    {
        if ($data['authorized'] === true) {
            return;
        }

        $stravaUserAuth = $this->stravaAuthRepository->findOneByStravaAthleteId($data['strava_athlete_id']);
        if (!$stravaUserAuth) {
            return;
        }

        $this->stravaAuthRepository->removeUserAuth($stravaUserAuth);
    }

    /**
     * Case of deauth performed by the user from our platform.
     */
    public function deauthorize(int $userId): void
    {
        // Irrelevant checks...
        // ...

        $userAccessToken = $this->stravaAuthRepository->findAccessTokenByAthleteId($userId);
        $response        = $this->stravaAPIClient->userDeauth($userAccessToken);

        // ... Some checks of the response data received from Strava, throw custom exceptions, etc...
    }

}
