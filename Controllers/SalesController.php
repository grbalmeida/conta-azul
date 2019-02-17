<?php

namespace Controllers;

use \Core\Controller;
use \Models\User;
use \Models\Company;
use \Models\Sale;

class SalesController extends Controller
{
    private $user;
    private $company;
    private $sale;

    public function __construct()
    {
        $this->user = new User();
        $this->user->setLoggedUser();
        $this->company = new Company($this->user->getCompany());
        $this->sale = new Sale();

        if (!$this->user->hasPermission('sales_view')) {
            header('Location: '.BASE_URL);
        }
    }

    public function index(): void
    {
        $data = [];
        $data['user_email'] = $this->user->getEmail();
        $data['company_name'] = $this->company->getName();
        $data['sales_list'] = $this->sale->getList($this->user->getCompany());

        $this->loadView('sales', $data);
    }
}
