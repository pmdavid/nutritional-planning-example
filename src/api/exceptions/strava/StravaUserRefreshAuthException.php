<?php

namespace api\exceptions\strava;

use api\repositories\AppTextRepository;
use Exception;

class StravaUserRefreshAuthException extends Exception
{
    private $errors;
    private $appTextRepository;

    public function __construct($errors = [])
    {
        $this->appTextRepository = new AppTextRepository(); // Repositorio que se encarga de obtener los textos en DDBB a través de la key
        $html = $this->appTextRepository->findValueByKey("EXCEPTION_STRAVA_USER_REFRESH_AUTH");
        parent::__construct($html, 409);
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
