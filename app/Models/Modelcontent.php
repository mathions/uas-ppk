<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelcontent extends Model
{
    protected $table = 'content';
    protected $allowedFields = ['content_id', 'username', 'image', 'caption', 'date'];
}
