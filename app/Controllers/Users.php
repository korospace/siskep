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
        ->select("users.id as id,users.username,users.password,users.id_previlege,user_type.type as previlege,user_detail.nik,user_detail.npwp,user_detail.email,user_detail.nama_lengkap,user_detail.notelp,user_detail.alamat,user_detail.tgl_lahir,user_detail.kelamin,user_detail.agama,user_detail.pendidikan,user_detail.id_kedudukan,kedudukan.name as kedudukan,user_detail.income,user_detail.masa_kerja,user_detail.status,bagian.id as id_bagian,bagian.name as bagian,subagian.id as id_subagian,subagian.name as subagian")
        ->join("user_type"        ,"users.id_previlege = user_type.id")
        ->join("user_detail"      ,"users.id  = user_detail.user_id", 'left')
        ->join("kedudukan"        ,"kedudukan.id = user_detail.id_kedudukan", 'left')
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

        global $g_previlege;
        global $g_bagian;
        global $g_subagian;

        $rows = $this->db->table("users");

        if (isset($get['id'])) {
            $rows = $rows->select("users.id as id,users.username,users.password,users.id_previlege,user_type.type as previlege,user_detail.nik,user_detail.npwp,user_detail.email,user_detail.nama_lengkap,user_detail.notelp,user_detail.alamat,user_detail.tgl_lahir,user_detail.kelamin,user_detail.agama,user_detail.pendidikan,user_detail.id_kedudukan,kedudukan.name as kedudukan,user_detail.income,user_detail.masa_kerja,user_detail.status,bagian.id as id_bagian,bagian.name as bagian,subagian.id as id_subagian,subagian.name as subagian");
        } 
        else {
            $rows = $rows->select("users.id,users.username,user_type.type as previlege,user_detail.nik,user_detail.nama_lengkap,bagian.name as bagian,bagian.id as id_bagian,subagian.name as subagian,subagian.id as id_subagian,user_detail.id_kedudukan,user_detail.income,user_detail.masa_kerja");
        }

        $rows = $rows->join("user_detail"      ,"users.id = user_detail.user_id", 'left')
        ->join("user_type"        ,"users.id_previlege = user_type.id")
        ->join("kedudukan"        ,"kedudukan.id = user_detail.id_kedudukan", 'left')
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
            if (isset($get['name'])) {
                $rows = $rows->like("user_detail.nama_lengkap",$get['name']);
            }
            $rows = $rows->orderBy("users.created_at",$urutan)->get()->getResultArray();
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
            $post = $this->request->getPost();
            
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
            else if (isset($post['id_bagian'])) {
                $dbsubag = $dbsubag->where("id_bagian",$post['id_bagian']);
            }
            $dbsubag = $dbsubag->get()->getResultArray();
            
            $allowedSubag = "";
            foreach ($dbsubag as $value) {
                $allowedSubag .= $value["id"].",";
            }
            $allowedSubag = trim($allowedSubag,",");

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
                $this->validation->run($post,'userValidateBag');
            }
            if (isset($post["id_previlege"]) && in_array($post["id_previlege"],["3","4"])) 
            {
                if ($g_idsubagian != null) {
                    $post["id_subagian"] = $g_idsubagian;
                }
                else {
                    $post["id_subagian"] = isset($post["id_subagian"]) ? $post["id_subagian"] : "";
                }
                $this->validation->run($post,'userValidateSubag');
            }
            if (isset($post["id_previlege"]) && in_array($post["id_previlege"],["4"])) 
            {
                $this->validation->run($post,'createUserValidateDetail');
                
                if (isset($post["tgl_lahir"])) 
                {
                    $this->validation->run($post,'userValidateTglLahir');
                }
                if (isset($post["kelamin"])) 
                {
                    $this->validation->run($post,'userValidateKelamin');
                }
                if (isset($post["agama"])) 
                {
                    $this->validation->run($post,'userValidateAgama');
                }
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

                // Insert table users
                $data_users = [
                    "id" => $id,
                    "username" => htmlspecialchars($post["username"]),
                    // "password" => password_hash(preg_replace("/-/","",$post["tgl_lahir"]),PASSWORD_DEFAULT),
                    "password" => password_hash($post["username"],PASSWORD_DEFAULT),
                    "id_previlege" => (int) $post["id_previlege"],
                    "created_at"   => time(),
                ];
                $this->db->table("users")->insert($data_users);

                // Insert table user_detail_bag
                if (in_array($post["id_previlege"],["2","3","4"])) {
                    $this->db->table("user_detail_bag")->insert([
                        "user_id"   => $id,
                        "id_bagian" => $post["id_bagian"]
                    ]);
                }

                // Insert table user_detail_subag
                if (in_array($post["id_previlege"],["3","4"])) {
                    $this->db->table("user_detail_subag")->insert([
                        "user_id"     => $id,
                        "id_subagian" => $post["id_subagian"]
                    ]);
                }

                // Insert table user_detail
                if (in_array($post["id_previlege"],["4"])) 
                {
                    $this->db->table("user_detail")->insert([
                        "user_id"      => $id,
                        "nik"          => $post["nik"],
                        "npwp"         => htmlspecialchars(trim($post["npwp"])),
                        "email"        => htmlspecialchars(trim($post["email"])),
                        "notelp"       => $post["notelp"],
                        "id_kedudukan" => $post["id_kedudukan"],
                        "masa_kerja"   => $post["masa_kerja"],
                        "income"       => $post["income"],
                        "nama_lengkap" => !isset($post["nama_lengkap"])?"-": htmlspecialchars(strtolower(trim($post["nama_lengkap"]))),
                        "alamat"       => !isset($post["alamat"])      ?"-": htmlspecialchars(strtolower(trim($post["alamat"]))),
                        "pendidikan"   => !isset($post["pendidikan"])  ?"-": htmlspecialchars(strtolower(trim($post["pendidikan"]))),
                        "tgl_lahir"    => !isset($post["tgl_lahir"])?"-" : $post["tgl_lahir"],
                        "kelamin"      => !isset($post["kelamin"])  ?"-" : $post["kelamin"],
                        "agama"        => !isset($post["agama"])    ?"-" : $post["agama"],
                        "status"       => "active",
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
            else if (isset($put['id_bagian'])) {
                $dbsubag = $dbsubag->where("id_bagian",$put['id_bagian']);
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
                $this->validation->run($put,'userValidateBag');
            }
            if (isset($put["id_previlege"]) && in_array($put["id_previlege"],["3","4"])) 
            {
                if ($g_idsubagian != null) {
                    $put["id_subagian"] = $g_idsubagian;
                }
                else {
                    $put["id_subagian"] = isset($put["id_subagian"]) ? $put["id_subagian"] : "";
                }
                $this->validation->run($put,'userValidateSubag');
            }
            if (isset($put["id_previlege"]) && in_array($put["id_previlege"],["4"])) 
            {
                $this->validation->run($put,'updateUserValidateDetail');
                
                if (isset($put["tgl_lahir"])) 
                {
                    $this->validation->run($put,'userValidateTglLahir');
                }
                if (isset($put["kelamin"])) 
                {
                    $this->validation->run($put,'userValidateKelamin');
                }
                if (isset($put["agama"])) 
                {
                    $this->validation->run($put,'userValidateAgama');
                }
                if (isset($put["status"])) 
                {
                    $this->validation->run($put,'userValidateStatus');
                }
            }

            $errors = $this->validation->getErrors();
            
            // if there is id's error
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

                // Update table users
                $data_users = [
                    "username"     => htmlspecialchars($put["username"]),
                    "id_previlege" => (int) $put["id_previlege"],
                ];

                if (isset($put["new_password"])) {
                    $data_users["password"] = password_hash($put["new_password"],PASSWORD_DEFAULT); 
                }

                $updateStatus = $this->db->table("users")
                    ->where("id",$put["id"])
                    ->whereIn("id_previlege",$allowedPrevilegeArr)
                    ->update($data_users);

                if ($put["id_previlege"] == "3") {
                    $this->db->table("user_detail")
                        ->where("user_id",$put["id"])
                        ->delete();
                }
                
                // Update table user_detail_bag
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

                // Update table user_detail_subag
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

                if (in_array($put["id_previlege"],["4"])) 
                {
                    $data = [
                        "nik"          => $put["nik"],
                        "npwp"         => htmlspecialchars(trim($put["npwp"])),
                        "email"        => htmlspecialchars(trim($put["email"])),
                        "notelp"       => $put["notelp"],
                        "id_kedudukan" => $put["id_kedudukan"],
                        "masa_kerja"   => $put["masa_kerja"],
                        "income"       => $put["income"],
                        "nama_lengkap" => !isset($put["nama_lengkap"])?"-": htmlspecialchars(strtolower(trim($put["nama_lengkap"]))),
                        "alamat"       => !isset($put["alamat"])      ?"-": htmlspecialchars(strtolower(trim($put["alamat"]))),
                        "pendidikan"   => !isset($put["pendidikan"])  ?"-": htmlspecialchars(strtolower(trim($put["pendidikan"]))),
                        "tgl_lahir"    => !isset($put["tgl_lahir"])?"-" : $put["tgl_lahir"],
                        "kelamin"      => !isset($put["kelamin"])  ?"-" : $put["kelamin"],
                        "agama"        => !isset($put["agama"])    ?"-" : $put["agama"],
                        "status"       => !isset($put["status"]) ?"active": $put["status"],
                    ];

                    $isExist = $this->db->table("user_detail")
                        ->where("user_id",$put["id"])
                        ->get()
                        ->getFirstRow();
                    
                    if ($isExist) {
                        $this->db->table("user_detail")
                            ->where("user_id",$put["id"])
                            ->update($data);
                    } else {
                        $data["user_id"] = $put["id"];
                        $this->db->table("user_detail")
                            ->insert($data);
                    }
                    
                }
                
                $respond = [
                    'code'    => ($updateStatus) ? 201   : 401,
                    'error'   => ($updateStatus) ? false : true,
                    'message' => ($updateStatus) ? "pegawai dengan id:".$put["id"]." berhasil diupdate" : "access denied"
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

            if (isset($put["new_password"])) {
                $this->validation->run($put,'newPasswordValidate');
            }
            if ($g_previlege!="nonasn") {
                $this->validation->run($put,'updateProfileAsnValidate');
            } 
            else {
                $this->validation->run($put,'updateProfileNonAsnValidate');

                if (isset($put["tgl_lahir"])) 
                {
                    $this->validation->run($put,'userValidateTglLahir');
                }
                if (isset($put["kelamin"])) 
                {
                    $this->validation->run($put,'userValidateKelamin');
                }
                if (isset($put["agama"])) 
                {
                    $this->validation->run($put,'userValidateAgama');
                }
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
                
                if ($g_previlege=="nonasn") {
                    $this->db->table("user_detail")
                        ->where("user_id",$put["id"])
                        ->update([
                            "nik"          => $put["nik"],
                            "npwp"         => htmlspecialchars(trim($put["npwp"])),
                            "email"        => htmlspecialchars(trim($put["email"])),
                            "notelp"       => $put["notelp"],
                            "nama_lengkap" => !isset($put["nama_lengkap"])?"-": htmlspecialchars(strtolower(trim($put["nama_lengkap"]))),
                            "alamat"       => !isset($put["alamat"])      ?"-": htmlspecialchars(strtolower(trim($put["alamat"]))),
                            "pendidikan"   => !isset($put["pendidikan"])  ?"-": htmlspecialchars(strtolower(trim($put["pendidikan"]))),
                            "tgl_lahir"    => !isset($put["tgl_lahir"])?"-" : $put["tgl_lahir"],
                            "kelamin"      => !isset($put["kelamin"])  ?"-" : $put["kelamin"],
                            "agama"        => !isset($put["agama"])    ?"-" : $put["agama"],
                        ]);
                    
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
