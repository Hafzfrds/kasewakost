<?php

use App\Models\LogActivityModel;

if (!function_exists('logActivity')) {
    function logActivity($aktivitas, $keterangan, $id_user = null, $username = null, $role = null)
    {
        $session = session();
        $logModel = new LogActivityModel();

        $logModel->insert([
            'id_user'    => $id_user ?? $session->get('id_user'),
            'username'   => $username ?? $session->get('username'),
            'role'       => $role ?? $session->get('role'),
            'aktivitas'  => $aktivitas,
            'keterangan' => $keterangan,
            'tanggal'    => date('Y-m-d H:i:s')
        ]);
    }
}