<?php namespace Simplecast\Controller;

use Simplecast\Core\View;

class Controller
{

    protected $view;

    public function __construct()
    {
        $this->view = new View();
    }
}