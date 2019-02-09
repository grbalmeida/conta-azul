<?php

namespace Controllers;

use \Core\Controller;
use \Models\User;
use \Models\Company;

class HomeController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
        $this->user->setLoggedUser();
        $this->company = new Company($this->user->getCompany());

        if (!$this->user->isLoggedIn()) {
            header('Location: '.BASE_URL.'/login');
        }
    }

    public function index(): void
    {
        $data = [];
        $data['company_name'] = $this->company->getName();
        $data['user_email'] = $this->user->getEmail();
        $this->loadView('template', $data);
    }
}
