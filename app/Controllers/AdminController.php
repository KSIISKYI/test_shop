<?php

namespace App\Controllers;

use App\Services\UserService;

class AdminController extends \App\Core\Controller
{
    public function index()
    {
        return $this->view->render('admin/index.twig', []);
    }

    public function showLoginForm()
    {
        $data = $this->flash->getMessages();
        $data['is_admin_login'] = true;

        return $this->view->render('auth/signin.twig', $data);
    }

    public function login()
    {
        $res = UserService::validateLoginForm($this->request->data, 1);

        if ($res['error']) {
            $this->flash->addMessage('errors', $res['error']);
            $this->flash->addMessage('data', $this->request->data);
            
            redirect(route(['name' => 'admin-signin']));
        }

        UserService::login($res['user']);

        redirect(route(['name' => 'admin-index'])); 
    }
}
