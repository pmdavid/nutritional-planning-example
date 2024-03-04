<?php

namespace api\exceptions;

use api\repositories\AppTextRepository;
use Exception;

class InvalidRequestException extends Exception
{
    private $missingFields;
    private $invalidFields;
    private $appTextRepository;

    public function __construct($missingFields, $invalidFields)
    {
        $this->appTextRepository = new AppTextRepository();
        parent::__construct($this->appTextRepository->findValueByKey("EXCEPTION_INVALID_REQUEST"), 400);
        $this->missingFields = $missingFields;
        $this->invalidFields = $invalidFields;
    }

    public function getMissingFields()
    {
        return $this->missingFields;
    }

    public function getInvalidFields()
    {
        return $this->invalidFields;
    }
}
