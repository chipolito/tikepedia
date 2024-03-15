<?php

namespace App\Controllers\API;

use App\Models\UsuarioModel;
use CodeIgniter\RESTful\ResourceController;

class Usuario extends ResourceController
{
    public function __construct()
    {
        $this->model = $this->setModel(new UsuarioModel());
    }

    public function read($usuario_id = null)
    {
        if($usuario_id == null):
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success'   => 'Lista de usuarios cargada correctamente.',
                    'data'      => $this->model->findAll()
                ]
            ];

            return $this->respond( $response );
        else:
            $usuario = $this->model->find($usuario_id);

            if(!$usuario) return $this->failNotFound('No se encontró información del usuario con el id proporcionado (' . $usuario_id . ')');

            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success'   => 'Información de usuario cargada correctamente.',
                    'data'      => $usuario
                ]
            ];

            return $this->respond($response);
        endif;
    }

    public function create()
    {
        try {
            $usuario = $this->request->getJSON();
            $usuario->usuario_contrasenia = password_hash($usuario->usuario_contrasenia, PASSWORD_BCRYPT, ['cost' => 12]);

            if( $this->model->insert($usuario) ):
                $response = [
                    'status'   => 201,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Usuario registrado correctamente.',
                        'usuario_id' => $this->model->getInsertID()
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

    public function update($usuario_id = null)
    {
        try {
            if($usuario_id == null)
                return $this->failValidationErrors('No proporciono una clave de usuario valido.');

            $existeUsuario = $this->model->find($usuario_id);
            if($existeUsuario == null)
                return $this->failNotFound('No se encontró datos de usuario con el id proporcionado (' . $usuario_id . ')');

            $usuario = $this->request->getJSON();

            $this->model->setValidationRule('usuario_nombre', 'required|max_length[255]|string|is_unique[usuario.usuario_nombre, usuario_id, '. $usuario_id .']');
            $this->model->setValidationRule('usuario_email', 'required|max_length[255]|valid_email|is_unique[usuario.usuario_email, usuario_id, '. $usuario_id .']');

            if( property_exists($usuario, 'usuario_contrasenia') )
                $usuario->usuario_contrasenia = password_hash($usuario->usuario_contrasenia, PASSWORD_BCRYPT, ['cost' => 12]);

            if( $this->model->update($usuario_id, $usuario) ):
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Datos del usuario actualizados correctamente.'
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

    public function delete($usuario_id = null)
    {
        try {
            if($usuario_id == null)
                return $this->failValidationErrors('No proporciono una clave de usuario valido.');

            $existeUsuario = $this->model->find($usuario_id);
            if($existeUsuario == null)
                return $this->failNotFound('No se encontró información del usuario con el id proporcionado (' . $usuario_id . ')');

            if( $this->model->delete($usuario_id) ):

                $this->model->update($usuario_id, ['usuario_estatus' => 0]);

                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Datos del usuario eliminados correctamente.'
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

    public function do_login()
    {
        try{
            $data       = $this->request->getJSON();
            $usuario    = $this->model->where('usuario_nombre', $data->usuario_nombre)->first();

            if(!$usuario) return $this->failUnauthorized('La cuenta de usuario no existe.');

            $verify     = password_verify($data->usuario_contrasenia, $usuario['usuario_contrasenia']);

            if(!$verify) return $this->failUnauthorized('La contraseña que ingresó no es correcta.');

            $response = [
                'status'   => 201,
                'error'    => null,
                'messages' => [
                    'success'   => 'Bienvenido ' . $usuario['usuario_propietario']
                ]
            ];

            return $this->respondCreated($response);
        } catch (\Throwable $e) {
            $complemento = (ENVIRONMENT == 'development') ? $e->getMessage() : '';

            return $this->failServerError( 'Ha ocurrido un error en el servidor de base de datos. ' . $complemento );
        }
    }
}
