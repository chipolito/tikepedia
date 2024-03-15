<?php

namespace App\Controllers\API;

use App\Models\OrganizacionModel;
use CodeIgniter\RESTful\ResourceController;

class Organizacion extends ResourceController
{
    public function __construct()
    {
        $this->model = $this->setModel(new OrganizacionModel());
    }

    public function read($organizacion_id = null)
    {
        if($organizacion_id == null):
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success'   => 'Lista de organizaciones cargada correctamente.',
                    'data'      => $this->model->findAll()
                ]
            ];

            return $this->respond( $response );
        else:
            $organizacion = $this->model->find($organizacion_id);

            if(!$organizacion) return $this->failNotFound('No se encontró información de la organización con el id proporcionado (' . $organizacion_id . ')');

            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success'   => 'Información de la organización cargada correctamente.',
                    'data'      => $organizacion
                ]
            ];

            return $this->respond($response);
        endif;
    }

    public function create()
    {
        try {
            $organizacion = $this->request->getJSON();

            if( $this->model->insert($organizacion) ):
                $response = [
                    'status'   => 201,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Organización registrada correctamente.',
                        'organizacion_id' => $this->model->getInsertID()
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

    public function update($organizacion_id = null)
    {
        try {
            if($organizacion_id == null)
                return $this->failValidationErrors('No proporciono una clave de organización valido.');

            $existeOrganizacion = $this->model->find($organizacion_id);
            if($existeOrganizacion == null)
                return $this->failNotFound('No se encontró datos de la organización con el id proporcionado (' . $organizacion_id . ')');

            $organizacion = $this->request->getJSON();

            if( $this->model->update($organizacion_id, $organizacion) ):
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Datos de la organización actualizados correctamente.'
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

    public function delete($organizacion_id = null)
    {
        try {
            if($organizacion_id == null)
                return $this->failValidationErrors('No proporciono una clave de organización valido.');

            $existeOrganizacion = $this->model->find($organizacion_id);
            if($existeOrganizacion == null)
                return $this->failNotFound('No se encontró información de la organización con el id proporcionado (' . $organizacion_id . ')');

            if( $this->model->delete($organizacion_id) ):

                $this->model->update($organizacion_id, ['organizacion_estatus' => 0]);

                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Datos de la organización eliminados correctamente.'
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

    public function putLogo()
    {
        $file               = $this->request->getFile('logo');
        $organizacion_id    = $this->request->getPost('organizacion_id');

        $path               = ROOTPATH . 'public/assets/images/organizacion';

        $rules              = [
            'logo' => [
                'label' => 'Logotipo organización',
                'rules' => [
                    'is_image[logo]',
                    'max_size[logo, 200]'
                ],
                'errors' => [
                    'is_image' => 'Solo se pueden subir archivos de tipo imagen',
                    'max_size' => 'No puede subir archivos que superen los 200 kb'
                ]
            ]
        ];

        if(!$file->isValid()) return $this->failValidationErrors( $file->getErrorString() );

        if(!$this->validateData([], $rules)) return $this->failValidationErrors( $this->validator->getErrors() );

        if(!$file->hasMoved()):
            $newName = $organizacion_id .'.'. $file->getClientExtension();
            
            $file->move($path, $newName, true);

            $this->model->update($organizacion_id, ['organizacion_logotipo' => $newName]);
            
            $response = [
                'status'   => 201,
                'error'    => null,
                'messages' => [
                    'success'   => 'Se a actualizado el logotipo de la organización correctamente.'
                ]
            ];

            return $this->respondCreated($response);
        else:
            return $this->failValidationErrors('No se pudo procesar la carga del archivo correctamente.');
        endif;
    }
}
