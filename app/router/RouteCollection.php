<?php
/**
 * Class RouteCollection.php
 *
 * This class registers the requested routes.
 *
 * @author: Jonty Sponsleee <jsponselee@student.scalda.nl>
 * @since: 16/03/2017
 * @version 0.1 16/03/2017 Initial class definition.
 */

namespace Simplecast\Router;


class RouteCollection
{
    /**
     * Collection of get routes.
     *
     * @var array
     */
    private $get_routes = [];

    /**
     * Collection of post routes.
     *
     * @var array
     */
    private $post_routes = [];

    /**
     * Collection of delete routes
     *
     * @var array
     */
    private $delete_routes = [];

    /**
     * Collection of put routes.
     *
     * @var array
     */
    private $put_routes = [];

    /**
     * namespace.
     *
     * @var string
     */
    private $namespace = '';

    /**
     * Add get route to the collection.
     *
     * @param string $uri
     * @param string $action
     */
    public function get($uri = '/bar/1/', $action = 'ClassBar@FooFunction')
    {
        $this->addRoute($uri, $action, 'get_routes');;
    }

    /**
     * Add Post route to the collection
     *
     * @param string $uri
     * @param string $action
     */
    public function post($uri = '/bar/', $action = 'ClassBar@FooFunction')
    {
        $this->addRoute($uri, $action, 'post_routes');
    }

    /**
     * Add delete route to the collection.
     *
     * @param string $uri
     * @param string $action
     */
    public function delete($uri = '/bar/1', $action = 'ClassBar@FooFunction')
    {
        $this->addRoute($uri, $action, 'delete_routes');
    }

    /**
     * Add put route to the collection.
     *
     * @param string $uri
     * @param string $action
     */
    public function put($uri = '/bar/1', $action = 'ClassBar@FooFunction')
    {
        $this->addRoute($uri, $action, 'put_routes');
    }

    /**
     * Add a route to the collection by the action method.
     *
     * @param $uri
     * @param $action
     * @param $action_method
     */
    private function addRoute($uri, $action, $action_method)
    {
        $action = $this->namespace . $action;

        $uri = $this->formatUri($uri);

        $this->checkAction($action, $action_method);

        $this->$action_method[$uri] = $action;
    }

    /**
     * Make sure that the namespace end with  a \
     * and set it in the object.
     *
     * @param $namespace
     */
    public function setNamespace($namespace)
    {
        $namespace = (string)$namespace;

        if(substr($namespace, -1) !== '\\'){
            $namespace .= '\\';
        }

        $this->namespace = $namespace;
    }

    /**
     * Format the given URI:
     * Check if the URI end with / otherwise
     * add it to the string and return it
     *
     * @param $uri
     * @return string
     */
    private function formatUri($uri)
    {
        if(substr($uri, -1) !== '/'){
            $uri .= '/';
        }
        return $uri;
    }

    /**
     * Check if the given action exists
     * in the collection.
     *
     * @param $action
     * @param $action_method
     * @throws \Exception
     */
    private function checkAction($action, $action_method)
    {
        $class_method = explode('@', $action);
        $class = $class_method[0];
        $method = $class_method[1];

        if (count($class_method) != 2) {
            throw new \Exception("Class method: {$action} is invalid.");
        }
        if (!class_exists($class)) {
            throw new \Exception("Class: {$class} does not exist in given action.");
        }
        if (!method_exists($class, $method)) {
            throw new \Exception("Method: {$method} does not exist in {$class}.");
        }
        if(array_key_exists($class, $this->$action_method)){
            if(in_array($method, $this->$action_method)){
                throw new \Exception("Action already exists");
            }
        }
    }

    /**
     * Return the requested collection.
     *
     * @param string $type
     * @return mixed
     */
    public function getCollection($type = '')
    {
        return $this->$type;
    }
}