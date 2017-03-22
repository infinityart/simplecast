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
    public function index()
    {
        echo 'Indexing users---';
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

    public function home()
    {
        echo 'dit is de homepage';
    }

    public function badRequest()
    {
        echo '404: pagina niet gevonden';
    }

}