<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Utils\Utils;

class Users extends ResourceController
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
     * - url           : /user/previlege
     * - Method        : GET
     * - request header: token
     */
    public function getPrevilege()
    {
        global $g_previlege;
        $types = [];

        if (in_array($g_previlege,["admin"])) {
            $types = ["admin"];
        }
        if (in_array($g_previlege,["kabag"])) {
            $types = ["admin","kabag"];
        }
        if (in_array($g_previlege,["kasubag"])) {
            $types = ["admin","kabag","kasubag"];
        }

        $rows = $this->db->table("user_type")->select("*")->whereNotIn("type",$types)->get()->getResultArray();

        $respond  = [
            "code"  => count($rows) == 0 ? 404  : 200,
            "error" => count($rows) == 0 ? true : false,
            "data"  => count($rows) == 0 ? []   : $rows
        ];

        if (count($rows) == 0) {
            unset($respond["data"]);
            $respond["message"] = "previlege belum ditambah";
        }

        return $this->respond($respond,$respond['code']);
    }

    /**
     * Get Data Profile
     * ============
     * - api for display profle user
     * - previlege     : admin
     * - url           : /user/proflie
     * - Method        : GET
     * - request header: token
     */
    public function getProfile()
    {
        global $g_user_id;
        global $g_password;

        $dbresult = (array)$this->db->table("users")
        ->select("users.id as id,users.username,users.password,users.id_previlege,user_type.type as previlege,user_detail.nik,user_detail.email,user_detail.nama_lengkap,user_detail.agama,user_detail.tgl_lahir,user_detail.pendidikan,user_detail.golongan,user_detail.status,user_detail.masa_kerja,user_detail.alamat,user_detail.kelamin,user_detail.notelp,bagian.id as id_bagian,bagian.name as bagian,subagian.id as id_subagian,subagian.name as subagian")
        ->join("user_type"        ,"users.id_previlege = user_type.id")
        ->join("user_detail"      ,"users.id  = user_detail.user_id", 'left')
        ->join("user_detail_bag"  ,"users.id  = user_detail_bag.user_id", 'left')
        ->join("bagian"           ,"bagian.id = user_detail_bag.id_bagian", 'left')
        ->join("user_detail_subag","users.id  = user_detail_subag.user_id", 'left')
        ->join("subagian"         ,"subagian.id = user_detail_subag.id_subagian", 'left')
        ->getWhere(["users.id"=>$g_user_id])
        ->getFirstRow();
        $dbresult["password"] = $g_password;

        $respond  = [
            "code"  => 200,
            "error" => false,
            "data"  => Utils::removeNullObjEl($dbresult)
        ];

        return $this->respond($respond,$respond['code']);
    }

    /**
     * Show All users
     * ============
     * - api for get users data
     * - previlege     : admin
     * - url           : /user/show
     * - Method        : GET
     * - request header: token
     */
    public function show($id = null)
    {
        $get    = $this->request->getGet();
        $urutan = (isset($get['urutan']) && strtolower($get['urutan']) == "terlama") ? "ASC" : "DESC";
        // var_dump($get);die;

        global $g_previlege;
        global $g_bagian;
        global $g_subagian;

        $rows = $this->db->table("users");

        if (isset($get['id'])) {
            $rows = $rows->select("users.id,users.username,users.id_previlege,user_detail.nik,user_detail.email,user_detail.nama_lengkap,user_detail.agama,user_detail.tgl_lahir,user_detail.pendidikan,user_detail.golongan,user_detail.status,user_detail.masa_kerja,user_detail.alamat,user_detail.kelamin,user_detail.notelp,,bagian.id as id_bagian,bagian.name as bagian,subagian.id as id_subagian,subagian.name as subagian");
        } 
        else {
            $rows = $rows->select("users.id,users.username,user_type.type as previlege,user_detail.nik,user_detail.nama_lengkap,user_detail.golongan,bagian.name as bagian,subagian.name as subagian");
        }

        $rows = $rows->join("user_detail"      ,"users.id = user_detail.user_id")
        ->join("user_type"        ,"users.id_previlege = user_type.id")
        ->join("user_detail_bag"  ,"users.id = user_detail_bag.user_id", 'left')
        ->join("bagian"           ,"bagian.id = user_detail_bag.id_bagian", 'left')
        ->join("user_detail_subag","users.id = user_detail_subag.user_id", 'left')
        ->join("subagian"         ,"subagian.id = user_detail_subag.id_subagian", 'left')
        ->where("users.id_previlege !=",1);

        if (isset($get['bagian']) && in_array($g_previlege,["admin"])) {
            $rows = $rows->where("bagian.name",$get['bagian']);
        }
        if (isset($get['subagian']) && in_array($g_previlege,["admin","kabag"])) {
            $rows = $rows->where("subagian.name",$get['subagian']);
        }

        if (in_array($g_previlege,["kabag"])) {
            $rows = $rows->where("bagian.name",$g_bagian)
                ->whereIn("users.id_previlege",[3,4]);
        }
        else if (in_array($g_previlege,["kasubag"])) {
            $rows = $rows->where("subagian.name",$g_subagian)
                ->whereIn("users.id_previlege",[4]);
        }

        if (isset($get['id'])) {
            $rows = $rows->where("users.id",$get['id']);
            $rows = (array)$rows->get()->getFirstRow();
        }
        else {
            $rows = $rows->orderBy("user_detail.id",$urutan)->get()->getResultArray();
        }

        $respond  = [
            "code"  => count($rows) == 0 ? 404  : 200,
            "error" => count($rows) == 0 ? true : false,
            "data"  => count($rows) == 0 ? []   : $rows
        ];

        if (count($rows) == 0) {
            unset($respond["data"]);
            $respond["message"] = "user belum ditambah";
        }

        return $this->respond($respond,$respond['code']);
    }

    /**
     * Create account
     * ============
     * - api for create new account
     * - previlege     : admin,kabag,kasubag
     * - url           : /user/create
     * - Method        : POST
     * - request header: token
     */
    public function create()
    {
        try {
            global $g_previlege;
            global $g_idbagian;
            global $g_idsubagian;
            
            // Set allowed previlege
            if ($g_previlege=="admin") {
                $allowedPrevilege = "2,3,4";
            }
            if ($g_previlege=="kabag") {
                $allowedPrevilege = "3,4";
            }
            if ($g_previlege=="kasubag") {
                $allowedPrevilege = "4";
            }

            // Set allowed subagian
            $dbsubag = $this->db->table("subagian")->select("*");
            if ($g_idbagian != null) {
                $dbsubag = $dbsubag->where("id_bagian",$g_idbagian);
            }
            $dbsubag = $dbsubag->get()->getResultArray();
            
            $allowedSubag = "";
            foreach ($dbsubag as $value) {
                $allowedSubag .= $value["id"].",";
            }
            $allowedSubag = trim($allowedSubag,",");

            $post = $this->request->getPost();
            $post["allowedPrevilege"] = $allowedPrevilege;
            $post["allowedSubagian"]  = $allowedSubag;
            
            $this->validation->run($post,'createUserValidate');

            if (isset($post["id_previlege"]) && in_array($post["id_previlege"],["2","3","4"])) 
            {
                if ($g_idbagian != null) {
                    $post["id_bagian"] = $g_idbagian;
                }
                else {
                    $post["id_bagian"] = isset($post["id_bagian"]) ? $post["id_bagian"] : "";
                }
                $this->validation->run($post,'createUserBagValidate');
            }
            if (isset($post["id_previlege"]) && in_array($post["id_previlege"],["3","4"])) 
            {
                if ($g_idsubagian != null) {
                    $post["id_subagian"] = $g_idsubagian;
                }
                else {
                    $post["id_subagian"] = isset($post["id_subagian"]) ? $post["id_subagian"] : "";
                }
                $this->validation->run($post,'createUserSubagValidate');
            }

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

                $id = uniqid();

                $data_users = [
                    "id" => $id,
                    "username" => htmlspecialchars($post["username"]),
                    // "password" => password_hash(preg_replace("/-/","",$post["tgl_lahir"]),PASSWORD_DEFAULT),
                    "password" => password_hash($post["username"],PASSWORD_DEFAULT),
                    "id_previlege" => (int) $post["id_previlege"],
                ];

                $data_user_detail = [
                    "user_id"      => $id,
                    "nik"          => htmlspecialchars($post["nik"]),
                    "nama_lengkap" => htmlspecialchars(strtolower($post["nama_lengkap"])),
                    "email"        => $post["email"],
                    "agama"        => htmlspecialchars(strtolower($post["agama"])),
                    "pendidikan"   => htmlspecialchars(strtolower($post["pendidikan"])),
                    "golongan"     => htmlspecialchars(strtolower($post["golongan"])),
                    "status"       => "active",
                    "masa_kerja"   => $post["masa_kerja"],
                    "tgl_lahir"    => $post["tgl_lahir"],
                    "alamat"       => htmlspecialchars(strtolower($post["alamat"])),
                    "kelamin"      => $post["kelamin"],
                    "notelp"       => $post["notelp"],
                ];

                $this->db->table("users")->insert($data_users);
                $this->db->table("user_detail")->insert($data_user_detail);

                if (in_array($post["id_previlege"],["2","3","4"])) {
                    $this->db->table("user_detail_bag")->insert([
                        "user_id"   => $id,
                        "id_bagian" => $post["id_bagian"]
                    ]);
                }
                if (in_array($post["id_previlege"],["3","4"])) {
                    $this->db->table("user_detail_subag")->insert([
                        "user_id"     => $id,
                        "id_subagian" => $post["id_subagian"]
                    ]);
                }
                
                $transStatus = $this->db->transStatus();
                $respond = [
                    'code'  => ($transStatus) ? 201   : 500,
                    'error' => ($transStatus) ? false : true,
                ];
                
                if ($transStatus) {
                    $respond['message'] = "akun baru berhasil dibuat";
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
     * Update account
     * ============
     * - api for update account
     * - previlege     : admin,kabag,kasubag
     * - url           : /user/update/{:id}
     * - Method        : PUT
     * - request header: token
     */
    public function update($id = null)
    {
        try {
            Utils::_methodParser("put");
            global $put;
            global $g_previlege;
            global $g_idbagian;
            global $g_idsubagian;
            
            // Set allowed previlege
            if ($g_previlege=="admin") {
                $allowedPrevilege = "2,3,4";
                $allowedPrevilegeArr = ["2","3","4"];
            }
            if ($g_previlege=="kabag") {
                $allowedPrevilege = "3,4";
                $allowedPrevilegeArr = ["3","4"];
            }
            if ($g_previlege=="kasubag") {
                $allowedPrevilege = "4";
                $allowedPrevilegeArr = ["4"];
            }

            // Set allowed subagian
            $dbsubag = $this->db->table("subagian")->select("*");
            if ($g_idbagian != null) {
                $dbsubag = $dbsubag->where("id_bagian",$g_idbagian);
            }
            $dbsubag = $dbsubag->get()->getResultArray();
            
            $allowedSubag = "";
            foreach ($dbsubag as $value) {
                $allowedSubag .= $value["id"].",";
            }
            $allowedSubag = trim($allowedSubag,",");
            
            $put["id"] = $id;
            $put["allowedPrevilege"] = $allowedPrevilege;
            $put["allowedSubagian"]  = $allowedSubag;

            $this->validation->run($put,'updateUserValidate');

            if (isset($put["new_password"])) {
                $this->validation->run($put,'newPasswordValidate');
            }
            if (isset($put["id_previlege"]) && in_array($put["id_previlege"],["2","3","4"])) 
            {
                if ($g_idbagian != null) {
                    $put["id_bagian"] = $g_idbagian;
                }
                else {
                    $put["id_bagian"] = isset($put["id_bagian"]) ? $put["id_bagian"] : "";
                }
                $this->validation->run($put,'updateUserBagValidate');
            }
            if (isset($put["id_previlege"]) && in_array($put["id_previlege"],["3","4"])) 
            {
                if ($g_idsubagian != null) {
                    $put["id_subagian"] = $g_idsubagian;
                }
                else {
                    $put["id_subagian"] = isset($put["id_subagian"]) ? $put["id_subagian"] : "";
                }
                $this->validation->run($put,'updateUserSubagValidate');
            }

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

                $data_users = [
                    "username"     => htmlspecialchars($put["username"]),
                    "id_previlege" => (int) $put["id_previlege"],
                ];

                if (isset($put["new_password"])) {
                    $data_users["password"] = password_hash($put["new_password"],PASSWORD_DEFAULT); 
                }

                $data_user_detail = [
                    "nik"          => htmlspecialchars($put["nik"]),
                    "nama_lengkap" => htmlspecialchars(strtolower($put["nama_lengkap"])),
                    "email"        => $put["email"],
                    "agama"        => htmlspecialchars(strtolower($put["agama"])),
                    "pendidikan"   => htmlspecialchars(strtolower($put["pendidikan"])),
                    "golongan"     => htmlspecialchars(strtolower($put["golongan"])),
                    "status"       => $put["status"],
                    "masa_kerja"   => $put["masa_kerja"],
                    "tgl_lahir"    => $put["tgl_lahir"],
                    "alamat"       => htmlspecialchars(strtolower($put["alamat"])),
                    "kelamin"      => $put["kelamin"],
                    "notelp"       => $put["notelp"],
                ];

                $updateStatus = $this->db->table("users")
                    ->where("id",$put["id"])
                    ->whereIn("id_previlege",$allowedPrevilegeArr)
                    ->update($data_users);

                $this->db->table("user_detail")
                    ->where("user_id",$put["id"])
                    ->update($data_user_detail);
                
                if (in_array($put["id_previlege"],["2","3","4"])) {
                    $this->db->table("user_detail_bag")
                        ->where("user_id",$put["id"])
                        ->update([
                            "id_bagian" => $put["id_bagian"]
                        ]);
                    
                    if ($put["id_previlege"] == "2") {
                        $this->db->table("user_detail_subag")
                            ->where("user_id",$put["id"])
                            ->delete();
                    }
                }
                if (in_array($put["id_previlege"],["3","4"])) {
                    $isExist = $this->db->table("user_detail_subag")
                        ->where("user_id",$put["id"])
                        ->get()
                        ->getFirstRow();
                    
                    if ($isExist) {
                        $this->db->table("user_detail_subag")
                            ->where("user_id",$put["id"])
                            ->update([
                                "id_subagian" => $put["id_subagian"]
                            ]);
                    }
                    else {
                        $this->db->table("user_detail_subag")
                            ->insert([
                                "user_id" => $put["id"],
                                "id_subagian" => $put["id_subagian"]
                            ]);
                    }
                }
                
                $respond = [
                    'code'    => ($updateStatus) ? 201   : 401,
                    'error'   => ($updateStatus) ? false : true,
                    'message' => ($updateStatus) ? "pegawai dengan nama:".$put["nama_lengkap"]." berhasil diupdate" : "access denied"
                ];

                if ($updateStatus) {
                    $this->db->transCommit();
                } 
                else {
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
     * Update Profile
     * ============
     * - api for update profile
     * - previlege     : admin,kabag,kasubag,pegawau
     * - url           : /user/update_profile
     * - Method        : PUT
     * - request header: token
     */
    public function updateProfile()
    {
        try {
            Utils::_methodParser("put");
            global $put;
            global $g_user_id;
            global $g_previlege;

            $put["id"] = $g_user_id;

            if ($g_previlege=="admin") {
                $this->validation->run($put,'updateProfileAdminValidate');
            } 
            else {
                $this->validation->run($put,'updateProfileValidate');
            }

            if (isset($put["new_password"])) {
                $this->validation->run($put,'newPasswordValidate');
            }

            $errors = $this->validation->getErrors();
            
            if ($errors) {
                $respond = [
                    'code'    => 400,
                    'error'   => true,
                    'message' => $errors,
                ]; 
            } 
            else {
                $this->db->transBegin();

                $data_users = [
                    "username" => htmlspecialchars($put["username"]),
                ];

                if (isset($put["new_password"])) {
                    $data_users["password"] = password_hash($put["new_password"],PASSWORD_DEFAULT); 
                }

                $this->db->table("users")
                    ->where("id",$put["id"])
                    ->update($data_users);
                $affectedRows1 = $this->db->affectedRows();
                $affectedRows2 = 0;
                
                if ($g_previlege!="admin") {
                    $data_user_detail = [
                        "nik"          => htmlspecialchars($put["nik"]),
                        "nama_lengkap" => htmlspecialchars(strtolower($put["nama_lengkap"])),
                        "email"        => $put["email"],
                        "agama"        => htmlspecialchars(strtolower($put["agama"])),
                        "pendidikan"   => htmlspecialchars(strtolower($put["pendidikan"])),
                        "tgl_lahir"    => $put["tgl_lahir"],
                        "alamat"       => htmlspecialchars(strtolower($put["alamat"])),
                        "kelamin"      => $put["kelamin"],
                        "notelp"       => $put["notelp"],
                    ];

                    $this->db->table("user_detail")
                        ->where("user_id",$put["id"])
                        ->update($data_user_detail);
                    
                    $affectedRows2 = $this->db->affectedRows();
                }

                $affectedRows = $affectedRows1+$affectedRows2;
                
                $respond = [
                    'code'    => 201,
                    'error'   => false,
                    'message' => ($affectedRows!=0) ? "profile berhasil diupdate!" : "tidak ada yang diubah"
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
     * Delete account
     * ============
     * - api for delete account
     * - previlege     : admin,kabag,kasubag
     * - url           : /user/delete/{:id}
     * - Method        : DELETE
     * - request header: token
     */
    public function delete($id = null)
    {
        try {
            global $g_previlege;
            
            // Set allowed previlege
            if ($g_previlege=="admin") {
                $allowedPrevilege = ["2","3","4"];
            }
            if ($g_previlege=="kabag") {
                $allowedPrevilege = ["3","4"];
            }
            if ($g_previlege=="kasubag") {
                $allowedPrevilege = ["4"];
            }

            $data["id"] = $id;
            $this->validation->run($data,'deleteUserValidate');
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
                $this->db->table("users")
                    ->whereIn("users.id_previlege",$allowedPrevilege)
                    ->where("users.id",$id)
                    ->delete();

                $affectedRows = $this->db->affectedRows();
                $transStatus  = $this->db->transStatus();
                
                if ($transStatus) {
                    $respond = [
                        'code'  => ($affectedRows) ? 201   : 401,
                        'error' => ($affectedRows) ? false : true,
                        'message' => ($affectedRows) ? "pegawai dengan id (".$id.") berhasil didelete" : "access denied"
                    ];

                    $this->db->transCommit();
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
