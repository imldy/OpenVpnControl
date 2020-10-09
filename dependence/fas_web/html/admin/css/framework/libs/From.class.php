<?php

/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/9/5
 * Time: 0:00
 */
class From
{
    static function isSubmit(){
        if(isset($_POST['submit']) || $_SERVER['REQUEST_METHOD'] == "POST")
        {
            return true;
        }
        return false;
    }
}