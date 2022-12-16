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

    public function create()
    {
        $modelProduk = new Modelproduk();
        $nama = $this->request->getPost("produk_nama");
        $harga = $this->request->getPost("produk_harga");
        $gambar = $this->request->getPost("produk_gambar");
    
        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'produk_nama' => [
                'rules' => 'is_unique[produk.produk_nama]',
                'label' => 'Nama Produk',
                'errors' => [
                    'is_unique' => "{field} sudah ada"
                ]
            ]
        ]);

        if(!$valid){
            $response = [
                'status' => 404,
                'error' => true,
                'message' => $validation->getError("produk_nama"),
            ];
            return $this->respond($response,404);
        } else {

            $modelProduk->insert([
                'produk_nama' => $nama,
                'produk_harga' => $harga,
                'produk_gambar' => $gambar,
            ]);
    
            $response = [
                'status' => 201,
                'error' => false,
                'message' => "Data Produk berhasil disimpan"
            ];
    
            return $this->respond ($response,201);
        }

    }
}