<?php

namespace App\Controllers\API;

use App\Models\SlaModel;
use CodeIgniter\RESTful\ResourceController;

class Sla extends ResourceController
{
    public function __construct()
    {
        $this->model = $this->setModel(new SlaModel());
    }

    public function read($sla_id = null)
    {
        if($sla_id == null):
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success'   => 'Lista de SLA cargada correctamente.',
                    'data'      => $this->model->findAll()
                ]
            ];

            return $this->respond( $response );
        else:
            $sla = $this->model->find($sla_id);

            if(!$sla) return $this->failNotFound('No se encontró información del SLA con el id proporcionado (' . $sla_id . ')');

            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success'   => 'Información del SLA cargada correctamente.',
                    'data'      => $sla
                ]
            ];

            return $this->respond($response);
        endif;
    }

    public function create()
    {
        try {
            $sla = $this->request->getJSON();

            if( $this->model->insert($sla) ):
                $response = [
                    'status'   => 201,
                    'error'    => null,
                    'messages' => [
                        'success' => 'SLA registrado correctamente.',
                        'sla_id' => $this->model->getInsertID()
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

    public function update($sla_id = null)
    {
        try {
            if($sla_id == null)
                return $this->failValidationErrors('No proporciono una clave de SLA valido.');

            $existeSla = $this->model->find($sla_id);
            if($existeSla == null)
                return $this->failNotFound('No se encontró datos del SLA con el id proporcionado (' . $sla_id . ')');

            $sla = $this->request->getJSON();

            if( $this->model->update($sla_id, $sla) ):
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Datos del SLA actualizados correctamente.'
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

    public function delete($sla_id = null)
    {
        try {
            if($sla_id == null)
                return $this->failValidationErrors('No proporciono una clave de SLA valido.');

            $existeSla = $this->model->find($sla_id);
            if($existeSla == null)
                return $this->failNotFound('No se encontró información del SLA con el id proporcionado (' . $sla_id . ')');

            if( $this->model->delete($sla_id) ):

                $this->model->update($sla_id, ['sla_estatus' => 0]);

                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Datos del SLA eliminados correctamente.'
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
