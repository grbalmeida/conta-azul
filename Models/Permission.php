<?php

namespace Models;

use \Core\Model;
use \Models\User;

class Permission extends Model
{
    private $group;
    private $permissions;

    public function __construct()
    {
        parent::__construct();
        $this->permissions = [];
    }

    public function setGroup(int $group_id, int $company_id): void
    {
        $this->group = $group_id;
        $sql = 'SELECT p.name
                FROM groups_has_permissions g
                INNER JOIN permissions p
                ON p.id = g.permission_id
                WHERE g.group_id = :group_id
                AND g.company_id = :company_id';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':group_id', $group_id);
        $sql->bindValue(':company_id', $company_id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            array_map(function($permissions) {
                array_push($this->permissions, $permissions['name']);
            }, $sql->fetchAll(\PDO::FETCH_ASSOC));
        }
    }

    public function hasPermission(string $permission_name): bool
    {
        return in_array($permission_name, $this->permissions);
    }

    public function getList(int $company_id): array
    {
        $array = [];

        $sql = $sql = 'SELECT p.name, p.id
                       FROM permissions p
                       WHERE p.company_id = :company_id';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':company_id', $company_id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function getGroupList(int $company_id): array
    {
        $array = [];

        $sql = 'SELECT id, name FROM groups WHERE company_id = :company_id';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':company_id', $company_id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function add(string $name, int $company_id): void
    {
        $sql = 'INSERT INTO permissions(name, company_id)
                VALUES(:name, :company_id)';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':name', $name);
        $sql->bindValue(':company_id', $company_id);
        $sql->execute();
    }

    public function addGroup(string $permission_name, array $permissions_list, int $company_id): void
    {
        $sql = 'INSERT INTO groups
                  (name, company_id)
                VALUES
                  (:name, :company_id)';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':name', $permission_name);
        $sql->bindValue(':company_id', $company_id);
        $sql->execute();

        $sql = 'SELECT MAX(id) AS max FROM groups';
        $sql = $this->database->query($sql);
        $group_id = $sql->fetch(\PDO::FETCH_ASSOC)['max'];

        foreach ($permissions_list as $permission) {
            $sql = 'INSERT INTO groups_has_permissions
                      (group_id, permission_id, company_id)
                    VALUES
                      (:group_id, :permission_id, :company_id)';
            $sql = $this->database->prepare($sql);
            $sql->bindValue(':group_id', $group_id);
            $sql->bindValue(':permission_id', $permission);
            $sql->bindValue(':company_id', $company_id);
            $sql->execute();
        }
    }

    public function delete(int $id): void
    {
        $sql = 'DELETE FROM groups_has_permissions WHERE permission_id = :permission_id';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':permission_id', $id);
        $sql->execute();

        $sql = 'DELETE FROM permissions WHERE id = :id';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();
    }

    public function deleteGroup(int $group_id): void
    {
        $user = new User();
        if (!$user->getCountUsersByGroupId($group_id) > 0) {
            $sql = 'DELETE FROM groups_has_permissions WHERE group_id = :group_id';
            $sql = $this->database->prepare($sql);
            $sql->bindValue(':group_id', $group_id);
            $sql->execute();

            $sql = 'DELETE FROM groups WHERE id = :id';
            $sql = $this->database->prepare($sql);
            $sql->bindValue(':id', $group_id);
            $sql->execute();
        }
    }
}
