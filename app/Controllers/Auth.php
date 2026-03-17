<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function process()
    {
        $session = session();
        $model = new UserModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->where('username', $username)->first();

        if ($user) {

            if (password_verify($password, $user['password'])) {

                $data = [
                    'id_user' => $user['id_user'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'isLoggedIn' => true
                ];

                $session->set($data);

                if ($user['role'] == 'admin') {
                    return redirect()->to('/admin/dashboard');
                }

                if ($user['role'] == 'kasir') {
                    return redirect()->to('/kasir/dashboard');
                }

                if ($user['role'] == 'owner') {
                    return redirect()->to('/owner/dashboard');
                }

            } else {
                return redirect()->back()->with('error','Password salah');
            }

        } else {
            return redirect()->back()->with('error','Username tidak ditemukan');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}