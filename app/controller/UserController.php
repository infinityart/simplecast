<?php
/**
 * Class UserController.php
 *
 * Class documentation
 *
 * @author: Jonty Sponsleee <jsponselee@student.scalda.nl>
 * @since: 16/03/2017
 * @version 0.1 16/03/2017 Initial class definition.
 */

namespace Simplecast\Controller;


class UserController extends Controller
{

    private $foo = "test";
    public function index()
    {
        echo $this->foo;
    }

    public function show()
    {
        echo 'show User';
    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function save()
    {

    }

    public function badRequest()
    {
        echo '404: pagina niet gevonden';
    }

}