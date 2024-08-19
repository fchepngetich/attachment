<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Course;
use App\Models\School;

use App\Libraries\CIAuth;

class CourseController extends BaseController
{
    public function index()
    {
        $model = new Course();
        $full_name = CIAuth::fullName();
        $schoolModel = new School();  
        $data['schools'] = $schoolModel->findAll();
        $data['full_name'] = $full_name;
        $data['courses'] = $model->findAll();
        return view('backend/pages/courses/index', $data);
    }
    public function create()
    {
        $validationRules = [
            'name' => [
                'label' => 'Course Name',
                'rules' => 'required|is_unique[courses.name]',
                'errors' => [
                    'required' => 'The {field} field is required.',
                    'is_unique' => 'The {field} already exists.'
                ]
            ],
            'school_id' => [
                'label' => 'School',
                'rules' => 'required',
                'errors' => [
                    'required' => 'The {field} field is required.'
                ]
            ]
        ];
    
        if (!$this->validate($validationRules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }
    
        $data = [
            'name' => $this->request->getPost('name'),
            'school_id' => $this->request->getPost('school_id'),
        ];
    
        $courseModel = new Course();
    
        if ($courseModel->save($data)) {
            return redirect()->to(base_url('admin/courses'))->with('message', 'Course added successfully');
        } else {
            // Handle failure
            session()->setFlashdata('error', 'Failed to add course');
            return redirect()->back()->withInput();
        }
    }
    

    
    public function edit()
    {
        $id = $this->request->getPost('id');
        $model = new Course();
        $course = $model->find($id);

        if (!$course) {
            return $this->response->setJSON(['status' => 0, 'msg' => 'Course not found.']);
        }

        return $this->response->setJSON(['status' => 1, 'data' => $course]);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $data = $this->request->getPost();
        $model = new Course();
        
        if (!$model->update($id, $data)) {
            return $this->response->setJSON(['status' => 0, 'msg' => 'Failed to update course.']);
        }

        return $this->response->setJSON(['status' => 1, 'msg' => 'Course updated successfully.']);
    }

    public function delete($id)
    {
        $courseModel = new Course();

        try {
            if ($courseModel->delete($id)) {
                return $this->response->setJSON([
                    'status' => 1,
                    'msg' => 'Course deleted successfully.'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 0,
                    'msg' => 'Failed to delete the course.'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 0,
                'msg' => 'An error occurred: ' . $e->getMessage()
            ]);
        }
    }

}
