<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Post extends ResourceController
{
    protected $modelName = 'App\Models\PostModel'; //model yang akan digunakan di controller ini
    protected $format = 'json'; // return format data

    /**
     * index function
     * @method : GET
     */
    public function index()
    {
        return $this->respond([
            'statusCode' => 200,
            'message' => 'OK',
            'data' => $this->model->orderBy('id', 'DESC')->findAll()
        ], 200);
    }

    /**
     * show function
     * @method : GET with params ID (untuk edit)
     */
    public function show($id = null)
    {
        return $this->respond([
            'statusCode' => 200,
            'message' => 'OK',
            'data' => $this->model->find($id)
        ], 200);
    }

    public function create()
    {
        if ($this->request) {
            //get request from Vue Js
            //Hasil dari reques vue json adalah berupa json
            if ($this->request->getJSON()) {
                $json = $this->request->getJSON();
                $post = $this->model->insert([
                    'title' => $json->title,
                    'content' => $json->content
                ]);
            } else {
                //get request from Postman and more
                $post = $this->model->insert([
                    'title' => $this->request->getPost('title'),
                    'content' => $this->request->getPost('content')
                ]);
            }

            return $this->respond([
                'statusCode' => 201,
                'content' => 'Data Berhasil Disimpan'
            ], 201);
        }
    }

    /**
     * update function
     * @method : PUT or PATCH
     */
    public function update($id = null)
    {
        //model 
        $post = $this->model;

        if ($this->request) {
            //get request from Vue Js
            if ($this->request->getJSON()) {
                $json = $this->request->getJSON();
                $post->update($json->id, [
                    'title' => $json->title,
                    'content' => $json->content
                ]);
            } else {
                //get request from Postman and more
                $data = $this->request->getRawInput();
                $post->update($id, $data);
            }

            return $this->respond([
                'statusCode' => 200,
                'message' => 'Data Behasil Diupdate!'
            ], 200);
        }
    }

    /**
     * edit function
     * @method : DELETE with params ID
     */
    public function delete($id = null)
    {
        $post = $this->model->find($id);
        if ($post) {
            $this->model->delete($id);

            return $this->respond([
                'statusCode' => 200,
                'message' => 'Data Berhasil Dihapus!'
            ], 200);
        }
    }
}
