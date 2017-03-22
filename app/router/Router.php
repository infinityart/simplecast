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

    /**
     * Check if the current request matches with one of the collection.
     * If the request exists, it will call the function within the given class.
     *
     */
    public function matchRequest()
    {
        $this->setMethod();
        $this->setRequestUri();

        $response = $this->checkExistence();

        if(http_response_code() == 200){
            $this->render($response);
        }
    }

    /**
     * Format the method and set it.
     */
    private function setMethod(){
        $method = $_SERVER['REQUEST_METHOD'];

        $method = strtolower($method);

        $this->method = $method . '_routes';
    }

    /**
     * Format the request and set it.
     */
    private function setRequestUri(){
        $request_uri = $_SERVER['REQUEST_URI'];

        if(substr($request_uri, -1) !== '/'){
            $request_uri .= '/';
        }

        $this->request_uri = $request_uri;
    }

    /**
     * Check if the request exists in the collection.
     *
     * @return int
     */
    private function checkExistence(){
        $routes = $this->RouterCollection->getCollection($this->method);

        if(!array_key_exists($this->request_uri, $routes)){
            http_response_code(404);
            return;
        }

        return $class_method = $routes[$this->request_uri];
    }

    /**
     * Render the given request.
     *
     * @param $class_method
     */
    private function render($class_method)
    {
        $class_method = explode('@',$class_method);
        $class = new $class_method[0];
        $method = $class_method[1];

        echo $class->$method();
    }
}