<?php
/**
 * Class Database.php
 *
 * This is the main Database class, it executes the queries.
 *
 * @author Donny van Walsem <donnehvw@gmail.com>
 * @since 31/03/2016
 * @version 0.1 31/03/2016 Initial class definition.
 */

namespace DDatabase;


class Database
{

    /**
     * Contaings the Database credentials.
     *
     * @var array $db_config
     */
    private $db_config;

    /**
     * Contains a PDO Connection
     *
     * @var \PDO $connection
     */
    private $connection;

    /**
     * Database constructor.
     *
     * @param $db_config
     */
    public function __construct($db_config)
    {
        $this->db_config = $db_config;

        $this->connect(new Connection());

        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Get a connection to the database.
     *
     * @param Connection $conn
     */
    public function connect(Connection $conn)
    {
        if($connection = $conn->resolveConnection($this->db_config)) {
            $this->connection = $connection;
        }
    }

    /**
     * This function executes the query.
     *
     * @param $query
     * @param array ...$params
     * @return \PDOStatement
     */
    public function query($query, $params = null)
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    public function paginate()
    {
        //
    }
}