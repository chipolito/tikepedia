<?php

namespace App\Models;

use CodeIgniter\Model;

class OrganizacionModel extends Model
{
    protected $table                    = 'organizacion';
    protected $primaryKey               = 'organizacion_id';

    protected $useAutoIncrement         = true;

    protected $returnType               = 'array'; #object
    protected $useSoftDeletes           = true;

    protected $allowedFields            = [
        'organizacion_nombre', 
        'organizacion_telefono', 
        'organizacion_correo',
        'organizacion_web',
        'organizacion_logotipo',
        'organizacion_direccion',
        'organizacion_administrador',
        'organizacion_estatus'
    ];

    protected bool $allowEmptyInserts   = false;

    // Dates
    protected $useTimestamps            = true;
    protected $dateFormat               = 'datetime';
    protected $createdField             = 'organizacion_created_at';
    protected $updatedField             = 'organizacion_updated_at';
    protected $deletedField             = 'organizacion_deleted_at';

    // Validation
    protected $validationRules          = [
        'organizacion_nombre'           => 'required|max_length[250]|alpha_numeric_punct',
        'organizacion_telefono'         => 'permit_empty|max_length[50]|alpha_numeric_space',
        'organizacion_correo'           => 'permit_empty|max_length[250]|valid_email',
        'organizacion_web'              => 'permit_empty|max_length[250]|string',
        'organizacion_logotipo'         => 'permit_empty|max_length[255]|alpha_numeric_punct',
        'organizacion_direccion'        => 'permit_empty|max_length[500]|string',
        'organizacion_administrador'    => 'permit_empty|max_length[10]|integer|is_not_unique[usuario.usuario_id]',
        'organizacion_estatus'          => 'required|max_length[1]|integer|in_list[0,1]'
    ];

    protected $validationMessages       = [
        'organizacion_nombre'       => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 250 caracteres.',
            'alpha_numeric_punct'       => 'Este campo no debe tener caracteres especiales.'
        ],
        'organizacion_telefono'     => [
            'max_length'                => 'El tamaño máximo de este campo debe ser 50 caracteres.',
            'alpha_numeric_space'       => 'Este campo no debe tener caracteres especiales.'
        ],
        'organizacion_correo'       => [
            'max_length'                => 'El tamaño máximo de este campo debe ser 250 caracteres.',
            'valid_email'               => 'Debe proporcionar una dirección de correo valida.'
        ],
        'organizacion_web'          => [
            'max_length'                => 'El tamaño máximo de este campo debe ser 250 caracteres.',
            'string'                    => 'Este campo no debe tener caracteres especiales.'
        ],
        'organizacion_logotipo'     => [
            'max_length'                => 'El tamaño máximo de este campo debe ser 255 caracteres.',
            'alpha_numeric_punct'       => 'Este campo no debe tener caracteres especiales.'
        ],
        'organizacion_direccion'    => [
            'max_length'                => 'El tamaño máximo de este campo debe ser 500 caracteres.',
            'string'                    => 'Este campo no debe tener caracteres especiales.'
        ],
        'organizacion_administrador'=> [
            'max_length'                => 'El tamaño máximo de este campo debe ser 10 caracteres.',
            'integer'                   => 'Tipo de dato proporcionado no es valido.',
            'is_not_unique'             => 'La clave de usuario proporcionado no existe'
        ],
        'organizacion_estatus'      => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 1 carácter.',
            'integer'                   => 'Tipo de dato proporcionado no es valido.',
            'in_list'                   => 'La clave de estatus proporcionado no existe'
        ]
    ];

    protected $skipValidation           = false;
}
