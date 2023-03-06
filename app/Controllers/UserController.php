<?php

namespace App\Controllers;

use App\Core\{Controller, Paginator};
use App\Services\UserService;

class UserController extends Controller
{
    public function index()
    {
        $users = UserService::getUsers();
        $page_number = isset($this->request->data['page']) ? $this->request->data['page'] : 1;
        $pgn = new Paginator($users, 10);

        if (isset($this->request->server['CONTENT_TYPE']) &&  $this->request->server['CONTENT_TYPE'] == 'application/json') {
            header('Content-type: application/json');
            print_r(json_encode($pgn->getData($page_number)));
        }
    }

    public function indexForAdmin()
    {
        return $this->view->render('admin/user/index.twig');
    }

    public function getMyUser()
    {
        $user = UserService::getMyUser();

        if (isset($this->request->server['CONTENT_TYPE']) &&  $this->request->server['CONTENT_TYPE'] == 'application/json') {
            header('Content-type: application/json');
            print_r(json_encode($user));
        }
    }

    public function create()
    {
        $data = $this->flash->getMessages();

        return $this->view->render('admin/user/create.twig', $data);
    }

    public function store()
    {
        $errors = UserService::validateRegisterForm($this->request->data);

        if ($errors) {
            $this->flash->addMessage('errors', $errors);
            $this->flash->addMessage('data', $this->request->data);
            
            redirect(route(['name' => 'users-create',]));
        }

        UserService::createUser($this->request->data);

        redirect(route(['name' => 'admin-users-index']));
    }

    public function destroy()
    {
        UserService::removeUser($this->request);
    }
}
