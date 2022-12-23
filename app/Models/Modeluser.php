<?php

namespace App\Models;

use CodeIgniter\Model;

class Modeluser extends Model
{
    protected $table = 'user';
    protected $allowedFields = ['username', 'userpassword', 'useremail', 'fullname', 'role', 'image'];

}
