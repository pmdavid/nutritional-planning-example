<?php
namespace api\traits;

use Yii;

trait YiiResponseTrait
{
    protected function handleException(\Exception $e, array $exceptionsAllowed, bool $notify = false): \yii\base\Response
    {
        $isAllowed = in_array(get_class($e), $exceptionsAllowed);

        if (!$isAllowed || $notify) {
            Yii::error("Controller exception: " . $e->getTraceAsString() . ". Message: " . print_r($e->getMessage(), true));
        }

        $statusCode = $e->getCode() && $e->getCode() >= 100 && $e->getCode() < 600? $e->getCode() : 400;
        $title = $this->getExceptionTitle($e);

        if ($isAllowed) {
            return $this->sendErrorResponse(0, $title, $e->getMessage(), $statusCode);
        } else {
            return $this->sendErrorResponse(0, $title, 'Generic error message', $statusCode);
        }
    }

    private function getExceptionTitle(\Exception $e): string
    {
        return is_subclass_of($e,'api\exceptions\CustomException') ? $e->getTitle() : 'Error';
    }

    protected function sendResponse($data = [], array $notification = []): Response
    {
        $response = new Response();
        $response->result = ['resultCode'=> 0, 'resultDescription'=>'OK'];
        $response->data = $data;
        $response->notification = $notification;
        Yii::$app->response->format = 'json';

        return $response;
    }


    protected function sendErrorResponse(int $resultCode, string $title, string $message, int $statusCode = 400): \yii\base\Response
    {
        $response = Yii::$app->getResponse();
        $response->setStatusCode($statusCode);
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = [
            'result' => [ 'resultCode' => $resultCode, 'resultDescription' => 'KO'],
            'data' => [ 'title' => $title, 'message' => $message ],
        ];

        return $response;
    }
}
