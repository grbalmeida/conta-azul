<?php

namespace Controllers;

use \Core\Controller;
use \Models\User;
use \Models\Permission;
use \Models\Company;
use \Models\Customer;

class CustomersController extends Controller
{
    private $user;
    private $permission;
    private $company;
    private $customer;

    public function __construct()
    {
        $this->user = new User();
        $this->permission = new Permission();
        $this->customer = new Customer();
        $this->user->setLoggedUser();
        $this->company = new Company($this->user->getCompany());
        if (!$this->user->isLoggedIn()) {
            header('Location: '.BASE_URL.'/login');
            exit;
        }

        if (!$this->user->hasPermission('customers_view')) {
            header('Location: '.BASE_URL);
        }
    }

    public function index(): void
    {
        $data = [];
        $data['company_name'] = $this->company->getName();
        $data['user_email'] = $this->user->getEmail();
        $data['customers_list'] = $this->customer->getList();
        $data['has_permission_customers_edit'] = $this->user->hasPermission('customers_edit');
        $this->loadView('customers', $data);
    }
}
