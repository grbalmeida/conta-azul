<?php

namespace Models;

use \Core\Model;

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
}
