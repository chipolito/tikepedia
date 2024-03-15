<?php

namespace App\Controllers\API;

use App\Models\DepartamentoModel;
use CodeIgniter\RESTful\ResourceController;

class Departamento extends ResourceController
{
    public function __construct()
    {
        $this->model = $this->setModel(new DepartamentoModel());
    }

    public function read($departamento_id = null)
    {
        if($departamento_id == null):
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success'   => 'Lista de departamentos cargada correctamente.',
                    'data'      => $this->model->findAll()
                ]
            ];

            return $this->respond( $response );
        else:
            $departamento = $this->model->find($departamento_id);

            if(!$departamento) return $this->failNotFound('No se encontró información del departamento con el id proporcionado (' . $departamento_id . ')');

            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success'   => 'Información del departamento cargada correctamente.',
                    'data'      => $departamento
                ]
            ];

            return $this->respond($response);
        endif;
    }

    public function create()
    {
        try {
            $departamento = $this->request->getJSON();

            if( $this->model->insert($departamento) ):
                $response = [
                    'status'   => 201,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Departamento registrado correctamente.',
                        'departamento_id' => $this->model->getInsertID()
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

    public function update($departamento_id = null)
    {
        try {
            if($departamento_id == null)
                return $this->failValidationErrors('No proporciono una clave de departamento valido.');

            $existeDepartamento = $this->model->find($departamento_id);
            if($existeDepartamento == null)
                return $this->failNotFound('No se encontró datos del departamento con el id proporcionado (' . $departamento_id . ')');

            $departamento = $this->request->getJSON();

            if( $this->model->update($departamento_id, $departamento) ):
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Datos del departamento actualizados correctamente.'
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

    public function delete($departamento_id = null)
    {
        try {
            if($departamento_id == null)
                return $this->failValidationErrors('No proporciono una clave de departamento valido.');

            $existeDepartamento = $this->model->find($departamento_id);
            if($existeDepartamento == null)
                return $this->failNotFound('No se encontró información del departamento con el id proporcionado (' . $departamento_id . ')');

            if( $this->model->delete($departamento_id) ):

                $this->model->update($departamento_id, ['departamento_estatus' => 0]);

                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Datos del departamento eliminados correctamente.'
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
