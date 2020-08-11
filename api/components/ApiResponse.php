<?php

namespace api\components;


class ApiResponse
{

    public $data;
    public $errors;
    public $success;

    public function __construct(  $data,   $errors, $success)
    {
        $this->data = $data;
        $this->errors = $errors;
        $this->success = $success;
    }
}