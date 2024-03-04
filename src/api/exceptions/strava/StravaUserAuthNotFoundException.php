<?php

namespace api\exceptions\strava;

use api\repositories\AppTextRepository;
use Exception;

class StravaUserAuthNotFoundException extends Exception
{
    private $errors;
    private $appTextRepository;

    public function __construct($errors = [])
    {
        $this->appTextRepository = new AppTextRepository();
        $html = $this->appTextRepository->findValueByKey("EXCEPTION_STRAVA_USER_AUTH_NOT_FOUND");
        parent::__construct($html, 409);
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
