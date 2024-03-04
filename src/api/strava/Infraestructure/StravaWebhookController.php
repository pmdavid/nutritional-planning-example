<?php
namespace api\strava\infraestructure;

use api\controllers\v3\ApiV3BaseController;
use api\exceptions\InvalidAccessException;
use api\exceptions\webhook\InvalidJsonDataTypeNotFoundException;
use StravaWebhookHandler;

class StravaWebhookController extends ApiV3BaseController
{
    private $stravaWebhookService;

    public function __construct(StravaUserAuthRepositoryInterface $stravaAuthRepository)
    {
        $this->stravaWebhookService = new StravaWebhookHandler($stravaAuthRepository);

        parent::__construct();
    }

    public function actionIndex()
    {
        try {
            $postData = Yii::$app->request->getRawBody();
            // ... Other irrelevant validations
            // ...

            $this->stravaWebhookService->handleStravaEvent($postData);

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
