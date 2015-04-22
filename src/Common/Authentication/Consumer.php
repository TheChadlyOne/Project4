<?php
/**
 * Created by PhpStorm.
 * User: GennadiyM
 * Date: 4/8/2015
 * Time: 6:20 PM
 */

namespace Common\Authentication;


class Consumer {

    private $localuserID;
    public $localFirstName;
    public $localLastName;
    public $localTwitterid;
    public $localEmail;

    public function __construct($firstName,$lastName,$twitterid,$email)
    {
        $this->localFirstName = $firstName;
        $this->localLastName = $lastName;
        $this->localTwitterid = $twitterid;
        $this->localEmail = $email;
    }

    public function getFirstName()
    {
        return $this->localFirstName;
    }

    public function getLastName()
    {
        return $this->localLastName;
    }

    public function getTwitterID()
    {
        return $this->localTwitterid;
    }

    public function getEmail()
    {
        return $this->localEmail;
    }
}