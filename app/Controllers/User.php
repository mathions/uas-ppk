<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Modeluser;

class User extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $modelUser = new Modeluser();
        $data = $modelUser->findAll();
        $response = [
            'status' => 200,
            'error' => "false",
            'message' => '',
            'totaldata' => count($data),
            'data' => $data,
        ];

        return $this->respond($response, 200);
    }

    public function create()
    {
        $modelUser = new Modeluser();

        $username = $this->request->getPost("username");
        $userpassword = md5($this->request->getPost("userpassword"));
        $useremail = $this->request->getPost("useremail");
        $fullname = $this->request->getPost("fullname");
        
        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'username' => [
                'rules' => 'required|is_unique[user.username]',
                'label' => 'Username',
                'errors' => [
                    'required' => "{field} must fill",
                    'is_unique' => "{field} is been used"
                    ]
                ],
            'userpassword' => [
                'rules' => 'required[user.userpassword]',
                'label' => 'Password',
                'errors' => [
                    'required' => "{field} must fill"
                    ]
                ],
            'useremail' => [
                'rules' => 'required[user.useremail]',
                'label' => 'Email',
                'errors' => [
                    'required' => "{field} must fill"
                    ]
                ],
            'fullname' => [
                'rules' => 'required[user.fullname]',
                'label' => 'Fullname',
                'errors' => [
                    'required' => "{field} must fill"
                    ]
                ]
        ]);

        if(!$valid){
            $response = [
                'status' => 404,
                'error' => true,
                'message' => $validation->getErrors(),
            ];
            return $this->respond($response,404);
        } else {
            $modelUser->insert([
                'username' => $username,
                'userpassword' => $userpassword,
                'useremail' => $useremail,
                'fullname' => $fullname,
            ]);
            $response = [
                'status' => 201,
                'error' => false,
                'message' => "Your account successfully created"
            ];
            return $this->respond ($response,201);
        }
    }

    public function show($id = null)
    {
        $modelUser = new Modeluser();

        $data = $modelUser->where('id', $id)->get()->getResult();

        if (count($data) > 1) {
            $response = [
                'status' => 200,
                'error' => "false",
                'message' => '',
                'totaldata' => count($data),
                'data' => $data,
            ];
            return $this->respond($response, 200);
        } else if (count($data) === 1) {
            $response = [
                'status' => 200,
                'error' => "false",
                'message' => '',
                'totaldata' => count($data),
                'data' => $data,
            ];
            return $this->respond($response, 200);
        } else {
            return $this->failNotFound('Sorry we can not find the user you`re looking for');
        }
    }

    public function update($id = null)
    {
        $modelUser = new Modeluser();
        
        $data = [
            'useremail' => $this->request->getPost("useremail"),
            'fullname' => $this->request->getPost("fullname"),
        ];

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'useremail' => [
                'rules' => 'required[user.useremail]|valid_email',
                'label' => 'Email',
                'errors' => [
                    'required' => "{field} must fill",
                    'valid_email' => "Please fill a valid email"
                    ]
                ],
            'fullname' => [
                'rules' => 'required[user.fullname]',
                'label' => 'Fullname',
                'errors' => [
                    'required' => "{field} must fill"
                    ]
                ]
        ]);

        if(!$valid){
            $response = [
                'status' => 404,
                'error' => true,
                'message' => $validation->getErrors(),
            ];
            return $this->respond($response,404);
        } else {

            $data = $this->request->getRawInput();
            $modelUser->update($id, $data);
            $response = [
                'status' => 200,
                'error' => null,
                'message' => "User profile has been updated",
            ];
            return $this->respond($response);
        }
    }


}