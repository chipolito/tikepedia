<?php

namespace App\Models;

use CodeIgniter\Model;

class PrioridadModel extends Model
{
    protected $table                    = 'prioridad';
    protected $primaryKey               = 'prioridad_id';

    protected $useAutoIncrement         = true;

    protected $returnType               = 'array'; #object
    protected $useSoftDeletes           = true;

    protected $allowedFields            = [
        'prioridad_nombre', 
        'prioridad_descripcion',
        'prioridad_color',
        'prioridad_estatus'
    ];

    protected bool $allowEmptyInserts   = false;

    // Dates
    protected $useTimestamps            = true;
    protected $dateFormat               = 'datetime';
    protected $createdField             = 'prioridad_created_at';
    protected $updatedField             = 'prioridad_updated_at';
    protected $deletedField             = 'prioridad_deleted_at';

    // Validation
    protected $validationRules          = [
        'prioridad_nombre'          => 'required|max_length[50]|alpha_numeric_punct',
        'prioridad_descripcion'     => 'permit_empty|max_length[255]|string',
        'prioridad_color'           => 'required|max_length[50]|alpha_numeric_punct',
        'prioridad_estatus'         => 'required|max_length[1]|integer|in_list[0,1]'
    ];

    protected $validationMessages       = [
        'prioridad_nombre'          => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 50 caracteres.',
            'alpha_numeric_punct'       => 'Este campo no debe tener caracteres especiales.'
        ],
        'prioridad_descripcion'     => [
            'max_length'                => 'El tamaño máximo de este campo debe ser 255 caracteres.',
            'string'                    => 'Este campo no debe tener caracteres especiales.'
        ],
        'prioridad_color'           => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 50 caracteres.',
            'alpha_numeric_punct'       => 'Este campo no debe tener caracteres especiales.'
        ],
        'prioridad_estatus'         => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 1 carácter.',
            'integer'                   => 'Tipo de dato proporcionado no es valido.',
            'in_list'                   => 'La clave de estatus proporcionado no existe'
        ]
    ];

    protected $skipValidation           = false;
}
