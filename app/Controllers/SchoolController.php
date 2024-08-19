<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\School;
use App\Libraries\CIAuth;


class SchoolController extends BaseController
{
    public function index()
    {
        $School = new School();
        $full_name = CIAuth::fullName();

        $data['schools'] = $School->findAll();
        $data['full_name'] = $full_name;
        return view('backend/pages/schools/index', $data);
    }

    public function create()
    {
        return view('backend/pages/schools/create');
    }

    public function store()
    {
        $School = new School();

        $data = [
            'name' => $this->request->getPost('name')
        ];

        if ($School->save($data)) {
            return $this->response->setJSON(['status' => 1, 'msg' => 'School added successfully.']);
        } else {
            return $this->response->setJSON(['status' => 0, 'msg' => 'Failed to add school.']);
        }
    }

    public function edit()
    {
        $id = $this->request->getPost('id');
        
        if (!$id) {
            return $this->response->setJSON(['status' => 0, 'msg' => 'Invalid ID provided.']);
        }
    
        $School = new School();
        $school = $School->find($id);
    
        if (!$school) {
            return $this->response->setJSON(['status' => 0, 'msg' => 'School not found.']);
        }
    
        return $this->response->setJSON(['status' => 1, 'data' => $school]);
    }
    
    


    public function update()
    {
        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');

        // Validation rules
        $validationRules = [
            'name' => 'required|min_length[3]|max_length[255]',
        ];

        // Validate input
        if (!$this->validate($validationRules)) {
            return $this->response->setJSON([
                'status' => 0,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $School = new School();
        $updateSuccess = $School->update($id, ['name' => $name]);

        if ($updateSuccess) {
            return $this->response->setJSON(['status' => 1, 'msg' => 'School updated successfully.']);
        } else {
            return $this->response->setJSON(['status' => 0, 'msg' => 'Failed to update school.']);
        }
    }

   
    

    public function delete($id)
    {
        $School = new School();
        if ($School->delete($id)) {
            return $this->response->setJSON(['status' => 1, 'msg' => 'School deleted successfully.']);
        } else {
            return $this->response->setJSON(['status' => 0, 'msg' => 'Failed to delete school.']);
        }
    }
}
