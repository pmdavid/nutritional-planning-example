<?php

namespace api\exceptions;

use Exception;

class ApiException extends Exception
{
    private $errors;

    public function __construct(string $message, int $statusCode, array $errors = [])
    {
        parent::__construct($message, $statusCode);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        if (empty($this->errors)) {
            $this->errors[] = $this->message;
        }

        return $this->errors;
    }
}
