<?php
/**
 * Class Router.php
 *
 * This class handle the route request from the user.
 *
 * @author: Jonty Sponsleee <jsponselee@student.scalda.nl>
 * @since: 16/03/2017
 * @version 0.1 16/03/2017 Initial class definition.
 */

namespace Simplecast\Router;


class Router
{
    /**
     * @var RouteCollection | null
     */
    private $RouterCollection = null;

    /**
     * @var string
     */
    private $request_uri = '';

    /**
     * @var string
     */
    private $method = '';

    /**
     * Router constructor.
     * @param $RouterCollection
     */
    public function __construct($RouterCollection)
    {
        try {
            if(!is_object($RouterCollection)){
                throw new \Exception("Argument isn't valid.");
            }
        } catch (\Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
        $this->RouterCollection = $RouterCollection;
    }

    public function matchRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $method = strtolower($method);

        $this->method = $method . '_routes';

        $this->request_uri = $_SERVER['REQUEST_URI'];

        $response = $this->checkExistence();

        if(!is_int($response)){
            $this->render($response);
        }
    }

    private function checkExistence(){
        $routes = $this->RouterCollection->getCollection($this->method);

        if(!array_key_exists($this->request_uri, $routes)){
            return 404;
        }

        return $class_method = $routes[$this->request_uri];
    }

    private function render($class_method)
    {

    }
}