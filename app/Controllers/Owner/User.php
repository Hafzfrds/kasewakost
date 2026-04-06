<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;

class User extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $data['user'] = $db->table('users')->get()->getResult();

        return view('owner/user_lihat', $data);
    }
}