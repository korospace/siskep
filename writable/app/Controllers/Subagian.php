<?php

namespace App\Controllers;

use App\Utils\Utils;
use CodeIgniter\RESTful\ResourceController;

class Subagian extends ResourceController
{
    private $db;
    private $validation;

    public function __construct()
    {
        $this->db = \Config\Database::connect(); 
        $this->validation = \Config\Services::validation();
    }

    /**
     * Show All subagian
     * ============
     * - api for display all data of subagian
     * - previlege     : admin
     * - url           : /subagian/show
     * - Method        : GET
     * - request header: token
     */
    public function show($id = null)
    {
        $get  = $this->request->getGet();
        $rows = $this->db->table("subagian")->select("subagian.id,subagian.name,subagian.id_bagian,bagian.name as bagian")
        ->join("bagian","bagian.id = subagian.id_bagian")
        ->get()
        ->getResultArray();

        $respond  = [
            "code"  => count($rows) == 0 ? 404  : 200,
            "error" => count($rows) == 0 ? true : false,
            "data"  => count($rows) == 0 ? []   : $rows
        ];

        if (count($rows) == 0) {
            unset($respond["data"]);
            $respond["message"] = "subagian belum ditambah";
        }

        return $this->respond($respond,$respond['code']);
    }

    public function detail($id = null)
    {
        $rows = $this->db->table("subagian")->select("subagian.id,subagian.name,subagian.id_bagian,bagian.name as bagian,subagian.description")
            ->join("bagian","bagian.id = subagian.id_bagian")
            ->where("subagian.id",$id)  
            ->get()
            ->getFirstRow();

        $respond  = [
            "code"  => empty($rows) ? 404  : 200,
            "error" => empty($rows) ? true : false,
            "data"  => empty($rows) ? [] : $rows
        ];

        if (empty($rows)) {
            unset($respond["data"]);
            $respond["message"] = "subagian dengan id ($id) tidak ditemukan";
        }

        return $this->respond($respond,$respond['code']);
    }

    /**
     * Create subagian
     * ============
     * - api for create new subagian
     * - previlege     : admin
     * - url           : /subagian/create
     * - Method        : POST
     * - request header: token
     */
    public function create()
    {
        try {
            $post    = $this->request->getPost();
            $this->validation->run($post,'createSubagianValidate');
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

                $lastId = $this->db->table("subagian")
                    ->select('id')->limit(1)
                    ->orderBy('id','DESC')->get()
                    ->getResultArray();
                
                if (!empty($lastId)) {
                    $lastId = $lastId[0]["id"];
                    $lastId = (int)substr($lastId,2)+1;
                    $lastId = sprintf('%02d',$lastId);
                    $lastId = 'SB'.$lastId;
                }
                else {
                    $lastId = 'SB01';
                }

                $data = [
                    "id"          => $lastId,
                    "id_bagian"   => $post["id_bagian"],
                    "name"        => htmlspecialchars(strtolower($post["name"])),
                    "description" => $post["description"],
                ];

                $this->db->table("subagian")->insert($data);

                $transStatus = $this->db->transStatus();
                $respond = [
                    'code'  => ($transStatus) ? 201   : 500,
                    'error' => ($transStatus) ? false : true,
                ];
                
                if ($transStatus) {
                    $respond['message'] = "subagian baru berhasil dibuat";
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
     * Update subagian
     * ============
     * - api for update subagian
     * - previlege     : admin
     * - url           : /subagian/update
     * - Method        : PUT
     * - request header: token
     */
    public function update($id = null)
    {
        try {
            Utils::_methodParser("put");
            global $put;

            $this->validation->run($put,'updateSubagValidate');
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
                    "id_bagian"   => $put["id_bagian"],
                    "description" => $put["description"],
                ];

                $this->db->table("subagian")
                    ->where("id",$put["id"])
                    ->update($data);

                $respond = [
                    'code'    => 201,
                    'error'   => false,
                    'message' => "subagian dengan id:".$put["id"]." berhasil diupdate"
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
     * Delete subagian
     * ============
     * - api for delete subagian
     * - previlege     : admin
     * - url           : /subagian/delete/{:id}
     * - Method        : DELETE
     * - request header: token
     */
    public function delete($id = null)
    {
        try {
            $data["id"] = $id;
            $this->validation->run($data,'deleteSubagianValidate');
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
                $this->db->table("subagian")->delete(["id" => $id]);

                $transStatus = $this->db->transStatus();
                $respond = [
                    'code'  => ($transStatus) ? 201   : 500,
                    'error' => ($transStatus) ? false : true,
                ];
                
                if ($transStatus) {
                    $respond['message'] = "subagian dengan id (".$id.") berhasil didelete";
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
