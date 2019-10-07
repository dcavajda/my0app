<?php

class LawyersController extends Controller
{

    private $viewGreska="";
    private $id=0;


    public function index()
    {  
        $this->view->render("privatno/lawyers/index",
            ["lawyers"=>Lawyer::getLawyers()]);
    }



    public function pripremaNovi()
    {
        $this->view->render("privatno/lawyers/novi");
    }



    public function novi()
    {  
        $this->viewGreska="privatno/lawyers/novi";

       //tu dođu kontrole
      if(!$this->kontrole()){
          return;
      }
       Lawyer::novi();
       $this->index();
    }




    public function pripremaPromjeni($id)
    {
        App::setParams(Lawyer::read($id));
        $this->view->render("privatno/lawyers/promjeni", ['id'=>$id]);
    }



    public function promjeni($id)
    {
        $this->viewGreska="privatno/lawyers/promjeni";
        $this->id=$id;

        if(!$this->kontrole()){
            return;
        }
  
         Lawyer::promjeni($id);
         $this->index();
    }


    public function brisanje($id)
    {  
       Lawyer::brisi($id);
       $this->index();
    }


    private function kontrole()
    {
        if(!$this->kontrolaFirstname()){
            return;
        }
        
        if(!$this->kontrolaLastname()){
            return;
        }

        if(!$this->kontrolaIBAN()){
            return;
        }

        if(!$this->kontrolaOIB()){
            return;
        }

    return true;
    }

    private function kontrolaFirstname()
    {

        if(trim(App::param('firstname'))===''){
            $this->greska('firstname','must add Firstname');
            return false;
        }
    
        if(strlen(App::param('firstname'))>50){
            $this->greska('firstname','no more than 50 letters (now: ' . 
            strlen(App::param('firstname')) . ')');
            return false;
        }
    return true;
    }

    private function kontrolaLastname()
    {


        if(trim(App::param('lastname'))===''){
            $this->greska('lastname','must add lastname');
            return false;
       }
       
       if(strlen(App::param('lastname'))>50){
        $this->greska('lastname','no more than 50 letters (now: ' . 
        strlen(App::param('lastname')) . ')');
        return false;
       } 

       return true;
    }   
    
    private function kontrolaIBAN()
    {
       if(trim(App::param('IBAN'))===''){
        $this->greska('IBAN','must add IBAN');
        return false;
        }

        if(strlen(App::param('IBAN'))>21){
            $this->greska('IBAN','must be 21 signs (now: ' . 
            strlen(App::param('IBAN')) . ')');
            return false;
        } 
        return true;
    }   

    private function kontrolaOIB()
    {
        if(trim(App::param('OIB'))===''){
            $this->greska('OIB','must add OIB');
            return false;
            }
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

    

