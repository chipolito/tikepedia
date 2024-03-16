<?php

namespace App\Controllers\API;

use App\Models\PermisoModel;
use CodeIgniter\RESTful\ResourceController;

class Permiso extends ResourceController
{
    public function __construct()
    {
        $this->model = $this->setModel(new PermisoModel());
    }

    public function read()
    {
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success'   => 'Lista de permisos cargada correctamente.',
                'data'      => $this->model->findAll()
            ]
        ];

        return $this->respond( $response );
    }

    public function hasPermission()
    {
        $db         = \Config\Database::connect();
        $validate   = $this->request->getJSON();

        $subquery   = $db->table('usuario_permiso');

        $builder    = $db->table('permiso')->fromSubquery($subquery, 'configuracion');

        $builder->where('configuracion.usuario_id', $validate->usuario_id);
        $builder->where('configuracion.permiso_id = permiso.permiso_id');
        $builder->where('permiso.permiso_clave', $validate->permiso_clave);

        $query      = $builder->get();

        $response   = [
            'hasPermission'   => $query->getNumRows() == 1 ? TRUE : FALSE
        ];

        return $this->respond( $response );
    }
    
    public function putPermission()
    {
        $db             = \Config\Database::connect();
        $configuracion  = $this->request->getJSON();
        $builder        = $db->table('usuario_permiso');

        if( $builder->delete(['usuario_id' => $configuracion->usuario_id]) ):
            $builder->insertBatch( $configuracion->permisos );

            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Permisos actualizados correctamente.'
                ]
            ];
    
            return $this->respondUpdated( $response );
        else:
            return $this->failValidationErrors('Fallo la actualización de permisos.');
        endif;
    }
}
