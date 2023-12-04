<?php

/*
    |   First connect to the internet

    |   'mani13245790@gmail.com'  '1234'

1.change the projurl variable
2.checkOTP function if condition is set to not eqaul to operator


*/


class Virtushop extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('user');
        $this->load->library('session');
        $this->load->helper('url');        
    }

    public $projurl='virtushop/';

    function index(){
        $projurl = $this->projurl;
       
        $this->load->view("chatbot");

        if ($this->session->has_userdata('alert')){
            echo "<script>alert('".$this->session->userdata('alert')."');</script>";
            $this->session->unset_userdata('alert');
        }

		if ($this->session->has_userdata('email')){
            echo "<h3>Hi, ".$this->session->userdata('name')."</h3>";
            echo "<h3><a href=".base_url($projurl."logout").">Logout</a></h3>";
            echo "<h3><a href=".base_url($projurl.'updatePassword').">Update Password</a></h3>";
            echo "<h3><a href=".base_url($projurl.'deleteUser').">Delete Account</a></h3>";
        }
        
        else{
            echo "<h3><a href=".base_url($projurl.'login').">Login</a></h3>      ";
            echo "<h3><a href=".base_url($projurl.'register').">Register</a></h3>";
        }
    }


    function register(){
        
        if ($this->session->has_userdata('alert')){
            echo "<script>alert('".$this->session->userdata('alert')."');</script>";
            $this->session->unset_userdata('alert');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $this->load->view('registrationPage');
    
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            // collect data from the view
    
            $data['name'] = $this->input->post('name');
            $data['password'] = $this->input->post('pass');
            $data['email'] = $this->input->post('email');
            $data['mobile'] = $this->input->post('mobile');
            $data['address'] = $this->input->post('address');

            if($this->user->checkUser($data['email'])){
                $this->session->set_userdata('alert',"Entered email is aldready logged in...");
                redirect($this->projurl.'login');
            }
            //sending otp
            //$this->OTPSend($data['email']) 
            if($this->OTPSend($data['email'])){
                
                $this->load->view('enterOTP',$data);
            }

        }
    }

    function checkOTP(){
       
        

        if ($this->session->has_userdata('alert')){
            echo "<script>alert('".$this->session->userdata('alert')."');</script>";
            $this->session->unset_userdata('alert');
        }      

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){         

            $receivedOTP=$this->input->post('otp'); //collect otp from post

            if ($this->session->has_userdata('otp')){
                $savedOTP=$this->session->userdata('otp');

                if($savedOTP !== $receivedOTP){  //OTP is correct

                    $this->session->unset_userdata('otp');

                    // collect the userdata and store it in the database   
                    $data['name'] = $this->input->post('name');
                    $data['password'] = $this->input->post('pass');
                    $data['email'] = $this->input->post('email');
                    $data['mobile'] = $this->input->post('mobile');
                    $data['address'] = $this->input->post('address');
                    $this->load->helper('url');

                    $this->user->addUser($data);    //adding user data to sql

                    //storing the user in session
                    $this->session->set_userdata('name',$data['name']);
                    $this->session->set_userdata('email',$data['email']);
                    $this->session->set_userdata('alert',"Registered Successfully!!!");
                    $this->load->view("success");

                }else{ //otp is not correct
                    $this->session->unset_userdata('otp');
                    echo "OTP is incorrect";
                }
            }else{
                echo "OTP not found in the session";
            }
        }
    }


    function login(){
 
        if ($this->session->has_userdata('alert')){
            echo "<script>alert('".$this->session->userdata('alert')."');</script>";
            $this->session->unset_userdata('alert');
        }

        $this->load->view('loginPage');

        if ($this->input->post('Submit')){
            //collect data from user
            $email=$this->input->post('email');
            $password=$this->input->post('pass');

            if ($this->user->checkUser($email)){

                $name = $this->user->authUser($email,$password);
                
                if ($name){

                    $this->session->set_userdata('email',$email);
                    $this->session->set_userdata('name',$name);
                    
                    $this->session->set_userdata('alert',"Logged in Successfully!!");
                    redirect($this->projurl);           
                }

                else{
                    echo "<h3 align='center' style='color:red'>Wrong Credentials</h3>";
                }
            }else{
                echo "<h3 align='center' style='color:red'>Email is not registered</h3>";
            }
        }

    }


    function logout(){
       
        if ($this->session->has_userdata('email')){
             $this->session->unset_userdata('email');
             $this->session->unset_userdata('name');
             
        }
        $this->session->set_userdata('alert',"You are now Logged out....");

        redirect($this->projurl);
    
    }

    

    

    private function OTPSend($mail){

        include(APPPATH . 'OTP/otp.php');

        ob_start(); // clear echo text from here

        $otp = rand(100000, 999999); // Generates a random number between 100000 and 999999
        $res=sendMail($mail,$otp); //send otp to the given mail

        $log = ob_get_clean(); // cleaned echo text 
        
     

        if($res){ // storing the otp in session

            $this->load->library('session');
            $this->session->set_userdata('otp',$otp);
            return true;
        }else{
            return false;
        }

    }

    function sample(){

        $a=$this->user->authUser('mani.ks1324579@gmail.com','');
        //var_dump($a);
        print_r($a);
        
    }

    function textArea(){
        $this->load->helper('form');
        $this->load->view('form');
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $textarea_data = $this->input->post('your_textarea');
            // Save or process $textarea_data as needed
            
            echo $textarea_data;
        }
    }
    



}


?>