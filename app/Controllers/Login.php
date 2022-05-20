<?php

namespace App\Controllers;

use App\Utils\TokenUtil;

use CodeIgniter\RESTful\ResourceController;

class Login extends ResourceController
{
    private $db;
    private $validation;

    public function __construct()
    {
        $this->db = \Config\Database::connect(); 
        $this->validation = \Config\Services::validation();
    }

    /**
     * PAGE: login
     * - show login page
     */
    public function index()
    {
        $data = [
            'title' => 'login'
        ];

        return view("Login/index",$data);
    }

    /**
     * check token
     * ============
     * - api for check token duration
     * - url            : /login/show
     * - Method         : GET
     * - request header : token
     */
    public function show($id = null)
    {
        $authHeader = $this->request->getHeader('token');
        $token      = ($authHeader != null) ? $authHeader->getValue() : null;
        $respond    = TokenUtil::checkToken($token);

        return $this->respond($respond,$respond['code']);
    }

    /**
     * create token
     * ============
     * - api for login
     * - url         : /login/create
     * - Method      : POST
     * - request body: username,password
     */
    public function create()
    {
        
        try {
            $post    = $this->request->getPost();
            $this->validation->run($post,'loginValidate');
            $errors  = $this->validation->getErrors();
            
            if ($errors) {
                $respond = [
                    'code'    => 400,
                    'error'   => true,
                    'message' => $errors,
                ]; 
            } 
            else {
                
                $dbresult = (array)$this->db->table("users")
                ->select("users.id as id,users.username,users.password,users.id_previlege,user_type.type as previlege,user_detail.nik,user_detail.email,user_detail.nama_lengkap,user_detail.agama,user_detail.tgl_lahir,user_detail.pendidikan,user_detail.golongan,user_detail.masa_kerja,user_detail.alamat,user_detail.kelamin,user_detail.notelp,user_detail_bag.bag_name as bagian,user_detail_subag.subag_name as subagian")
                ->join("user_type"        ,"users.id_previlege = user_type.id")
                ->join("user_detail"      ,"users.id = user_detail.user_id", 'left')
                ->join("user_detail_bag"  ,"users.id = user_detail_bag.user_id", 'left')
                ->join("user_detail_subag","users.id = user_detail_subag.user_id", 'left')
                ->getWhere(["users.username"=>$post["username"]])
                ->getFirstRow();

                if (count($dbresult) == 0) {
                    $respond = [
                        'code'    => 400,
                        'error'   => true,
                        'message' => "username atau password salah",
                    ]; 
                } 
                else {
                    if (!password_verify($post["password"],$dbresult["password"])) {
                        $respond = [
                            'code'    => 400,
                            'error'   => true,
                            'message' => "username atau password salah",
                        ];
                    } 
                    else {
                        $data = [
                            "user_id" => $dbresult["id"],
                            "token"   => TokenUtil::generateToken([
                                "user_id"      => $dbresult["id"],
                                "username"     => $post["username"],
                                "password"     => $post["password"],
                                "nik"          => $dbresult["nik"],
                                "email"        => $dbresult["email"],
                                "nama_lengkap" => $dbresult["nama_lengkap"],
                                "agama"        => $dbresult["agama"],
                                "tgl_lahir"    => $dbresult["tgl_lahir"],
                                "pendidikan"   => $dbresult["pendidikan"],
                                "golongan"     => $dbresult["golongan"],
                                "masa_kerja"   => $dbresult["masa_kerja"],
                                "alamat"       => $dbresult["alamat"],
                                "kelamin"      => $dbresult["kelamin"],
                                "notelp"       => $dbresult["notelp"],
                                "id_previlege" => $dbresult["id_previlege"],
                                "previlege"    => $dbresult["previlege"],
                                "bagian"       => $dbresult["bagian"],
                                "subagian"     => $dbresult["subagian"],
                            ])
                        ];

                        $this->db->table("user_token")->insert($data);

                        $respond = [
                            'code'    => 200,
                            'error   '=> false,
                            'message' => "login berhasil",
                            'data' => [
                                "token" => $data["token"]
                            ],
                        ];

                    }
                }
            }
        } 
        catch (\Throwable $th) {
            $respond = [
                'code'    => 500,
                'error'   => true,
                "message" => $th->getMessage(),
                'debug'   => $th->getTraceAsString(),
            ]; 
        }
        

        return $this->respond($respond,$respond['code']);
    }

    /**
     * delete token
     * ============
     * - api for logout
     * - url           : /login/delete
     * - Method        : DELETE
     * - request header: token
     */
    public function delete($token = null)
    {
        $authHeader = $this->request->getHeader('token');
        $token      = ($authHeader != null) ? $authHeader->getValue() : null;
        TokenUtil::checkToken($token);

        $this->db->table("user_token")
            ->where("token", $token)
            ->delete();

        $respond = [
            "error"   => false,
            "code"    => 201,
            "message" => "logout success"
        ];

        return $this->respond($respond,$respond['code']);
    }
}
