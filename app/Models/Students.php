<?php

namespace App\Models;

use CodeIgniter\Model;

class Students extends Model
{
    protected $table            = 'students';
    protected $primaryKey       = 'id';
  
    protected $allowedFields = [
        'name',
        'email',
        'phone',
        'password',
        'year_study',
        'semester',
        'reg_no',
        'usertype',
        'course',
        'school',
    ];

   
}
