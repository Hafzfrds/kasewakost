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
            ->orderBy('id_user', 'DESC') // 🔥 penting
            ->findAll();
    } else {
        $data['users'] = $model
            ->orderBy('id_user', 'DESC') // 🔥 penting
            ->findAll();
    }

    $data['keyword'] = $keyword;

    return view('admin/user/index', $data);
}


    public function create()
    {
        return view('admin/user/create');
    }


    public function store()
    {
        $model = new UserModel();

        $model->insert([
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama' => $this->request->getPost('nama'),
            'role' => $this->request->getPost('role'),
            'status_user' => $this->request->getPost('status_user')
        ]);

        return redirect()->to('/admin/user');
    }


    public function edit($id)
    {
        $model = new UserModel();

        $data['user'] = $model->find($id);

        return view('admin/user/edit', $data);
    }


    public function update($id)
    {
        $model = new UserModel();

        $data = [
            'username' => $this->request->getPost('username'),
            'nama' => $this->request->getPost('nama'),
            'role' => $this->request->getPost('role'),
            'status_user' => $this->request->getPost('status_user')
        ];

        // jika password diisi
        if($this->request->getPost('password')){
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $model->update($id, $data);

        return redirect()->to('/admin/user');
    }


    public function delete($id)
    {
        $model = new UserModel();

        $model->delete($id);

        return redirect()->to('/admin/user');
    }

}