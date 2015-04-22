<?php
/**
 * Created by PhpStorm.
 * User: GennadiyM
 * Date: 4/7/2015
 * Time: 3:14 PM
 */

namespace Common\Authentication;


use PDO;

class SQLiteConnection
{
    public $generatedUserID = 0;

    public function Enroll ($userName, $password, $consumer)
    {
        $db = new PDO("sqlite:../src/Common/Authentication/SQLiteDB");

        $sql="INSERT INTO Users (LoginID, Password) VALUES('$userName','$password') ";
         $db->query($sql);

        $this->generatedUserID = $db->lastInsertId();
        if ($this->generatedUserID===0)
        {
            return;
        }

        $sql="INSERT INTO Consumer (UserID, FirstName, LastNAme, TwitterID, Email) VALUES( $this->generatedUserID, '$consumer->localFirstName' ,'$consumer->localLastName', '$consumer->localTwitterid', '$consumer->localEmail') ";
        $db->query($sql);
    }

    public function GetProfileInfo($UserID)
    {
        $db = new PDO("sqlite:../src/Common/Authentication/SQLiteDB");

        $result = $db->query("select u.LoginID, c.FirstName, c.LastName, c.TwitterID, c.Email from Users u join Consumer c on u.UserID = c.UserID where u.UserID = '$UserID'");

        $localArr = array();

        foreach($result as $row)
        {
            $localArr[]  = array(
            "loginid" => $row["LoginID"],
            "firstname" => $row["FirstName"],
            "lastname" => $row["LastName"],
                "twitterid" => $row["TwitterID"],
                "email" => $row["Email"]
            );
        }

        return $localArr;
    }


    public function authenticate ($userName, $password)
    {
        $this->localUserName=$userName;
        $this->localPassword=$password;

        $db = new PDO("sqlite:../src/Common/Authentication/SQLiteDB");

        $result = $db->query("select * from Users where loginid = '$this->localUserName'");

        $localArr=['','',''];
        foreach($result as $row)
        {
            $localArr[0] = $row['LoginID'];
            $localArr[1] =  $row['Password'];
            $localArr[2] =  $row['UserID'];
        }

        if ($localArr[0]==='' && $localArr[1]==='' ) // no records returned with such Username
        {
            return false;
        }
        if ($localArr[0]===$this->localUserName && $localArr[1]!==$this->localPassword ) // password not match but username exist
        {
            return false;
        }
        if ($localArr[0]===$this->localUserName && $localArr[1]===$this->localPassword ) // User has been authenticated
        {
            $this->generatedUserID = $localArr[2];
            return true;
        }

    }

    public function GetTheUUID()
    {
        $db = new PDO("sqlite:../src/Common/Authentication/SQLiteDB");

        $UUID= $this->getGUID();

        $db->query("INSERT INTO UUID (UUIDValue) VALUES('$UUID') ");    // $db->exec("INSERT INTO UUID (UUIDValue) VALUES ('$UUID')");

        return $UUID;
    }

    private function getGUID(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = chr(123)// "{"
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12)
                .chr(125);// "}"
            return $uuid;
        }
    }

}