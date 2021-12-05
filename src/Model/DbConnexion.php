<?php

namespace Model;

use PDO;

abstract class DbConnexion
{
    protected $db;

    public function __construct($servername="db",$dbname="cmsphp",$username="root",$password="root")
    {
      
      try {
         $this->db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password); 
           $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          }
      catch(PDOException $e)
          {
          echo "Connection failed: " . $e->getMessage();
          }

    }  
}