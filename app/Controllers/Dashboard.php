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

        return view("DashboardPage/Main/index",$data);
    }

    /**
     * PAGE: Update profile
     * - show update profile page in dashboard
     */
    public function updateProfile()
    {
        global $g_token;
        global $g_previlege;

        $data = [
            'title' => 'update profile',
            'token' => $g_token,
            'previlege' => $g_previlege,
        ];

        if ($g_previlege == "admin") {
            return redirect()->to(base_url());
        }
        else {
            return view("DashboardPage/UpdateProfile/index",$data);
        }
    }

    /**
     * PAGE: List Users
     * - show list users page in dashboard
     */
    public function listUsers()
    {
        global $g_token;
        global $g_previlege;

        $data = [
            'title' => 'pegawai',
            'token' => $g_token,
            'previlege' => $g_previlege,
        ];

        return view("DashboardPage/Users/index",$data);
    }

    /**
     * PAGE: Crud Users
     * - show crud users page in dashboard
     */
    public function crudUsers($title = null,$id = null)
    {
        global $g_token;
        global $g_previlege;

        $data = [
            'title' => $title,
            'token' => $g_token,
            'previlege' => $g_previlege,
        ];

        return view("DashboardPage/CrudUsers/index",$data);
    }
}
