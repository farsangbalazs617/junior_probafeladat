<?php

class DB
{
    
    private $provider = "mysql";
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dbname = "junior_probafeladat";

    public $handler = null;

    public function connect()
    {
        try {
            $this->handler = new PDO($this->provider.':host='.$this->host.';dbname='.$this->dbname, $this->user, $this->password);
        } catch (PDOException $e) {
            die("Hiba a kapcsolódásnál: " . $e->getMessage());
        }
    }

    

    public function close()
    {

    }

}
