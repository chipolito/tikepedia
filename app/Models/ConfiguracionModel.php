<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfiguracionModel extends Model
{
    protected $table                    = 'configuracion';
    protected $primaryKey               = 'configuracion_id';

    protected $useAutoIncrement         = true;

    protected $returnType               = 'array'; #object
    protected $useSoftDeletes           = true;

    protected $allowedFields            = [
        'configuracion_tipo', 
        'configuracion_parametros'
    ];

    protected bool $allowEmptyInserts   = false;

    // Dates
    protected $useTimestamps            = true;
    protected $dateFormat               = 'datetime';
    protected $createdField             = 'configuracion_created_at';
    protected $updatedField             = 'configuracion_updated_at';
    protected $deletedField             = 'configuracion_deleted_at';

    // Validation
    protected $validationRules          = [
        'configuracion_tipo'        => 'required|max_length[255]|string',
        'configuracion_parametros'  => 'required|string'
    ];

    protected $validationMessages       = [
        'configuracion_tipo'        => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 255 caracteres.',
            'string'                     => 'Este campo no debe tener caracteres especiales.'
        ],
        'configuracion_parametros'  => [
            'required'                  => 'Este campo es requerido.',
            'string'                    => 'Este campo no debe tener caracteres especiales.'
        ]
    ];

    protected $skipValidation           = false;
}
