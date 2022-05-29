<?php

namespace App\Controllers;

use App\Utils\Utils;
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
        $rows = $this->db->table("bagian")->select("id,name")->get()->getResultArray();

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
     * Show detail bagian
     * ============
     * - api for display detail of bagian
     * - previlege     : admin
     * - url           : /bagian/detail/:id
     * - Method        : GET
     * - request header: token
     */
    public function detail($id = null)
    {
        $rows = $this->db->table("bagian")->select("id,name,description")
            ->where("id",$id)  
            ->get()
            ->getFirstRow();

        $respond  = [
            "code"  => empty($rows) ? 404  : 200,
            "error" => empty($rows) ? true : false,
            "data"  => empty($rows) ? [] : $rows
        ];

        if (empty($rows)) {
            unset($respond["data"]);
            $respond["message"] = "bagian dengan id ($id) tidak ditemukan";
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
                    "description" => $post["description"],
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
     * Update bagian
     * ============
     * - api for update bagian
     * - previlege     : admin
     * - url           : /bagian/update
     * - Method        : PUT
     * - request header: token
     */
    public function update($id = null)
    {
        try {
            Utils::_methodParser("put");
            global $put;

            $this->validation->run($put,'updateBagValidate');
            $errors = $this->validation->getErrors();
            
            if (isset($errors["id"])) {
                foreach ($errors as $key => $value) {
                    if ($key != "id") {
                        unset($errors[$key]);
                    }
                }

                $errors = $errors["id"];
            }

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
                    "name"        => htmlspecialchars($put["name"]),
                    "description" => $put["description"],
                ];

                $this->db->table("bagian")
                    ->where("id",$put["id"])
                    ->update($data);

                $respond = [
                    'code'    => 201,
                    'error'   => false,
                    'message' => "bagian dengan id:".$put["id"]." berhasil diupdate"
                ];

                $this->db->transCommit();
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
