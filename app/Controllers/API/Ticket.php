<?php

namespace App\Controllers\API;

use App\Models\TicketModel;
use CodeIgniter\RESTful\ResourceController;

class Ticket extends ResourceController
{
    public function __construct()
    {
        $this->model = $this->setModel(new TicketModel());
    }

    public function read($condicion = null)
    {
        $db         = \Config\Database::connect();

        $builder   = $db->table('ticket');
        $builder->select('
            ticket.*,
            JSON_OBJECT(
                "usuario_nombre", usuario.usuario_nombre,
                "usuario_propietario", usuario.usuario_propietario,
                "usuario_email", usuario.usuario_email,
                "usuario_telefono", usuario.usuario_telefono,
                "usuario_firma", usuario.usuario_firma,
                "usuario_avatar", usuario.usuario_avatar 
            ) AS ticket_usuario_registra_detalle,
            departamento.departamento_nombre AS ticket_departamento_nombre,
            JSON_OBJECT( 
                "prioridad_nombre", prioridad.prioridad_nombre, 
                "prioridad_descripcion", prioridad.prioridad_descripcion, 
                "prioridad_color", prioridad.prioridad_color 
            ) AS ticket_prioridad_detalle,
            JSON_OBJECT( 
                "sla_nombre", sla.sla_nombre, 
                "sla_periodo_hora", sla.sla_periodo_hora, 
                "sla_periodo_minuto", sla.sla_periodo_minuto 
            ) AS ticket_sla_detalle,
            JSON_OBJECT( 
                "sla_nombre", sl.sla_nombre, 
                "sla_periodo_hora", sl.sla_periodo_hora, 
                "sla_periodo_minuto", sl.sla_periodo_minuto 
            ) AS ticket_sla_respuesta_detalle,
            JSON_OBJECT(
                "tema_nombre", tema_ayuda.tema_nombre, 
                "tema_prioridad", ( SELECT p.prioridad_nombre FROM prioridad AS p WHERE p.prioridad_id = tema_ayuda.tema_prioridad ),
                "tema_sla", ( SELECT JSON_OBJECT( "sla_nombre", s.sla_nombre, "sla_periodo_hora", s.sla_periodo_hora, "sla_periodo_minuto", s.sla_periodo_minuto ) FROM sla AS s WHERE s.sla_id = tema_ayuda.tema_sla )
            ) AS ticket_tema_detalle,
            JSON_OBJECT(
                "estatus_nombre", ticket_estatus.estatus_nombre,
                "estatus_estado", ticket_estatus.estatus_estado,
                "estatus_mensage", ticket_estatus.estatus_mensage,
                "estatus_descripcion", ticket_estatus.estatus_descripcion
            ) AS ticket_estatus_detalle,
            CASE WHEN ticket.ticket_agente IS NULL THEN null
            ELSE ( select JSON_OBJECT(
                "usuario_nombre", u.usuario_nombre,
                "usuario_propietario", u.usuario_propietario,
                "usuario_email", u.usuario_email,
                "usuario_telefono", u.usuario_telefono,
                "usuario_firma", u.usuario_firma,
                "usuario_avatar", u.usuario_avatar 
            ) from usuario u where u.usuario_id = ticket.ticket_agente)
            END AS ticket_agente_detalle
        ');
        
        $builder->join('departamento', 'departamento.departamento_id = ticket.ticket_departamento', 'inner');
        $builder->join('usuario', 'usuario.usuario_id = ticket.ticket_usuario_registra', 'inner');
        $builder->join('prioridad', 'prioridad.prioridad_id = ticket.ticket_prioridad', 'inner');
        $builder->join('sla', 'sla.sla_id = ticket.ticket_sla', 'inner');
        $builder->join('tema_ayuda', 'tema_ayuda.tema_id = ticket.ticket_tema', 'inner');
        $builder->join('ticket_estatus', 'ticket_estatus.estatus_id = ticket.ticket_estatus', 'inner');
        $builder->join('sla as sl', 'sl.sla_id = ticket.ticket_sla_respuesta', 'inner');

        if($condicion == null):
            $builder->where('ticket.ticket_estatus <', 5);
            $query      = $builder->get();

            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success'   => 'Lista de ticket cargada correctamente.',
                    'data'      => $query->getResultArray()
                ]
            ];

            return $this->respond( $response );
        else:
            // $ticket = $this->model->find($ticket_id);
            // if(!$ticket) return $this->failNotFound('No se encontró información del ticket con el id proporcionado (' . $ticket_id . ')');

            /**
             *[1] =>    Mostrar los tickets nuevos - Son los que se han registrado recientemente
             *          no tienen asignado un agente y esta en el tiempo limite para dar una respuesta segun SLA
            **/

            $builder->where('ticket.ticket_usuario_registra', session()->get('usuario_id'));

            switch ($condicion) {
                case 1:
                    $builder->where('ticket.ticket_estatus', 1);
                    $builder->where('ticket.ticket_agente', null);
                    $builder->where('(ticket.ticket_created_at + INTERVAL sl.sla_periodo_hora HOUR + INTERVAL sl.sla_periodo_minuto MINUTE) > CURRENT_TIMESTAMP()');
                    $builder->orderBy('ticket.ticket_created_at', 'desc');
                    break;
                case 2:
                    $builder->where('ticket.ticket_estatus', 1);
                    $builder->where('ticket.ticket_agente', null);
                    $builder->where('(ticket.ticket_created_at + INTERVAL sl.sla_periodo_hora HOUR + INTERVAL sl.sla_periodo_minuto MINUTE) < CURRENT_TIMESTAMP()');
                    $builder->orderBy('ticket.ticket_created_at', 'desc');
                    break;
                default:
                    $builder->where('ticket.ticket_estatus', 1);
                    break;
            }

            $query = $builder->get();

            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success'   => 'Información del ticket cargada correctamente.',
                    'data'      => $query->getResultArray()
                ]
            ];

            return $this->respond($response);
        endif;
    }

    public function create()
    {
        try {
            $ticket = $this->request->getJSON();
            $ticket->ticket_usuario_registra = session()->get('usuario_id');

            if( $this->model->insert($ticket) ):
                $response = [
                    'status'   => 201,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Ticket registrado correctamente.',
                        'ticket_id' => $this->model->getInsertID()
                    ]
                ];

                return $this->respondCreated( $response );
            else:
                return $this->failValidationErrors( $this->model->validation->getErrors() );
            endif;
        } catch (\Throwable $e) {
            $complemento = (ENVIRONMENT == 'development') ? $e->getMessage() : '';

            return $this->failServerError( 'Ha ocurrido un error en el servidor de base de datos. ' . $complemento );
        }
    }

    public function update($ticket_id = null)
    {
        try {
            if($ticket_id == null)
                return $this->failValidationErrors('No proporciono una clave de ticket valido.');

            $existeTicket = $this->model->find($ticket_id);
            if($existeTicket == null)
                return $this->failNotFound('No se encontró datos del ticket con el id proporcionado (' . $ticket_id . ')');

            $ticket = $this->request->getJSON();

            $this->model->setValidationRule('ticket_folio', 'required|max_length[20]|alpha_numeric_punct|is_unique[ticket.ticket_folio, ticket_id, '. $ticket_id .']');

            if( $this->model->update($ticket_id, $ticket) ):
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Datos del ticket actualizados correctamente.'
                    ]
                ];

                return $this->respondUpdated( $response );
            else:
                return $this->failValidationErrors( $this->model->validation->getErrors() );
            endif;
        } catch (\Throwable $e) {
            $complemento = (ENVIRONMENT == 'development') ? $e->getMessage() : '';

            return $this->failServerError( 'Ha ocurrido un error en el servidor de base de datos. ' . $complemento );
        }
    }

    public function delete($ticket_id = null)
    {
        try {
            if($ticket_id == null)
                return $this->failValidationErrors('No proporciono una clave de ticket valido.');

            $existeTicket = $this->model->find($ticket_id);
            if($existeTicket == null)
                return $this->failNotFound('No se encontró información del ticket con el id proporcionado (' . $ticket_id . ')');

            if( $this->model->delete($ticket_id) ):

                $this->model->update($ticket_id, ['ticket_estatus' => 5]);

                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Datos del ticket eliminados correctamente.'
                    ]
                ];

                return $this->respondDeleted( $response );
            else:
                return $this->failValidationErrors( $this->model->validation->getErrors() );
            endif;
        } catch (\Throwable $e) {
            $complemento = (ENVIRONMENT == 'development') ? $e->getMessage() : '';

            return $this->failServerError( 'Ha ocurrido un error en el servidor de base de datos. ' . $complemento );
        }
    }

    public function putEvidencia()
    {
        $evidencias     = $this->request->getFiles();
        $ticket_id      = $this->request->getPost('ticket_id');

        $path           = ROOTPATH . 'public/assets/evidencia/ticket/' . $ticket_id;

        $rules          = [
            'evidencia' => [
                'label' => 'Evidencia ticket',
                'rules' => [
                    'max_size[evidencia, 2000]'
                ],
                'errors' => [
                    'max_size' => 'No puede subir archivos que superen los 2MB'
                ]
            ]
        ];

        $noSave     = [];
        $success    = [];

        foreach ($evidencias['evidencia'] as $file) {
            if(!$file->isValid()) {
                $noSave[] = ['file' => $file->getName(), 'reason' => $file->getErrorString()];
                continue;
            }

            if(!$this->validateData([], $rules)) {
                $noSave[] = ['file' => $file->getName(), 'reason' => $this->validator->getErrors()];
                continue;
            }

            if(!$file->hasMoved()):
                $originalName   = $file->getName();
                $newName        = uniqid() .'.'. $file->getClientExtension();
                
                $file->move($path, $newName, true);

                $success[] = ['file' => $originalName, 'newName' => $newName];
            else:
                $noSave[] = ['file' => $file->getName(), 'reason' => 'Error general'];
            endif;
        }

        if( count($success) > 0 ) {
            $this->model->update($ticket_id, ['ticket_evidencia' => json_encode($success) ]);
        }

        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success'   => $success,
                'error'     => $noSave
            ]
        ];

        return $this->respondCreated($response);
    }
}
