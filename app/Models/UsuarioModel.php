<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table                    = 'usuario';
    protected $primaryKey               = 'usuario_id';

    protected $useAutoIncrement         = true;

    protected $returnType               = 'array'; #object
    protected $useSoftDeletes           = true;

    protected $allowedFields            = [
        'usuario_nombre', 
        'usuario_contrasenia', 
        'usuario_propietario', 
        'usuario_email', 
        'usuario_telefono', 
        'usuario_departamento', 
        'usuario_organizacion', 
        'usuario_tipo', 
        'usuario_firma', 
        'usuario_avatar', 
        'usuario_estatus'
    ];

    protected bool $allowEmptyInserts   = false;

    // Dates
    protected $useTimestamps            = true;
    protected $dateFormat               = 'datetime';
    protected $createdField             = 'usuario_created_at';
    protected $updatedField             = 'usuario_updated_at';
    protected $deletedField             = 'usuario_deleted_at';

    // Validation
    protected $validationRules          = [
        'usuario_nombre'        => 'required|max_length[255]|string|is_unique[usuario.usuario_nombre]',
        'usuario_contrasenia'   => 'required|max_length[255]',
        'usuario_propietario'   => 'required|max_length[255]|alpha_space',
        'usuario_email'         => 'required|max_length[255]|valid_email|is_unique[usuario.usuario_email]',
        'usuario_telefono'      => 'permit_empty|max_length[255]|alpha_numeric_space',
        'usuario_departamento'  => 'permit_empty|max_length[1]|integer|is_not_unique[departamento.departamento_id]',
        'usuario_organizacion'  => 'permit_empty|max_length[1]|integer|is_not_unique[organizacion.organizacion_id]',
        'usuario_tipo'          => 'required|max_length[1]|integer|in_list[1,2,3]',
        'usuario_firma'         => 'permit_empty|alpha_numeric_punct',
        'usuario_avatar'        => 'permit_empty|alpha_numeric_space',
        'usuario_estatus'       => 'required|max_length[1]|integer',
    ];

    protected $validationMessages       = [
        'usuario_nombre'        => [
            'required'              => 'Este campo es requerido.',
            'max_length'            => 'El tamaño máximo de este campo debe ser 255 caracteres.',
            'string'                => 'Este campo no debe tener caracteres especiales.',
            'is_unique'             => 'Este nombre de usuario ya esta en uso, por favor proporcione otro nombre de usuario.'
        ],
        'usuario_contrasenia'   => [
            'required'              => 'Este campo es requerido.',
            'max_length'            => 'El tamaño máximo de este campo debe ser 255 caracteres.'
        ],
        'usuario_propietario'   => [
            'required'              => 'Este campo es requerido.',
            'max_length'            => 'El tamaño máximo de este campo debe ser 255 caracteres.',
            'alpha_space'           => 'Este campo no debe tener caracteres especiales.'
        ],
        'usuario_email'         => [
            'required'              => 'Este campo es requerido.',
            'max_length'            => 'El tamaño máximo de este campo debe ser 255 caracteres.',
            'valid_email'           => 'Debe proporcionar una dirección de correo valida.',
            'is_unique'             => 'Este correo electrónico ya ha sido registrado, proporcione otra dirección de correo electrónico.'
        ],
        'usuario_telefono'      => [
            'max_length'            => 'El tamaño máximo de este campo debe ser 255 caracteres.',
            'alpha_numeric_space'   => 'Este campo no debe tener caracteres especiales.'
        ],
        'usuario_departamento'  => [
            'max_length'            => 'El tamaño máximo de este campo debe ser 1 carácter.',
            'integer'               => 'Tipo de dato proporcionado no es valido.',
            'is_not_unique'         => 'La clave de departamento proporcionado no existe'
        ],
        'usuario_organizacion'  => [
            'max_length'            => 'El tamaño máximo de este campo debe ser 1 carácter.',
            'integer'               => 'Tipo de dato proporcionado no es valido.',
            'is_not_unique'         => 'La clave de organización proporcionado no existe'
        ],
        'usuario_tipo'          => [
            'required'              => 'Este campo es requerido.',
            'max_length'            => 'El tamaño máximo de este campo debe ser 1 carácter.',
            'integer'               => 'Tipo de dato proporcionado no es valido.',
            'in_list'               => 'La clave de tipo de usuario proporcionado no existe.'
        ],
        'usuario_firma'         => [
            'alpha_numeric_punct'   => 'Este campo no debe tener caracteres especiales.'
        ],
        'usuario_avatar'        => [
            'alpha_numeric_space'   => 'Este campo no debe tener caracteres especiales.'
        ],
        'usuario_estatus'       => [
            'required'              => 'Este campo es requerido.',
            'max_length'            => 'El tamaño máximo de este campo debe ser 1 carácter.',
            'integer'               => 'Tipo de dato proporcionado no es valido.'
        ]
    ];

    protected $skipValidation           = false;
}
