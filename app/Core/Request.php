<?php

namespace App\Core;

class Request
{
    public $data = [];
    public $files = [];
    public $server = [];
    public $user;
    public $matches;
    public $cart;

    function __construct($user = null)
    {
        $this->server = $_SERVER;
        $this->data = $_REQUEST;
        $this->files = $_FILES;
    }
}
