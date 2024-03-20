<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoriaModel extends Model
{
    protected $table                    = 'ticket_historia';
    protected $primaryKey               = 'historia_id';

    protected $useAutoIncrement         = true;

    protected $returnType               = 'array'; #object
    protected $useSoftDeletes           = true;

    protected $allowedFields            = [
        'historia_ticket', 
        'historia_usuario',
        'historia_detalle',
        'historia_evidencia'
    ];

    protected bool $allowEmptyInserts   = false;

    // Dates
    protected $useTimestamps            = true;
    protected $dateFormat               = 'datetime';
    protected $createdField             = 'historia_created_at';
    protected $updatedField             = 'historia_updated_at';
    protected $deletedField             = 'historia_deleted_at';

    // Validation
    protected $validationRules          = [
        'historia_ticket'       => 'required|max_length[10]|integer|is_not_unique[ticket.ticket_id]',
        'historia_usuario'      => 'required|max_length[10]|integer|is_not_unique[usuario.usuario_id]',
        'historia_detalle'      => 'required|string',
        'historia_evidencia'    => 'permit_empty|string'
    ];

    protected $validationMessages       = [
        'historia_ticket'           => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 10 caracteres.',
            'integer'                   => 'Este campo no debe tener caracteres especiales.',
            'is_not_unique'             => 'La clave del ticket proporcionado no existe en el catalogo'
        ],
        'historia_usuario'          => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 10 caracteres.',
            'integer'                   => 'Este campo no debe tener caracteres especiales.',
            'is_not_unique'             => 'La clave del usuario proporcionado no existe en el catalogo'
        ],
        'historia_detalle'          => [
            'required'                  => 'Este campo es requerido.',
            'string'                    => 'Este campo no debe tener caracteres especiales.'
        ],
        'historia_evidencia'        => [
            'string'                    => 'Este campo no debe tener caracteres especiales.'
        ]
    ];

    protected $skipValidation           = false;
}
