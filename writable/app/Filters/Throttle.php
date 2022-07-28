<?php

namespace App\Filters;

use App\Utils\Utils;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class Throttle implements FilterInterface
{
    /**
     * This is a demo implementation of using the Throttler class
     * to implement rate limiting for your application.
     *
     * @param array|null $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $throttler = Services::throttler();
        
        if ($throttler->check(md5($request->getIPAddress()), 10, 10) == false) {
            Utils::httpResponse([
                'error'   => true,
                'code'    => 429,
                'message' => 'request blocked'
            ]);
        }
    }

    /**
     * We don't have anything to do here.
     *
     * @param array|null $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // ...
    }
}