<?php

namespace Controllers;

use \Core\Controller;
use \Models\User;
use \Models\Company;
use \Models\Sale;
use \Models\Purchase;

class HomeController extends Controller
{
    private $user;
    private $company;
    private $sale;
    private $purchase;

    public function __construct()
    {
        $this->user = new User();
        $this->user->setLoggedUser();
        $this->company = new Company($this->user->getCompany());
        $this->sale = new Sale();
        $this->purchase = new Purchase();

        if (!$this->user->isLoggedIn()) {
            header('Location: '.BASE_URL.'/login');
        }
    }

    public function index(): void
    {
        $data = [];
        $data['company_name'] = $this->company->getName();
        $data['user_email'] = $this->user->getEmail();
        $data['products_sold'] = $this->sale->getTotalProducts($this->user->getCompany());
        $data['revenue'] = $this->sale->getTotalRevenue($this->user->getCompany());
        $data['expenses'] = $this->purchase->getTotalExpenses($this->user->getCompany());
        $data['days_list'] = [];

        for ($daysOfTheMonth = 30; $daysOfTheMonth > 0; $daysOfTheMonth--) {
            $data['days_list'][] = date('d/m', strtotime('-'.$daysOfTheMonth.'days'));
        }

        $data['revenue_list'] = $this->sale->getRevenueList(
            $this->user->getCompany(),
            date('Y-m-d', strtotime('-30 days')),
            date('Y-m-d')
        );
        $data['status_list'] = $this->sale->getQuantityStatusList(
            $this->user->getCompany()
        );

        $this->loadView('template', $data);
    }
}
