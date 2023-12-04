<?php 
Class User extends CI_model{

    public function addUser($data){

        $data["password"] = password_hash($data["password"],1);
        $this->db->insert('user',$data);        
        return true;

    }



    public function checkUser($email){
        $query=$this->db->select('name')
                        ->where(['email' => $email])
                            ->get('user');
        $result=$query->result_array();
                              
        if (!empty($result)){
            return true;
        }else{
            return false;
        }
    }


  
    public function authUser($email,$password){
        $query = $this->db->select(array('password','name'))
                            ->where(['email' => $email])
                            ->get('user');

        $result = $query->result_array();
                            
        
        if($result){
            if (password_verify($password,$result[0]['password'])){
                return $result[0]['name'];
            }else{
                return false;
            }
        }
        

    }



    public function getUserNameByEmail($email) {
        // Query the user table to fetch the name for the given email
        $query = $this->db->select(array('name','uid'))
                          ->where('email', $email)
                          ->get('user');

        // Check if a user with the given email exists
        if ($query->num_rows() > 0) {
            // Return the name if found
            return $query->row();
        } else {
            // Return an empty string or handle as per your requirement
            return '';
        }
    }


    
    public function updatePassword($user,$password){

        $this->db->update('user', 
                        array('password'=>password_hash($password,1)), 
                        array('username' => $user));

        return true;

    }


    public function getUser($user){
        $query = $this->db->get_where('user',array('username'=>$user));
        return $query->result_array();
    }


    public function deleteUser($username){
        $this->db->delete('user', array('username' => $username));
        return true;
    }

    

}
?>