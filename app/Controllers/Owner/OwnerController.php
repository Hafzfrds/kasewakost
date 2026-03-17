<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;

class OwnerController extends BaseController
{
    public function dashboard()
    {
        return view('owner/dashboard');
    }
}