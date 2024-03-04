<?php

namespace api\strava\Infraestructure;

use api\strava\Domain\StravaUserAuth;
use api\strava\Domain\StravaUserAuthRepositoryInterface;

class StravaUserAuthMysqlRepository implements StravaUserAuthRepositoryInterface
{
    public function findOneByStravaAthleteId(int $athleteId): ?StravaUserAuth
    {
        return StravaUserAuth::findOne(['athlete_id' => $athleteId]);
    }

    public function findAccessTokenByAthleteId(int $athleteId): string
    {
        return StravaUserAuth::findOne(['athlete_id' => $athleteId])->getAccessToken();
    }

    public function findAccessTokenByStravaAthleteId(int $stravaAthleteId): string
    {
        return StravaUserAuth::findOne(['strava_athlete_id' => $stravaAthleteId])->getAccessToken();
    }

    public function removeUserAuth(StravaUserAuth $stravaUserAuth): void
    {
        $stravaUserAuth->delete();
        // Symfony: $entityManager->remove($stravaUserAuth);
    }
}
