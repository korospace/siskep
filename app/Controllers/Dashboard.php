<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    /**
     * PAGE: Dashboard
     * - show dashboard page
     */
    public function index()
    {
        global $g_token;

        $data = [
            'title' => 'dashboard',
            'token' => $g_token
        ];

        return view("Dashboard/index",$data);
    }
}
