<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;

class KasirController extends BaseController
{
    public function dashboard()
    {
        return view('kasir/dashboard');
    }
}