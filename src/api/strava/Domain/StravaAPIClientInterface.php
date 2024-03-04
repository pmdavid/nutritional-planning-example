<?php

namespace api\strava\Domain;

interface StravaAPIClientInterface
{
    public function userDeauth(string $accessToken): array;
}
