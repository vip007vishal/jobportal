<?php

namespace App\Models;

use CodeIgniter\Model;

class JobModel extends Model
{
    protected $table = 'job_roles';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'role_name',
        'description',
        'technical_skills',
        'status'
    ];
}