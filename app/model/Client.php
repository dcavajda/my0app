<?php

class Client
{
    public static function getClients($stranica)
    {

        $sps = App::config("stavakaPoStranici");
        $odKuda=($stranica -1) * $sps;
        
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        select client_id, firstname, lastname, IBAN, OIB
        from client 
        where concat(firstname,lastname,ifnull(OIB,'')) like :uvjet
        order by firstname
        limit
        "
        

        . $odKuda . ', ' . $sps);
        $izraz->execute(["uvjet"=>"%" . App::param("uvjet") . "%"]);
        return $izraz->fetchAll();

    }

    /* NEMOGU
    public static function getClients()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("select * from client");
        $izraz->execute();
        return $izraz->fetchAll();
    }
    */


    public static function read($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select * from client where client_id=:client


        ");
        $izraz->execute(['client'=>$id]);
        return $izraz->fetch(PDO::FETCH_ASSOC);

    }

    public static function novi()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        insert into client values
        (null,:firstname,:lastname,:OIB,:IBAN)
        
        ");
        $izraz->execute($_POST);
    }


    public static function promjeni($id)
    {   
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        

        update client set
        firstname=:firstname,
        lastname=:lastname,
        OIB=:OIB,
        IBAN=:IBAN
        
        where client_id=:client_id
        
        ");
        $_POST['client_id']=$id;
        $izraz->execute($_POST);
    }


    public static function brisi($id) 
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
            
        delete from client where client_id=:client_id
            
        ");
        $izraz->execute(['client_id'=>$id]);
    }
  


    public static function ukupnoStranica()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select count(client_id) from client
        where concat(firstname,lastname,ifnull(OIB,'')) like :uvjet
        ");
        $izraz->execute(["uvjet"=>"%" . App::param("uvjet") . "%"]);
        $ukupno = $izraz->fetchColumn();
        return ceil($ukupno/App::config("stavakaPoStranici"));
    }

   

}
