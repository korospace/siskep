<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Utils\Utils;
use App\Utils\TokenUtil;
use LDAP\Result;

class DashboardAsn implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $token  = (isset($_COOKIE['token'])) ? $_COOKIE['token'] : null;
        $result = TokenUtil::checkToken($token,false);
        
        if($result['error'] == true) {
            setcookie('token', null, -1, '/');
            unset($_COOKIE['token']);
            return redirect()->to(base_url().'/login');
        } 
        else {
            if (!in_array($result['data']['previlege'],['admin','kabag','kasubag'])) {
                return redirect()->to(base_url().'/');
            } 
            else {
                $GLOBALS["g_token"]        = $token;
                $GLOBALS["g_password"]     = $result['data']['password'];
                $GLOBALS["g_previlege"]    = $result['data']['previlege'];
                $GLOBALS["g_id_previlege"] = $result['data']['id_previlege'];
                $GLOBALS["g_bagian"]    = isset($result['data']['bagian'])   ? $result['data']['bagian']   : null;
                $GLOBALS["g_idbagian"]  = isset($result['data']['id_bagian'])   ? $result['data']['id_bagian']   : null;
                $GLOBALS["g_subagian"]  = isset($result['data']['subagian']) ? $result['data']['subagian'] : null;
                $GLOBALS["g_idsubagian"]= isset($result['data']['id_subagian'])   ? $result['data']['id_subagian']   : null;
                setcookie('token',$token,Utils::cookieOps($result['data']['expired']));
            }
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
