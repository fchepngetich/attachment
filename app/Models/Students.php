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
    

    public function getFilteredStudents($searchData)
    {
        $builder = $this->builder();

        if (!empty($searchData['name'])) {
            $builder->like('name', $searchData['name']);
        }
        if (!empty($searchData['email'])) {
            $builder->like('email', $searchData['email']);
        }
        if (!empty($searchData['phone'])) {
            $builder->like('phone', $searchData['phone']);
        }
        if (!empty($searchData['year_study'])) {
            $builder->like('year_study', $searchData['year_study']);
        }
        if (!empty($searchData['semester'])) {
            $builder->like('semester', $searchData['semester']);
        }
        if (!empty($searchData['reg_no'])) {
            $builder->like('reg_no', $searchData['reg_no']);
        }
        if (!empty($searchData['course'])) {
            $builder->where('course', $searchData['course']);
        }
        if (!empty($searchData['school'])) {
            $builder->where('school', $searchData['school']);
        }

        return $builder->get()->getResultArray();
    }

    public function getStudentNameById($studentId)
    {
        $builder = $this->builder();
        $builder->select('name'); 
        $builder->where('id', $studentId); 
        
        $query = $builder->get();
        
        if ($query->getNumRows() > 0) {
            return $query->getRow()->name;
        } else {
            return null; 
        }

   
}




}
