<?php

namespace App\Models;

use CodeIgniter\Model;

class ApplicationLogModel extends Model
{
    protected $table = 'application_logs';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'application_id',
        'user_id',
        'action',
        'description'
    ];
}