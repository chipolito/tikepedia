<?php

namespace App\Controllers\API;

use App\Models\HistoriaModel;
use CodeIgniter\RESTful\ResourceController;

class Historia extends ResourceController
{
    public function __construct()
    {
        $this->model = $this->setModel(new HistoriaModel());
    }

    public function read($ticket_id = null)
    {
        $db         = \Config\Database::connect();

        $builder   = $db->table('ticket_historia');
        $builder->select('
            ticket_historia.*,
            JSON_OBJECT(
                "usuario_nombre", usuario.usuario_nombre,
                "usuario_propietario", usuario.usuario_propietario,
                "usuario_email", usuario.usuario_email,
                "usuario_telefono", usuario.usuario_telefono,
                "usuario_firma", usuario.usuario_firma,
                "usuario_avatar", usuario.usuario_avatar 
            ) AS historia_usuario_detalle
        ');

        $builder->join('usuario', 'usuario.usuario_id = ticket_historia.historia_usuario', 'inner');

        $builder->where('ticket_historia.historia_ticket', $ticket_id);
        $builder->where('historia_deleted_at', null);

        $query      = $builder->get();
        
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success'   => 'Lista de historia cargada correctamente.',
                'data'      => $query->getResultArray()
            ]
        ];

        return $this->respond( $response );
    }

    public function create()
    {
        try {
            $historia = $this->request->getJSON();

            if( $this->model->insert($historia) ):
                $response = [
                    'status'   => 201,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Historia registrado correctamente.',
                        'historia_id' => $this->model->getInsertID()
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

    public function update($historia_id = null)
    {
        try {
            if($historia_id == null)
                return $this->failValidationErrors('No proporciono una clave de historia valido.');

            $existeHistoria = $this->model->find($historia_id);
            if($existeHistoria == null)
                return $this->failNotFound('No se encontró datos de la historia con el id proporcionado (' . $historia_id . ')');

            $historia = $this->request->getJSON();

            if( $this->model->update($historia_id, $historia) ):
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Datos de la historia actualizados correctamente.'
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

    public function delete($historia_id = null)
    {
        try {
            if($historia_id == null)
                return $this->failValidationErrors('No proporciono una clave de historia valido.');

            $existeHistoria = $this->model->find($historia_id);
            if($existeHistoria == null)
                return $this->failNotFound('No se encontró información de la historia con el id proporcionado (' . $historia_id . ')');

            if( $this->model->delete($historia_id) ):
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Datos de la historia eliminados correctamente.'
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
        $historia_id    = $this->request->getPost('historia_id');

        $path           = ROOTPATH . 'public/assets/evidencia/historia/' . $historia_id;

        $rules          = [
            'evidencia' => [
                'label' => 'Evidencia historia ticket',
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
            $this->model->update($historia_id, ['historia_evidencia' => json_encode($success) ]);
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
