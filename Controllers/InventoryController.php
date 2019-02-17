<?php

namespace Controllers;

use \Core\Controller;
use \Models\User;
use \Models\Company;
use \Models\Inventory;

class InventoryController extends Controller
{
    private $user;
    private $company;
    private $inventory;

    public function __construct()
    {
        $this->user = new User();
        $this->user->setLoggedUser();
        $this->company = new Company($this->user->getCompany());
        $this->inventory = new Inventory();

        if (!$this->user->isLoggedIn()) {
            header('Location: '.BASE_URL);
            exit;
        }

        if (!$this->user->hasPermission('inventory_view')) {
            header('Location: '.BASE_URL);
        }
    }

    public function index(): void
    {
        $data = [];
        $data['company_name'] = $this->company->getName();
        $data['user_email'] = $this->user->getEmail();
        $data['has_permission_inventory_add'] = $this->user->hasPermission('inventory_add');
        $data['has_permission_inventory_edit'] = $this->user->hasPermission('inventory_edit');
        $data['inventory_list'] = $this->inventory->getList($this->user->getCompany());

        $this->loadView('inventory', $data);
    }

    public function add(): void
    {
        $data = [];
        $data['company_name'] = $this->company->getName();
        $data['user_email'] = $this->user->getEmail();
        $data['errors'] = [];

        if (!$this->user->hasPermission('inventory_add')) {
            header('Location: '.BASE_URL.'/inventory');
        }

        if (isset($_POST['submit'])) {
            if (empty($_POST['name']))
                $data['errors']['name'] = 'Nome é obrigatório';
            else
                unset($data['errors']['name']);

            if (empty($_POST['price']))
                $data['errors']['price'] = 'O preço é obrigatório';
            else
                unset($data['errors']['price']);

            if (strlen($_POST['quantity']) === 0)
                $data['errors']['quantity'] = 'A quantidade é obrigatória';
            else
                unset($data['errors']['quantity']);

            if (strlen($_POST['minimum_quantity']) === 0)
                $data['errors']['minimum_quantity'] = 'A quantidade mínima é obrigatória';
            else
                unset($data['errors']['minimum_quantity']);

            if (!count($data['errors']) > 0) {
                $name = $_POST['name'];
                $price = $_POST['price'];
                $quantity = $_POST['quantity'];
                $minimum_quantity = $_POST['minimum_quantity'];
                $price = floatval(str_replace(',', '.', $price));

                $this->inventory->add($this->user->getCompany(), $this->user->getId(), $name, $price, $quantity, $minimum_quantity);

                header('Location: '.BASE_URL.'/inventory');
            }
        }

        $this->loadView('inventory-add', $data);
    }
}
