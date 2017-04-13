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
    private $RouteCollection = null;

    /**
     * @var string
     */
    private $request_uri = '';

    /**
     * @var array
     */
    private $request_uri_parts = [];

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
     * @var array
     */
    private $matched_uri_parts = [];

    /**
     * @var null | Dispatcher
     */
    private $dispatcher = null;

    /**
     * Router constructor.
     * @param RouteCollection $RouteCollection
     */
    public function __construct(RouteCollection $RouteCollection)
    {
        $this->RouteCollection = $RouteCollection;
    }

    /**
     * Match the current request matches with one of the collection.
     * If the request exists, it will call the function within the given class.
     */
    public function matchRequest()
    {
        $this->setMethod();
        $this->setRequestUri();
        $this->setRequestUriParts();
        $this->setRoutes();

        $this->checkMatch();

        if (http_response_code() == 200) {
            $this->dispatcher->dispatch();
        }
    }

    /**
     * Explode the request uri into parts for later use.
     */
    private function setRequestUriParts()
    {
        $this->request_uri_parts = explode('/', $this->request_uri);
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
        $this->routes = $this->RouteCollection->getCollection($this->method);
    }

    /**
     * Check if the request exists in the collection.
     *
     * @return int
     */
    private function checkMatch()
    {
        $match = true;

        if (!$this->checkExistence()) {
            $match = $this->startMatching();
        }

        if (!$match) {
            http_response_code(404);
        }
    }

    /**
     * The start of the match process.
     *
     * @return array
     */
    private function startMatching()
    {
        return $this->checkCount();
    }

    /**
     * Process to eliminate parts and
     * the last part is the correct one.
     *
     * @return array
     */
    private function eliminateRoutes()
    {
        // Todo reformat process to a clean way.
        $possible_uri_parts_array = $this->routes_uri_parts;

        foreach ($this->request_uri_parts as $idx => $request_uri_part) {
            foreach ($this->routes_uri_parts as $idx_uri_parts => $uri_parts) {

                if ($request_uri_part !== $uri_parts[$idx]) {

                    $match = false;

                    foreach ($possible_uri_parts_array as $idx_possible_uri_parts => $possible_uri_parts) {

                        if ($request_uri_part === $possible_uri_parts[$idx]) {
                            $match = true;
                            unset($possible_uri_parts_array[$idx_uri_parts]);
                        }

                        if ($match === false) {
                            $pattern = '/^{.*}$/';

                            if (!preg_match($pattern, $possible_uri_parts[$idx])) {
                                unset($possible_uri_parts_array[$idx_possible_uri_parts]);
                            }
                        }
                    }
                }
            }
        }

        if(empty($possible_uri_parts_array)){
            return false;
        }

        $this->matched_uri_parts = $possible_uri_parts_array[key($possible_uri_parts_array)];

        return $this->searchParams();
    }

    /**
     * Search for the params within
     * the requested uri parts.
     */
    private function searchParams()
    {
        $matched_uri = implode('/', $this->matched_uri_parts);

        $parameters = [];

        foreach ($this->matched_uri_parts as $idx => $routes_uri_part) {
            $pattern = '/^{.*}$/';

            if (preg_match($pattern, $routes_uri_part, $matches)) {
                $routes_uri_part = $this->removeBrackets($routes_uri_part);

                $parameters[$routes_uri_part] = $this->request_uri_parts[$idx];
            }
        }

        if(empty($parameters)){
            return false;
        }

        $this->initDispatcher(new Dispatcher(), $this->routes[$matched_uri], $parameters);

        return true;
    }

    /**
     * Remove the delimiter used for parameters in the URI.
     *
     * @param $string
     * @return string
     */
    private function removeBrackets($string)
    {
        $string = substr_replace( $string, '', 0, 1);
        $string = substr_replace( $string, '', -1, 1);
        return $string;
    }

    /**
     * Pre fill the dispatcher with data.
     *
     * @param DispatcherInterface $Dispatcher
     * @param $matched_route
     * @param array $parameters
     */
    private function initDispatcher(DispatcherInterface $Dispatcher, $matched_route, $parameters = [])
    {
        $this->dispatcher = $Dispatcher;

        $this->dispatcher->init($matched_route);

        if (!empty($parameters)) {
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
            $this->initDispatcher(new Dispatcher(), $this->routes[$this->request_uri]);
            return true;
        }
        return false;
    }

    /**
     * Check in the collection for routes which has the
     * same count in parts as the param and put it in the routes_uri_parts variable.
     *
     * @return array
     */
    private function checkCount()
    {
        foreach ($this->routes as $uri => $route) {
            $uri_parts = explode('/', $uri);

            if (count($this->request_uri_parts) !== count($uri_parts)) {
                unset($this->routes[$uri]);
            } else {
                $this->routes_uri_parts[] = $uri_parts;
            }
        }

        if(empty($this->routes_uri_parts)){
            return false;
        }

        return $this->eliminateRoutes();
    }

    /**
     * Sets the namespace in the RouteCollection
     *
     * @param $namespace
     */
    public function setNamespace($namespace)
    {
        $this->RouteCollection->setNamespace($namespace);
    }

    /**
     * Add get route to the collection.
     *
     * @param string $uri example: /foo/bar/{id}
     * @param string $action example: FooClass@barMethod
     */
    public function get($uri, $action)
    {
        $this->RouteCollection->get($uri, $action);
    }

    /**
     * Add Post route to the collection
     *
     * @param string $uri example: /foo/bar/{id}
     * @param string $action example: FooClass@barMethod
     */
    public function post($uri, $action)
    {
        $this->RouteCollection->post($uri, $action);
    }

    /**
     * Add delete route to the collection.
     *
     * @param string $uri example: /foo/bar/{id}
     * @param string $action example: FooClass@barMethod
     */
    public function delete($uri, $action)
    {
        $this->RouteCollection->delete($uri, $action);
    }

    /**
     * Add put route to the collection.
     *
     * @param string $uri example: /foo/bar/{id}
     * @param string $action example: FooClass@barMethod
     */
    public function put($uri, $action)
    {
        $this->RouteCollection->put($uri, $action);
    }
}