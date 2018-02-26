<?php

namespace App\Http\Repositories;

use App\Mensaje;

class MensajeRepository
{
    /**
     * @var Mensaje
     */
    private $model;

    public function __construct(Mensaje $model)
    {
        $this->model = $model;
    }

    public function getByNombreArchivo($nombre_archivo)
    {
        return $this->model->where('nombre_archivo', $nombre_archivo)->firstOrFail();
    }

    public function store($data)
    {
        $model                 = new $this->model;
        $model->nombre_archivo = $data['nombre_archivo'];
        $model->ruta           = $data['ruta'];
        $model->save();
    }
}