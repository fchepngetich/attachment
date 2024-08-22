<?php

namespace App\Models;

use CodeIgniter\Model;

class Course extends Model
{
    
        protected $table = 'courses';
        protected $primaryKey = 'id';
        protected $allowedFields = ['name','school_id'];
    
        
}
