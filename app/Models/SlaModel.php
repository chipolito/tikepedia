<?php

namespace App\Models;

use CodeIgniter\Model;

class SlaModel extends Model
{
    protected $table                    = 'sla';
    protected $primaryKey               = 'sla_id';

    protected $useAutoIncrement         = true;

    protected $returnType               = 'array'; #object
    protected $useSoftDeletes           = true;

    protected $allowedFields            = [
        'sla_nombre', 
        'sla_periodo_hora',
        'sla_periodo_minuto',
        'sla_comentario',
        'sla_estatus'
    ];

    protected bool $allowEmptyInserts   = false;

    // Dates
    protected $useTimestamps            = true;
    protected $dateFormat               = 'datetime';
    protected $createdField             = 'sla_created_at';
    protected $updatedField             = 'sla_updated_at';
    protected $deletedField             = 'sla_deleted_at';

    // Validation
    protected $validationRules          = [
        'sla_nombre'            => 'required|max_length[255]|alpha_numeric_punct',
        'sla_periodo_hora'      => 'required|max_length[10]|integer',
        'sla_periodo_minuto'    => 'required|max_length[10]|integer',
        'sla_comentario'        => 'permit_empty|string',
        'sla_estatus'           => 'required|max_length[1]|integer|in_list[0,1]'
    ];

    protected $validationMessages       = [
        'sla_nombre'                => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 255 caracteres.',
            'alpha_numeric_punct'       => 'Este campo no debe tener caracteres especiales.'
        ],
        'sla_periodo_hora'          => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 10 caracteres.',
            'integer'                   => 'Este campo no debe tener caracteres especiales.'
        ],
        'sla_periodo_minuto'        => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 10 caracteres.',
            'integer'                   => 'Este campo no debe tener caracteres especiales.'
        ],
        'sla_comentario'            => [
            'string'                    => 'Este campo no debe tener caracteres especiales.'
        ],
        'sla_estatus'               => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 1 carácter.',
            'integer'                   => 'Tipo de dato proporcionado no es valido.',
            'in_list'                   => 'La clave de estatus proporcionado no existe'
        ]
    ];

    protected $skipValidation           = false;
}
