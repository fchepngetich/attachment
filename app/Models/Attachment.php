<?php

namespace App\Models;

use CodeIgniter\Model;

class Attachment extends Model
{
    protected $table = 'attachment';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'student_id', 'company_name', 'company_location', 'county', 'company_email',
        'company_phone', 'date_start', 'date_end', 'google_map', 'supervisor_id','supervisor_comments',
        'assessment_confirmed_at', 'is_assessment_confirmed','student_confirmation_date','is_student_confirmed'
    ];
    protected $useTimestamps = false;
}

    