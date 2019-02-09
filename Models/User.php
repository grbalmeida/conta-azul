<?php

namespace Models;

use \Core\Model;
use \Models\Permission;

class User extends Model
{
    private $user_info;
    private $permission;

    public function __construct()
    {
        $this->permission = new Permission();
        parent::__construct();
    }

    public function isLoggedIn(): bool
    {
        return !empty($_SESSION['user_id']);
    }

    public function doLogin(string $email, string $password): bool
    {
        $sql = 'SELECT id FROM users WHERE email = :email AND password = :password';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':password', md5($password));
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $row = $sql->fetch(\PDO::FETCH_ASSOC);
            $_SESSION['user_id'] = $row['id'];
            return true;
        }

        return false;
    }

    public function setLoggedUser(): void
    {
        $sql = 'SELECT name, email, company_id, group_id FROM users WHERE id = :id';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':id', $_SESSION['user_id']);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $this->user_info = $sql->fetch(\PDO::FETCH_ASSOC);
            $this->permission->setGroup($this->user_info['group_id'], $this->user_info['company_id']);
        }
    }

    public function logout(): void
    {
        session_destroy();
    }

    public function hasPermission(string $name): bool
    {
        return $this->permission->hasPermission($name);
    }

    public function getCompany(): int
    {
        return isset($this->user_info['company_id']) ? $this->user_info['company_id'] : 0;
    }

    public function getEmail(): string
    {
        return isset($this->user_info['email']) ? $this->user_info['email'] : '';
    }
}
