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
     */
    public function setTemplate($template)
    {
        try {
            $file = '../views/' . strtolower($template) . '.php';

            if(file_exists($file)) {
                $this->template = $template;
            } else {
                throw new customException('Template ' . $template . ' not found!');
            }
        }
        catch (customException $e) {
            echo $e->errorMessage();
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
    public function render()
    {
        return $this->plates->render($this->template, $this->data);
    }
}