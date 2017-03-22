<?php namespace Simplecast\Controller;

use Simplecast\Core\View;

class PagesController extends Controller
{

    public function home()
    {
        $this->view->setTemplate('home');
        return $this->view->render();
    }
}