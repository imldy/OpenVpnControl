<?php

class U
{
    static private $userinfo = [];
    static private $cache = [];

    public static function checkLogin()
    {
        $username = $_SESSION["username"];
        $password = $_SESSION["password"];

        if ($_SESSION['login'] != 1) {
            return false;
        }
        if ($username == "" || $password == "") {
            return false;
        }

        if ($info = db("user")->where(["email_v"=>1,"username" => $username, "password" => $password])->find()) {
            self::$userinfo = $info;
            return true;
        }
        return false;
    }


    public static function getInfo($id = null)
    {
        if ($id) {
            if(!self::$cache[$id]){
                self::$cache[$id]= db("user")->where(["id" => $id])->find();
            }
            return self::$cache[$id];
        } else {
            return self::$userinfo;
        }
    }

    public static function getInfou($username = null)
    {
        if ($username) {
            if($info= db("user")->where(["username" => $username])->find()){
                self::$cache[$info['id']] = $info;
                return $info;
            }
        }
        return false;
    }
}