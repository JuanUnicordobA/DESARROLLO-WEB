<?php

namespace Controller;

require_once 'Utils/JsonResponse.php';
require_once 'Models/Detalle.php';
require_once 'Dao/DetalleDao.php';

use Dao\DetalleDao;
use Models\Detalle;
use Utils\JsonResponse;

class DetalleController
{
    private $detalleDao;

    public function __construct()
    {
        $this->detalleDao = new DetalleDao();
    }

    public function index()
    {
        $detalles = $this->detalleDao->index();

        JsonResponse::send(
            200,
            'Lista de detalles',
            $detalles
        );
    }

    public function store()
    {
        $requestData = json_decode(file_get_contents('php://input'), true);

        $eventoId = $requestData['evento_id'];
        $asistenteId = $requestData['asistente_id'];
        $inscripcionId = $requestData['inscripcion_id'];
        $tipoEntrada = $requestData['tipo_entrada'];
        $codigoPromocional = $requestData['codigo_promocional'];

        $detalle = new Detalle(null, $eventoId, $asistenteId, $inscripcionId, $tipoEntrada, $codigoPromocional);

        $detalle->setId($this->detalleDao->store($detalle));

        JsonResponse::send(
            201,
            'Detalle creado',
            $detalle->toArray()
        );
    }

    public function read($id)
    {
        $detalle = $this->detalleDao->read($id);

        if (!$detalle) {
            JsonResponse::send(
                404,
                'Detalle no encontrado',
                null
            );
            return;
        }

        JsonResponse::send(
            200,
            'Detalle encontrado',
            $detalle->toArray()
        );
    }

    public function update($id)
    {
        $requestData = json_decode(file_get_contents('php://input'), true);

        $eventoId = $requestData['evento_id'];
        $asistenteId = $requestData['asistente_id'];
        $inscripcionId = $requestData['inscripcion_id'];
        $tipoEntrada = $requestData['tipo_entrada'];
        $codigoPromocional = $requestData['codigo_promocional'];

        $detalle = new Detalle($id, $eventoId, $asistenteId, $inscripcionId, $tipoEntrada, $codigoPromocional);

        $this->detalleDao->update($detalle);

        JsonResponse::send(
            200,
            'Detalle actualizado',
            $detalle->toArray()
        );
    }

    public function delete($id)
    {
        $result = $this->detalleDao->delete($id);
        if ($result) {
            JsonResponse::send(
                200,
                'Detalle eliminado',
                null
            );
        } else {
            JsonResponse::send(
                404,
                'Detalle no encontrado',
                null
            );
        }
    }
}
