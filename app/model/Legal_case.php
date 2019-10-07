<?php

class Legal_case
{
    public static function getLegal_cases()
    {
       
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        select    
        concat(c.client_id,c.firstname, ' ',c.lastname) as client,
        a.legal_case_id, a.legal_case_code, a.case_date_start, a.case_date_end,
        concat(b.lawyer_id,b.firstname, ' ', b.lastname) as lawyer
        from legal_case a inner join lawyer b
        on a.lawyer=b.lawyer_id
        inner join client c
        on a.client=c.client_id
        
        "
        );
        $izraz->execute();
        return $izraz->fetchAll();
    }

    
    public static function getClients()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        select * from client
        ");
        $izraz->execute();
        return $izraz->fetchAll();
    }


    public static function read($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        select * from legal_case where legal_case_id=:legal_case
        ");
        $izraz->execute(['legal_case'=>$id]);
        return $izraz->fetch(PDO::FETCH_ASSOC);

    }


    public static function novi()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        insert into legal_case values
        (null,:client,:legal_case_code,:case_date_start,:case_date_end,:lawyer)
        
        ");
        $izraz->execute($_POST);
    }

    public static function promjeni($id)
    {   
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        update legal_case set
        client=:client,
        legal_case_code=:legal_case_code,
        case_date_start=:case_date_start,
        case_date_end=:case_date_end,
        lawyer=:lawyer,
        where legal_case_id=:legal_case_id
        
        ");
        $_POST['legal_case_id']=$id;
        $izraz->execute($_POST);
    }



    public static function brisi($id)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare("
        
        delete from legal_case where legal_case_id=:legal_case_id
        
        ");
        $izraz->execute(['legal_case_id'=>$id]);
    }


}
