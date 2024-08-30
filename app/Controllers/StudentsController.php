<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Students;
use App\Models\Attachment;
use App\Models\School;
use App\Models\Course;
use App\Libraries\CIAuth;
use App\Libraries\Hash;
use App\Models\User;



class StudentsController extends BaseController
{
    protected $helpers = ['url', 'form', 'CIMail', 'CIFunctions'];
    protected $db;
    public function __construct()
    {
        require_once APPPATH . 'ThirdParty/ssp.php';
        $this->db = db_connect();
    }
    //     public function index()
// {
//     $full_name = CIAuth::fullName(); 
//     $studentsModel = new Students();
//     $usersModel = new User(); 

    //     $students = $studentsModel->findAll();

    //     $data = [
//         'full_name' => $full_name,
//         'students' => $students,
//     ];

    //     return view('backend/pages/home', $data);
// }



    // public function index()
    // {
    //     $userId = CIAuth::id();
    //     $userType = CIAuth::userType();
    //     $studentsModel = new Students();
    //     $usersModel = new User();

    //     $courseModel = new Course();
    //     $searchData = [
    //         'name' => $this->request->getVar('name'),
    //         'email' => $this->request->getVar('email'),
    //         'phone' => $this->request->getVar('phone'),
    //         'year_study' => $this->request->getVar('year_study'),
    //         'semester' => $this->request->getVar('semester'),
    //         'reg_no' => $this->request->getVar('reg_no'),
    //         'school_id' => $this->request->getVar('school_id'),
    //         'course_id' => $this->request->getVar('course_id'),
    //     ];

    //     if ($userType === 'student') {
    //         $student = $studentsModel->where('id', $userId)->first();
    //         $full_name = $student['full_name'] ?? 'Unknown Student';
    //     } elseif ($userType === 'user') {
    //         $user = $usersModel->find($userId);
    //         $full_name = $user['full_name'] ?? 'Unknown User';
    //     } elseif ($userType === 'lecturer') {

    //         $lecturerModel = new User();
    //         $lecturer = $lecturerModel->find($userId);
    //         $full_name = $lecturer['full_name'] ?? 'Unknown Lecturer';
    //     } else {
    //         $full_name = 'Guest';
    //     }

    //     $students = $studentsModel->findAll();
    //     $schoolModel = new School();
    //     $schools = $schoolModel->findAll();

    //     $data = [
    //         'full_name' => $full_name,
    //         'students' => $students,
    //         'schools' => $schools,
    //         'courses' => $courseModel->findAll(),
    //         'searchData' => $searchData,
    //     ];

    //     return view('backend/pages/home', $data);
    // }

    public function index()
{
    $userId = CIAuth::id();
    $userType = CIAuth::userType();

    $studentsModel = new Students();
    $usersModel = new User();
    $schoolModel = new School();
    $courseModel = new Course();
    $userModel= new User();

    switch ($userType) {
        case 'student':
            $student = $studentsModel->find($userId);
            $full_name = $student['full_name'] ?? 'Unknown Student';
            break;
        case 'user':
        case 'lecturer':
            $user = $usersModel->find($userId);
            $full_name = $user['full_name'] ?? 'Unknown User';
            break;
        default:
            $full_name = 'Guest';
            break;
    }

    if ($this->request->getMethod() === 'post') {
        $searchData = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'reg_no' => $this->request->getPost('reg_no'),
            'school_id' => $this->request->getPost('school_id'),
            'course_id' => $this->request->getPost('course_id'),
        ];

        $students = $studentsModel->getFilteredStudents($searchData);

        return view('admin/home', [
            'students' => $students,
            'schools' => $schoolModel->findAll(),
            'courses' => $courseModel->findAll(),
            'searchData' => $searchData, 
            'full_name' => $full_name,
        ]);
    } else {
        $students = $studentsModel->findAll();
        $schools = $schoolModel->findAll();
        $courses = $courseModel->findAll();
        $usersModel = $userModel->findAll();
       
        $data = [
            'full_name' => $full_name,
            'students' => $students,
            'schools' => $schools,
            'courses' => $courses,
        ];

        return view('backend/pages/home', $data);
    }
}

    public function getCoursesBySchool($schoolId)
    {
        $courseModel = new Course();
        $courses = $courseModel->where('school_id', $schoolId)->findAll();

        return $this->response->setJSON($courses);
    }
   
    public function studentsHome()
    {
        $full_name = CIAuth::StudentName();
        $id = CIAuth::id();
        $studentsModel = new Students();
        $usersModel = new User();

        $students = $studentsModel->where('id', $id)->findAll();

        $data = [
            'full_name' => $full_name,
            'students' => $students,
        ];

        return view('backend/pages/studentshome', $data);
    }

    public function create()
    {
        $fullName = CIAuth::StudentName();

        $data = [
            'full_name' => $fullName,
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


        return view('backend/pages/students/attachment-form', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'company_name' => 'required',
            'company_location' => 'permit_empty|string',
            'county' => 'permit_empty|string',
            'company_email' => 'permit_empty|valid_email',
            'company_phone' => 'permit_empty|string',
            'date_start' => 'required|valid_date',
            'date_end' => 'required|valid_date',
            'google_map' => 'permit_empty|string'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $userId = CIAuth::id();

        $data = [
            'student_id' => $userId,
            'company_name' => $this->request->getPost('company_name'),
            'company_location' => $this->request->getPost('company_location'),
            'county' => $this->request->getPost('county'),
            'company_email' => $this->request->getPost('company_email'),
            'company_phone' => $this->request->getPost('company_phone'),
            'date_start' => $this->request->getPost('date_start'),
            'date_end' => $this->request->getPost('date_end'),
            'google_map' => $this->request->getPost('google_map')
        ];

        $attachmentModel = new Attachment();
        if ($attachmentModel->save($data)) {
            return redirect()->to(base_url('admin/attachmentlist'))->with('message', 'Attachment created successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to create attachment');
        }
    }
 
    
    

    public function newgetCoursesBySchool()
    {
        $schoolId = $this->request->getGet('school_id');
        $coursesModel = new Course();

        $courses = $coursesModel->where('id', $schoolId)->findAll();

        if ($courses) {
            return $this->response->setJSON(['status' => 1, 'courses' => $courses]);
        } else {
            return $this->response->setJSON(['status' => 0, 'msg' => 'No courses found for the selected school.']);
        }
    }


    public function viewStudentDetails($id)
    {
        $studentsModel = new Students();
        $fullName = CIAuth::fullName();

        $student = $studentsModel->getStudentById($id);

        $course = $studentsModel->getCourseById($student['course']);
        $school = $studentsModel->getSchoolById($student['school']);

        $data = [
            'student' => $student,
            'course' => $course,
            'school' => $school,
            'full_name' => $fullName,
        ];

        return view('backend/pages/students/student-details', $data);
    }
}
