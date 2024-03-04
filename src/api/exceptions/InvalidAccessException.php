<?php

namespace api\exceptions;

use api\repositories\AppTextRepository;
use Exception;

class InvalidAccessException extends Exception
{
    private $errors;
    private $appTextRepository;

    public function __construct($errors = [])
    {
        $this->appTextRepository = new AppTextRepository();
        parent::__construct($this->appTextRepository->findValueByKey("EXCEPTION_INVALID_ACCESS"), 403);
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
