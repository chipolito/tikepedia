<?php

namespace App\Controllers\API;

use App\Models\TemaayudaModel;
use CodeIgniter\RESTful\ResourceController;

class Temaayuda extends ResourceController
{
    public function __construct()
    {
        $this->model = $this->setModel(new TemaayudaModel());
    }

    public function read($departamento_id = null)
    {
        if($departamento_id == null):
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success'   => 'Lista de temas cargada correctamente.',
                    'data'      => $this->model->findAll()
                ]
            ];

            return $this->respond( $response );
        else:
            $temas = $this->model->where('tema_departamento', $departamento_id)->findAll();

            if(!$temas) return $this->failNotFound('No se encontró información del tema con el id proporcionado (' . $departamento_id . ')');

            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success'   => 'Información del tema cargada correctamente.',
                    'data'      => $temas
                ]
            ];

            return $this->respond($response);
        endif;
    }

    public function create()
    {
        try {
            $tema = $this->request->getJSON();

            if( $this->model->insert($tema) ):
                $response = [
                    'status'   => 201,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Tema registrado correctamente.',
                        'tema_id' => $this->model->getInsertID()
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

    public function update($tema_id = null)
    {
        try {
            if($tema_id == null)
                return $this->failValidationErrors('No proporciono una clave de tema valido.');

            $existeTema = $this->model->find($tema_id);
            if($existeTema == null)
                return $this->failNotFound('No se encontró datos del tema con el id proporcionado (' . $tema_id . ')');

            $tema = $this->request->getJSON();

            if( $this->model->update($tema_id, $tema) ):
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Datos del tema actualizados correctamente.'
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

    public function delete($tema_id = null)
    {
        try {
            if($tema_id == null)
                return $this->failValidationErrors('No proporciono una clave de tema valido.');

            $existeTema = $this->model->find($tema_id);
            if($existeTema == null)
                return $this->failNotFound('No se encontró información del tema con el id proporcionado (' . $tema_id . ')');

            if( $this->model->delete($tema_id) ):

                $this->model->update($tema_id, ['tema_estatus' => 0]);

                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Datos del tema eliminados correctamente.'
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
