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
        global $g_previlege;

        $data = [
            'title' => 'dashboard',
            'token' => $g_token,
            'previlege' => $g_previlege,
        ];

        return view("Dashboard/index",$data);
    }
}
