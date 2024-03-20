<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Control extends BaseController
{
    public function login()
    {
        return view('login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}