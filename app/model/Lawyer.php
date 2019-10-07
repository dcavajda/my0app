<?php

class Lawyer
{
    public static function getLawyers()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("select * from lawyer");
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function read($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select * from lawyer where lawyer_id=:lawyer
        
        ");
        $izraz->execute(['lawyer'=>$id]);
        return $izraz->fetch(PDO::FETCH_ASSOC);

    }




    public static function novi()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        insert into lawyer
        (lawyer_id, firstname, lastname, IBAN, OIB, opis)
        values
        (null, :firstname, :lastname, :IBAN, :OIB, :opis)
        
        ");
        $izraz->execute($_POST);
    }



    public static function promjeni($id)
    {   
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        update lawyer set
        firstname=:firstname,
        lastname=:lastname,
        OIB=:OIB,
        IBAN=:IBAN,
        opis=:opis
        where lawyer_id=:lawyer_id
        
        ");
        $_POST['lawyer_id']=$id;
        $izraz->execute($_POST);
    }



    public static function brisi($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        delete from lawyer where lawyer_id=:lawyer_id
        
        ");
        $izraz->execute(['lawyer_id'=>$id]);
    }


}
