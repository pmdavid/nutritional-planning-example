<?php

namespace api\exceptions\block;

use api\repositories\AppTextRepository;
use Exception;

class BlockNotFoundException extends Exception
{
    private $errors;
    private $appTextRepository;


    public function __construct($blockUuid, $errors = [])
    {
        $this->appTextRepository = new AppTextRepository();
        $html = $this->appTextRepository->findValueByKey("EXCEPTION_BLOCK_NOT_FOUND");;
        parent::__construct($html, 404);
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
