<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['password','email','uuid'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';



    // Validation
    protected $validationRules      = [
      "password" => "required|min_length[8]|max_length[256]",
      "email" => "required|valid_email|min_length[5]|is_unique[users.email]",
    ];
    protected $validationMessages   = [
      "password" => [
        "required" => "Password is required",
        "min_length" => "Minimum length of password should be 8 chars",
        "max_length" => "Maximum length of password should be 256 chars",
      ],
      "email" => [
        "required" => "Email needed",
        "valid_email" => "Please provide a valid email address"
      ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
