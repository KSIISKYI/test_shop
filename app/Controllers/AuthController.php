<?php

namespace App\Controllers;

use App\Services\UserService;
use App\Models\User;

class AuthController extends \App\Core\Controller
{
    public function showRegisterForm()
    {
        $data = $this->flash->getMessages();
        $data['is_admin_login'] = false;

        return $this->view->render('auth/signup.twig', $data);
    }

    public function showLoginForm()
    {
        $data = $this->flash->getMessages();

        return $this->view->render('auth/signin.twig', $data);
    }

    public function register()
    {
        $errors = UserService::validateRegisterForm($this->request->data);

        if ($errors) {
            $this->flash->addMessage('errors', $errors);
            $this->flash->addMessage('data', $this->request->data);
            
            redirect(route(['name' => 'signup']));
        } 

        UserService::createUser($this->request->data);
        $this->flash->addMessage('message', 'Registration is successful, please sign in');

        redirect(route(['name' => 'signin']));
    }

    public function login()
    {
        $res = UserService::validateLoginForm($this->request->data);

        if ($res['error']) {
            $this->flash->addMessage('errors', $res['error']);
            $this->flash->addMessage('data', $this->request->data);
            
            redirect(route(['name' => 'signin']));
        }

        UserService::login($res['user']);

        redirect(route(['name' => 'home'])); 
    }

    public function logout()
    {
        UserService::logout();

        redirect(route(['name' => 'signin']));
    }
}
