<?php

namespace App\Models;

use CodeIgniter\Model;

class Logs extends Model
{
    protected $table = 'system_logs';
    protected $allowedFields = ['user_id', 'action', 'details', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
}
