<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['full_name','email','password','role_id','password_reset_required','first_login','usertype'];

    public function getFullNameById($id)
    {
        return $this->where('id', $id)->first()['full_name'];
    }
    public function getSupervisorNameById($supervisorId)
    {
        $builder = $this->builder();
        $builder->select('full_name'); 
        $builder->where('id', $supervisorId); 
        
        $query = $builder->get();
        
        if ($query->getNumRows() > 0) {
            return $query->getRow()->full_name;
        } else {
            return null; 
        }

   
}
}
