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

    public function getUserById(int $id): array
    {
        $array = [];

        $sql = 'SELECT group_id, name
                FROM users
                WHERE id = :id';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetch(\PDO::FETCH_ASSOC);
        }

        return $array;
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

    public function getList(int $company_id): array
    {
        $array = [];

        $sql = 'SELECT u.id, u.email, u.name AS user_name, g.name AS group_name
                FROM users u
                LEFT JOIN groups g
                ON g.id = u.group_id';
        $sql = $this->database->query($sql);

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function add(string $name, string $email, string $password, int $group_id, int $company_id): string
    {
        $sql = 'SELECT COUNT(*) AS count FROM users WHERE email = :email';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':email', $email);
        $sql->execute();

        if (!$sql->fetch(\PDO::FETCH_ASSOC)['count'] > 0) {
            $sql = 'INSERT INTO users
                   (name, email, password, group_id, company_id)
                VALUES
                   (:name, :email, :password, :group_id, :company_id)';
            $sql = $this->database->prepare($sql);
            $sql->bindValue(':name', $name);
            $sql->bindValue(':email', $email);
            $sql->bindValue(':password', md5($password));
            $sql->bindValue(':group_id', $group_id);
            $sql->bindValue(':company_id', $company_id);
            $sql->execute();
            return '';
        }

        return 'E-mail já cadastrado';
    }

    public function edit(int $id, string $name, int $group_id, int $company_id): void
    {
        $sql = 'UPDATE users
                SET name = :name, group_id = :group_id
                WHERE id = :id
                AND company_id = :company_id';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':name', $name);
        $sql->bindValue(':group_id', $group_id);
        $sql->bindValue(':id', $id);
        $sql->bindValue(':company_id', $company_id);
        $sql->execute();
    }

    public function delete(int $id, int $company_id): void
    {
        $sql = 'DELETE FROM users WHERE id = :id AND company_id = :company_id';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->bindValue(':company_id', $company_id);
        $sql->execute();
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

    public function getCountUsersByGroupId(int $group_id): int
    {
        $sql = 'SELECT COUNT(*) AS count FROM users WHERE group_id = :group_id';
        $sql = $this->database->prepare($sql);
        $sql->bindValue(':group_id', $group_id);
        $sql->execute();

        return $sql->fetch(\PDO::FETCH_ASSOC)['count'];
    }
}
