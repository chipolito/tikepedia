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

    public function ticketsSinAtencion()
    {
        return view('cliente/ticketsSinAtencion');
    }

    public function ticketsEnProceso()
    {
        return view('cliente/ticketsEnProceso');
    }

    public function ticketsAtrasados()
    {
        return view('cliente/ticketsAtrasados');
    }

    public function ticketsPorAprobar()
    {
        return view('cliente/ticketsPorAprobar');
    }
}