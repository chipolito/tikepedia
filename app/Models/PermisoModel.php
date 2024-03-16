<?php

namespace App\Models;

use CodeIgniter\Model;

class PermisoModel extends Model
{
    protected $table                    = 'permiso';
    protected $primaryKey               = 'permiso_id';

    protected $useAutoIncrement         = true;

    protected $returnType               = 'array'; #object
    protected $useSoftDeletes           = true;

    protected $allowedFields            = [
        'permiso_nombre', 
        'permiso_descripcion',
        'permiso_clave'
    ];

    protected bool $allowEmptyInserts   = false;

    // Dates
    protected $useTimestamps            = true;
    protected $dateFormat               = 'datetime';
    protected $createdField             = 'permiso_created_at';
    protected $updatedField             = 'permiso_updated_at';
    protected $deletedField             = 'permiso_deleted_at';

    // Validation
    protected $validationRules          = [
        'permiso_nombre'        => 'required|max_length[255]|alpha_numeric_punct',
        'permiso_descripcion'   => 'required|max_length[500]|alpha_numeric_punct',
        'permiso_clave'         => 'required|max_length[255]|alpha_numeric',
    ];

    protected $validationMessages       = [
        'permiso_nombre'        => [
            'required'              => 'Este campo es requerido.',
            'max_length'            => 'El tamaño máximo de este campo debe ser 255 caracteres.',
            'alpha_numeric_punct'   => 'Este campo no debe tener caracteres especiales.'
        ],
        'permiso_descripcion'   => [
            'required'              => 'Este campo es requerido.',
            'max_length'            => 'El tamaño máximo de este campo debe ser 500 caracteres.',
            'alpha_numeric_punct'   => 'Este campo no debe tener caracteres especiales.'
        ],
        'permiso_clave'         => [
            'required'              => 'Este campo es requerido.',
            'max_length'            => 'El tamaño máximo de este campo debe ser 255 caracteres.',
            'alpha_numeric'         => 'Este campo no debe tener caracteres especiales.'
        ]
    ];

    protected $skipValidation           = false;
}
