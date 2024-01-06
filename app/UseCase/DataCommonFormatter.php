<?php

namespace App\UseCase;

use Exception;

class DataCommonFormatter
{
    private ?Exception $exception;

    private ?object $data;

    public function __construct($exception, $data)
    {
        $this->data = $data;
        $this->exception = $exception;
    }

    public function getException(): ?Exception
    {
        return $this->exception;
    }

    public function getData(): ?object
    {
        return $this->data;
    }
}
