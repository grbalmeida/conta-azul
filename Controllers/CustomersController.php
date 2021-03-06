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
        $data['current_page'] = $_GET['page'] ?? 1;
        $data['current_page'] = intval($data['current_page']);
        $data['current_page'] = $data['current_page'] == 0 ? 1 : $data['current_page'];
        $offset = (10 * ($data['current_page'] - 1));
        $data['customers_list'] = $this->customer->getList($offset, $this->user->getCompany());
        $data['customers_count'] = $this->customer->getCount($this->user->getCompany());
        $data['pages_count'] = ceil($data['customers_count'] / 10);
        $data['has_permission_customers_edit'] = $this->user->hasPermission('customers_edit');
        $this->loadView('customers', $data);
    }

    public function add(): void
    {
        if ($this->user->hasPermission('customers_edit')) {
            $data = [];
            $data['company_name'] = $this->company->getName();
            $data['user_email'] = $this->user->getEmail();
            $data['errors'] = [];

            if (isset($_POST['submit'])) {
                if (empty($_POST['name']))
                $data['errors']['name'] = 'O nome é obrigatório';
                else
                    unset($data['errors']['name']);

                if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                    $data['errors']['email'] = 'O e-mail é inválido';
                else
                    unset($data['errors']['email']);

                if (!count($data['errors']) > 0) {
                    $name = $_POST['name'];
                    $email = $_POST['email'] ?? '';
                    $phone = $_POST['phone'] ?? '';
                    $stars = $_POST['stars'] ?? 3;
                    $note = $_POST['note'] ?? '';
                    $address = $_POST['address'] ?? '';
                    $number = $_POST['number'] ?? 0;
                    $zipcode = $_POST['zipcode'] ?? '';
                    $city = $_POST['city'] ?? '';
                    $state = $_POST['state'] ?? '';
                    $country = $_POST['country'] ?? '';
                    $neighborhood = $_POST['neighborhood'] ?? '';
                    $complement = $_POST['complement'] ?? '';

                    $this->customer->add(
                        $this->user->getCompany(),
                        $name,
                        $email,
                        $phone,
                        intval($stars),
                        $note,
                        intval($number),
                        $address,
                        $zipcode,
                        $city,
                        $state,
                        $country,
                        $neighborhood,
                        $complement
                    );

                    header('Location: '.BASE_URL.'/customers');
                }
            }

            $this->loadView('customers-add', $data);
        } else {
            header('Location: '.BASE_URL.'/customers');
        }
    }

    public function edit(int $id): void
    {
        if ($this->user->hasPermission('customers_edit')) {
            $data = [];
            $data['company_name'] = $this->company->getName();
            $data['user_email'] = $this->user->getEmail();
            $data['customer_info'] = $this->customer->getInfo($id, $this->user->getCompany());
            $data['errors'] = [];

            if (!count($data['customer_info']) > 0) {
                header('Location: '.BASE_URL.'/customers');
            }

            if (isset($_POST['submit'])) {
                if (empty($_POST['name']))
                $data['errors']['name'] = 'O nome é obrigatório';
                else
                    unset($data['errors']['name']);

                if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                    $data['errors']['email'] = 'O e-mail é inválido';
                else
                    unset($data['errors']['email']);

                if (!count($data['errors']) > 0) {
                    $name = $_POST['name'];
                    $email = $_POST['email'] ?? '';
                    $phone = $_POST['phone'] ?? '';
                    $stars = $_POST['stars'] ?? 3;
                    $note = $_POST['note'] ?? '';
                    $address = $_POST['address'] ?? '';
                    $number = $_POST['number'] ?? 0;
                    $zipcode = $_POST['zipcode'] ?? '';
                    $city = $_POST['city'] ?? '';
                    $state = $_POST['state'] ?? '';
                    $country = $_POST['country'] ?? '';
                    $neighborhood = $_POST['neighborhood'] ?? '';
                    $complement = $_POST['complement'] ?? '';

                    $this->customer->edit(
                        $this->user->getCompany(),
                        $id,
                        $name,
                        $email,
                        $phone,
                        intval($stars),
                        $note,
                        intval($number),
                        $address,
                        $zipcode,
                        $city,
                        $state,
                        $country,
                        $neighborhood,
                        $complement
                    );

                    header('Location: '.BASE_URL.'/customers');
                }
            }

            $this->loadView('customers-edit', $data);
        } else {
            header('Location: '.BASE_URL.'/customers');
        }
    }

    public function delete(int $id): void
    {
        if ($this->user->hasPermission('customers_edit')) {
            $this->customer->delete($id, $this->user->getCompany());
        }

        header('Location: '.BASE_URL.'/customers');
    }
}
