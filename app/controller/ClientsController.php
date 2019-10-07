<?php

class ClientsController extends Controller
{
    private $viewGreska="";
    private $id=0;

    public function index($stranica=1)
    {  

        if(isset($_GET["trazi"])){
            $stranica=1;
        }

        if($stranica==1){
            $prethodnaStranica=1;
        }else{
            $prethodnaStranica=$stranica-1;
        }


        $ukupnoStranica = Client::ukupnoStranica();

        if($stranica>=$ukupnoStranica){
            $sljedecaStranica=$ukupnoStranica;
        }else{
            $sljedecaStranica=$stranica+1;
        }

        $this->view->render("privatno/clients/index",
            ["clients"=>Client::getClients($stranica),
            "prethodnaStranica"=>$prethodnaStranica,
            "stranica"=>$stranica,
            "sljedecaStranica"=>$sljedecaStranica,
            "ukupnoStranica"=>$ukupnoStranica]);
    }


    public function pripremaNovi()
    {
        $this->view->render("privatno/clients/novi");
    }



    public function novi()
    {  
        $this->viewGreska="privatno/clients/novi";

       //tu dođu kontrole
      if(!$this->kontrole()){
          return;
      }
       Client::novi();
       $this->index();
    }

    
   
    public function pripremaPromjeni($id)
    {
        App::setParams(Client::read($id));
        $this->view->render("privatno/clients/promjeni", ['id'=>$id]);
    }
    

    public function promjeni($id)
    {
        $this->viewGreska="privatno/clients/promjeni";
        $this->id=$id;

        if(!$this->kontrole()){
            return;
        }
  
         Client::promjeni($id);
         $this->index();
    }


    public function brisanje($id)
    {  
       Client::brisi($id);
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



    public function napuni()
    {
        if(!App::config("dev")){
            exit;
        }  

        set_time_limit(0);
        
        for($i=0;$i<100;$i++){
            $_POST["firstname"]="Client";
            $_POST["lastname"]="$i";
            $_POST["IBAN"]="";
            $_POST["OIB"]="";

            Client::novi();
        }
        echo "GOTOV";
    }

    

}

    

