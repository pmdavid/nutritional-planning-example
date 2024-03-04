<?php

namespace api\exceptions\webhook;

use api\repositories\AppTextRepository;
use Exception;

class InvalidJsonDataTypeNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct('EXCEPTION_WEBHOOK_INVALID_JSON_DATA', 403);
    }
}
