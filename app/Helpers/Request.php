<?php

namespace App\Helpers;

class Request
{
    private $request;

    public function __construct()
    {
        
        $this->request = $_REQUEST;
    }

    public function input($key, $default = null)
    {
        if (isset($this->request[$key])) {
            return $this->request[$key];
        }

        return $default;
    }
}
