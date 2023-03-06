<?php

namespace App\Core;

use Twig\Loader\FilesystemLoader;
use Twig\{Environment, TwigFunction};
use Twig\Extension\AbstractExtension;

use App\Models\{User, Category, Cart};

class View
{
    protected $loader;
    protected $twig;


    function __construct()
    {
        $this->loader = new FilesystemLoader('../resources/views');
        $this->twig = new Environment($this->loader);
        $this->twig->addExtension(new AssetExtension);
    }

    function render(string $view_name, array $data = [])
    {
        return $this->twig->render($view_name, $data);
    }
}

class AssetExtension extends AbstractExtension
{
    function getFunctions()
    {
        return [
            new TwigFunction('route', [$this, 'getRoute']),
            new TwigFunction('getUser', [$this, 'getUser']),
            new TwigFunction('getCategories', [$this, 'getCategories']),
            new TwigFunction('getCart', [$this, 'getCart']),
        ];
    }

    function getRoute($arr)
    {
        return route($arr);
    }

    function getCategories()
    {
        $category_model = new Category;

        return $category_model->filter();
    }

    function getCart()
    {
        $cart_model = new Cart;

        return $cart_model->get('id', $_SESSION['cart_id']);
    }

    function getUser()
    {
        if (isset($_SESSION['user_id'])) {
            $user_model = new User;

            return $user_model->get('id', $_SESSION['user_id']);
        }
    }
}
