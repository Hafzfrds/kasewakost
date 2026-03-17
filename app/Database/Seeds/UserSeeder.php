<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [  'role' => 'admin',
                'status_user' => 'aktif'
            ],
            [
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'nama' => 'Administrator',
              
                'username' => 'kasir',
                'password' => password_hash('kasir123', PASSWORD_DEFAULT),
                'nama' => 'Kasir',
                'role' => 'kasir',
                'status_user' => 'aktif'
            ],
            [
                'username' => 'owner',
                'password' => password_hash('owner123', PASSWORD_DEFAULT),
                'nama' => 'Owner',
                'role' => 'owner',
                'status_user' => 'aktif'
            ]
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
