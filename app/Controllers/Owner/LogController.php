<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\LogActivityModel;

class LogController extends BaseController
{
    public function index()
    {
        $model = new LogActivityModel();

        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $log = $model
                ->like('username', $keyword)
                ->orLike('aktivitas', $keyword)
                ->orLike('keterangan', $keyword)
                ->orderBy('tanggal', 'DESC')
                ->findAll();
        } else {
            $log = $model
                ->orderBy('tanggal', 'DESC')
                ->findAll();
        }

        $data = [
            'log' => $log,
            'keyword' => $keyword
        ];

        return view('owner/log_activity', $data);
    }
}