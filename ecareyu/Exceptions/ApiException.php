<?php

namespace EcareYu\Exceptions;

use Exception;
use Throwable;

class ApiException extends Exception
{
    public $errorNo = '';

    public function __construct(string $message = "", string $errorNo = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        // 错误编号
        $this->errorNo = $errorNo;
    }
}
