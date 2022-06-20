<?php
namespace App\Utils;

use App\Utils\Utils;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class TokenUtil {

    /**
     * Database Connection
     */
    private static function dbconnect()
    {
        return \Config\Database::connect();
    }

    /**
     * TOKEN KEY.
     */
    private static function getKey() : String
    {
        return "03102000";
    }

    /**
     * Generate token
     */
    public static function generateToken(Array $data): String
    {
        $payload = $data;
        $payload["expired"] = time()+3600;
        $payload = Utils::removeNullObjEl($payload);

        return JWT::encode($payload, self::getKey(), 'HS256');
    }

    /**
     * Check token
     */
    public static function checkToken(?string $token = null,?bool $dbcheck = true): Array
    {
        try {
            // if ($token == null) {
            //     $token = self::getTokenFromHeader();
            // }

            $decoded = JWT::decode($token, new Key(self::getKey(),"HS256"));
            $decoded = (array)$decoded;

            if ($dbcheck == false) {
                $decoded["expired"] = $decoded["expired"]-time();
                
                return [
                    'error' => false,
                    'code'  => 200,
                    'data'  => $decoded,
                ];
            }
            else if (time() < $decoded['expired']) { // <
                // $dbresult = self::dbconnect()->table("user_token")
                //     ->getWhere(["token" => $token])
                //     ->getFirstRow();
                
                $decoded["expired"] = $decoded["expired"]-time();
                
                // if (!is_null($dbresult)) {
                //     return [
                //         'error' => false,
                //         'code'  => 200,
                //         'data'  => $decoded,
                //     ];
                // } 
                // else {
                //     Utils::httpResponse([
                //         'error'   => true,
                //         'code'    => 401,
                //         'message' => 'invalid token',
                //     ]);
                // }

                return [
                    'error' => false,
                    'code'  => 200,
                    'data'  => $decoded,
                ];
            } 
            else {
                // $dbresult = self::dbconnect()->table("user_token")
                //     ->where("token", $token)
                //     ->delete();

                Utils::httpResponse([
                    'error'   => true,
                    'code'    => 401,
                    // 'message' => ($dbresult) ? 'token expired' : 'invalid token',
                    'message' => 'token expired', 
                ]);
            }
        } 
        catch (\Throwable $ex) {
            $response = [
                'error'   => true,
                'code'    => 500,
                'message' => 'invalid token'
            ];

            if ($dbcheck == false) {
                return $response;
            }

            Utils::httpResponse($response);
        }
    }
} 