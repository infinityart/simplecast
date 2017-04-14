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
            if (!is_object($RouterCollection)) {
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

        if (http_response_code() == 200) {
            $this->render($response);
        }
    }

    /**
     * Format the method and set it.
     */
    private function setMethod()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        $method = strtolower($method);

        $this->method = $method . '_routes';
    }

    /**
     * Format the request and set it.
     */
    private function setRequestUri()
    {
        $request_uri = $_SERVER['REQUEST_URI'];

        if (substr($request_uri, -1) !== '/') {
            $request_uri .= '/';
        }

        $this->request_uri = $request_uri;
    }

    /**
     * Check if the request exists in the collection.
     *
     * @return int
     */
    private function checkExistence()
    {
        $routes = $this->RouterCollection->getCollection($this->method);

        $requested_class_method = [];

        if (array_key_exists($this->request_uri, $routes)) {
            $requested_class_method[] = $routes[$this->request_uri];
        } else {
            $request_uri_parts = explode('/', $this->request_uri);

            $uri_parts_array = [];
            foreach ($routes as $uri => $route){
                $uri_parts =  explode('/', $uri);

                if(count($request_uri_parts) !== count($uri_parts)){
                    unset($routes[$uri]);
                } else {
                    $uri_parts_array[] = $uri_parts;
                }
            }

            $possible_uri_parts_array = $uri_parts_array;

            foreach ($request_uri_parts as $idx => $request_uri_part){

                foreach ($uri_parts_array as $idx_uri_parts => $uri_parts){
                    if($request_uri_part !== $uri_parts[$idx]){
                        $match = false;
                        foreach ($possible_uri_parts_array as $idx_possible_uri_parts => $possible_uri_parts){
                            if($request_uri_part === $possible_uri_parts[$idx]){
                                $match = true;
                                unset($possible_uri_parts_array[$idx_uri_parts]);
                            }
                            if($match === false){
                                $pattern = '/^{.*}$/';

                                if(!preg_match($pattern, $possible_uri_parts[$idx])){
                                    unset($possible_uri_parts_array[$idx_possible_uri_parts]);
                                }
                            }
                        }
                    }
                }
            }

            if(!empty($possible_uri_parts_array)){
                $requested_class_method_with_parameters = [];

                foreach ($possible_uri_parts_array as $possible_uri_parts){


                    $matched_uri = implode('/', $possible_uri_parts);

                    $parameters = [];
                    foreach ($possible_uri_parts as $idx => $possible_uri_part){
                        $pattern = '/^{.*}$/';

                        if(preg_match($pattern, $possible_uri_part)){
                            $parameters[] = $request_uri_parts[$idx];
                        }
                    }
                }

                $requested_class_method_with_parameters[] = $routes[$matched_uri];
                $requested_class_method_with_parameters[] = $parameters;

                return $requested_class_method_with_parameters;
            }
        }

        // als class_method leeg is/niet gevonden dan 404
        if (empty($requested_class_method)) {
            http_response_code(404);
            return;
        }
        return $requested_class_method;
    }

    /**
     * Render the given request.
     *
     * @param $response
     * @return mixed
     */
    private function render($response)
    {
        $class_method = explode('@', $response[0]);
        $class = $class_method[0];
        $method = $class_method[1];

        $object = new $class;

        if(key_exists(1, $response)) {
            $object->$method($response[1]);
        } else {
            $object->$method();
        }
    }
}