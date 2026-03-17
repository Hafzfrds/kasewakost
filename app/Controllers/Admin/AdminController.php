<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class AdminController extends BaseController
{
    public function dashboard()
    {
        return view('admin/dashboard');
    }
}