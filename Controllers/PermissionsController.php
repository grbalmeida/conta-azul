<?php

namespace Controllers;

use \Core\Controller;
use \Models\User;
use \Models\Company;
use \Models\Permission;

class PermissionsController extends Controller
{
    private $user;
    private $company;
    private $permission;

    public function __construct()
    {
        $this->user = new User();
        $this->permission = new Permission();
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

        $data['permissions_list'] = $this->permission->getList($this->user->getCompany());
        $this->loadView('permissions', $data);
    }

    public function add(): void
    {
        $data = [];
        $data['company_name'] = $this->company->getName();
        $data['user_email'] = $this->user->getEmail();

        if (!$this->user->hasPermission('permissions_view')) {
           header('Location: '.BASE_URL);
           exit;
        }

        if (!empty($_POST['name'])) {
            $name = $_POST['name'];
            $this->permission->add($name, $this->user->getCompany());
            header('Location: '.BASE_URL.'/permissions');
        }

        $data['permissions_list'] = $this->permission->getList($this->user->getCompany());
        $this->loadView('permissions-add', $data);
    }

    public function delete(int $id): void
    {
        if (!$this->user->hasPermission('permissions_view')) {
            header('Location: '.BASE_URL);
            exit;
        }

        $this->permission->delete($id);
        header('Location: '.BASE_URL.'/permissions');
    }
}
