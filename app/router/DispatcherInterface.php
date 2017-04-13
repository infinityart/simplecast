<?php
/**
 * @author: Jonty Sponselee <jsponselee@student.scalda.nl>
 * @since: 12-4-2017
 */

namespace Simplecast\Router;


interface DispatcherInterface
{
    public function dispatch();
    public function init($requested_route);
    public function setParameters($parameters);
}