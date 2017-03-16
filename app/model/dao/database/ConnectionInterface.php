<?php
namespace DDatabase;

interface ConnectionInterface {

    public function connect($host, $username, $password, $database);

}