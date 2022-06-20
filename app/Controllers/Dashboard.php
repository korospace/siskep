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
     * PAGE: Penempatan
     * - show Penempatan page in dashboard
     */
    public function penempatan()
    {
        global $g_token;
        global $g_previlege;
        global $g_idbagian;
        global $g_idsubagian;

        $data = [
            'title' => 'penempatan',
            'token' => $g_token,
            'previlege'  => $g_previlege,
            'idbagian'   => $g_idbagian,
            'idsubagian' => $g_idsubagian,
        ];

        return view("DashboardPage/Penempatan/index",$data);
    }

    /**
     * PAGE: List Users
     * - show list users page in dashboard
     */
    public function listUsers()
    {
        global $g_token;
        global $g_previlege;
        global $g_bagian;
        global $g_idbagian;
        global $g_subagian;
        global $g_idsubagian;

        $data = [
            'title' => 'pegawai',
            'token' => $g_token,
            'previlege'  => $g_previlege,
            'bagian'     => $g_bagian,
            'idbagian'   => $g_idbagian,
            'subagian'   => $g_subagian,
            'idsubagian' => $g_idsubagian,
        ];

        return view("DashboardPage/Users/index",$data);
    }

    /**
     * PAGE: Surat Keputusan
     * - show list users page in dashboard
     */
    public function suratKeputusan()
    {
        global $g_token;
        global $g_previlege;
        global $g_bagian;
        global $g_idbagian;
        global $g_subagian;
        global $g_idsubagian;

        $data = [
            'title' => 'surat keputusan',
            'token' => $g_token,
            'previlege'  => $g_previlege,
            'bagian'     => $g_bagian,
            'idbagian'   => $g_idbagian,
            'subagian'   => $g_subagian,
            'idsubagian' => $g_idsubagian,
        ];

        return view("DashboardPage/SuratKeputusan/index",$data);
    }

    /**
     * PAGE: Surat Keputusan
     * - show list users page in dashboard
     */
    public function tugas()
    {
        global $g_token;
        global $g_previlege;
        global $g_bagian;
        global $g_idbagian;
        global $g_subagian;
        global $g_idsubagian;

        $data = [
            'title' => 'tugas',
            'token' => $g_token,
            'previlege'  => $g_previlege,
            'bagian'     => $g_bagian,
            'idbagian'   => $g_idbagian,
            'subagian'   => $g_subagian,
            'idsubagian' => $g_idsubagian,
        ];

        return view("DashboardPage/Tugas/index",$data);
    }

    /**
     * PAGE: profile
     * - show profile page in dashboard
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
            return view("DashboardPage/Profile/index",$data);
        }
    }
}
