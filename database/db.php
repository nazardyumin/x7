<?php
class db
{
    static function connect(
        $host = "localhost:3306",   
        $user = "root",    
        $pass = "r)p6fJkLgSiY*9OK",  
        $dbname = "x7"    
    )    
    {    
        $cs = 'mysql:host='.$host.';dbname='.$dbname.';charset=utf8;';        
    
        $options = array(    
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,    
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,    
            PDO::MYSQL_ATTR_INIT_COMMAND => 'set names utf8'    
        );
        
        try {    
            $pdo = new PDO($cs, $user, $pass, $options);   
            return $pdo;    
        }    
        catch (PDOException $ex)   
        {    
            echo $ex -> getMessage();    
            return false;    
        }    
    }
}
?>