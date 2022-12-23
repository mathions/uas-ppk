<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Modelcontent;

class Content extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $modelContent = new Modelcontent();
        $data = $modelContent->orderBy('id', 'DESC')->findAll();
        $response = [
            'status' => 200,
            'error' => "false",
            'message' => '',
            'totaldata' => count($data),
            'data' => $data,
        ];

        return $this->respond($response, 200);
    }

    public function show($cari = null)
    {
        $modelContent = new Modelcontent();

        $cek = is_numeric($cari);
        
        if ($cek == 1){
            $data = $modelContent->where('id', $cari)->get()->getResult();
        } else {
            $data = $modelContent->orLike('caption', $cari)->get()->getResult();
        }

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
            return $this->failNotFound('Sorry we can not find the content you`re looking for');
        }
    }

    public function create()
    {
        $modelContent = new Modelcontent();

        $username = $this->request->getPost("username");
        $caption = $this->request->getPost("caption");

        $modelContent->insert([
            'username' => $username,
            'caption' => $caption
        ]);

        $response = [
            'status' => 201,
            'error' => false,
            'message' => "Your content has been successfully uploaded"
        ];

        return $this->respond ($response,201);
    }

    public function update($id = null)
    {
        $modelContent = new Modelcontent();
        $data = [
            'caption' => $this->request->getPost("caption"),
        ];
        $data = $this->request->getRawInput();
        $modelContent->update($id, $data);
        $response = [
            'status' => 200,
            'error' => null,
            'message' => "Data has been updated",
        ];
        return $this->respond($response);
    }



    public function delete($id = null)
    {
        $modelContent= new Modelcontent();

        $cekData = $modelContent->find($id);
        if ($cekData){

            $modelContent->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'message' => 'Content has been deleted'
            ];
            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('No Found');
        }
    }

}