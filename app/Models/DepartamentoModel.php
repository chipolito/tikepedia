<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartamentoModel extends Model
{
    protected $table                    = 'departamento';
    protected $primaryKey               = 'departamento_id';

    protected $useAutoIncrement         = true;

    protected $returnType               = 'array'; #object
    protected $useSoftDeletes           = true;

    protected $allowedFields            = [
        'departamento_nombre', 
        'departamento_gerente', 
        'departamento_estatus'
    ];

    protected bool $allowEmptyInserts   = false;

    // Dates
    protected $useTimestamps            = true;
    protected $dateFormat               = 'datetime';
    protected $createdField             = 'departamento_created_at';
    protected $updatedField             = 'departamento_updated_at';
    protected $deletedField             = 'departamento_deleted_at';

    // Validation
    protected $validationRules          = [
        'departamento_nombre'   => 'required|max_length[255]|string',
        'departamento_gerente'  => 'permit_empty|max_length[10]|integer|is_not_unique[usuario.usuario_id]',
        'departamento_estatus'  => 'required|max_length[1]|integer|in_list[0,1]',
    ];

    protected $validationMessages       = [
        'departamento_nombre'   => [
            'required'              => 'Este campo es requerido.',
            'max_length'            => 'El tamaño máximo de este campo debe ser 255 caracteres.',
            'string'                => 'Este campo no debe tener caracteres especiales.'
        ],
        'departamento_gerente'  => [
            'max_length'            => 'El tamaño máximo de este campo debe ser 10 caracteres.',
            'integer'               => 'Tipo de dato proporcionado no es valido.',
            'is_not_unique'         => 'La clave de usuario proporcionado no existe'
        ],
        'departamento_estatus'  => [
            'required'              => 'Este campo es requerido.',
            'max_length'            => 'El tamaño máximo de este campo debe ser 1 carácter.',
            'integer'               => 'Tipo de dato proporcionado no es valido.',
            'in_list'               => 'La clave de estatus proporcionado no existe'
        ]
    ];

    protected $skipValidation           = false;
}
