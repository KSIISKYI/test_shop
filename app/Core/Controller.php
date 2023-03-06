<?php 

namespace App\Core;

abstract class Controller
{
    protected $request;
    protected $view;
    protected $flash;

    function __construct($request)
    {
        $this->request = $request;
        $this->view = new View;
        $this->flash = new Flash;
    }
}
