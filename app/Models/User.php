<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['full_name','email','password','role','password_reset_required','first_login','usertype'];

    public function getFullNameById($id)
    {
        return $this->where('id', $id)->first()['full_name'];
    }
   
}
