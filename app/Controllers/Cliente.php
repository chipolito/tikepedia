<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Cliente extends BaseController
{
    public function __construct()
    {
        if (session()->get('usuario_tipo') < 3) {
            echo 'Access denied';
            exit;
        }
    }

    public function index()
    {
        return view('cliente/dashboard');
    }

    public function ticketsNuevos()
    {
        return view('cliente/ticketsNuevos');
    }
}