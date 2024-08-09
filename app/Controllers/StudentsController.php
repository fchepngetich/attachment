<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Students;
use App\Models\Attachment;
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
    public function index()
    {
        $userModel = new User();
        $userId = CIAuth::id();

        $full_name = $userModel->getFullNameById($userId);
        $studentsModel = new Students();
        
        $students = $studentsModel->findAll();
        
        $data = [
            'full_name' => $full_name,
            'students' => $students,
        ];
    
        return view('backend/pages/home', $data);
    }
   
        public function create()
        {
            $userModel = new User();
            $fullName = CIAuth::StudentName();
          
            $data = [
                'full_name' => $fullName,
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
                return redirect()->to(base_url('admin/home'))->with('message', 'Attachment created successfully');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to create attachment');
            }
        }
    }
    