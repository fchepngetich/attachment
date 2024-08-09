<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Attachment;
use App\Models\User;
use App\Models\Students;
use App\Models\Logs;
use App\Libraries\CIAuth;



class AttachmentController extends BaseController
{
    
    public function index()
    {
        $attachmentModel = new Attachment();
        $studentModel = new Students(); 
        $supervisorModel = new User();
        $full_name = CIAuth::fullName();

    
        $attachments = $attachmentModel->findAll();
        
        $students = $studentModel->findAll();
        $studentLookup = [];
        foreach ($students as $student) {
            $studentLookup[$student['id']] = $student['name']; 
        }
    
        $supervisors = $supervisorModel->findAll();
        
        foreach ($attachments as &$attachment) {
            $attachment['student_name'] = $studentLookup[$attachment['student_id']] ?? 'Unknown';
    
            if (!empty($attachment['supervisor_id'])) {
                $supervisor = array_filter($supervisors, function($supervisor) use ($attachment) {
                    return $supervisor['id'] === $attachment['supervisor_id'];
                });
                $attachment['supervisor'] = array_shift($supervisor);
            } else {
                $attachment['supervisor'] = null;
            }
        }
    
        $data = [
            'attachments' => $attachments,
            'supervisors' => $supervisors,
            'full_name' => $full_name,
        ];
    
        return view('backend/pages/students/student-list', $data);
    }
    

    public function assignSupervisor($attachmentId)
    {
        $full_name = CIAuth::fullName();

        $attachmentModel = new Attachment();
        $supervisorModel = new User();

        $attachment = $attachmentModel->find($attachmentId);

        if (!$attachment) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Attachment not found');
        }

        $supervisors = $supervisorModel->findAll();

        $data = [
            'attachment' => $attachment,
            'supervisors' => $supervisors,
            'full_name' => $full_name,

        ];

        return view('backend/pages/students/assign-supervisor', $data);
    }

    public function saveAssignment()
{
    $attachmentId = $this->request->getPost('attachment_id');
    $supervisorId = $this->request->getPost('supervisor_id');
    $userId = CIAuth::id(); 

    $attachmentModel = new Attachment();
    $userModel = new User(); 
    $logModel = new Logs(); 

    $attachment = $attachmentModel->find($attachmentId);
    $studentId = $attachment['student_id']; 

    $supervisor = $userModel->find($supervisorId);
    $supervisorName = $supervisor['full_name'];  

    $attachmentModel->update($attachmentId, ['supervisor_id' => $supervisorId]);

    $logModel->save([
        'action' => sprintf(
            'Supervisor %s assigned to student ID %s for attachment ID %s',
            esc($supervisorName),
            esc($studentId),
            esc($attachmentId)
        ),
        'user_id' => $userId,
        'attachment_id' => $attachmentId,
        'supervisor_id' => $supervisorId
    ]);

    return redirect()->to(base_url('/admin/attachment/get'))->with('message', 'Supervisor assigned successfully');
}

    public function changeSupervisor($attachmentId)
    {
        $full_name = CIAuth::fullName();

        $attachmentModel = new Attachment();
        $userModel = new User();
    
        $attachment = $attachmentModel->find($attachmentId);
    
        if (!$attachment) {
            return redirect()->back()->with('error', 'Attachment not found');
        }
    
        $supervisors = $userModel->findAll();  
    
        $data = [
            'attachment' => $attachment,
            'supervisors' => $supervisors,
            'full_name' => $full_name,

        ];
    
        return view('backend/pages/students/change-supervisor', $data);
    }
    
    public function saveSupervisorChange()
    {
        $attachmentId = $this->request->getPost('attachment_id');
        $supervisorId = $this->request->getPost('supervisor_id');
    
        $attachmentModel = new Attachment();
        $currentAttachment = $attachmentModel->find($attachmentId);
    
        if ($currentAttachment['supervisor_id'] != $supervisorId) {
            $attachmentModel->update($attachmentId, ['supervisor_id' => $supervisorId]);
    
            $logModel = new Logs();
            $userId = CIAuth::id();
            $logModel->save([
                'user_id' => $userId,
                'action' => 'Supervisor Change',
                'details' => 'Changed supervisor from ' . $currentAttachment['supervisor_id'] . ' to ' . $supervisorId . ' for attachment ID: ' . $attachmentId,
            ]);
    
            return redirect()->to(base_url('/admin/attachment/get'))->with('message', 'Supervisor changed successfully');
        } else {
            return redirect()->to(base_url('/admin/attachment/get'))->with('message', 'No changes made. The supervisor remains the same.');
        }
    }
    

}
