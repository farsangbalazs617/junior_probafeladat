<?php

class DB
{
    
    //ADATBÁZIS kapcsolathoz az adatok
    private $provider = "mysql";
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dbname = "junior_probafeladat";

    public $handler = null;

    public function __construct()
    {
        try {
            $this->handler = new PDO($this->provider.':host='.$this->host.';dbname='.$this->dbname, $this->user, $this->password);
        } catch (PDOException $e) {
            die("Hiba a kapcsolódásnál: " . $e->getMessage());
        }
    }

}
