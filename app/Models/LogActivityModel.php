<?php

namespace App\Models;

use CodeIgniter\Model;

class LogActivityModel extends Model
{
    protected $table      = 'log_activity';
    protected $primaryKey = 'id_log';

    protected $allowedFields = [
        'id_user',
        'username',
        'role',
        'aktivitas',
        'keterangan',
        'tanggal'
    ];

    protected $useTimestamps = false;
}