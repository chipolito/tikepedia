<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table                    = 'ticket';
    protected $primaryKey               = 'ticket_id';

    protected $useAutoIncrement         = true;

    protected $returnType               = 'array'; #object
    protected $useSoftDeletes           = true;

    protected $allowedFields            = [
        'ticket_folio',
        'ticket_sunto',
        'ticket_detalle',
        'ticket_evidencia',
        'ticket_usuario_registra',
        'ticket_departamento',
        'ticket_prioridad',
        'ticket_sla',
        'ticket_tema',
        'ticket_estatus',
        'ticket_calificacion',
        'ticket_agente',
        'ticket_reabierto',
        'ticket_cerrado',
        'ticket_reabierto_fecha',
        'ticket_cerrado_fecha'
    ];

    protected bool $allowEmptyInserts   = false;

    // Dates
    protected $useTimestamps            = true;
    protected $dateFormat               = 'datetime';
    protected $createdField             = 'ticket_created_at';
    protected $updatedField             = 'ticket_updated_at';
    protected $deletedField             = 'ticket_deleted_at';

    // Validation
    protected $validationRules          = [
        'ticket_folio'                  => 'required|max_length[20]|alpha_numeric_punct|is_unique[ticket.ticket_folio]',
        'ticket_sunto'                  => 'required|max_length[100]|alpha_numeric_punct',
        'ticket_detalle'                => 'required|string',
        'ticket_evidencia'              => 'permit_empty|string',
        'ticket_usuario_registra'       => 'required|max_length[10]|integer|is_not_unique[usuario.usuario_id]',
        'ticket_departamento'           => 'required|max_length[10]|integer|is_not_unique[departamento.departamento_id]',
        'ticket_prioridad'              => 'required|max_length[10]|integer|is_not_unique[prioridad.prioridad_id]',
        'ticket_sla'                    => 'required|max_length[10]|integer|is_not_unique[sla.sla_id]',
        'ticket_tema'                   => 'required|max_length[10]|integer|is_not_unique[tema_ayuda.tema_id]',
        'ticket_estatus'                => 'required|max_length[10]|integer|is_not_unique[ticket_estatus.estatus_id]',
        'ticket_calificacion'           => 'required|max_length[1]|integer|in_list[0,1,2,3,4,5]',
        'ticket_agente'                 => 'permit_empty|max_length[10]|integer|is_not_unique[usuario.usuario_id]',
        'ticket_reabierto'              => 'required|max_length[1]|integer|in_list[0,1]',
        'ticket_cerrado'                => 'required|max_length[1]|integer|in_list[0,1]',
        'ticket_reabierto_fecha'        => 'permit_empty|valid_date[Y-m-d H:i:s]',
        'ticket_cerrado_fecha'          => 'permit_empty|valid_date[Y-m-d H:i:s]'
    ];

    protected $validationMessages       = [
        'ticket_folio'              => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 20 caracteres.',
            'alpha_numeric_punct'       => 'Este campo no debe tener caracteres especiales.',
            'is_unique'                 => 'No se puede registrar el ticket, el folio ya se encuentra en uso.'
        ],
        'ticket_sunto'              => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 100 caracteres.',
            'alpha_numeric_punct'       => 'Este campo no debe tener caracteres especiales.'
        ],
        'ticket_detalle'            => [
            'required'                  => 'Este campo es requerido.',
            'string'                    => 'Este campo no debe tener caracteres especiales.'
        ],
        'ticket_evidencia'          => [
            'string'                    => 'Este campo no debe tener caracteres especiales.'
        ],
        'ticket_usuario_registra'   => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 10 caracteres.',
            'integer'                   => 'Tipo de dato proporcionado no es valido',
            'is_not_unique'             => 'La clave del usuario proporcionado no existe en el catalogo'
        ],
        'ticket_departamento'       => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 10 caracteres.',
            'integer'                   => 'Tipo de dato proporcionado no es valido',
            'is_not_unique'             => 'La clave de departamento proporcionado no existe en el catalogo'
        ],
        'ticket_prioridad'          => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 10 caracteres.',
            'integer'                   => 'Tipo de dato proporcionado no es valido',
            'is_not_unique'             => 'La clave de prioridad proporcionado no existe en el catalogo'
        ],
        'ticket_sla'                => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 10 caracteres.',
            'integer'                   => 'Tipo de dato proporcionado no es valido',
            'is_not_unique'             => 'La clave de SLA proporcionado no existe en el catalogo'
        ],
        'ticket_tema'               => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 10 caracteres.',
            'integer'                   => 'Tipo de dato proporcionado no es valido',
            'is_not_unique'             => 'La clave del tema proporcionado no existe en el catalogo'
        ],
        'ticket_estatus'            => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 10 caracteres.',
            'integer'                   => 'Tipo de dato proporcionado no es valido',
            'is_not_unique'             => 'La clave del tema proporcionado no existe en el catalogo'
        ],
        'ticket_calificacion'       => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 1 carácter.',
            'integer'                   => 'Tipo de dato proporcionado no es valido.',
            'in_list'                   => 'La puntuacion proporcionado no es valido'
        ],
        'ticket_agente'             => [
            'max_length'                => 'El tamaño máximo de este campo debe ser 10 caracteres.',
            'integer'                   => 'Tipo de dato proporcionado no es valido',
            'is_not_unique'             => 'La clave del agente proporcionado no existe en el catalogo'
        ],
        'ticket_reabierto'          => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 1 carácter.',
            'integer'                   => 'Tipo de dato proporcionado no es valido',
            'in_list'                   => 'La clave proporcionado no existe'
        ],
        'ticket_cerrado'            => [
            'required'                  => 'Este campo es requerido.',
            'max_length'                => 'El tamaño máximo de este campo debe ser 1 carácter.',
            'integer'                   => 'Tipo de dato proporcionado no es valido',
            'in_list'                   => 'La clave proporcionado no existe'
        ],
        'ticket_reabierto_fecha'    => [
            'valid_date'                => 'El formato de fecha proporcionado no es valido "AAAA-MM-DD H:M:S"'
        ],
        'ticket_cerrado_fecha'      => [
            'valid_date'                => 'El formato de fecha proporcionado no es valido "AAAA-MM-DD H:M:S"'
        ]
    ];

    protected $skipValidation           = false;
}
