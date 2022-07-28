<?php

namespace App\Controllers;

use App\Utils\Utils;
use CodeIgniter\RESTful\ResourceController;

class SuratKeputusan extends ResourceController
{
    protected $modelName = 'App\Models\SuratKeputusanModel';

    private $db;
    private $validation;

    public function __construct()
    {
        $this->db = \Config\Database::connect(); 
        $this->validation = \Config\Services::validation();
    }

    /**
     * Show All SK
     * ============
     * - api for get list of SK
     * - previlege     : admin, kabag, kasubag, nonasn
     * - url           : /sk/show
     * - Method        : GET
     * - request header: token
     */
    public function show($id = null)
    {
        global $g_user_id;
        global $g_previlege;
        global $g_bagian;
        global $g_subagian;

        $rows = $this->db->table("SK")
            ->select("SK.id,SK.no_sk,SK.title,SK.tgl_sk,SK.file_sk")
            ->join("SK_detail" ,"SK.no_sk = SK_detail.no_sk", 'left')
            ->join("users"     ,"SK_detail.user_id = users.id", 'left')
            ->join("bagian"    ,"SK_detail.id_bagian = bagian.id", 'left')
            ->join("subagian"  ,"SK_detail.id_subagian = subagian.id", 'left')
            ->where("users.id_previlege",4);

        if (in_array($g_previlege,["kabag"])) {
            $rows = $rows->where("bagian.name",$g_bagian);
        }
        else if (in_array($g_previlege,["kasubag"])) {
            $rows = $rows->where("subagian.name",$g_subagian);
        }
        else if (in_array($g_previlege,["nonasn"])) {
            $rows = $rows->where("SK_detail.user_id",$g_user_id);
        }

        $rows = $rows->distinct()->get()->getResultArray();

        $respond  = [
            "code"  => count($rows) == 0 ? 404  : 200,
            "error" => count($rows) == 0 ? true : false,
            "data"  => count($rows) == 0 ? []   : Utils::modifImgPath($rows,"file_sk","/file_sk/")
        ];

        if (count($rows) == 0) {
            unset($respond["data"]);
            $respond["message"] = "SK belum ditambah";
        }

        return $this->respond($respond,$respond['code']);
    }

    /**
     * Create Surat Keputusan
     * ============
     * - api for create new surat keputusan
     * - previlege     : admin, kabag, kasubag
     * - url           : /sk/create
     * - Method        : POST
     * - request header: token
     */
    public function create()
    {
        global $g_idbagian;

        try {
            $data = $this->request->getPost(); 
            $data['file_sk'] = $this->request->getFile('file_sk'); 
            
            $this->validation->run($data,'createSkValidate');
            $errors = $this->validation->getErrors();

            if($errors) {
                $respond = [
                    'code'    => 400,
                    'error'   => true,
                    'message' => $errors,
                ]; 
            } 
            else {
                foreach ($data['sk_detail'] as $t) {

                    // Set allowed subagian
                    $dbsubag = $this->db->table("subagian")->select("*");
                    if ($g_idbagian != null) {
                        $dbsubag = $dbsubag->where("id_bagian",$g_idbagian);
                    }
                    else if (isset($t['id_bagian'])) {
                        $dbsubag = $dbsubag->where("id_bagian",$t['id_bagian']);
                    }
                    $dbsubag = $dbsubag->get()->getResultArray();
                    
                    $allowedSubag = "";
                    foreach ($dbsubag as $value) {
                        $allowedSubag .= $value["id"].",";
                    }
                    $allowedSubag = trim($allowedSubag,",");
                    
                    $t["allowedSubagian"] = $allowedSubag;

                    $this->validation->run($t,'createSkValidateDetail');
                    $this->validation->run($t,'userValidateBag');
                    $this->validation->run($t,'userValidateSubag');
                    $errors = $this->validation->getErrors();
        
                    if($errors) {
                        $respond = [
                            'code'    => 400,
                            'error'   => true,
                            'message' => $errors,
                        ];
                
                        return $this->respond($respond,$respond['code']);
                    } 
                }

                $dbrespond = $this->model->createSk($data);
                $respond   = $dbrespond;  
            }
        } 
        catch (\Throwable $th) {
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
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete SK
     * ============
     * - api for delete SK
     * - previlege     : admin,kabag,kasubag
     * - url           : /sk/delete/{:no_sk}
     * - Method        : DELETE
     * - request header: token
     */
    public function delete($no_sk = null)
    {
        try {
            global $g_previlege;
            global $g_bagian;
            global $g_subagian;

            $this->db->transBegin();

            $SKdb = $this->db->table("SK")
                ->select("SK.id,SK.no_sk,SK.title,SK.tgl_sk,SK.file_sk,SK_detail.user_id")
                ->join("SK_detail" ,"SK.no_sk = SK_detail.no_sk", 'left')
                ->join("users"     ,"SK_detail.user_id = users.id", 'left')
                ->join("bagian"    ,"SK_detail.id_bagian = bagian.id", 'left')
                ->join("subagian"  ,"SK_detail.id_subagian = subagian.id", 'left')
                ->where("SK.no_sk",$no_sk);

            if (in_array($g_previlege,["kabag"])) {
                $SKdb = $SKdb->where("bagian.name",$g_bagian);
            }
            else if (in_array($g_previlege,["kasubag"])) {
                $SKdb = $SKdb->where("subagian.name",$g_subagian);
            }

            $SKdb = $SKdb->get()->getResultObject();
            
            if (count($SKdb) == 0) {
                $respond = [
                    'code'    => 400,
                    'error'   => true,
                    'message' => "sk dengan no: $no_sk tidak ditemukan",
                ]; 
            } 
            else{
                $file_sk = "";

                foreach ($SKdb as $key => $value) {
                    $user_id = $value->user_id;
                    $file_sk = $value->file_sk;

                    $SKprevious = $this->db->table("SK_detail")
                        ->select("SK_detail.no_sk,SK_detail.user_id,SK_detail.id_bagian,SK_detail.id_subagian,SK_detail.id_kedudukan,SK_detail.masa_kerja,SK_detail.income")
                        ->where("SK_detail.user_id",$user_id)
                        ->where("SK_detail.no_sk !=",$no_sk)
                        ->orderBy("SK_detail.id","desc")
                        ->get()->getFirstRow();
                    
                    if (!is_null($SKprevious)) {
                        $this->db->table("user_detail")
                            ->where("no_sk",  $no_sk)
                            ->where("user_id",$user_id)
                            ->update([
                                "no_sk"       => $SKprevious->no_sk,
                                "masa_kerja"  => $SKprevious->masa_kerja,
                                "income"      => $SKprevious->income,
                                "id_bagian"   => $SKprevious->id_bagian,
                                "id_subagian" => $SKprevious->id_subagian,
                                "id_kedudukan"=> $SKprevious->id_kedudukan,
                            ]);    
                    }
                    else {
                        $this->db->table("user_detail")
                            ->where("no_sk",  $no_sk)
                            ->where("user_id",$user_id)
                            ->update([
                                "no_sk"       => null,
                                "masa_kerja"  => null,
                                "income"      => null,
                                "id_bagian"   => null,
                                "id_subagian" => null,
                                "id_kedudukan"=> null,
                            ]); 
                    }
                }

                $this->db->table("SK")
                    ->where("no_sk",$no_sk)
                    ->delete();

                if ($this->db->transStatus()) {
                    if (unlink('./file_sk/'.$file_sk)) {
                        $this->db->transCommit();
                        $respond = [
                            'code'  => 201,
                            'error' => false,
                            'message' => "sk berhasil dihapus"
                        ];
                    }
                    else {
                        $this->db->transRollback();
                        $respond = [
                            'code'  => 500,
                            'error' => true,
                            'message' => "gagal menghapus berkas SK"
                        ];
                    }

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
