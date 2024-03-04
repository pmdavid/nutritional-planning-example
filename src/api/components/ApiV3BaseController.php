<?php

namespace api\controllers\v3;

use api\components\ApiControllerBase;
use api\traits\YiiResponseTrait;

/**
 * Example of API Base Controller to handle authorization on the platform, CORs, timezones...
 */
class ApiV3BaseController extends ApiControllerBase
{
    use YiiResponseTrait;

    public function __construct()
    {

    }

    // Custom configuration Yii2 framework allows
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                // restrict access to
                'Origin' => [

                ],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['Origin', 'X-Requested-With', 'Content-Type', 'Accept', 'Authorization'],
            ]
        ];

        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'auth' => function($username, $password){
                $user = User::loginByAccessToken($password);
                $user = $this->attachHeaderInformationToUser($user, $password);
                return $user;
            }
        ];

        return $behaviors;
    }

    private function attachHeaderInformationToUser(?User $user, string $token): ?User
    {
        $this->setTimeZone();
        $this->setLocale();

        if (empty($user)) {
            return null;
        }

        $appBuildVersion = Yii::$app->request->getHeaders()->get('Build');
        $appPlatform = Yii::$app->request->getHeaders()->get('Platform');
        $storeCountryCode = Yii::$app->request->getHeaders()->get('Store-Country-Code');
        $user->setAppBuildVersion($appBuildVersion);
        $user->setAppPlatform($appPlatform);
        $user->setStoreCountryCode($storeCountryCode);
        $user->setAccessToken($token);

        return $user;
    }

    protected function setTimeZone(): void
    {
       // ...
    }

    private function isValidTimezone(string $timeZone): bool
    {
        $timeZoneList = timezone_identifiers_list();

        return in_array($timeZone, $timeZoneList);
    }
}
