<?php
/**
 * Class Connection.php
 *
 * Handles all the possible connections.
 *
 * @author Donny van Walsem <donnehvw@gmail.com>
 * @since 31/03/2016
 * @version 0.1 31/03/2016 Initial class definition.
 */

namespace Simplecast\Model\Dao\Database;

class Connection
{

    /**
     * Returns the right connection based on the configuration.
     *
     * @param $config
     * @return mixed
     */
    public function resolveConnection($config)
    {
        $className = $this->resolveClass($config['driver']);

        $connection = new $className;
        return $connection->connect($config['host'], $config['username'], $config['password'], $config['name']);
    }

    /**
     * Resolves the class name for the connection and checks if it exists.
     *
     * @param $driver
     * @return string
     */
    public function resolveClass($driver)
    {
        $name = '\\Simplecast\Model\Dao\Database;\\'.$driver.'Connection';
        if(class_exists($name)) {
            return $name;
        }
    }
}