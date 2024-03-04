<?php

namespace api\strava\Infraestructure;

use api\strava\Domain\StravaAPIClientInterface;

class StravaAPIClient implements StravaAPIClientInterface
{
    private $oauthUrl;

    public function __construct()
    {
        $this->oauthUrl = Yii::$app->params["strava_deauthorization_endpoint"];
    }

    public function userDeauth(string $accessToken): array
    {
        $authorization = 'Authorization: Bearer ' . $accessToken;

        $c = curl_init($this->oauthUrl);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        $result = curl_exec($c);
        curl_close($c);

        return json_decode($result, true);
    }
}
