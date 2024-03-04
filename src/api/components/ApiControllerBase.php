<?php

namespace api\components;

use api\athlete\Domain\Athlete;
use Yii;


class ApiControllerBase extends Controller {

    public $format = 'json';
    public $clientData = null;

    protected function sendErrorResponse($statusCode, $data)
    {
        $response = new Response();
        $response->setStatusCode($statusCode);
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $data;

        return $response;
    }

    /**
     * @return array action filters
     */
    public function filters() {
        return array();
    }

    protected function getParam($name = null, $default = null) {
        if (is_null($name)) {
            return $default;
        }
        $param = Yii::$app->request->get($name, $default);
        if (!$param) {
            $param = isset($this->_post[$name])?$this->_post[$name]:$default;
        }
        return $param;
    }

    public function createResponse($success, $data = array(), $error = ''){

        $result = array('success' => $success);

        if (!$success) {
            $result['errorMessage'] = $error;
        }

        if (!empty($data) && is_array($data)) {
            $result['response'] = $data;
        }

        return $result;
    }

    public function _sendJSONResponse($success, $data = array(), $error = '') {
        $result = array('success' => $success);

        if (!$success) {
            $result['errorMessage'] = $error;
        }

        if (!empty($data) && is_array($data)) {
            $result['response'] = $data;
        }

        $this->_sendResponse(200, \yii\helpers\Json::encode($result), 'application/json');
    }

    /**
     * Sends the API response
     *
     * @param int $status
     * @param string $body
     * @param string $content_type
     * @access private
     * @return void
     */
    public function _sendResponse($status = 200, $body = '', $content_type = 'text/html') {
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        // set the status
        header($status_header);
        // set the content type
        header('Content-type: ' . $content_type);

        // pages with body are easy
        if ($body != '') {
            // send the body
            echo $body;
            exit;
        }
        // we need to create the body if none is passed
        else {
            // create some body messages
            $message = '';

            // this is purely optional, but makes the pages a little nicer to read
            // for your users.  Since you won't likely send a lot of different status codes,
            // this also shouldn't be too ponderous to maintain
            switch ($status) {
                case 401:
                    $message = 'You must be authorized to view this page.';
                    break;
                case 404:
                    $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
                    break;
                case 500:
                    $message = 'The server encountered an error processing your request.';
                    break;
                case 501:
                    $message = 'The requested method is not implemented.';
                    break;
            }

            // servers don't always have a signature turned on (this is an apache directive "ServerSignature On")
            $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

            // this should be templatized in a real-world solution
            $body = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
                        <html>
                            <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
                                <title>' . $status . ' ' . $this->_getStatusCodeMessage($status) . '</title>
                            </head>
                            <body>
                                <h1>' . $this->_getStatusCodeMessage($status) . '</h1>
                                <p>' . $message . '</p>
                                <hr />
                                <address>' . $signature . '</address>
                            </body>
                        </html>';

            echo $body;
            exit;
        }
    }

    /**
     * Gets the message for a status code
     *
     * @param mixed $status
     * @access private
     * @return string
     */
    public function _getStatusCodeMessage($status) {
        // these could be stored in a .ini file and loaded
        // via parse_ini_file()... however, this will suffice
        // for an example
        $codes = Array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported'
        );

        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    public function _authClient() {

        $ApiAuthManager = ApiAuthenticationManager::getInstance();
        //Authenticate the client before any action
        $result = $ApiAuthManager->authenticateClient();

        //if authentication fails
        if (!$result['success']) {
            $this->_sendJSONResponse(FALSE, NULL, $result['errorMessage']);
            Yii::app()->end();
        }

        $this->clientData = $result['data'];
    }

    public function _authUser() {

        $ApiAuthManager = ApiAuthenticationManager::getInstance();
        //Authenticate the client before any action
        $result = $ApiAuthManager->authenticateUser($this->clientData);

        //if authentication fails
        if (!$result['success']) {
            $this->_sendJSONResponse(FALSE, NULL, $result['errorMessage']);
            Yii::app()->end();
        }

        $this->clientData = $result['data'];
    }

    /**
     * @return User
     */
    protected function getLoggedUser()
    {
        return Yii::$app->user->identity;
    }


    /**
     * @return Athlete
     */
    protected function getLoggedAthlete(): Athlete
    {
        return $this->getLoggedAthlete();
    }
}
