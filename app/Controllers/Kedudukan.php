<?php

namespace App\Controllers;

use App\Utils\Utils;
use CodeIgniter\RESTful\ResourceController;

class Kedudukan extends ResourceController
{
    private $db;
    private $validation;

    public function __construct()
    {
        $this->db = \Config\Database::connect(); 
        $this->validation = \Config\Services::validation();
    }

    /**
     * Show All kedudukan
     * ============
     * - api for display all data of kedudukan
     * - previlege     : admin
     * - url           : /kedudukan/show
     * - Method        : GET
     * - request header: token
     */
    public function show($id = null)
    {
        $rows = $this->db->table("kedudukan")
            ->get()
            ->getResultArray();

        $respond  = [
            "code"  => count($rows) == 0 ? 404  : 200,
            "error" => count($rows) == 0 ? true : false,
            "data"  => count($rows) == 0 ? []   : $rows
        ];

        if (count($rows) == 0) {
            unset($respond["data"]);
            $respond["message"] = "kedudukan belum ditambah";
        }

        return $this->respond($respond,$respond['code']);
    }

    /**
     * Create kedudukan
     * ============
     * - api for create new kedudukan
     * - previlege     : admin
     * - url           : /kedudukan/create
     * - Method        : POST
     * - request header: token
     */
    public function create()
    {
        try {
            $post    = $this->request->getPost();
            $this->validation->run($post,'createKedudukanValidate');
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

                $lastId = $this->db->table("kedudukan")
                    ->select('id')->limit(1)
                    ->orderBy('id','DESC')->get()
                    ->getResultArray();
                
                if (!empty($lastId)) {
                    $lastId = $lastId[0]["id"];
                    $lastId = (int)substr($lastId,2)+1;
                    $lastId = sprintf('%02d',$lastId);
                    $lastId = 'K'.$lastId;
                }
                else {
                    $lastId = 'K01';
                }

                $data = [
                    "id"   => $lastId,
                    "name" => htmlspecialchars(strtolower($post["name"])),
                ];

                $this->db->table("kedudukan")->insert($data);

                $transStatus = $this->db->transStatus();
                $respond = [
                    'code'  => ($transStatus) ? 201   : 500,
                    'error' => ($transStatus) ? false : true,
                ];
                
                if ($transStatus) {
                    $respond['message'] = "kedudukan baru berhasil dibuat";
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
     * Update kedudukan
     * ============
     * - api for update kedudukan
     * - previlege     : admin
     * - url           : /kedudukan/update
     * - Method        : PUT
     * - request header: token
     */
    public function update($id = null)
    {
        try {
            Utils::_methodParser("put");
            global $put;

            $this->validation->run($put,'updateKedudukanValidate');
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
                    "name" => htmlspecialchars($put["name"]),
                ];

                $this->db->table("kedudukan")
                    ->where("id",$put["id"])
                    ->update($data);

                $respond = [
                    'code'    => 201,
                    'error'   => false,
                    'message' => "kedudukan dengan id:".$put["id"]." berhasil diupdate"
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
     * Delete kedudukan
     * ============
     * - api for delete kedudukan
     * - previlege     : admin
     * - url           : /kedudukan/delete/{:id}
     * - Method        : DELETE
     * - request header: token
     */
    public function delete($id = null)
    {
        try {
            $data["id"] = $id;
            $this->validation->run($data,'deleteKedudukanValidate');
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
                $this->db->table("kedudukan")->delete(["id" => $id]);

                $transStatus = $this->db->transStatus();
                $respond = [
                    'code'  => ($transStatus) ? 201   : 500,
                    'error' => ($transStatus) ? false : true,
                ];
                
                if ($transStatus) {
                    $respond['message'] = "kedudukan dengan id (".$id.") berhasil didelete";
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
