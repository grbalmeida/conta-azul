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
}
