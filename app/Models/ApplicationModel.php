<?php

namespace App\Models;

use CodeIgniter\Model;

class ApplicationModel extends Model
{
    protected $table = 'applications';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'role_id',
        'assigned_user_id',
        'full_name',
        'email',
        'mobile',
        'dob',
        'gender',
        'address',
        'nationality',
        'relocate',
        'qualification',
        'institution',
        'graduation_year',
        'cgpa',
        'technical_skills',
        'certifications',
        'work_experience',
        'employment_status',
        'previous_organization',
        'job_title',
        'skills_summary',
        'resume',
        'declaration_accept',
        'status',
        'technical_review',
        'technical_rating',
        'technical_recommendation',
        'interview_date',
        'interview_mode',
        'interview_link',
        'interview_status',
        'interviewer_notes'
    ];
}
