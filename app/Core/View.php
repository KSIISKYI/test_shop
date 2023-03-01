<?php

namespace App\Core;

use Twig\Loader\FilesystemLoader;
use Twig\{Environment, TwigFunction};
use Twig\Extension\AbstractExtension;

use App\Models\User;

class View
{
    protected $loader;
    protected $twig;


    function __construct()
    {
        $this->loader = new FilesystemLoader('../resources/views');
        $this->twig = new Environment($this->loader);
    }

    function render(string $view_name, array $data = [])
    {
        return $this->twig->render($view_name, $data);
    }
}
