<?php

namespace Controllers;

use \Core\Controller;
use \Models\User;

class HomeController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = new User();

        if (!$this->user->isLoggedIn()) {
            header('Location: '.BASE_URL.'/login');
        }
    }

    public function index(): void
    {
        $this->loadTemplate('home', []);
    }
}
