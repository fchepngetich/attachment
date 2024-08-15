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

    public function viewAttachmentDetails()
    {
        $attachmentModel = new Attachment();
        $id = CIAuth::id();
        $fullName = CIAuth::StudentName();

        $attachmentDetails = $attachmentModel->where('student_id', $id)->first();

        if (!$attachmentDetails) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Attachment not found');
        }

        $data = [
            'attachmentDetails' => $attachmentDetails,
            'full_name' =>$fullName,
        ];

        return view('backend/pages/students/attachment-details', $data);
    }
    
    public function editAttachment($id)
{
    $attachmentModel = new Attachment();
    $attachmentDetails = $attachmentModel->find($id);
    $full_name = CIAuth::StudentName();

    if (!$attachmentDetails) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Attachment not found');
    }

    $data = [
        'full_name' => $full_name,
        'attachmentDetails' => $attachmentDetails,
        'counties' => [
            'BARINGO'         => 'Baringo County',
            'BOMET'           => 'Bomet County',
            'BUNGOMA'         => 'Bungoma County',
            'BUSIA'           => 'Busia County',
            'ELGEYO-MARAKWET' => 'Elgeyo-Marakwet County',
            'EMBU'            => 'Embu County',
            'GARISSA'         => 'Garissa County',
            'HOMA-BAY'        => 'Homa-bay County',
            'ISIOLO'          => 'Isiolo County',
            'KAJIADO'         => 'Kajiado County',
            'KAKAMEGA'        => 'Kakamega County',
            'KERICHO'         => 'Kericho County',
            'KIAMBU'          => 'Kiambu County',
            'KILIFI'          => 'Kilifi County',
            'KIRINYAGA'       => 'Kirinyaga County',
            'KISII'           => 'Kisii County',
            'KISUMU'          => 'Kisumu County',
            'KITUI'           => 'Kitui County',
            'KWALE'           => 'Kwale County',
            'LAIKIPIA'        => 'Laikipia County',
            'LAMU'            => 'Lamu County',
            'MACHAKOS'        => 'Machakos County',
            'MAKUENI'         => 'Makueni County',
            'MANDERA'         => 'Mandera County',
            'MARSABIT'        => 'Marsabit County',
            'MERU'            => 'Meru County',
            'MIGORI'          => 'Migori County',
            'MOMBASA'         => 'Mombasa County',
            'MURANGA'         => 'Muranga County',
            'NAIROBI'         => 'Nairobi County',
            'NAKURU'          => 'Nakuru County',
            'NANDI'           => 'Nandi County',
            'NAROK'           => 'Narok County',
            'NYAMIRA'         => 'Nyamira County',
            'NYANDARUA'       => 'Nyandarua County',
            'NYERI'           => 'Nyeri County',
            'SAMBURU'         => 'Samburu County',
            'SIAYA'           => 'Siaya County',
            'TAITA-TAVETA'    => 'Taita-Taveta County',
            'TANA RIVER'      => 'Tana River County',
            'THARAKA-NITHI'   => 'Tharaka-Nithi County',
            'TRANS-NZOIA'     => 'Trans-Nzoia County',
            'TURKANA'         => 'Turkana County',
            'UASIN GISHU'     => 'Uasin Gishu County',
            'VIHIGA'          => 'Vihiga County',
            'WAJIR'           => 'Wajir County',
            'WEST POKOT'      => 'West Pokot County',
        ],
    ];

    return view('backend/pages/students/edit-attachment', $data);
}

public function updateAttachment()
{
    $attachmentModel = new Attachment();
    $id = $this->request->getPost('id');

    $data = [
        'company_name' => $this->request->getPost('company_name'),
        'county' => $this->request->getPost('county'),
        'company_location' => $this->request->getPost('company_location'),
        'company_email' => $this->request->getPost('company_email'),
        'company_phone' => $this->request->getPost('company_phone'),
        'date_start' => $this->request->getPost('date_start'),
        'date_end' => $this->request->getPost('date_end'),
        'google_map' => $this->request->getPost('google_map'),
    ];

    if ($attachmentModel->update($id, $data)) {
        return redirect()->to('admin/attachment/attachment-details')->with('success', 'Attachment details updated successfully.');
    } else {
        return redirect()->back()->with('fail', 'Failed to update attachment details.');
    }
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
    
    public function students()
    {
        $full_name = CIAuth::fullName();

        $studentModel = new attachment();
        $supervisor_id = CIAuth::id(); 
        $data = ['full_name' => $full_name];
        $data['students'] = $studentModel->where('supervisor_id', $supervisor_id)->findAll();

        return view('backend/pages/students/my-students', $data);
    }

    public function assessmentForm($attachmentId)
    {
        $attachmentModel = new Attachment();
        $attachment = $attachmentModel->find($attachmentId);
    
        if (!$attachment) {
            return redirect()->to(base_url('admin/attachment/my-students'))->with('error', 'Attachment not found');
        }
    
        $full_name = CIAuth::fullName();
    
        $data = [
            'attachment' => $attachment,
            'full_name' => $full_name
        ];
    
        return view('backend/pages/students/confirm_assessment_form', $data);
    }
    
    

    public function confirmAssessment()
{
    $attachmentId = $this->request->getPost('attachment_id');
    $comments = $this->request->getPost('comments');
    $userId = CIAuth::id(); 

    $attachmentModel = new Attachment();
    $logModel = new Logs(); 

    $attachmentModel->update($attachmentId, 
    ['is_assessment_confirmed' => true,  'supervisor_comments' => $comments, 'assessment_confirmed_at' => date('Y-m-d H:i:s')]);

    $logModel->save([
        'action' => sprintf(
            'Assessment confirmed for attachment ID %s',
            esc($attachmentId)
        ),
        'user_id' => $userId,
        'attachment_id' => $attachmentId,
        'supervisor_id' => $userId
    ]);

    return redirect()->to(base_url('admin/attachment/my-students'))->with('message', 'Assessment confirmed successfully');
}


}
