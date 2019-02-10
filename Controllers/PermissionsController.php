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

        if (!$this->user->hasPermission('permissions_view')) {
            header('Location: '.BASE_URL);
            exit;
        }
    }

    public function index(): void
    {
        $data = [];
        $data['company_name'] = $this->company->getName();
        $data['user_email'] = $this->user->getEmail();

        $data['permissions_list'] = $this->permission->getList($this->user->getCompany());
        $data['permissions_group_list'] = $this->permission->getGroupList($this->user->getCompany());
        $this->loadView('permissions', $data);
    }

    public function add(): void
    {
        $data = [];
        $data['company_name'] = $this->company->getName();
        $data['user_email'] = $this->user->getEmail();

        if (!empty($_POST['name'])) {
            $name = $_POST['name'];
            $this->permission->add($name, $this->user->getCompany());
            header('Location: '.BASE_URL.'/permissions');
        }

        $data['permissions_list'] = $this->permission->getList($this->user->getCompany());
        $this->loadView('permissions-add', $data);
    }

    public function add_group(): void
    {
        $data = [];
        $data['company_name'] = $this->company->getName();
        $data['user_email'] = $this->user->getEmail();

        if (!empty($_POST['name'])) {
            $permission = $_POST['name'];
            $permissions_list = $_POST['permissions'] ?? [];

            $this->permission->addGroup($permission, $permissions_list, $this->user->getCompany());
        }

        $data['permissions_list'] = $this->permission->getList($this->user->getCompany());
        $this->loadView('permissions-add-group', $data);
    }

    public function edit_group(int $id): void
    {
        $data = [];
        $data['company_name'] = $this->company->getName();
        $data['user_email'] = $this->user->getEmail();

        $data['permissions_list'] = $this->permission->getList($this->user->getCompany());
        $data['group_info'] = $this->permission->getGroup($id, $this->user->getCompany());

        if (count($data['group_info']) > 0) {
            $data['group_permissions'] = $this->permission->getPermissionsByGroupId($id, $this->user->getCompany());

            foreach ($data['group_permissions'] as $permission_id => $permission) {
                $data['group_permissions'][$permission_id] = $permission['permission_id'];
            }

            if (!empty($_POST['name'])) {
                $permissions_list = $_POST['permissions'] ?? [];
                $this->permission->editGroup($_POST['name'], $id, $permissions_list, $this->user->getCompany());
                header('Location: '.BASE_URL.'/permissions');
            }

            $this->loadView('permissions-edit-group', $data);
        } else {
            header('Location: '.BASE_URL.'/permissions');
        }
    }

    public function delete(int $id): void
    {
        $this->permission->delete($id);
        header('Location: '.BASE_URL.'/permissions');
    }

    public function delete_group(int $id): void
    {
        $this->permission->deleteGroup($id);
        header('Location: '.BASE_URL.'/permissions');
    }
}
