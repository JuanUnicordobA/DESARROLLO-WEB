<?php

namespace Controller;

require_once 'Dao/InscripcionDao.php';
require_once 'Models/Inscripcion.php';
require_once 'Utils/JsonResponse.php';


use Dao\InscripcionDao;
use Models\Inscripcion;
use Utils\JsonResponse;

class InscripcionController
{
    private $inscripcionDao;

    public function __construct()
    {
        $this->inscripcionDao = new InscripcionDao();
    }

    public function index()
    {
        $inscripciones = $this->inscripcionDao->index();

        JsonResponse::send(
            200,
            'Lista de inscripciones',
            $inscripciones
        );
    }

    public function store()
    {
        $requestData = json_decode(file_get_contents('php://input'), true);

        $rol = $requestData['rol'];
        $costo = $requestData['costo'];
        $estadoPago = $requestData['estado_pago'];
        $fechaInscripcion = $requestData['fecha_inscripcion'];
        $fechaVencimiento = $requestData['fecha_vencimiento'];

        $inscripcion = new Inscripcion(null, $rol, $costo, $estadoPago, $fechaInscripcion, $fechaVencimiento);

        $inscripcion->setId($this->inscripcionDao->store($inscripcion));

        JsonResponse::send(
            201,
            'Inscripción creada',
            $inscripcion->toArray()
        );
    }

    public function read($id)
    {
        $inscripcion = $this->inscripcionDao->read($id);

        if (!$inscripcion) {
            JsonResponse::send(
                404,
                'Inscripción no encontrada',
                null
            );
            return;
        }

        JsonResponse::send(
            200,
            'Inscripción encontrada',
            $inscripcion->toArray()
        );
    }

    public function update($id)
    {
        $requestData = json_decode(file_get_contents('php://input'), true);

        $rol = $requestData['rol'];
        $costo = $requestData['costo'];
        $estadoPago = $requestData['estado_pago'];
        $fechaInscripcion = $requestData['fecha_inscripcion'];
        $fechaVencimiento = $requestData['fecha_vencimiento'];

        $inscripcion = new Inscripcion($id, $rol, $costo, $estadoPago, $fechaInscripcion, $fechaVencimiento);

        $result = $this->inscripcionDao->update($inscripcion);

        JsonResponse::send(
            200,
            'Inscripción actualizada',
            $inscripcion->toArray()
        );
    }

    public function delete($id)
    {
        $result = $this->inscripcionDao->delete($id);
        if ($result) {
            JsonResponse::send(
                200,
                'Inscripción eliminada',
                null
            );
        } else {
            JsonResponse::send(
                404,
                'Inscripción no encontrada',
                null
            );
        }
    }
}
