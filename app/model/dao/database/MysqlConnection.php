<?php
/**
 * Class MysqlConnection.php
 *
 * Class documentation.
 *
 * @author Donny van Walsem <donnehvw@gmail.com>
 * @since 31/03/2016
 * @version 0.1 31/03/2016 Initial class definition.
 */

namespace Donny;


class MysqlConnection implements ConnectionInterface
{

    /**
     * Create and return a new PDO connection.
     *
     * @param $host
     * @param $username
     * @param $password
     * @param $database
     * @return \PDO
     */
    public function connect($host, $username, $password, $database)
    {
        return new \PDO("mysql:host={$host};dbname={$database}", $username, $password);
    }
}