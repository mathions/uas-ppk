<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Modeluser;

class UploadProfile extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        //
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $modelUser = new Modeluser();

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'foto' => [
                'label' => 'File Image',
                'rules' => 'uploaded[foto]|is_image[foto]|ext_in[foto,png,jpg,jpeg,gif]',
                'errors' => [
                    'uploaded' => '{field} image required'
                ]
            ]
        ]);

        if(!$valid){
            $error_msg = [
                'err_upload' => $validation->getError('foto')
            ];

            $response = [
                'status' => 404,
                'error' => true,
                'message' => $error_msg
            ];

            return $this->respond($response,404);
        } else {

            $cekData = $modelUser->find($id);
            if($cekData['image'] != null || $cekData['image'] != ""){
                unlink('profile/' . $cekData['image']);
            }

            $img = $this->request->getFile('foto');

            if(!$img->hasMoved()){
                $img->move('profile',$cekData['username'].'.'.$img->getExtension());
            }

            $data = [
                'image' => $img->getName()
            ];

            $modelUser->update($id,$data);

            $response = [
                'status' => 201,
                'error' => false,
                'message' => 'Profile Image Uploaded'
            ];

            return $this->respond($response,201);
        }



    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}
