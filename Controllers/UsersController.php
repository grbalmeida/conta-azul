<?php

namespace Controllers;

use \Core\Controller;
use \Models\User;
use \Models\Company;
use \Models\Permission;

class UsersController extends Controller
{
    private $user;
    private $company;
    private $permission;

    public function __construct()
    {
        $this->user = new User();
        $this->user->setLoggedUser();
        $this->company = new Company($this->user->getCompany());
        $this->permission = new Permission();


        if (!$this->user->isLoggedIn()) {
            header('Location: '.BASE_URL.'/login');
        }

        if (!$this->user->hasPermission('users_view')) {
            header('Location: '.BASE_URL);
        }
    }

    public function index(): void
    {
        $data = [];
        $data['company_name'] = $this->company->getName();
        $data['user_email'] = $this->user->getEmail();
        $data['users_list'] = $this->user->getList($this->user->getCompany());
        $this->loadView('users', $data);
    }

    public function add(): void
    {
        $data = [];
        $data['company_name'] = $this->company->getName();
        $data['user_email'] = $this->user->getEmail();
        $data['group_list'] = $this->permission->getGroupList($this->user->getCompany());
        $data['errors'] = [];

        if (isset($_POST['submit'])) {
            if (empty($_POST['name']))
                $data['errors']['name'] = 'O nome é obrigatório';
            else
                unset($data['errors']['name']);

            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                $data['errors']['email'] = 'O e-mail é inválido';
            else
                unset($data['errors']['email']);

            if (empty($_POST['password']))
                $data['errors']['password'] = 'A senha é obrigatória';
            else
                unset($data['errors']['password']);

            if (!count($data['errors']) > 0) {
                if (empty($this->user->add(
                    $_POST['name'],
                    $_POST['email'],
                    $_POST['password'],
                    $_POST['group'],
                    $this->user->getCompany()
                ))) {
                    header('Location: '.BASE_URL.'/users');
                }

                $data['errors']['email'] = 'E-mail já cadastrado';
            }
        }

        $this->loadView('users-add', $data);
    }
}
