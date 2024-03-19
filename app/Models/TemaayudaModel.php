<?php

namespace App\Models;

use CodeIgniter\Model;

class TemaayudaModel extends Model
{
    protected $table                    = 'tema_ayuda';
    protected $primaryKey               = 'tema_id';

    protected $useAutoIncrement         = true;

    protected $returnType               = 'array'; #object
    protected $useSoftDeletes           = true;

    protected $allowedFields            = [
        'tema_nombre', 
        'tema_departamento',
        'tema_prioridad',
        'tema_sla',
        'tema_estatus'
    ];

    protected bool $allowEmptyInserts   = false;

    // Dates
    protected $useTimestamps            = true;
    protected $dateFormat               = 'datetime';
    protected $createdField             = 'tema_created_at';
    protected $updatedField             = 'tema_updated_at';
    protected $deletedField             = 'tema_deleted_at';

    // Validation
    protected $validationRules          = [
        'tema_nombre'       => 'required|max_length[255]|alpha_numeric_punct',
        'tema_departamento' => 'required|max_length[10]|integer|is_not_unique[departamento.departamento_id]',
        'tema_prioridad'    => 'required|max_length[10]|integer|is_not_unique[prioridad.prioridad_id]',
        'tema_sla'          => 'required|max_length[10]|integer|is_not_unique[sla.sla_id]',
        'tema_estatus'      => 'required|max_length[1]|integer|in_list[0,1]'
    ];

    protected $validationMessages       = [
        'tema_nombre'                => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 255 caracteres.',
            'alpha_numeric_punct'       => 'Este campo no debe tener caracteres especiales.'
        ],
        'tema_departamento'          => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 10 caracteres.',
            'integer'                   => 'Este campo no debe tener caracteres especiales.',
            'is_not_unique'             => 'La clave de departamento proporcionado no existe en el catalogo'
        ],
        'tema_prioridad'            => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 10 caracteres.',
            'integer'                   => 'Este campo no debe tener caracteres especiales.',
            'is_not_unique'             => 'La clave de prioridad proporcionado no existe en el catalogo'
        ],
        'tema_sla'                  => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 10 caracteres.',
            'integer'                   => 'Este campo no debe tener caracteres especiales.',
            'is_not_unique'             => 'La clave de SLA proporcionado no existe en el catalogo'
        ],
        'tema_estatus'               => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 1 carácter.',
            'integer'                   => 'Tipo de dato proporcionado no es valido.',
            'in_list'                   => 'La clave de estatus proporcionado no existe'
        ]
    ];

    protected $skipValidation           = false;
}
