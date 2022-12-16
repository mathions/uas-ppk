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
        $data = $modelContent->findAll();
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
        $modelContent = new Modelproduk();

        $data = $modelContent->orLike('caption', $cari)->get()->getResult();

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


        $image = $this->request->getPost("image");
        $caption = $this->request->getPost("caption");
        $date = $this->request->getPost("date");

        $modelContent->insert([
            'image' => $image,
            'caption' => $caption,
            'date' => $date,
        ]);

        $response = [
            'status' => 201,
            'error' => false,
            'message' => "Your content has been successfully uploaded"
        ];

        return $this->respond ($response,201);
    }
}