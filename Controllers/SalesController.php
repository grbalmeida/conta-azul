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

    public function add(): void
    {
        $data = [];
        $data['user_email'] = $this->user->getEmail();
        $data['company_name'] = $this->company->getName();
        $data['errors'] = [];

        if (isset($_POST['submit'])) {
            if (empty($_POST['customer_id']))
                $data['errors']['customer_id'] = 'Cliente não informado';
            else
                unset($data['errors']['customer_id']);

            if (strlen($_POST['total_price']) === 0)
                $data['errors']['total_price'] = 'Total não informado';
            else
                unset($data['errors']['total_price']);

            if (!count($data['errors']) > 0) {
                $total_price = $_POST['total_price'];
                $total_price = str_replace('.', '', $total_price);
                $total_price = str_replace(',', '.', $total_price);

                $this->sale->add(
                    $this->user->getCompany(),
                    $_POST['customer_id'],
                    $this->user->getId(),
                    $total_price,
                    $_POST['status']
                );

                header('Location: '.BASE_URL.'/sales');
            }
        }

        $this->loadView('sales-add', $data);
    }
}
