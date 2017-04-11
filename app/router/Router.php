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
     * @var array
     */
    private $routes = [];

    /**
     * @var array
     */
    private $routes_uri_parts = [];

    /**
     * @var null | Dispatcher
     */
    private $dispatcher = null;

    /**
     * Router constructor.
     *
     * @param $RouterCollection
     * @throws \Exception
     */
    public function __construct($RouterCollection)
    {
        if (!is_object($RouterCollection)) {
            throw new \Exception("Argument isn't valid.");
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

        $this->checkMatch();

        if (http_response_code() == 200) {
            $this->dispatcher->dispatch();
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
     * Set the Routes to search in from the collection.
     */
    private function setRoutes()
    {
        $this->routes = $this->RouterCollection->getCollection($this->method);
    }

    /**
     * Check if the request exists in the collection.
     *
     * @return int
     */
    private function checkMatch()
    {
        $this->setRoutes();

        if(!$this->checkExistence()){
            $request_uri_parts = explode('/', $this->request_uri);

            $this->checkCount($request_uri_parts);

            $matched_route = $this->eliminateRoutes($request_uri_parts);

            $this->searchParams($matched_route, $request_uri_parts);
        }

        // als class_method leeg is/niet gevonden dan 404
        if (empty($this->dispatcher)) {
            http_response_code(404);
        }
    }

    /**
     * Process to eliminate parts and
     * the last part is the correct one.
     *
     * @param $request_uri_parts
     * @return array
     */
    private function eliminateRoutes($request_uri_parts)
    {
        // Todo reformat process to a clean way.
        $possible_uri_parts_array = $this->routes_uri_parts;

        foreach ($request_uri_parts as $idx => $request_uri_part){
            foreach ($this->routes_uri_parts as $idx_uri_parts => $uri_parts){
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
        return $possible_uri_parts_array;
    }

    /**
     * Search for the params within 
     * the requested uri parts.
     * 
     * @param $possible_uri_parts_array
     * @param $request_uri_parts
     */
    private function searchParams($possible_uri_parts_array, $request_uri_parts)
    {
        // Todo reformat process to a clean way.
        if(!empty($possible_uri_parts_array)){

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

            $this->initDispatcher($this->routes[$matched_uri], $parameters);
        }
    }

    /**
     * Pre fill the dispatcher with data.
     *
     * @param $matched_route
     * @param array $parameters
     */
    private function initDispatcher($matched_route, $parameters = [])
    {
        $this->dispatcher = new Dispatcher();

        $this->dispatcher->init($matched_route);

        if(!empty($parameters)){
            $this->dispatcher->setParameters($parameters);
        }
    }

    /**
     * Check if the requested uri is directly in the collection.
     *
     * @return bool
     */
    private function checkExistence()
    {
        if (array_key_exists($this->request_uri, $this->routes)) {
            $this->initDispatcher($this->routes[$this->request_uri]);
            return true;
        }
        return false;
    }

    /**
     * Check in the collection for routes which has the
     * same count in parts as the param and put it in the routes_uri_parts variable.
     *
     * @param $request_uri_parts
     * @return array
     */
    private function checkCount($request_uri_parts)
    {
        foreach ($this->routes as $uri => $route){
            $uri_parts =  explode('/', $uri);

            if(count($request_uri_parts) !== count($uri_parts)){
                unset($this->routes[$uri]);
            }else{
                $this->routes_uri_parts[] = $uri_parts;
            }
        }
    }
}