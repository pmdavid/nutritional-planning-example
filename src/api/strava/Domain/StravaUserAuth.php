<?php

namespace api\strava\Domain;


final class StravaUserAuth extends ORMName
{
    protected $table = 'strava_user_auth';
    /* Some extra ORM settings
    ...
    */

    private $id;
    private $accessToken;

    public function __construct(int $id, string $suitability, int $menuRecipeId, string $accessToken)
    {
        $this->id = $id;
        $this->accessToken = $accessToken;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

}

