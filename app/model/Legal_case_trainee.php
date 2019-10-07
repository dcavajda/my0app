<?php

class Legal_case_trainee
{
    public static function getLegal_case_trainees()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("select * from legal_case_trainee");
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function read($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select * from legal_case_trainee where legal_case_trainee_id=:legal_case_trainee
        ");
        $izraz->execute(['legal_case_trainee'=>$id]);
        return $izraz->fetch(PDO::FETCH_ASSOC);

    }


    public static function novi()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        insert into legal_case_trainee values
        (legal_case,:legal_trainee)
        
        ");
        $izraz->execute($_POST);
    }

    public static function promjeni($id)
    {   
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        update legal_case_trainee set
        legal_case=:legal_case,
        legal_trainee=:legal_trainee,
        where legal_case_trainee_id=:legal_case_trainee_id
        
        ");
        $_POST['legal_case_trainee_id']=$id;
        $izraz->execute($_POST);
    }



    public static function brisi($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        delete from legal_case_trainee where legal_case_trainee_id=:legal_case_trainee_id
        
        ");
        $izraz->execute(['legal_case_trainee_id'=>$id]);
    }


}
