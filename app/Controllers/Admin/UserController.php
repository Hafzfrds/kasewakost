<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        $model = new UserModel();

        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $data['users'] = $model
                ->like('username', $keyword)
                ->orLike('nama', $keyword)
                ->orLike('role', $keyword)
                ->orderBy('id_user', 'DESC')
                ->findAll();
        } else {
            $data['users'] = $model
                ->orderBy('id_user', 'DESC')
                ->findAll();
        }

        $data['keyword'] = $keyword;

        return view('admin/user/index', $data);
    }

    public function create()
    {
        return view('admin/user/create');
    }

    // SIMPAN USER
    public function store()
    {
        $model = new UserModel();

        $username = $this->request->getPost('username');

        $model->insert([
            'username' => $username,
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama' => $this->request->getPost('nama'),
            'role' => $this->request->getPost('role'),
            'status_user' => $this->request->getPost('status_user')
        ]);

        // LOG
        logActivity(
            'INSERT USER',
            'Menambahkan user ' . $username
        );

        return redirect()->to('/admin/user')
    ->with('success', 'Data user berhasil ditambahkan');
    }

    public function edit($id)
    {
        $model = new UserModel();

        $data['user'] = $model->find($id);

        return view('admin/user/edit', $data);
    }

    // UPDATE USER
    public function update($id)
    {
        $model = new UserModel();

        $userLama = $model->find($id);

        $data = [
            'username' => $this->request->getPost('username'),
            'nama' => $this->request->getPost('nama'),
            'role' => $this->request->getPost('role'),
            'status_user' => $this->request->getPost('status_user')
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $model->update($id, $data);

        // CEK apakah nonaktifkan user
        if ($this->request->getPost('status_user') == 'nonaktif') {
            logActivity(
                'NONAKTIF USER',
                'Menonaktifkan user ' . $userLama['username']
            );
        } else {
            logActivity(
                'UPDATE USER',
                'Mengupdate user ' . $userLama['username']
            );
        }

       return redirect()->to('/admin/user')
    ->with('success', 'Data user berhasil diupdate');
    }

    // DELETE USER
    public function delete($id)
    {
        $model = new UserModel();

        $user = $model->find($id);

        $model->delete($id);

        // LOG
        logActivity(
            'DELETE USER',
            'Menghapus user ' . $user['username']
        );

        return redirect()->to('/admin/user')
    ->with('success', 'Data user berhasil dihapus');
    }
}