<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Headset extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Headset_model', 'headset');
        $this->methods['index_get']['limit'] = 500;
        $this->methods['index_post']['limit'] = 500;
        $this->methods['index_put']['limit'] = 500;
        $this->methods['index_delete']['limit'] = 500;
    }
    public function index_get()
    {
        $id = $this->get('id');
        if ($id == null) {
            $headset = $this->headset->getHeadset();
        } else {
            $headset = $this->headset->getHeadset($id);
        }
        if ($headset) {
            $this->response([
                'status' => true,
                'data' => $headset
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');
        if ($id == null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->headset->deleteHeadset($id) > 0) {
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'deleted'

                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'id not found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'id_headset' => $this->post('id_headset'),
            'nama_headset' => $this->post('nama_headset'),
            'gambar' => $this->post('gambar'),
            'harga' => $this->post('harga'),
            'stok' => $this->post('stok')
        ];

        if ($this->headset->createHeadset($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'new headset has been created'

            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to create data'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id = $this->put('id');
        $beli = $this->put('beli');
        if ($id != null && $beli == null) {
            $data = [
                'id_headset' => $this->put('id_headset'),
                'nama_headset' => $this->put('nama_headset'),
                'gambar' => $this->put('gambar'),
                'harga' => $this->put('harga'),
                'stok' => $this->put('stok')
            ];

            if ($this->headset->updateHeadset($data, $id) > 0) {
                $this->response([
                    'status' => true,
                    'message' => 'headset has been updated'

                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'failed to update data'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }elseif($id != null && $beli == 'beli'){
            $data = [
                'stok' => $this->put('stok')
            ];

            if ($this->headset->updateHeadset($data, $id) > 0) {
                $this->response([
                    'status' => true,
                    'message' => 'headset has been updated'

                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'failed to update data'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}
