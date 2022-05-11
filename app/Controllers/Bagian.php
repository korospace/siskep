<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Bagian extends ResourceController
{
    private $db;
    private $validation;

    public function __construct()
    {
        $this->db = \Config\Database::connect(); 
        $this->validation = \Config\Services::validation();
    }

    /**
     * Show All bagian
     * ============
     * - api for display all data of bagian
     * - previlege     : admin
     * - url           : /bagian/show
     * - Method        : GET
     * - request header: token
     */
    public function show($id = null)
    {
        $rows = $this->db->table("bagian")->select("*")->get()->getResultArray();

        $respond  = [
            "code"  => count($rows) == 0 ? 404  : 200,
            "error" => count($rows) == 0 ? true : false,
            "data"  => count($rows) == 0 ? []   : $rows
        ];

        if (count($rows) == 0) {
            unset($respond["data"]);
            $respond["message"] = "bagian belum ditambah";
        }

        return $this->respond($respond,$respond['code']);
    }

    /**
     * Create bagian
     * ============
     * - api for create new bagian
     * - previlege     : admin
     * - url           : /bagian/create
     * - Method        : POST
     * - request header: token
     */
    public function create()
    {
        try {
            $post    = $this->request->getPost();
            $this->validation->run($post,'createBagianValidate');
            $errors  = $this->validation->getErrors();

            if ($errors) {
                $respond = [
                    'code'    => 400,
                    'error'   => true,
                    'message' => $errors,
                ]; 
            } 
            else {
                $this->db->transBegin();

                $data = [
                    "name" => htmlspecialchars(strtolower($post["name"])),
                ];

                $this->db->table("bagian")->insert($data);

                $transStatus = $this->db->transStatus();
                $respond = [
                    'code'  => ($transStatus) ? 201   : 500,
                    'error' => ($transStatus) ? false : true,
                ];
                
                if ($transStatus) {
                    $respond['message'] = "bagian baru berhasil dibuat";
                    $this->db->transCommit();
                } 
                else {
                    $respond['message'] = "Rollback: terjadi kesalahan saat input data";
                    $this->db->transRollback();
                }
            }
        } 
        catch (\Throwable $th) {
            $this->db->transRollback();
            $respond = [
                "error"   => true,
                "code"    => 500,
                "message" => $th->getMessage(),
                "debug"   => $th->getTraceAsString()
            ];
        }

        return $this->respond($respond,$respond['code']);
    }

    /**
     * Delete bagian
     * ============
     * - api for delete bagian
     * - previlege     : admin
     * - url           : /bagian/delete/{:id}
     * - Method        : DELETE
     * - request header: token
     */
    public function delete($id = null)
    {
        try {
            $data["id"] = $id;
            $this->validation->run($data,'deleteBagianValidate');
            $errors     = $this->validation->getErrors();

            if ($errors) {
                $respond = [
                    'code'    => 400,
                    'error'   => true,
                    'message' => $errors["id"],
                ]; 
            } 
            else {
                $this->db->transBegin();
                $this->db->table("bagian")->delete(["id" => $id]);

                $transStatus = $this->db->transStatus();
                $respond = [
                    'code'  => ($transStatus) ? 201   : 500,
                    'error' => ($transStatus) ? false : true,
                ];
                
                if ($transStatus) {
                    $respond['message'] = "bagian dengan id (".$id.") berhasil didelete";
                    $this->db->transCommit();
                } 
                else {
                    $respond['message'] = "Rollback: terjadi kesalahan saat delete data";
                    $this->db->transRollback();
                }
            }
            
        } 
        catch (\Throwable $th) {
            $this->db->transRollback();
            $respond = [
                "error"   => true,
                "code"    => 500,
                "message" => $th->getMessage(),
                "debug"   => $th->getTraceAsString()
            ];
        }

        return $this->respond($respond,$respond['code']);
    }
}
