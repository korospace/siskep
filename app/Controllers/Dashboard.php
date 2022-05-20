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
        global $g_password;
        global $g_previlege;

        $data = [
            'title' => 'dashboard',
            'token' => $g_token,
            'password'  => $g_password,
            'previlege' => $g_previlege,
        ];

        return view("Dashboard/index",$data);
    }

    /**
     * PAGE: Update profile
     * - show update profile page in dashboard
     */
    public function updateProfile()
    {
        global $g_token;
        global $g_password;
        global $g_previlege;

        $data = [
            'title' => 'update profile',
            'token' => $g_token,
            'password'  => $g_password,
            'previlege' => $g_previlege,
        ];

        if ($g_previlege == "admin") {
            return redirect()->to(base_url().'/login');
        }
        else {
            return view("Dashboard/UpdateProfile/index",$data);
        }
    }
}
