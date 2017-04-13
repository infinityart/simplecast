<?php
/**
 * Class Dispatcher.php
 *
 * This class get instructions from the router
 * to generate the class with the method
 * and possible params with it.
 *
 * @author: Jonty Sponsleee <jsponselee@student.scalda.nl>
 * @since: 11/04/2017
 * @version 0.1 11/04/2017 Initial class definition.
 */

namespace Simplecast\Router;

class Dispatcher implements DispatcherInterface
{
    /**
     * @var string
     */
    private $class = '';

    /**
     * @var string
     */
    private $method = '';

    /**
     * @var array
     */
    private $parameters = [];

    /**
     * Dispatch the request or in other words, call the
     * method within the class with parameters.
     */
    public function dispatch()
    {
        $object = new $this->class;
        $method = $this->method;

        echo $object->$method($this->parameters);
    }

    /**
     * Init this object and fill the class
     * and method with the requested route.
     *
     * @param $requested_route
     */
    public function init($requested_route)
    {
        $class_method = explode('@', $requested_route);

        $this->class = $class_method[0];
        $this->method = $class_method[1];
    }

    /**
     * Sets the parameters of the request.
     *
     * @param $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }
}