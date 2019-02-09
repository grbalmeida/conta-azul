<?php

namespace Controllers;

use \Core\Controller;
use \Models\User;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->user = new User();
    }

    public function index(): void
    {
        $data = [
            'title' => 'Login'
        ];

        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if ($this->user->doLogin($email, $password)) {
                header('Location: '.BASE_URL);
                exit;
            } else {
                $data['error'] = 'E-mail ou senha errados.';
            }
        }

        $this->loadView('login', $data);
    }
}
