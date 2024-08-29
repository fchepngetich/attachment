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
                $supervisor = array_filter($supervisors, function ($supervisor) use ($attachment) {
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

        $data = [
            'attachmentDetails' => $attachmentDetails,
            'full_name' => $fullName,
            'hasAttachment' => $attachmentDetails !== null, // Flag to check if attachment details exist
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
                'BARINGO' => 'Baringo County',
                'BOMET' => 'Bomet County',
                'BUNGOMA' => 'Bungoma County',
                'BUSIA' => 'Busia County',
                'ELGEYO-MARAKWET' => 'Elgeyo-Marakwet County',
                'EMBU' => 'Embu County',
                'GARISSA' => 'Garissa County',
                'HOMA-BAY' => 'Homa-bay County',
                'ISIOLO' => 'Isiolo County',
                'KAJIADO' => 'Kajiado County',
                'KAKAMEGA' => 'Kakamega County',
                'KERICHO' => 'Kericho County',
                'KIAMBU' => 'Kiambu County',
                'KILIFI' => 'Kilifi County',
                'KIRINYAGA' => 'Kirinyaga County',
                'KISII' => 'Kisii County',
                'KISUMU' => 'Kisumu County',
                'KITUI' => 'Kitui County',
                'KWALE' => 'Kwale County',
                'LAIKIPIA' => 'Laikipia County',
                'LAMU' => 'Lamu County',
                'MACHAKOS' => 'Machakos County',
                'MAKUENI' => 'Makueni County',
                'MANDERA' => 'Mandera County',
                'MARSABIT' => 'Marsabit County',
                'MERU' => 'Meru County',
                'MIGORI' => 'Migori County',
                'MOMBASA' => 'Mombasa County',
                'MURANGA' => 'Muranga County',
                'NAIROBI' => 'Nairobi County',
                'NAKURU' => 'Nakuru County',
                'NANDI' => 'Nandi County',
                'NAROK' => 'Narok County',
                'NYAMIRA' => 'Nyamira County',
                'NYANDARUA' => 'Nyandarua County',
                'NYERI' => 'Nyeri County',
                'SAMBURU' => 'Samburu County',
                'SIAYA' => 'Siaya County',
                'TAITA-TAVETA' => 'Taita-Taveta County',
                'TANA RIVER' => 'Tana River County',
                'THARAKA-NITHI' => 'Tharaka-Nithi County',
                'TRANS-NZOIA' => 'Trans-Nzoia County',
                'TURKANA' => 'Turkana County',
                'UASIN GISHU' => 'Uasin Gishu County',
                'VIHIGA' => 'Vihiga County',
                'WAJIR' => 'Wajir County',
                'WEST POKOT' => 'West Pokot County',
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
        $studentModel = new Students();
        // Fetch the attachment and student details
        $attachment = $attachmentModel->find($attachmentId);
        $studentId = $attachment['student_id'];

        // Fetch the supervisor and student names
        $supervisor = $userModel->find($supervisorId);
        $supervisorName = $supervisor['full_name'];

        $student = $studentModel->find($studentId);
        $studentName = $student['name'];

        // Update the supervisor for the attachment
        $attachmentModel->update($attachmentId, ['supervisor_id' => $supervisorId]);

        // Log the assignment action
        $logModel->save([
            'action' => sprintf(
                'Supervisor %s assigned to student %s',
                esc($supervisorName),
                esc($studentName)
            ),
            'user_id' => $userId,
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
        $userModel = new User();
        $logModel = new Logs();
        $studentModel = new Students();


        $currentAttachment = $attachmentModel->find($attachmentId);

        $student = $studentModel->find($currentAttachment['student_id']);
        $studentName = $student ? $student['name'] : 'Unknown Student';
        $currentSupervisor = $userModel->find($currentAttachment['supervisor_id']);
        $currentSupervisorName = $currentSupervisor ? $currentSupervisor['full_name'] : 'Unknown';

        $newSupervisor = $userModel->find($supervisorId);
        $newSupervisorName = $newSupervisor ? $newSupervisor['full_name'] : 'Unknown';

        if ($currentAttachment['supervisor_id'] != $supervisorId) {
            $attachmentModel->update($attachmentId, ['supervisor_id' => $supervisorId]);

            $userId = CIAuth::id();
            $logModel->save([
                'user_id' => $userId,
                'details' => 'Supervisor Change',
                'action' => sprintf(
                    'Changed supervisor from %s to %s for student %s',
                    esc($currentSupervisorName),
                    esc($newSupervisorName),
                    esc($studentName)
                ),
            ]);

            return redirect()->to(base_url('/admin/attachment/get'))->with('message', 'Supervisor changed successfully');
        } else {
            return redirect()->to(base_url('/admin/attachment/get'))->with('message', 'No changes made. The supervisor remains the same.');
        }
    }


    public function students()
    {
        $full_name = CIAuth::fullName();

        $studentModel = new Students();
        $attachmentModel = new attachment();

        $supervisor_id = CIAuth::id();

        // Fetch search filters from POST request
        $search = $this->request->getPost();

        // Initialize query with default where condition
        $query = $attachmentModel->where('supervisor_id', $supervisor_id);

        if (!empty($search['name'])) {
            $studentIds = $studentModel->select('id')
                ->like('name', $search['name'])
                ->findAll();

            $studentIds = array_column($studentIds, 'id');
            $query->whereIn('student_id', $studentIds);
        }
        if (!empty($search['company'])) {
            $query->like('company_name', $search['company']);
        }
        if (!empty($search['county'])) {
            $query->like('county', $search['county']);
        }
        if (!empty($search['start_date'])) {
            $query->where('date_start >=', $search['start_date']);
        }
        if (!empty($search['end_date'])) {
            $query->where('date_end <=', $search['end_date']);
        }

        $students = $query->findAll();

        foreach ($students as &$student) {
            $student['name'] = $studentModel->getStudentNameById($student['student_id']);
        }

        $data = [
            'full_name' => $full_name,
            'students' => $students,
            'search' => $search // Pass the search data to the view to retain input values
        ];

        return view('backend/pages/students/my-students', $data);
    }

    public function mySchedule()
    {
        $full_name = CIAuth::fullName();
        $supervisor_id = CIAuth::id();

        $studentModel = new Students();
        $attachmentModel = new Attachment();

        $search = $this->request->getPost();

        $query = $attachmentModel->where('supervisor_id', $supervisor_id)
            ->where('schedule_cleared', false);

        if (!empty($search['name'])) {
            $studentIds = $studentModel->select('id')
                ->like('name', $search['name'])
                ->findAll();

            $studentIds = array_column($studentIds, 'id');
            $query->whereIn('student_id', $studentIds);
        }

        if (!empty($search['company'])) {
            $query->like('company_name', $search['company']);
        }

        if (!empty($search['county'])) {
            $query->like('county', $search['county']);
        }

        if (!empty($search['start_date'])) {
            $query->where('date_start >=', $search['start_date']);
        }

        if (!empty($search['end_date'])) {
            $query->where('date_end <=', $search['end_date']);
        }

        $students = $query->findAll();

        foreach ($students as &$student) {
            $student['name'] = $studentModel->getStudentNameById($student['student_id']);
        }

        $data = [
            'full_name' => $full_name,
            'students' => $students,
            'search' => $search
        ];

        return view('backend/pages/students/my-schedule', $data);
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
        $studentModel = new Students();

        // Fetch the attachment details using the attachment ID
    $attachment = $attachmentModel->find($attachmentId);

    // Retrieve the student ID from the attachment data
    $studentId = $attachment['student_id'];

    // Fetch the student's details using the student ID
    $student = $studentModel->find($studentId);
    $studentName = $student ? $student['name'] : 'Unknown Student';

    
        $attachmentModel->update(
            $attachmentId,
            ['is_assessment_confirmed' => true, 'supervisor_comments' => $comments, 'assessment_confirmed_at' => date('Y-m-d H:i:s')]
        );
      
  
        $logModel->save([
            'action' => sprintf(
                'Assessment confirmed for student %s',
                esc($studentName)
            ),
            'user_id' => $userId,
            'attachment_id' => $attachmentId,
            'supervisor_id' => $userId
        ]);

        return redirect()->to(base_url('admin/attachment/my-students'))->with('message', 'Assessment confirmed successfully');
    }

    // public function view($id)
//     {
//         $attachmentModel = new Attachment();
//         $attachment = $attachmentModel->find($id);
//         $full_name = CIAuth::fullName();

    //         if (!$attachment) {
//             return redirect()->to(base_url('admin/attachment/get'))->with('error', 'Attachment not found');
//         }

    //         return view('backend/pages/students/view-attach-details.php', [
//             'attachment' => $attachment,
//           'full_name' => $full_name,

    //         ]);
//     }

    public function view($id)
    {
        $full_name = CIAuth::fullName();

        $attachmentModel = new Attachment();
        $attachment = $attachmentModel->find($id);

        if (!$attachment) {
            return redirect()->to(base_url('admin/attachment/get'))->with('error', 'Attachment not found');
        }

        // Fetch related details
        $studentModel = new Students();
        $student = $studentModel->find($attachment['student_id']);

        $supervisorModel = new User();
        $supervisor = $supervisorModel->find($attachment['supervisor_id']);

        return view('backend/pages/students/view-attach-details.php', [
            'attachment' => $attachment,
            'student' => $student,
            'supervisor' => $supervisor,
            'full_name' => $full_name,

        ]);
    }

    public function searchAttachedStudents()
    {
        $searchData = $this->request->getPost();
        $attachmentModel = new Attachment();
        $studentModel = new Students();
        $supervisorModel = new User();
        $full_name = CIAuth::fullName();

        $students = $studentModel->findAll();
        $studentLookup = [];
        foreach ($students as $student) {
            $studentLookup[$student['id']] = $student['name'];
        }

        $supervisors = $supervisorModel->findAll();
        $supervisorLookup = [];
        foreach ($supervisors as $supervisor) {
            $supervisorLookup[$supervisor['id']] = $supervisor['full_name'];
        }

        if (!empty($searchData['student_name'])) {
            $studentIds = array_keys(array_filter($studentLookup, function ($name) use ($searchData) {
                return stripos($name, $searchData['student_name']) !== false;
            }));
            $attachmentModel->whereIn('student_id', $studentIds);
        }

        if (!empty($searchData['company_name'])) {
            $attachmentModel->like('company_name', $searchData['company_name']);
        }

        if (!empty($searchData['county'])) {
            $attachmentModel->like('county', $searchData['county']);
        }

        if (!empty($searchData['start_date'])) {
            $attachmentModel->where('date_start >=', $searchData['start_date']);
        }

        if (!empty($searchData['end_date'])) {
            $attachmentModel->where('date_end <=', $searchData['end_date']);
        }

        if (!empty($searchData['supervisor'])) {
            $supervisorIds = array_keys(array_filter($supervisorLookup, function ($name) use ($searchData) {
                return stripos($name, $searchData['supervisor']) !== false;
            }));
            $attachmentModel->whereIn('supervisor_id', $supervisorIds);
        }

        $attachments = $attachmentModel->findAll();

        foreach ($attachments as &$attachment) {
            $attachment['student_name'] = $studentLookup[$attachment['student_id']] ?? 'Unknown Student';

            if (!empty($attachment['supervisor_id'])) {
                $attachment['supervisor_name'] = $supervisorLookup[$attachment['supervisor_id']] ?? 'Unknown Supervisor';
            } else {
                $attachment['supervisor_name'] = 'Not Assigned';
            }
        }

        $data = [
            'attachments' => $attachments,
            'searchData' => $searchData,
            'full_name' => $full_name,
        ];

        return view('backend/pages/students/student-list', $data);
    }

    public function scheduleVisit()
    {
        $attachmentModel = new Attachment();
        $email = \Config\Services::email();

        $supervisor_id = CIAuth::id();
        $student_id = $this->request->getPost('student_id');
        $visit_date = $this->request->getPost('visit_date');
        $visit_time = $this->request->getPost('visit_time');

        $visit_scheduled_at = $visit_date . ' ' . $visit_time;

        $attachment = $attachmentModel->where('student_id', $student_id)
            ->where('supervisor_id', $supervisor_id)
            ->first();

        if ($attachment) {
            $attachmentModel->update($attachment['id'], [
                'visit_scheduled_at' => $visit_scheduled_at,
                'visit_status' => 'scheduled'
            ]);

            $student_email = $this->getStudentEmailById($student_id);
            $this->sendEmailNotification($student_email, $visit_scheduled_at);

            return redirect()->back()->with('message', 'Visit scheduled successfully and notification sent.');
        } else {
            return redirect()->back()->with('error', 'Attachment record not found.');
        }
    }


    private function sendEmailNotification($toEmail, $visit_date)
    {
        $email = \Config\Services::email();
        $email->setTo($toEmail);
        $email->setFrom('no-reply@example.com', 'Attachment Portal');
        $email->setSubject('Scheduled Visit Notification');
        $email->setMessage('A new visit has been scheduled for you on ' . $visit_date . '. Please be prepared.');

        if (!$email->send()) {
            log_message('error', 'Failed to send email: ' . $email->printDebugger(['headers']));
        }
    }

    private function getStudentEmailById($student_id)
    {
        $studentModel = new Students();
        $student = $studentModel->find($student_id);
        return $student ? $student['email'] : null;
    }

    public function saveSchedule()
    {
        $studentId = $this->request->getPost('student_id');
        $visitDate = $this->request->getPost('visit_date');
        $visitTime = $this->request->getPost('visit_time');
        $attachmentModel = new Attachment();

        $visitScheduledAt = $visitDate . ' ' . $visitTime;

        $existingSchedule = $attachmentModel->where('student_id', $studentId)->first();

        if ($existingSchedule) {
            $attachmentModel->update($existingSchedule['id'], [
                'visit_scheduled_at' => $visitScheduledAt

            ]);

            session()->setFlashdata('message', 'Schedule updated successfully!');
        }

        $this->sendScheduleNotification($studentId, $visitScheduledAt);

        return redirect()->to(base_url('admin/attachment/my-schedule'));
    }

    private function sendScheduleNotification($studentId, $visitScheduledAt)
    {
        $studentModel = new Students();
        $student = $studentModel->find($studentId);
        $email = \Config\Services::email();

        $email->setTo($student['email']);
        $email->setSubject('Visit Schedule Notification');
        $email->setMessage("
        Dear {$student['name']},

        Your visit has been scheduled on {$$visitScheduledAt}
        
        Thank you,
        Supervisor Team
    ");

        $email->send();
    }

    public function clearSchedule($studentId)
    {
        $attachmentModel = new Attachment();

        try {

            $updateStatus = $attachmentModel->where('student_id', $studentId)
                ->set(['schedule_cleared' => true])
                ->update();

            if ($updateStatus) {
                session()->setFlashdata('message', 'Schedule cleared successfully.');
            } else {
                $db = \Config\Database::connect();
                $error = $db->error();
                log_message('error', 'Failed to clear schedule. Error: ' . json_encode($error));

                session()->setFlashdata('error', 'Failed to clear the schedule. Please try again.');
            }

        } catch (\Exception $e) {

            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'An error occurred while clearing the schedule.');
        }

        return redirect()->to(base_url('admin/attachment/my-schedule'));
    }

    public function details($studentId)
    {
        $full_name = CIAuth::fullName();

        $attachmentModel = new Attachment();
        $attachments = $attachmentModel->getAttachmentsByStudentId($studentId);

        return view('backend/pages/students/single-student-attachment_details', ['attachments' => $attachments, 'full_name' => $full_name]);
    }

}





