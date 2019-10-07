<?php

class Legal_case_traineesController extends Controller
{

    private $viewGreska="";
    private $id=0;

    public function index()
    {

        $this->view->render("privatno/legal_case_trainees/index",
        ["legal_case_trainees"=>Legal_case_trainee::getLegal_case_trainees()]);
    }



    public function pripremaNovi()
    {
        $this->view->render("privatno/legal_case_trainees/novi"
        );


    }


    public function novi()
    {  
        $this->viewGreska="privatno/legal_case_trainees/novi";

       //tu dođu kontrole
      if(!$this->kontrole()){
          return;
      }
       Legal_case_trainee::novi();
       $this->index();
    }



    public function pripremaPromjeni($id)
    
    {
        $legal_case = Legal_case_trainee::read($id);  

       $this->view->render("privatno/legal_case_trainees/promjeni", 
       ['id'=>$id]);



    }



    public function promjeni($id)
    {
        $this->viewGreska="privatno/legal_case_trainee/promjeni";
        $this->id=$id;

        if(!$this->kontrole()){
            return;
        } 
         Legal_case_trainee::promjeni($id);
         $this->index();
    }

    

    public function brisanje($id)
    {  
       Legal_case_trainee::brisi($id);
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

    

