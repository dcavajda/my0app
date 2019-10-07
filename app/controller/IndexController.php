<?php

class IndexController
{
    private $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function era()
    {
        $this->view->render("era");
    }
    
    public function index()
    {
       $view = new View();

       $view->render("index",["a"=>1,"b"=>["ime"=>"Pero"]]);
    }

    public function onama()
    {
       $view = new View();

       $view->render("onama");
    }

    public function kontakt()
    {
       $view = new View();

       $view->render("kontakt");
    }

    public function login()
    {
       $view = new View();

       $view->render("login");
    }

    public function autoriziraj()
    {
        $view = new View();

        if(App::param("email")=="" && App::param("password")==""){
            $view->render("login",["greska"=>"Obavezno unos email i lozinka"]);
            return;
        }
        $db = DB::getInstance();
        $izraz=$db->prepare("select * from 
        operater where email=:email");
        $izraz->execute(["email"=>App::param("email")]);
        if($izraz->rowCount()==0){
            $view->render("login",["greska"=>"Ne postojeći korisnik"]);
            return;
        }
        $red = $izraz->fetch();
        if(!password_verify(App::param("password"),$red->password)){
            $view->render("login",["greska"=>"Netočna lozinka"]);
            return;
        }
        $korisnik = new stdClass();
        $korisnik->email=$red->email;
        $korisnik->firstnamelastname=$red->firstname . " " . $red->lastname;
        $_SESSION["autoriziran"]=$korisnik;
        
        $view->render("privatno/nadzornaPloca");

        /*
        if(App::param("email")!=="" && App::param("password")!==""){
            //izvrši provjeru na bazu
            $db = DB::getInstance();
            $izraz=$db->prepare("select * from 
            operater where email=:email");
            $izraz->execute(["email"=>App::param("email")]);
            if($izraz->rowCount()>0){
                $red = $izraz->fetch();
                if(password_verify(App::param("password"),$red->lozinka)){

                    $_SESSION["autoriziran"]=true;
                    $view->render("privatno/nadzornaPloca");
                }else{
                    $view->render("login",["greska"=>"Netočna lozinka"]);
                }
                    
            }else{
                $view->render("login",["greska"=>"Ne postojeći korisnik"]);
            }
            
        }else{
            $view->render("login",["greska"=>"Obavezno unos email i lozinka"]);
        }
        */
    }

    public function logout()
    {
        unset($_SESSION["autoriziran"]);
        session_destroy();
        
       $view = new View();

       $view->render("login");
    }
}