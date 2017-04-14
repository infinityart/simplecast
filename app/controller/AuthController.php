<?php namespace Simplecast\Controller;

class AuthController extends Controller
{
    public function showRegisterPage()
    {
        return $this->view->render('register');
    }

    public function showLoginPage()
    {
        return $this->view->render('login');
    }
}