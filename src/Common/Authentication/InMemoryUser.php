<?php

namespace Common\Authentication;
use PDO;


class InMemoryUser
{
    protected $username;
    protected $password;

    protected $response;

    public function __construct()
    {
        $this->responsecode = 401;

    }


    public function authenticate($username, $password)
    {
        if ($username === "CHADLYMEM" && $password === "123POP") {
            $this->response = 200;
            echo 'hi   ';
        }else{
            echo'sfdjk';
            $this->response = 400;
        }
        return $this->response;
    }


}
