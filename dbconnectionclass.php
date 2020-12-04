<?php
namespace leviconnect;
class MysqlConnection
{

    private $user;
    private $host;
    private $pass;
    private $db;
   
    public function __construct()
    {
        $this->user = "root";
        $this->host = "localhost";
        $this->pass = "root";
        $this->db = "bezoekers_registratie";
    }


    public function connect()
    {
        return new \mysqli($this->host, $this->user, $this->pass, $this->db);
    }

}


