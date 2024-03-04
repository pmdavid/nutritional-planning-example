<?php declare(strict_types=1);

namespace api\exceptions;

use Exception;

final class AccessDeniedException extends Exception
{
    const MESSAGE = 'Only athletes can access to API';
    const CODE = 403;

    public function __construct()
    {
        parent::__construct(self::MESSAGE, self::CODE);
    }
}
