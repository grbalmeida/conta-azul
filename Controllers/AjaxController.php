<?php

namespace Controllers;

use \Core\Controller;
use \Models\User;
use \Models\Customer;
use \Models\Company;

class AjaxController extends Controller
{
    private $user;
    private $customer;
    private $company;

    public function __construct()
    {
        $this->user = new User();
        $this->user->setLoggedUser();
        $this->customer = new Customer();
        $this->company = new Company($this->user->getCompany());

        if (!$this->user->isLoggedIn()) {
            header('Location: '.BASE_URL);
            exit;
        }
    }

    public function index(): void { }

    public function searchCustomers(): void
    {
        $data = [];

        if (isset($_GET['query']) && !empty($_GET['query'])) {
            $query = $_GET['query'];
            $customers = $this->customer->getCustomersByName($query, $this->user->getCompany());

            foreach ($customers as $customer) {
                $data[] = [
                    'id' => $customer['id'],
                    'name' => $customer['name'],
                    'link' => BASE_URL.'/customers/edit/'.$customer['id']
                ];
            }
        }

        echo json_encode($data);
    }

    public function add_customer(): void
    {
        $data = [];

        if(!empty($_POST['name'])) {
            $data['id'] = $this->customer->add($this->user->getCompany(), $_POST['name']);
        }

        echo json_encode($data);
    }
}
