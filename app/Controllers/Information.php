<?php

namespace App\Controllers;

use App\Utils\Utils;
use CodeIgniter\RESTful\ResourceController;

class Information extends ResourceController
{
    private $db;
    private $validation;

    public function __construct()
    {
        $this->db = \Config\Database::connect(); 
        $this->validation = \Config\Services::validation();
    }

    /**
     * Get Data Information
     * ============
     * - previlege     : no
     * - url           : /information/show
     * - Method        : GET
     */
    public function show($id = null)
    {
        $dbresult = $this->db->table("information")->get()->getFirstRow();
        $dbresult = Utils::modifImgPath($dbresult,"logo","/images/");

        $respond  = [
            "code"  => 200,
            "error" => false,
            "data"  => Utils::removeNullObjEl($dbresult)
        ];

        return $this->respond($respond,$respond['code']);
    }

    /**
     * Update Information
     * ============
     * - api for update information
     * - previlege     : admin
     * - url           : /information/update
     * - Method        : PUT
     * - request header: token
     */
    public function update($id = null)
    {
        try {
            Utils::_methodParser("put");
            global $put;

            $this->validation->run($put,'updateInformationValidate');
            $errors = $this->validation->getErrors();
            
            if (isset($errors["id"])) {
                foreach ($errors as $key => $value) {
                    if ($key != "id") {
                        unset($errors[$key]);
                    }
                }

                $errors = $errors["id"];
            }

            if($errors) {
                $response = [
                    'error'   => true,
                    'code'    => 400,
                    'message' => $errors,
                ];
        
                return $this->respond($response,400);
            } 
            else {
                $this->db->transBegin();

                $data = [
                    "id"    => $put['id'],
                    "title" => trim($put['title']),
                    "visi"  => trim($put['visi']),
                    "misi"  => trim($put['misi']),
                    "pengumuman" => trim($put['pengumuman']),
                ];

                if ($this->request->getFile('new_logo')) {
                    $xx['new_logo'] = $this->request->getFile('new_logo');
    
                    $this->validation->run($xx,'newLogoValidate');
                    $errors = $this->validation->getErrors();
    
                    if($errors) {
                        $response = [
                            'status'   => 400,
                            'error'    => true,
                            'messages' => $errors,
                        ];
                
                        return $this->respond($response,400);
                    }  
    
                    $file          = $xx['new_logo'];
                    $newFileName   = 'logo-kemendagri.webp';
                    $data['logo']  = $newFileName;

                    rename($file->getRealPath(),'./images/'.$newFileName);
                }

                $this->db->table("information")
                        ->where("id",$put["id"])
                        ->update($data);
                
                $respond = [
                    'code'    => 201,
                    'error'   => false,
                    'message' => "informasi berhasil diupdate!"
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
}
