<?php

namespace App\Models;

use CodeIgniter\Model;

class Modellogin extends Model
{
    protected $table = 'user';
    public function cekLogin($username)
    {
        $query = $this->table($this->table)->getWhere(['username' => $username]);
        return $query;
    }

}
