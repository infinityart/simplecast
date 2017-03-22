<?php namespace Simplecast\Controller;

class PagesController extends Controller
{
    public function home()
    {
        $this->view->setTemplate('home');
        return $this->view->render();
    }
}