<?php

namespace App\Controllers\API;

use App\Models\PrioridadModel;
use CodeIgniter\RESTful\ResourceController;

class Prioridad extends ResourceController
{
    public function __construct()
    {
        $this->model = $this->setModel(new PrioridadModel());
    }

    public function read($prioridad_id = null)
    {
        if($prioridad_id == null):
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success'   => 'Lista de prioridades cargada correctamente.',
                    'data'      => $this->model->findAll()
                ]
            ];

            return $this->respond( $response );
        else:
            $prioridad = $this->model->find($prioridad_id);

            if(!$prioridad) return $this->failNotFound('No se encontró información de la prioridad con el id proporcionado (' . $prioridad_id . ')');

            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success'   => 'Información de la prioridad cargada correctamente.',
                    'data'      => $prioridad
                ]
            ];

            return $this->respond($response);
        endif;
    }

    public function create()
    {
        try {
            $prioridad = $this->request->getJSON();

            if( $this->model->insert($prioridad) ):
                $response = [
                    'status'   => 201,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Prioridad registrada correctamente.',
                        'prioridad_id' => $this->model->getInsertID()
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

    public function update($prioridad_id = null)
    {
        try {
            if($prioridad_id == null)
                return $this->failValidationErrors('No proporciono una clave de prioridad valido.');

            $existePrioridad = $this->model->find($prioridad_id);
            if($existePrioridad == null)
                return $this->failNotFound('No se encontró datos de la prioridad con el id proporcionado (' . $prioridad_id . ')');

            $prioridad = $this->request->getJSON();

            if( $this->model->update($prioridad_id, $prioridad) ):
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Datos de la prioridad actualizados correctamente.'
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

    public function delete($prioridad_id = null)
    {
        try {
            if($prioridad_id == null)
                return $this->failValidationErrors('No proporciono una clave de prioridad valida.');

            $existePrioridad = $this->model->find($prioridad_id);
            if($existePrioridad == null)
                return $this->failNotFound('No se encontró información de la prioridad con el id proporcionado (' . $prioridad_id . ')');

            if( $this->model->delete($prioridad_id) ):

                $this->model->update($prioridad_id, ['prioridad_estatus' => 0]);

                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Datos de la prioridad eliminados correctamente.'
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
}
