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
    ];

    protected $returnType = 'array';

  
    protected $validationRules = [
        'name' => 'required|string|max_length[255]',
        'email' => 'required|valid_email|is_unique[students.email,id,{id}]',
        'phone' => 'permit_empty|string|max_length[20]',
        'password' => 'required|string|min_length[8]',
        'year_study' => 'required|integer',
        'semester' => 'required|integer',
        'reg_no' => 'required|string|is_unique[students.reg_no,id,{id}]'
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'This email address is already registered.',
        ],
        'reg_no' => [
            'is_unique' => 'This registration number is already in use.',
        ],
    ];

    protected $skipValidation = false;
}
