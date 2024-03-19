<?php
namespace api\strava\infraestructure;

use api\controllers\v3\ApiV3BaseController;
use api\exceptions\InvalidAccessException;
use api\exceptions\webhook\InvalidJsonDataTypeNotFoundException;
use api\strava\Infraestructure\persistence\StravaUserAuthMysqlRepository;
use StravaWebhookHandler;

class StravaWebhookController extends ApiV3BaseController
{
    public function actionIndex()
    {
        try {
            $postData = Yii::$app->request->getRawBody();
            // ... Other irrelevant validations
            // ...

            $stravaAuthRepository = new StravaUserAuthMysqlRepository();
            $stravaWebhookHandler = new StravaWebhookHandler($stravaAuthRepository);

            $stravaWebhookHandler->handleStravaEvent($postData);

            return $this->sendResponse();

        } catch (\Exception $e) {
            return $this->handleException($e, [
                InvalidAccessException::class,
                InvalidJsonDataTypeNotFoundException::class
                // Other custom Exceptions...
            ], true);
        }
    }
}
