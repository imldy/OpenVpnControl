<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/13
 * Time: 15:56
 */
class Message
{
    static $SYSTEM_SEND = 0;
    static $ALL_USER_RECV = 0;
    private $db;
    private $from = 0;
    private $recv = 0;

    function __construct(){
        $this->db = db("message");
    }

    function setFrom($from){
       $this->from = $from; 
    }

    function setRecv($recv){
        $this->recv = $recv;
    }

    function send($title="",$content="")
    {
        if($this->from < 0 || $this->recv < 1 )
        {
            return false;
        }
        $data["title"]=$title;
        $data["recv"]=$this->recv;
        $data["from"]=$this->from;
        $data["content"]=$content;
        $data["time"] = time();
        $data["isread"] = 0;
        if($this->db->insert($data)){
            return true;
        }
        return false;
    }


}