<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function admin()
    {
        if (session()->get('role') != 'admin') {
            return redirect()->to('/dashboard-user');
        }

        return view('dashboard/admin');
    }

    public function user()
    {
        if (session()->get('role') != 'user') {
            return redirect()->to('/dashboard');
        }

        return view('dashboard/user');
    }

    
}