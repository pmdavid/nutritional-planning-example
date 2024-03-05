<?php
namespace api\strava\Infraestructure;

use api\controllers\v3\ApiV3BaseController;
use api\exceptions\InvalidAccessException;
use api\exceptions\webhook\InvalidJsonDataTypeNotFoundException;
use StravaDeauth;

class StravaDeauthorizationController extends ApiV3BaseController
{
    public function actionIndex()
    {
        try {
            //$postData = Yii::$app->request->getRawBody();
            $athlete = $this->getLoggedAthlete();

            // ... Other irrelevant validations
            // ...

            $stravaAuthRepository = new StravaUserAuthMysqlRepository();
            $stravaAPIClient      = new StravaAPIClient();
            $stravaDeauth         = new StravaDeauth($stravaAuthRepository, $stravaAPIClient);

            // Calling use case
            $stravaDeauth->deauthorize($athlete->getId());

            return $this->sendResponse();

        } catch (\Exception $e) {
            return $this->handleException($e, [
                InvalidAccessException::class,
                InvalidJsonDataTypeNotFoundException::class
            ], true);
        }
    }
}
