<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Utils\Utils;
use App\Utils\TokenUtil;

class ApiGuard implements FilterInterface
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
        $request    = \Config\Services::request();
        $authHeader = $request->getHeader('token');
        $token      = ($authHeader != null) ? $authHeader->getValue() : null;
        $result     = TokenUtil::checkToken($token);
        $GLOBALS["g_user_id"]      = $result['data']['user_id'];
        $GLOBALS["g_password"]     = $result['data']['password'];
        $GLOBALS["g_previlege"]    = $result['data']['previlege'];
        $GLOBALS["g_id_previlege"] = $result['data']['id_previlege'];
        $GLOBALS["g_bagian"]   = isset($result['data']['bagian'])   ? $result['data']['bagian']   : null;
        $GLOBALS["g_subagian"] = isset($result['data']['subagian']) ? $result['data']['subagian'] : null;
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
