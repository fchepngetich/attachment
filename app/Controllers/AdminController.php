<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\CIAuth;
use App\Models\User;
use App\Models\Roles;
use App\Models\Students;
use App\Models\School;
use App\Models\Course;



use \Mberecall\CI_Slugify\SlugService;
use SSP;


class AdminController extends BaseController
{
    protected $helpers = ['url', 'form', 'CIMail', 'CIFunctions'];
    protected $db;
    public function __construct()
    {
        require_once APPPATH . 'ThirdParty/ssp.php';
        $this->db = db_connect();
    }

    public function forgotPassword()
    {
        $usermodel = new User();

    }
    public function default()
    {

        return redirect()->to(base_url('/admin/login'));
    }

    public function index()
    {
        $full_name = CIAuth::StudentName();
        $students = new Students();

        $data = ['full_name' => $full_name];
        return view('backend/pages/home', $data);
    }

    public function logoutHandler()
    {
        CIAuth::forget();
        return redirect()->to(base_url('admin/login'))->with('success', 'You are logged out');
    }

    public function getUsers()
    {
        $db = \Config\Database::connect();
        $full_name = CIAuth::fullName();
        $roleModel = new Roles();
        $roles = $roleModel->findAll();

        $userModel = new User();
        $data['full_name'] = $full_name;
        $data['roles'] = $roles;
        $data['users'] = $userModel->findAll();
        return view('backend/pages/users', $data);
    }

    public function addUser()
    {
        $roleModel = new Roles();
        $roles = $roleModel->findAll();

        $data = [
            'pageTitle' => 'Add User',
        ];
        $full_name = CIAuth::fullName();

        $data['full_name'] = $full_name;
        $data['roles'] = $roles;

        return view('backend/pages/new-user', $data);
    }

    public function createUser()
    {
        $request = \Config\Services::request();

        if ($request->isAJAX()) {
            $validation = \Config\Services::validation();

            $validation->setRules([
                'full_name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Full name is required',
                    ]
                ],
                'email' => [
                    'rules' => 'required|valid_email|is_unique[users.email]|regex_match[/^[\w\.\-]+@zetech\.ac\.ke$/]',
                    'errors' => [
                        'required' => 'Email is required',
                        'valid_email' => 'Please provide a valid email address',
                        'is_unique' => 'This email is already registered',
                        'regex_match' => 'Email must be a zetech.ac.ke email address',
                    ]
                ],
                'role_id' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Role is required',
                    ]
                ],
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                $errors = $validation->getErrors();
                return $this->response->setJSON([
                    'status' => 0,
                    'token' => csrf_hash(),
                    'errors' => $errors
                ]);
            } else {
                $userModel = new User();
                $password = $this->generatePassword(8);
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $data = [
                    'full_name' => $this->request->getPost('full_name'),
                    'email' => $this->request->getPost('email'),
                    'role_id' => (int) $this->request->getPost('role_id'), 
                    'password' => $hashedPassword,
                ];

                if ($userModel->save($data)) {
                    $userId = \App\Libraries\CIAuth::id();
                    $message = "User Full name: {$data['full_name']} with email: {$data['email']} was created.";
                    log_action($userId, $message);

                    $email = \Config\Services::email();
                    $email->setFrom('noreplyzetech@attachmentportal.com', 'Attachment Portal');
                    $email->setTo($data['email']);
                    $email->setCC('another@another-example.com');
                    $email->setBCC('them@their-example.com');
                    $email->setSubject('CMS User Credentials');

                    $message = "
                    <html>
                    <head>
                        <title>Attachment Portal User Credentials</title>
                    </head>
                    <body>
                        <h2>Welcome to the Attachment</h2>
                        <p>Dear {$data['full_name']},</p>
                        <p>You have been added as a user in the Attachment Portal. Here are your credentials:</p>
                        <table>
                            <tr>
                                <td><strong>Username:</strong></td><td>{$data['email']}</td>
                            </tr>
                            <tr>
                                <td><strong>Password:</strong></td><td>{$password}</td>
                            </tr>
                            <tr>
                                <td><strong>Website Link:</strong></td><td><a href='#'>Change Management System</a></td>
                            </tr>
                        </table>
                        <p>Please make sure to change your password after your first login.</p>
                        <br>
                        <p>Best Regards,</p>
                        <p>Attachment Portal Team</p>
                    </body>
                    </html>";

                    $email->setMessage($message);
                    $email->setMailType('html');

                    if ($email->send()) {
                        return $this->response->setJSON([
                            'status' => 1,
                            'msg' => 'User added successfully. Password has been sent to their email.',
                            'token' => csrf_hash()
                        ]);
                    } else {
                        return $this->response->setJSON([
                            'status' => 1,
                            'msg' => 'User added successfully. Failed to send the password email.',
                            'token' => csrf_hash()
                        ]);
                    }
                } else {
                    return $this->response->setJSON([
                        'status' => 0,
                        'msg' => 'Failed to add user. Please try again.',
                        'token' => csrf_hash(),
                    ]);
                }
            }
        } else {
            return $this->response->setStatusCode(400, 'Bad Request');
        }
    }

    private function generatePassword($length = 8)
    {
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $specialCharacters = '!@#$%^&*()-_+=<>?';

        $allCharacters = $uppercase . $lowercase . $numbers . $specialCharacters;
        $password = [
            $uppercase[rand(0, strlen($uppercase) - 1)],
            $lowercase[rand(0, strlen($lowercase) - 1)],
            $numbers[rand(0, strlen($numbers) - 1)],
            $specialCharacters[rand(0, strlen($specialCharacters) - 1)]
        ];

        for ($i = 4; $i < $length; $i++) {
            $password[] = $allCharacters[rand(0, strlen($allCharacters) - 1)];
        }

        shuffle($password);

        return implode('', $password);
    }

    public function createStudent()
    {
        $request = \Config\Services::request();
        $schoolModel = new School();  
        $data['schools'] = $schoolModel->findAll();
        
        if ($request->isAJAX()) {
            $validation = \Config\Services::validation();
    
            // Validation rules (already correctly set up)
            $validation->setRules([
                'name' => [
                    'rules' => 'required|string|max_length[255]',
                    'errors' => [
                        'required' => 'Name is required',
                    ]
                ],
                'email' => [
                    'rules' => 'required|valid_email|is_unique[students.email]',
                    'errors' => [
                        'required' => 'Email is required',
                        'valid_email' => 'Please provide a valid email address',
                        'is_unique' => 'This email is already registered',
                    ]
                ],
                'phone' => [
                    'rules' => 'permit_empty|string|max_length[20]',
                ],
                'year_study' => [
                    'rules' => 'required|integer',
                    'errors' => [
                        'required' => 'Year of study is required',
                    ]
                ],
                'semester' => [
                    'rules' => 'required|integer',
                    'errors' => [
                        'required' => 'Semester is required',
                    ]
                ],
                'reg_no' => [
                    'rules' => 'required|string|is_unique[students.reg_no]',
                    'errors' => [
                        'required' => 'Registration number is required',
                        'is_unique' => 'This registration number is already in use',
                    ]
                ],
                'school' => [
                    'rules' => 'required|integer',
                    'errors' => [
                        'required' => 'School is required',
                    ]
                ],
                'course' => [
                    'rules' => 'required|string|max_length[255]',
                    'errors' => [
                        'required' => 'Course is required',
                    ]
                ],
            ]);
    
            // Validation check
            if (!$validation->withRequest($this->request)->run()) {
                $errors = $validation->getErrors();
                return $this->response->setJSON([
                    'status' => 0,
                    'token' => csrf_hash(),
                    'errors' => $errors
                ]);
            } else {
                $studentModel = new Students();
    
                // Hash the registration number as the password
                $regNo = $this->request->getPost('reg_no');
                $hashedPassword = password_hash($regNo, PASSWORD_DEFAULT);
    
                // Prepare the data array for saving
                $data = [
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'phone' => $this->request->getPost('phone'),
                    'year_study' => $this->request->getPost('year_study'),
                    'semester' => $this->request->getPost('semester'),
                    'reg_no' => $regNo,
                    'password' => $hashedPassword,
                    'usertype' => 'student',
                    'school_id' => $this->request->getPost('school'),
                    'course' => $this->request->getPost('course'),
                ];
    
                // Save the data and handle response
                if ($studentModel->save($data)) {
                    // Send welcome email
                    $email = \Config\Services::email();
                    $email->setTo($data['email']);
                    $email->setSubject('Welcome to the System');
                    $email->setMessage('Dear ' . $data['name'] . ',<br><br>Welcome to the system. Your registration number is ' . $data['reg_no'] . '.');
    
                    if (!$email->send()) {
                        log_message('error', 'Failed to send email to ' . $data['email']);
                    }
    
                    return $this->response->setJSON([
                        'status' => 1,
                        'msg' => 'Student added successfully.',
                        'token' => csrf_hash()
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 0,
                        'msg' => 'Failed to add student. Please try again.',
                        'token' => csrf_hash(),
                    ]);
                }
            }
        } else {
            return $this->response->setStatusCode(400, 'Bad Request');
        }
    }
    

    // public function createStudent()
    // {
    //     $request = \Config\Services::request();

    //     if ($request->isAJAX()) {
    //         $validation = \Config\Services::validation();

    //         $validation->setRules([
    //             'name' => [
    //                 'rules' => 'required|string|max_length[255]',
    //                 'errors' => [
    //                     'required' => 'Name is required',
    //                 ]
    //             ],
    //             'email' => [
    //                 'rules' => 'required|valid_email|is_unique[students.email]',
    //                 'errors' => [
    //                     'required' => 'Email is required',
    //                     'valid_email' => 'Please provide a valid email address',
    //                     'is_unique' => 'This email is already registered',
    //                 ]
    //             ],
    //             'phone' => [
    //                 'rules' => 'permit_empty|string|max_length[20]',
    //             ],
    //             'year_study' => [
    //                 'rules' => 'required|integer',
    //                 'errors' => [
    //                     'required' => 'Year of study is required',
    //                 ]
    //             ],
    //             'semester' => [
    //                 'rules' => 'required|integer',
    //                 'errors' => [
    //                     'required' => 'Semester is required',
    //                 ]
    //             ],
    //             'reg_no' => [
    //                 'rules' => 'required|string|is_unique[students.reg_no]',
    //                 'errors' => [
    //                     'required' => 'Registration number is required',
    //                     'is_unique' => 'This registration number is already in use',
    //                 ]
    //             ]
    //         ]);

    //         if (!$validation->withRequest($this->request)->run()) {
    //             $errors = $validation->getErrors();
    //             return $this->response->setJSON([
    //                 'status' => 0,
    //                 'token' => csrf_hash(),
    //                 'errors' => $errors
    //             ]);
    //         } else {
    //             $studentModel = new Students();

    //             $regNo = $this->request->getPost('reg_no');
    //             $hashedPassword = password_hash($regNo, PASSWORD_DEFAULT);

    //             $data = [
    //                 'name' => $this->request->getPost('name'),
    //                 'email' => $this->request->getPost('email'),
    //                 'phone' => $this->request->getPost('phone'),
    //                 'year_study' => $this->request->getPost('year_study'),
    //                 'semester' => $this->request->getPost('semester'),
    //                 'reg_no' => $regNo,
    //                 'password' => $hashedPassword,
    //                 'usertype' => 'student', 
    //             ];

    //             if ($studentModel->save($data)) {
    //                 return $this->response->setJSON([
    //                     'status' => 1,
    //                     'msg' => 'Student added successfully.',
    //                     'token' => csrf_hash()
    //                 ]);
    //             } else {
    //                 return $this->response->setJSON([
    //                     'status' => 0,
    //                     'msg' => 'Failed to add student. Please try again.',
    //                     'token' => csrf_hash(),
    //                 ]);
    //             }
    //         }
    //     } else {
    //         return $this->response->setStatusCode(400, 'Bad Request');
    //     }
    // }

    public function editStudent()
    {
        $studentModel = new Students();
        $schoolModel = new School();
        $courseModel = new Course(); 
    
        $studentId = $this->request->getGet('id');
    
        $student = $studentModel->find($studentId);
        if ($student) {
            $school = $schoolModel->find($student['school']);
            $course = $courseModel->find($student['course']);
    
            return $this->response->setJSON([
                'status' => 1, 
                'data' => $student,
                'school' => $school,
                'course' => $course
            ]);
        } else {
            return $this->response->setJSON(['status' => 0, 'msg' => 'Student not found.']);
        }
    }
        public function updateStudent()
    {
        $studentModel = new Students();
        $studentId = $this->request->getPost('id');
    
        log_message('info', 'Updating student with ID: ' . $studentId);
    
        $currentStudent = $studentModel->find($studentId);
        if (!$currentStudent) {
            log_message('error', 'Student not found with ID: ' . $studentId);
            return $this->response->setJSON(['status' => 0, 'msg' => 'Student not found.']);
        }
    
        log_message('info', 'Current student data: ' . json_encode($currentStudent));
    
        $newData = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'year_study' => $this->request->getPost('year_study'),
            'semester' => $this->request->getPost('semester'),
            'reg_no' => $this->request->getPost('reg_no'),
            'school' => $this->request->getPost('school'),
            'course' => $this->request->getPost('course'),
        ];
    
        $emailInUse = $studentModel->where('email', $newData['email'])
                                   ->where('id !=', $studentId)
                                   ->first();
    
        if ($emailInUse) {
            log_message('error', 'Email ' . $newData['email'] . ' is already in use by another student.');
            return $this->response->setJSON(['status' => 0, 'msg' => 'Email is already in use by another student.']);
        }
    
        log_message('info', 'New student data from form: ' . json_encode($newData));
    
        $changes = [];
        foreach ($newData as $field => $value) {
            if ($currentStudent[$field] != $value) {
                $changes[] = "{$field}: '{$currentStudent[$field]}' to '{$value}'";
            }
        }
    
        if (!empty($changes)) {
            log_message('info', 'Changes detected: ' . implode(', ', $changes));
        } else {
            log_message('info', 'No changes detected for student ID: ' . $studentId);
        }
    
        try {
            if ($studentModel->update($studentId, $newData)) {
                log_message('info', 'Student updated successfully.');
                return $this->response->setJSON(['status' => 1, 'msg' => 'Student updated successfully.']);
            } else {
                log_message('error', 'Update method returned false.');
                throw new \RuntimeException('Failed to update student. Database update failed.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception: ' . $e->getMessage());
            return $this->response->setJSON(['status' => 0, 'msg' => 'Failed to update student. ' . $e->getMessage()]);
        }
    }
    
    public function deleteStudent()
    {
        $studentModel = new Students();

        $id = $this->request->getPost('id');

        // Validate ID
        if (empty($id) || !is_numeric($id)) {
            return $this->response->setJSON([
                'status' => 0,
                'msg' => 'Invalid student ID.',
                'token' => csrf_hash()
            ]);
        }

        if ($studentModel->delete($id)) {
            return $this->response->setJSON([
                'status' => 1,
                'msg' => 'Student deleted successfully.',
                'token' => csrf_hash()
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'msg' => 'Failed to delete student.',
                'token' => csrf_hash()
            ]);
        }
    }

    public function getUser($id)
    {
        $userModel = new User();
        $roleModel = new Roles();

        $user = $userModel->find($id);
        $roles = $roleModel->findAll();
        foreach ($roles as $role) {
            echo $role['name'];
        }

        $roleNames = [];
        foreach ($roles as $role) {
            $roleNames[$role['id']] = $role['name'];
        }


        if ($user) {
            $user['role'] = isset($roleNames[$user['role']]) ? $roleNames[$user['role']] : 'Unknown Role';
            $user['name'] = getRoleNameById($user['role']);
            return $this->response->setJSON([
                'status' => 1,
                'user' => $user,
                'roles' => $roles,
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'msg' => 'User not found',
            ]);
        }
    }

    public function roleName($roleId)
    {
        $roleModel = new Roles();

        $roleName = $roleModel->getRoleNameById($roleId);

        return $this->response->setJSON(['name' => $roleName]);
    }

    public function edit()
    {
        $userId = $this->request->getGet('id');
        $userModel = new User();
        $roleModel = new Roles();

        $user = $userModel->find($userId);
        $roles = $roleModel->findAll();

        if ($user) {
            return $this->response->setJSON(['status' => 1, 'data' => $user, 'roles' => $roles]);
        } else {
            return $this->response->setJSON(['status' => 0, 'msg' => 'User not found.']);
        }
    }

    public function update()
    {
        $userModel = new User();
        $userId = $this->request->getPost('user_id');
        $roleId = (int) $this->request->getPost('role_id');


        // Fetch current user data before update
        $currentUser = $userModel->find($userId);
        if (!$currentUser) {
            return $this->response->setJSON(['status' => 0, 'msg' => 'User not found.']);
        }

        // New data from form submission
        $newData = [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'role_id' => $roleId,
        ];

        // Compare old and new data
        $changes = [];
        foreach ($newData as $field => $value) {
            if ($currentUser[$field] != $value) {
                $changes[] = "{$field}: '{$currentUser[$field]}' to '{$value}'";
            }
        }

        // Perform the update
        if ($userModel->update($userId, $newData)) {
            // Retrieve current user's full name for logging
            $loggedInUserName = \App\Libraries\CIAuth::id();

            $username = getUsernameById($userId);

            if (!empty($changes)) {
                $message = "User '{$username}' was updated.. Changes: " . implode(', ', $changes);
            } else {
                $message = "User '{$username}' was updated without changes.";
            }
            log_action($loggedInUserName, $message);

            return $this->response->setJSON(['status' => 1, 'msg' => 'User updated successfully.']);
        } else {
            return $this->response->setJSON(['status' => 0, 'msg' => 'Failed to update user.']);
        }
    }

    public function delete()
    {
        $userId = $this->request->getPost('id');
        $userModel = new User();
        $username = getUsernameById($userId);

        $loggedInId = \App\Libraries\CIAuth::id();

        if ($userModel->delete($userId)) {
            $message = "User '{$username}' was deleted.";
            log_action($loggedInId, $message);
            return $this->response->setJSON(['status' => 1, 'msg' => 'User deleted successfully.']);
        } else {
            return $this->response->setJSON(['status' => 0, 'msg' => 'Failed to delete user.']);
        }

    }

    public function changePassword()
    {
        $full_name = CIAuth::fullName();

        $data['full_name'] = $full_name;
        return view('backend/pages/auth/change_password', $data);
    }
    public function updatePassword()
    {
        $session = session();
        $userModel = new User();
    
        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');
    
        $validationRules = [
            'new_password' => [
                'rules' => 'required|min_length[8]|regex_match[/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$/]',
                'errors' => [
                    'required' => 'New password is required.',
                    'min_length' => 'New password must be at least 8 characters long.',
                    'regex_match' => 'New password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.'
                ]
            ],
            'confirm_password' => [
                'rules' => 'required|matches[new_password]',
                'errors' => [
                    'required' => 'Confirm password is required.',
                    'matches' => 'Confirm password does not match the new password.'
                ]
            ]
        ];
    
        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }
    
        $userId = CIAuth::id();
        $user = $userModel->find($userId);
    
        if (is_null($user)) {
            $session->setFlashdata('fail', 'User not found.');
            return redirect()->back();
        } elseif (!isset($user['password'])) {
            $session->setFlashdata('fail', 'Password field not found in user data.');
            return redirect()->back();
        }
    
        if (!password_verify($currentPassword, $user['password'])) {
            $session->setFlashdata('fail', 'Current password is incorrect.');
            return redirect()->back();
        }
    
        $updateData = ['password' => password_hash($newPassword, PASSWORD_DEFAULT)];
        
        if ($user['password_reset_required'] == 0) {
            $updateData['password_reset_required'] = 1;
        }
    
        $userModel->update($userId, $updateData);
    
        $session->setFlashdata('success', 'Password successfully updated.');
        return redirect()->to(base_url('/admin/home'));
    }
    
    public function profile()
    {
        $session = session();
        $userId = CIAuth::id();
        $userType = CIAuth::userType();
        $full_name = 'Unknown';

        if ($userType === 'student') {
            $studentModel = new Students();
            $user = $studentModel->find($userId);
            if (!is_null($user)) {
                $full_name = $user['full_name'] ?? 'Unknown Student';
            }
        } elseif ($userType === 'user') {
            $userModel = new User();
            $user = $userModel->find($userId);
            if (!is_null($user)) {
                $full_name = $user['full_name'] ?? 'Unknown User';
            }
        } elseif ($userType === 'lecturer') {
            $lecturerModel = new User();
            $user = $lecturerModel->find($userId);
            if (!is_null($user)) {
                $full_name = $user['full_name'] ?? 'Unknown Lecturer';
            }
        } else {
            $full_name = 'Guest';
        }

        if (is_null($user)) {
            $session->setFlashdata('fail', 'User not found.');
            return redirect()->to('backend/pages/auth/profile');
        }

        return view('backend/pages/auth/profile', [
            'user' => $user,
            'full_name' => $full_name
        ]);
    }

    public function studentsProfile()
    {
        $session = session();
        $userModel = new Students();

        $full_name = CIAuth::StudentName();
        $userId = CIAuth::id();

        $user = $userModel->find($userId);

        if (is_null($user)) {
            $session->setFlashdata('fail', 'User not found.');
            return redirect()->to('backend/pages/auth/studentsprofile');
        }

        return view('backend/pages/auth/studentsprofile', [
            'user' => $user,
            'full_name' => $full_name
        ]);
    }

    public function uploadUsers()
    {
        $validation = \Config\Services::validation();
    
        $validation->setRules([
            'user_file' => [
                'label' => 'File',
                'rules' => 'uploaded[user_file]|mime_in[user_file,text/csv,text/plain]|max_size[user_file,1024]',
            ],
        ]);
    
        if (!$this->validate($validation->getRules())) {
            log_message('error', 'Validation failed: ' . json_encode($validation->getErrors()));
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
    
        $file = $this->request->getFile('user_file');
    
        if ($file->isValid() && !$file->hasMoved()) {
            $filePath = $file->getTempName();
            $users = $this->parseCSVFile($filePath);
    
            if (empty($users)) {
                log_message('error', 'No users found in the CSV file.');
                return redirect()->back()->with('error', 'No users found in the CSV file.');
            }
    
            $userModel = new User();
            $roleModel = new Roles();
    
            foreach ($users as $user) {
                $role = $roleModel->where('name', $user['role'])->first();
                if ($role) {
                    $existingUser = $userModel->where('email', $user['email'])->first();
                    if (!$existingUser) {
                        $userModel->insert([
                            'full_name' => $user['full_name'],
                            'email' => $user['email'],
                            'role_id' => $role['id'],
                            // Add other necessary fields
                        ]);
                    } else {
                        // Log or handle the duplicate case as needed
                        log_message('info', 'User already exists, skipping: ' . $user['email']);
                    }
                } else {
                    log_message('error', 'Role not found: ' . $user['role']);
                }
            }
    
            return redirect()->back()->with('success', 'Users uploaded successfully.');
        } else {
            log_message('error', 'File upload failed or file has already been moved.');
            return redirect()->back()->with('error', 'Failed to upload the file.');
        }
    }
    
    private function parseCSVFile($filePath)
    {
        $users = [];
    
        if (($handle = fopen($filePath, 'r')) !== FALSE) {
            // Skip the first row if it contains headers
            $headers = fgetcsv($handle);
    
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                if (count($data) >= 3) { // Ensure there are at least 3 columns
                    $users[] = [
                        'full_name' => $data[0],
                        'email' => $data[1],
                        'role' => $data[2],
                        // Add additional fields as necessary
                    ];
                } else {
                    log_message('error', 'Invalid CSV row: ' . implode(',', $data));
                }
            }
            fclose($handle);
        } else {
            log_message('error', 'Unable to open file: ' . $filePath);
        }
    
        return $users;
    }

    public function batchUpload()
    {
        $validation = \Config\Services::validation();
    
        $validation->setRules([
            'students_csv' => [
                'label' => 'CSV File',
                'rules' => 'uploaded[students_csv]|mime_in[students_csv,text/csv,text/plain]|max_size[students_csv,1024]',
            ],
        ]);
    
        if (!$this->validate($validation->getRules())) {
            log_message('error', 'Validation failed: ' . json_encode($validation->getErrors()));
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
    
        $file = $this->request->getFile('students_csv');
    
        if ($file->isValid() && !$file->hasMoved()) {
            $filePath = $file->getTempName();
            $students = $this->studentsparseCSVFile($filePath);
    
            if (empty($students)) {
                log_message('error', 'No students found in the CSV file.');
                return redirect()->back()->with('error', 'No students found in the CSV file.');
            }
    
            $studentModel = new Students();
            $courseModel = new Course(); 
            $schoolModel = new School(); 
    
            $courses = $courseModel->findAll(); 
            $schools = $schoolModel->findAll(); 
    
            $courseLookup = array_column($courses, 'id', 'name');
            $schoolLookup = array_column($schools, 'id', 'name');
    
            foreach ($students as $student) {
                if (
                    !empty($student['name']) &&
                    !empty($student['email']) &&
                    !empty($student['phone']) &&
                    !empty($student['year_study']) &&
                    !empty($student['semester']) &&
                    !empty($student['reg_no']) &&
                    !empty($student['school']) &&
                    !empty($student['course'])
                ) {
                    $data = [
                        'name' => $student['name'],
                        'email' => $student['email'],
                        'phone' => $student['phone'],
                        'year_study' => $student['year_study'],
                        'semester' => $student['semester'],
                        'reg_no' => $student['reg_no'],
                        'school' => $schoolLookup[$student['school']] ?? null,
                        'course' => $courseLookup[$student['course']] ?? null,
                        'password' => password_hash($student['reg_no'], PASSWORD_BCRYPT),
                    ];
    
                    if (isset($data['email'])) {
                        $existingStudent = $studentModel->where('email', $data['email'])->first();
                        if (!$existingStudent) {
                            $studentModel->insert($data);
                        } else {
                            log_message('info', 'Student already exists, skipping: ' . $data['email']);
                        }
                    }
                } else {
                    log_message('info', 'Skipping row due to missing mandatory fields: ' . json_encode($student));
                }
            }
    
            return redirect()->back()->with('success', 'Students uploaded successfully.');
        } else {
            log_message('error', 'File upload failed or file has already been moved.');
            return redirect()->back()->with('error', 'Failed to upload the file.');
        }
    }
    
    private function studentsparseCSVFile($filePath)
    {
        $students = [];
    
        if (($handle = fopen($filePath, 'r')) !== FALSE) {
            $headers = fgetcsv($handle);
    
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                if (count($data) >= 8) {
                    $students[] = [
                        'name' => $data[0] ?? null,
                        'email' => $data[1] ?? null,
                        'phone' => $data[2] ?? null,
                        'year_study' => $data[3] ?? null,
                        'semester' => $data[4] ?? null,
                        'reg_no' => $data[5] ?? null,
                        'school' => $data[6] ?? null,
                        'course' => $data[7] ?? null,
                    ];
                }
            }
            fclose($handle);
        } else {
            log_message('error', 'Unable to open file: ' . $filePath);
        }
    
        return $students;
    }
    
    
    public function search()
{
    $studentModel = new Students();
    $schoolModel = new School();
    $courseModel = new Course();
    $full_name = CIAuth::fullName();

    $searchData = [
        'name' => $this->request->getPost('name'),
        'email' => $this->request->getPost('email'),
        'phone' => $this->request->getPost('phone'),
        'reg_no' => $this->request->getPost('reg_no'),
        'school' => $this->request->getPost('school_id'),
        'course' => $this->request->getPost('course_id'),
    ];
    
    $builder = $studentModel->builder();
    
    if (!empty($searchData['name'])) {
        $builder->like('name', $searchData['name']);
    }
    if (!empty($searchData['email'])) {
        $builder->like('email', $searchData['email']);
    }
    if (!empty($searchData['phone'])) {
        $builder->like('phone', $searchData['phone']);
    }
    if (!empty($searchData['reg_no'])) {
        $builder->like('reg_no', $searchData['reg_no']);
    }
    if (!empty($searchData['school'])) {
        $builder->where('school', $searchData['school']);
    }
    if (!empty($searchData['course'])) {
        $builder->where('course', $searchData['course']);
    }

    $data['students'] = $builder->get()->getResultArray();
    $data['schools'] = $schoolModel->findAll();
    $data['courses'] = $courseModel->findAll();
    $data['searchData'] = $searchData;
    $data['full_name'] = $full_name;

    return view('backend/pages/home', $data); 
}

}

