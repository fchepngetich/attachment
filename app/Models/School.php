<?php

namespace App\Models;

use CodeIgniter\Model;

class School extends Model
{
    protected $table = 'schools';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name'];
   

    
}
