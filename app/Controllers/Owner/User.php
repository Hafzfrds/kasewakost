<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;

class User extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');

  
        $keyword = $this->request->getGet('keyword');
        if ($keyword) {
            $builder->groupStart()
                ->like('username', $keyword)
                ->orLike('nama', $keyword)
                ->orLike('role', $keyword)
                ->groupEnd();
        }

        $data['user'] = $builder->get()->getResult();

        return view('owner/user_lihat', $data);
    }
}