<?php

namespace App\Controllers\API;

use App\Models\ConfiguracionModel;
use CodeIgniter\RESTful\ResourceController;

class Configuracion extends ResourceController
{
    public function __construct()
    {
        $this->model = $this->setModel(new ConfiguracionModel());
    }

    public function read($configuracion_tipo = null)
    {
        $configuracion = $this->model->where('configuracion_tipo', $configuracion_tipo)->first();

        if(!$configuracion) return $this->failNotFound('No se encontró información de la configuración solicitada.');

        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success'   => 'Configuración cargada correctamente.',
                'data'      => $configuracion
            ]
        ];

        return $this->respond( $response );
    }

    public function update($configuracion_tipo = null)
    {
        try {
            if($configuracion_tipo == null)
                return $this->failValidationErrors('No proporciono una clave de configuración valido.');

            $existeConfiguracion = $this->model->where('configuracion_tipo', $configuracion_tipo)->first();
            if($existeConfiguracion == null)
                return $this->failNotFound('No se encontró el parrametro de configuración (' . $configuracion_tipo . ')');

            $configuracion = $this->request->getJSON();

            if( $this->model->update($existeConfiguracion['configuracion_id'], $configuracion) ):
                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Parametros de configuración actualizados correctamente.'
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
}
