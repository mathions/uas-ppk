<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Modelproduk;

class Produk extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $modelProduk = new Modelproduk();
        $data = $modelProduk->findAll();
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
        $modelProduk = new Modelproduk();

        $data = $modelProduk->orLike('produk_nama', $cari)->get()->getResult();

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
            return $this->failNotFound('Maaf data ' . $cari . ' tidak ditemukan');
        }
    }
}