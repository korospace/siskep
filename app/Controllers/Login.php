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
            'title'   => 'login',
            'lasturl' => (isset($_COOKIE['lasturl'])) ? $_COOKIE['lasturl'] : '',
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
                ->select("users.id as id,users.password,users.id_previlege,user_type.type as previlege,user_detail.status,bagian.id as id_bagian,bagian.name as bagian,subagian.id as id_subagian,subagian.name as subagian")
                ->join("user_type"   ,"users.id_previlege = user_type.id")
                ->join("user_detail" ,"users.id = user_detail.user_id", 'left')
                ->join("bagian"      ,"user_detail.id_bagian = bagian.id", 'left')
                ->join("subagian"    ,"user_detail.id_subagian = subagian.id", 'left')
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
                        if ($dbresult["status"] == 'nonactive') {
                            $respond = [
                                'code'    => 400,
                                'error'   => true,
                                'message' => "Maaf, akun anda <b>dinonaktifkan<b>",
                            ];
                        }
                        else {
                            $data = [
                                "user_id" => $dbresult["id"],
                                "token"   => TokenUtil::generateToken([
                                    "user_id"      => $dbresult["id"],
                                    "password"     => $post["password"],
                                    "status"       => $dbresult["status"],
                                    "id_previlege" => $dbresult["id_previlege"],
                                    "previlege"    => $dbresult["previlege"],
                                    "bagian"       => $dbresult["bagian"],
                                    "id_bagian"    => $dbresult["id_bagian"],
                                    "subagian"     => $dbresult["subagian"],
                                    "id_subagian"  => $dbresult["id_subagian"],
                                ])
                            ];
    
                            // $this->db->table("user_token")->insert($data);
    
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
