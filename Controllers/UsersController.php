<?php

namespace Controllers;

use \Core\Controller;
use \Models\User;
use \Models\Company;

class UsersController extends Controller
{
    private $user;
    private $company;

    public function __construct()
    {
        $this->user = new User();
        $this->user->setLoggedUser();
        $this->company = new Company($this->user->getCompany());


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
}
