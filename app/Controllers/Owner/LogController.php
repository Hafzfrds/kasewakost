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
                ->paginate(10); // 10 data per halaman
        } else {
            $log = $model
                ->orderBy('tanggal', 'DESC')
                ->paginate(10);
        }

        $data = [
            'log' => $log,
            'keyword' => $keyword,
            'pager' => $model->pager
        ];

        return view('owner/log_activity', $data);
    }
}