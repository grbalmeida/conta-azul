<?php

namespace Models;

use \Core\Model;

class User extends Model
{
    public function __construct()
    {
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
}
