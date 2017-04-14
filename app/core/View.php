<?php namespace Simplecast\Core;

use League\Plates\Engine;

class View
{
    private $data = [];
    private $plates;

    private $template = FALSE;

    /**
     * View constructor.
     */
    public function __construct()
    {
        $this->plates = new Engine('../views');
    }

    /**
     * Set the template to use.
     *
     * @param $template
     * @throws \Exception
     */
    public function setTemplate($template)
    {
        $file = "../views/".strtolower($template).".php";

        if(file_exists($file)) {
            $this->template = $template;
        } else {
            throw new \Exception('Template ' . $template . ' not found!');
        }
    }

    /**
     * Assign data to the view.
     *
     * @param $variable
     * @param $value
     */
    public function assign($variable, $value)
    {
        $this->data[$variable] = $value;
    }

    /**
     * Render the view with provided data.
     *
     * @return string
     */
    public function render($template = null)
    {
        if($template) {
            $this->setTemplate($template);
        }
        echo $this->plates->render($this->template, $this->data);
    }
}