<?php

namespace Controllers;

use \Core\Controller;
use \Models\User;
use \Models\Company;

class PermissionsController extends Controller
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
            exit;
        }
    }

    public function index(): void
    {
        $data = [];
        $data['company_name'] = $this->company->getName();
        $data['user_email'] = $this->user->getEmail();

        if (!$this->user->hasPermission('permissions_view')) {
           header('Location: '.BASE_URL);
           exit;
        }

        $this->loadView('permissions', $data);
    }
}
