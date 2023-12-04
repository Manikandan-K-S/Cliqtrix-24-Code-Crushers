<?php




class UserControll extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('user');
        $this->load->helper('url');        
    }


    public function checkUserExist() {
        // Get email from POST
        $email = $this->input->get('email');

        // Check if the email exists
        $userExists = $this->user->checkUser($email); 
  
        if($userExists){ $response= array('userExist' => 1); }
        else{ $response= array('userExist' => 0); }

        $response=json_encode($response, JSON_PRETTY_PRINT);
        
        print_r($response);
            
    }



    public function loginOTP() {
        // Get email from GET
        $email = $this->input->get('email');

        // Generate a 6-digit random number (OTP)
        $otp = mt_rand(100000, 999999);

        $result = $this->OTPSend($email, $otp); 

        // Prepare response
        $response = array( 'otp' => $otp );

        // Convert the response to JSON and send it
        $response=json_encode($response, JSON_PRETTY_PRINT);
        
        print_r($response);
    }



    public function fetchName() {
        // Get email from GET
        $email = $this->input->get('email');

        // Fetch the name using the model function
        $data = $this->user->getUserNameByEmail($email); // Replace 'Your_model_name' with your actual model name

        // Prepare response
        $response = array( 'userName' => $data->name,
                            "uid" =>$data->uid );

        $response=json_encode($response, JSON_PRETTY_PRINT);
        
        print_r($response);
    }



    private function OTPSend($mail,$otp){

        include(APPPATH . 'OTP/otp.php');

        ob_start(); // clear echo text from here

        $res=sendMail($mail,$otp); //send otp to the given mail

        $log = ob_get_clean(); // cleaned echo text 

        return $res;

    }



}


?>