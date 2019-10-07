<?php

class Legal_casesController extends Controller
{

    private $viewGreska="";
    private $id=0;


    public function index()
    {  
        $this->view->render("privatno/legal_cases/index",
            ["legal_cases"=>Legal_case::getLegal_cases()]);
    }


    public function pripremaNovi()
    {
        $this->view->render("privatno/legal_cases/novi",
        ["lawyers"=>Lawyer::getLawyers()]
        );

//kada ubacim da mi prikaze client dobijem eror
        //["clients"=>Client::getClients(),
        //"lawyers"=>Lawyer::getLawyers()]
    }


    public function novi()
    {  
        $this->viewGreska="privatno/legal_cases/novi";

       //tu dođu kontrole
      if(!$this->kontrole()){
          return;
      }
       Legal_case::novi();
       $this->index();
    }



    public function pripremaPromjeni($id)
    
    {
        $legal_case = Legal_case::read($id);  
        $legal_case["case_date_start"] = date("c",strtotime($legal_case["case_date_start"]));
        App::setParams($legal_case);

       $this->view->render("privatno/legal_cases/promjeni", 
       ['id'=>$id,
       "lawyers"=>Lawyer::getLawyers()]);

//kada ubacim da mi prikaze client dobijem eror
        //["clients"=>Client::getClients(),
        //"lawyers"=>Lawyer::getLawyers()]


    }



    public function promjeni($id)
    {
        $this->viewGreska="privatno/legal_cases/promjeni";
        $this->id=$id;

        if(!$this->kontrole()){
            return;
        } 
         Legal_case::promjeni($id);
         $this->index();
    }

    

    public function brisanje($id)
    {  
       Legal_case::brisi($id);
       $this->index();
    }


    private function kontrole()
    {
        return true;
    }



    private function greska($polje,$poruka){
        $this->view->render($this->viewGreska,
        ['greska'=>
            ['polje'=>$polje,
             'poruka'=>$poruka],
         'id'=>$this->id
        ]);
    }

    

}

    

