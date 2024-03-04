<?php
namespace api\strava\Infraestructure;

use api\controllers\v3\ApiV3BaseController;
use api\exceptions\InvalidAccessException;
use api\exceptions\webhook\InvalidJsonDataTypeNotFoundException;
use api\strava\Domain\StravaAPIClientInterface;
use api\strava\Domain\StravaUserAuthRepositoryInterface;
use StravaDeauth;

class StravaDeauthorizationController extends ApiV3BaseController
{
    private $stravaDeauth;

    public function __construct(StravaUserAuthRepositoryInterface $stravaAuthRepository, StravaAPIClientInterface $stravaAPIService)
    {
        $this->stravaDeauth = new StravaDeauth($stravaAuthRepository);

        parent::__construct();
    }

    public function actionIndex()
    {
        try {
            //$postData = Yii::$app->request->getRawBody();
            $athlete = $this->getLoggedAthlete();

            // ... Other irrelevant validations
            // ...

            // Calling use case
            $this->stravaDeauth->deauthorize($athlete->getId());

            return $this->sendResponse();

        } catch (\Exception $e) {
            return $this->handleException($e, [
                InvalidAccessException::class,
                InvalidJsonDataTypeNotFoundException::class
            ], true);
        }
    }
}
