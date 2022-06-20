<?php

namespace App\Controllers;

use App\Utils\Utils;
use CodeIgniter\I18n\Time;
use CodeIgniter\RESTful\ResourceController;
use DateTime;
use DateTimeZone;

class Tugas extends ResourceController
{
    private $db;
    private $validation;

    public function __construct()
    {
        $this->db = \Config\Database::connect(); 
        $this->validation = \Config\Services::validation();
    }

    /**
     * Show tugas
     * ============
     * - api for show tugas
     * - previlege     : admin, kabag, kasubag, nonasn
     * - url           : /tugas/show
     * - Method        : GET
     * - request header: token
     */
    public function show($id = null)
    {
        global $g_user_id;
        global $g_previlege;
        global $g_bagian;
        global $g_subagian;

        try {
            // get data tugas from db
            $tugasDb = $this->db->table("tugas")
                ->select("tugas.id as id_tugas,tugas.title,tugas.status,tugas.komentar,tugas.created_at,user_detail.user_id,user_detail.nama_lengkap,user_detail.nik")
                ->join("user_detail" ,"tugas.user_id = user_detail.user_id", 'left')
                ->join("bagian"      ,"user_detail.id_bagian = bagian.id", 'left')
                ->join("subagian"    ,"user_detail.id_subagian = subagian.id", 'left');
            
            if (!is_null($id)) {
                $tugasDb = $tugasDb->where("tugas.id",$id);
            }

            if ($g_previlege == "nonasn") {
                $tugasDb = $tugasDb->where("tugas.user_id",$g_user_id);
            }
            else {
                if ($g_previlege != "admin") {
                    $tugasDb = $tugasDb->where("bagian.name",$g_bagian);

                    if (!is_null($g_subagian)) {
                        $tugasDb = $tugasDb->where("subagian.name",$g_subagian);
                    }
                }
            }

            if (!is_null($id)) {
                $tugasDb = $tugasDb->get()->getFirstRow();
                $tugasDb = (array)$tugasDb;

                if (count($tugasDb) != 0) {

                    $tugasDb["file_tugas"] = $this->db->table("tugas_file")
                        ->select("tugas_file.id as id_file,tugas_file.file_tugas")
                        ->join("tugas" ,"tugas.id = tugas_file.id_tugas", 'left')
                        ->where("tugas.id",$id)
                        ->get()->getResultArray();

                    if (count($tugasDb["file_tugas"]) != 0) {
                        $tugasDb["file_tugas"] = Utils::modifImgPath($tugasDb["file_tugas"],"file_tugas","/file_tugas/");
                    }
                }
            }
            else{
                $tugasDb = $tugasDb->orderBy("tugas.created_at","desc")->get()->getResultArray();
            }

            $respond  = [
                "code"  => count($tugasDb) == 0 ? 404  : 200,
                "error" => count($tugasDb) == 0 ? true : false,
                "data"  => count($tugasDb) == 0 ? []   : $tugasDb
            ];

            if (count($tugasDb) == 0) {
                unset($respond["data"]);
                $respond["message"] = !is_null($id)? "tugas dengan id:$id tidak ditemukan" :  "tugas belum ditambah";
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
     * Create Tugas
     * ============
     * - api for create new tugas
     * - previlege     : nonasn
     * - url           : /tugas/create
     * - Method        : POST
     * - request header: token
     */
    public function create()
    {
        global $g_user_id;
        global $g_previlege;
        global $g_bagian;
        global $g_subagian;

        try {
            $post  = $this->request->getPost();
            $files = $this->request->getFileMultiple('file_tugas');

            if ($g_previlege != "nonasn") {
                if (is_null($files)) {
                    $validationName = "createTugasValidateAsn";
                }
                else{
                    $validationName = "createTugasValidateAsnWithFile";
                }

                // Set allowed user_id
                $rowsUser = $this->db->table("users")->select("users.id as id")
                    ->join("user_detail"      ,"users.id = user_detail.user_id", 'left')
                    ->join("user_type" ,"users.id_previlege = user_type.id")
                    ->join("kedudukan" ,"kedudukan.id = user_detail.id_kedudukan", 'left')
                    ->join("bagian"    ,"user_detail.id_bagian = bagian.id", 'left')
                    ->join("subagian"  ,"user_detail.id_subagian = subagian.id", 'left')
                    ->where("users.id_previlege",4);

                if (in_array($g_previlege,["kabag"])) {
                    $rowsUser = $rowsUser->where("bagian.name",$g_bagian)
                        ->whereIn("users.id_previlege",[3,4]);
                }
                else if (in_array($g_previlege,["kasubag"])) {
                    $rowsUser = $rowsUser->where("subagian.name",$g_subagian)
                        ->whereIn("users.id_previlege",[4]);
                }

                $rowsUser = $rowsUser->get()->getResultArray();
                
                $allowedUserId = "";
                foreach ($rowsUser as $value) {
                    $allowedUserId .= $value["id"].",";
                }
                $post["allowedUserId"] = trim($allowedUserId,",");
            } 
            else {
                $validationName = "createTugasValidate";
                unset($post["user_id"]);
                unset($post["komentar"]);
            }
            
            if (!is_null($files)) {
                foreach ($files as $f) {
                    $post['file_tugas'] = $f;
    
                    $this->validation->run($post,$validationName);
                }
            } 
            else {
                $this->validation->run($post,$validationName);
            }

            $errors = $this->validation->getErrors();

            if($errors) {
                $respond = [
                    'code'    => 400,
                    'error'   => true,
                    'message' => $errors,
                ]; 
            } 
            else {
                //  -- Ci4 --
                // $myTime = new Time('now', 'Asia/Jakarta', 'id_ID');
                // $myTime->toLocalizedString('MMMM d, yyyy 00:00');

                // -- Native --
                $date = new DateTime();
                $date->setTimezone(new DateTimeZone('Asia/Jakarta'));
                // $date->format('d-M-Y H:i:s');

                $this->db->transBegin();

                $id = uniqid();

                // insert table tugas
                $this->db->table("tugas")->insert([
                    "id"         => $id,
                    "user_id"    => isset($post["user_id"]) ? $post["user_id"] : $g_user_id,
                    "title"      => $post['title'],
                    "status"     => ($g_previlege == "nonasn") ? "pengecekan" : "tugas baru",
                    "komentar"   => isset($post["komentar"]) ? $post["komentar"] : null,
                    "created_at" => $date->getTimestamp(),
                ]);

                // insert table tugas_file
                $i = 0;
                $fileSaved = true;

                if (!is_null($files)) {
                    $arrFileName = [];
                    foreach ($files as $f) {
                        $uniqId  = uniqid();
                        $newName = $uniqId."_".$f->getClientName();
                        $arrFileName[] = $newName;
    
                        $this->db->table("tugas_file")->insert([
                            "id"         => $uniqId,
                            "id_tugas"   => $id,
                            "file_tugas" => $newName,
                        ]); 
                    }
    
                    // save file to folder
                    foreach ($files as $f) {
                        if (!$f->move('file_tugas/',$arrFileName[$i++])) {
                            $fileSaved = false;
                        }  
                    }
                }

                if ($fileSaved) {
                    $this->db->transCommit();
                    $respond = [
                        "error"   => false,
                        "code"    => 201,
                        "message" => "tugas berhasil disimpan",
                    ];
                }
                else {
                    $this->db->transRollback();
                    $respond = [
                        "error"   => true,
                        "code"    => 500,
                        "message" => "terjadi kesalahan saat menyimpan file",
                    ];
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
     * Update Tugas
     * ============
     * - api for update tugas
     * - previlege     : admin, kabag, kasubag, nonasn
     * - url           : /tugas/update
     * - Method        : PUT
     * - request header: token
     */
    public function update($id = null)
    {
        Utils::_methodParser("put");
        global $put;
        $files = $this->request->getFiles('file_tugas');

        global $g_user_id;
        global $g_previlege;
        global $g_bagian;
        global $g_subagian;

        try {
            if ($g_previlege == "nonasn") {
                unset($put['status']);
                unset($put['komentar']);
                $this->validation->run($put,'updateTugasValidateNonAsn');
            } 
            else {
                $this->validation->run($put,'updateTugasValidateAsn');
            }
                            
            $errors = $this->validation->getErrors();

            if (count($files) != 0) {
                if ($g_previlege == "nonasn") {
                    $put['status'] = "pengecekan";
                } 

                foreach ($files as $f) {
                    $mimeType = explode(".",$f->getClientName());
                    $mimeType = end($mimeType);

                    if (!in_array($mimeType,["pdf","csv","xls","xlsx","ppt","doc","docx","png","jpg","jpeg"])) {
                        $errors["file_tugas"] = "format file '.$mimeType' tidak dizinkan";
                    }

                }
            }

            if($errors) {
                $respond = [
                    'code'    => 400,
                    'error'   => true,
                    'message' => $errors,
                ]; 
            }
            else {
                $this->db->transBegin();

                // valildate ID
                $tugasDb = $this->db->table("tugas")->select("tugas.title,tugas.status,tugas.komentar")
                    ->join("user_detail" ,"tugas.user_id = user_detail.user_id", 'left')
                    ->join("bagian"      ,"user_detail.id_bagian = bagian.id", 'left')
                    ->join("subagian"    ,"user_detail.id_subagian = subagian.id", 'left')
                    ->where("tugas.id",$id);
    
                if ($g_previlege == "nonasn") {
                    $tugasDb = $tugasDb->where("tugas.user_id",$g_user_id);
                }
                else {
                    if ($g_previlege != "admin") {
                        $tugasDb = $tugasDb->where("bagian.name",$g_bagian);
    
                        if (!is_null($g_subagian)) {
                            $tugasDb = $tugasDb->where("subagian.name",$g_subagian);
                        }
                    }
                }
    
                $tugasDb = $tugasDb->get()->getFirstRow();
    
                if (is_null($tugasDb)) {
                    $respond = [
                        "error"   => true,
                        "code"    => 404,
                        "message" => "tugas dengan id:$id tidak ditemukan",
                    ];
                } 
                else {
                    // update table tugas
                    $this->db->table("tugas")->where("tugas.id",$id)->update([
                        "title"    => $put['title'],
                        "status"   => isset($put['status']) ? $put['status'] : $tugasDb->status,
                        "komentar" => isset($put['komentar']) ? $put['komentar'] : $tugasDb->komentar,
                    ]);

                    // update table tugas_file
                    $i = 0;
                    $fileSaved = true;

                    if (count($files) != 0) {
                        $arrFileName = [];
                        foreach ($files as $f) {
                            $uniqId  = uniqid();
                            $newName = $uniqId."_".$f->getClientName();
                            $arrFileName[] = $newName;
        
                            $this->db->table("tugas_file")->insert([
                                "id"         => $uniqId,
                                "id_tugas"   => $id,
                                "file_tugas" => $newName,
                            ]); 
                        }

                        // save file to folder
                        foreach ($files as $f) {
                            if (!rename($f->getRealPath(),'./file_tugas/'.$arrFileName[$i++])) 
                            {
                                $fileSaved = false;
                            } 
                        }

                    }

                    if ($fileSaved) {
                        $this->db->transCommit();
                        $respond = [
                            "error"   => false,
                            "code"    => 201,
                            "message" => "tugas berhasil diupdate",
                        ];
                    }
                    else {
                        $this->db->transRollback();
                        $respond = [
                            "error"   => true,
                            "code"    => 500,
                            "message" => "tugas gagal diupdate",
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

    /**
     * Delete file
     * ============
     * - api for delete file tugas
     * - previlege     : admin, kabag, kasubag, nonasn
     * - url           : /tugas/delete_file
     * - Method        : DELETE
     * - request header: token
     */
    public function deleteFile($id = null)
    {
        global $g_user_id;
        global $g_previlege;
        global $g_bagian;
        global $g_subagian;

        try {
            // find file from DB
            $tugasDb = $this->db->table("tugas_file")->select("tugas_file.file_tugas")
                ->join("tugas"       ,"tugas_file.id_tugas = tugas.id", 'left')
                ->join("user_detail" ,"tugas.user_id = user_detail.user_id", 'left')
                ->join("bagian"      ,"user_detail.id_bagian = bagian.id", 'left')
                ->join("subagian"    ,"user_detail.id_subagian = subagian.id", 'left')
                ->where("tugas_file.id",$id);
    
            if ($g_previlege == "nonasn") {
                $tugasDb = $tugasDb->where("tugas.user_id",$g_user_id);
            }
            else {
                if ($g_previlege != "admin") {
                    $tugasDb = $tugasDb->where("bagian.name",$g_bagian);
        
                    if (!is_null($g_subagian)) {
                        $tugasDb = $tugasDb->where("subagian.name",$g_subagian);
                    }
                }
            }
    
            $tugasDb = $tugasDb->get()->getFirstRow();
    
            if (is_null($tugasDb)) {
                $respond = [
                    "error"   => true,
                    "code"    => 404,
                    "message" => "file tugas dengan id:$id tidak ditemukan",
                ];
            } 
            else{
                $this->db->transBegin();

                $this->db->table("tugas_file")->where("id",$id)->delete();

                if (unlink('./file_tugas/'.$tugasDb->file_tugas)) {
                    $this->db->transCommit();
                    $respond = [
                        "error"   => false,
                        "code"    => 201,
                        "message" => "file tugas dengan id:$id berhasil dihapus",
                    ];
                } 
                else {
                    $this->db->transRollback();
                    $respond = [
                        "error"   => true,
                        "code"    => 500,
                        "message" => "gagal menghapus file",
                    ];
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
     * Delete tugas
     * ============
     * - api for delete tugas
     * - previlege     : admin, kabag, kasubag, nonasn
     * - url           : /tugas/delete
     * - Method        : DELETE
     * - request header: token
     */
    public function delete($id = null)
    {
        global $g_user_id;
        global $g_previlege;
        global $g_bagian;
        global $g_subagian;

        try {
            // get data tugas from db
            $tugasDb = $this->db->table("tugas")->select("tugas.title,tugas_file.id as id_file,tugas_file.file_tugas")
                ->join("tugas_file"  ,"tugas.id = tugas_file.id_tugas", 'left')
                ->join("user_detail" ,"tugas.user_id = user_detail.user_id", 'left')
                ->join("bagian"      ,"user_detail.id_bagian = bagian.id", 'left')
                ->join("subagian"    ,"user_detail.id_subagian = subagian.id", 'left')
                ->where("tugas.id",$id);

            if ($g_previlege == "nonasn") {
                $tugasDb = $tugasDb->where("tugas.user_id",$g_user_id);
            }
            else {
                if ($g_previlege != "admin") {
                    $tugasDb = $tugasDb->where("bagian.name",$g_bagian);
    
                    if (!is_null($g_subagian)) {
                        $tugasDb = $tugasDb->where("subagian.name",$g_subagian);
                    }
                }
            }

            $tugasDb = $tugasDb->get()->getResultObject();

            if (count($tugasDb) == 0) {
                $respond = [
                    "error"   => true,
                    "code"    => 404,
                    "message" => "tugas dengan id:$id tidak ditemukan",
                ];
            } 
            else {
                foreach ($tugasDb as $t) {
                    if (!is_null($t->file_tugas)) {
                        unlink('./file_tugas/'.$t->file_tugas);
                    }
                }

                $this->db->table("tugas")->where("id",$id)->delete();

                $respond = [
                    "error"   => false,
                    "code"    => 201,
                    "message" => "tugas dengan id:$id berhasil dihapus",
                ];
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
}
