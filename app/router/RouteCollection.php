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
}