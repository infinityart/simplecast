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
     * @param string $request
     */
    public function addGet($uri = '/bar/1/', $request = 'ClassBar@FooFunction')
    {
        $request = $this->namespace . $request;

        try{
            $this->checkRequest($request, 'get_routes');
        } catch (\Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }

        $this->get_routes[$uri] = $request;
    }

    /**
     * Set the namespace
     *
     * @param $namespace
     */
    public function setNamespace($namespace)
    {
        $namespace = (string)$namespace;

        // Make sure that the namespace end with  a \
        if(substr($namespace, -1) !== '\\'){
            $namespace .= '\\';
        }

        $this->namespace = $namespace;
    }

    /**
     * Add Post route to the collection
     *
     * @param string $uri
     * @param string $request
     */
    public function addPost($uri = '/bar/', $request = 'ClassBar@FooFunction')
    {
        $request = $this->namespace . $request;

        try{
            $this->checkRequest($request, 'post_routes');
        } catch (\Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }

        $this->post_routes[$uri] = $request;
    }

    /**
     * Add delete route to the collection.
     *
     * @param string $uri
     * @param string $request
     */
    public function addDelete($uri = '/bar/1', $request = 'ClassBar@FooFunction')
    {
        $request = $this->namespace . $request;

        try{
            $this->checkRequest($request, 'delete_routes');
        } catch (\Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }

        $this->delete_routes[$uri] = $request;
    }

    /**
     * Add put route to the collection.
     *
     * @param string $uri
     * @param string $request
     */
    public function addPut($uri = '/bar/1', $request = 'ClassBar@FooFunction')
    {
        $request = $this->namespace . $request;

        try{
            $this->checkRequest($request, 'put_routes');
        } catch (\Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }

        $this->put_routes[$uri] = $request;
    }

    /**
     * Check if the given request exists.
     *
     * @param $request
     * @param $request_method
     * @throws \Exception
     */
    private function checkRequest($request, $request_method)
    {
        $class_function = explode('@', $request);
        $class = $class_function[0];
        $method = $class_function[1];

        if (count($class_function) != 2) {
            throw new \Exception("Class function request does not exist.");
        }
        if (!class_exists($class)) {
            throw new \Exception("Class does not exist in given request.");
        }
        if (!method_exists($class, $method)) {
            throw new \Exception("Method does not exist in given class.");
        }
        if(array_key_exists($class, $this->$request_method)){
            if(in_array($method, $this->$request_method)){
                throw new \Exception("Request already exists");
            }
        }
    }
}