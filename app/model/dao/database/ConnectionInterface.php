<?php
namespace Simplecast\Model\Dao\Database;

interface ConnectionInterface {

    public function connect($host, $username, $password, $database);

}