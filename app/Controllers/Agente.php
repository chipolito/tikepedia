<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Agente extends BaseController
{
    public function __construct()
    {
        if (session()->get('usuario_tipo') == 3) {
            echo 'Access denied';
            exit;
        }
    }

    public function index()
    {
        return view('agente/dashboard');
    }
}