<?php

namespace api\strava\Domain;

use api\strava\Domain\StravaUserAuth;

interface StravaUserAuthRepositoryInterface
{

    public function findOneByStravaAthleteId(int $athleteId): ?StravaUserAuth;

    public function findAccessTokenByAthleteId(int $athleteId): ?StravaUserAuth;

    public function findAccessTokenByStravaAthleteId(int $athleteId): ?StravaUserAuth;

    public function removeUserAuth(StravaUserAuth $stravaUserAuth): void;
}
