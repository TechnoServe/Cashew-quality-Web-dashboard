<?php

namespace api\components;


class ApiError
{
    const INVALID_DATA = "INVALID_DATA";
    public $code;
    public $description;

    public function __construct($code, $description)
    {
        $this->code = $code;
        $this->description = $description;
    }
}