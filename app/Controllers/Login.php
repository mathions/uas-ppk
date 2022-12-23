<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Modellogin;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Login extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        
        $modelLogin = new Modellogin();
        $username = $this->request->getVar("username");
        $userpassword = md5($this->request->getVar("userpassword"));

        $cekUser = $modelLogin->ceklogin($username);

        if(count($cekUser->getResultArray()) > 0){

            $row = $cekUser->getRowArray();
            $pass_hash = $row['userpassword'];

            if($userpassword == $pass_hash){
                $issudate_claim = time();
                $expire_time = $issudate_claim +3600;

                $token = [
                    'iat' => $issudate_claim,
                    'exp' => $expire_time
                ];

                $token = JWT::encode($token,getenv("TOKEN_KEY"),'HS256');
                $output = [
                    'status' => 200,
                    'error' => 200,
                    'messages' => 'Login Successful',
                    'token' => $token,
                    'username' => $username,
                    'id' => $row['id']
                ];
                return $this->respond($output,200);

            }else{
                return $this->failNotFound("The username or password is incorrect");
            }
        }else{
            return $this->failNotFound("The username or password is incorrect");
        }
    }

}
