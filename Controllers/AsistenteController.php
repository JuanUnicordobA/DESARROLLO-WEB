<?php

namespace Controller;

require_once 'Utils/JsonResponse.php';
require_once 'Models/Asistente.php';
require_once 'Dao/AsistenteDao.php';

use Dao\AsistenteDao;
use Models\Asistente;
use Utils\JsonResponse;

class AsistenteController
{
    private $asistenteDao;

    public function __construct()
    {
        $this->asistenteDao = new AsistenteDao();
    }

    public function index()
    {
        $asistentes = $this->asistenteDao->index();

        JsonResponse::send(
            200,
            'Lista de asistentes',
            $asistentes
        );
    }

    public function store()
    {
        $requestData = json_decode(file_get_contents('php://input'), true);

        $nombre = $requestData['nombre'];
        $apellido = $requestData['apellido'];
        $email = $requestData['email'];
        $telefono = $requestData['telefono'];
        $fechaNacimiento = $requestData['fecha_nacimiento'];

        $asistente = new Asistente(null, $nombre, $apellido, $email, $telefono, $fechaNacimiento);

        $asistente->setId($this->asistenteDao->store($asistente));

        JsonResponse::send(
            201,
            'Asistente creado',
            $asistente->toArray()
        );
    }

    public function read($id)
    {
        $asistente = $this->asistenteDao->read($id);

        if (!$asistente) {
            JsonResponse::send(
                404,
                'Asistente no encontrado',
                null
            );
            return;
        }

        JsonResponse::send(
            200,
            'Asistente encontrado',
            $asistente->toArray()
        );
    }

    public function update($id)
    {
        $requestData = json_decode(file_get_contents('php://input'), true);

        $nombre = $requestData['nombre'];
        $apellido = $requestData['apellido'];
        $email = $requestData['email'];
        $telefono = $requestData['telefono'];
        $fechaNacimiento = $requestData['fecha_nacimiento'];

        $asistente = new Asistente($id, $nombre, $apellido, $email, $telefono, $fechaNacimiento);

        $result = $this->asistenteDao->update($asistente);

        JsonResponse::send(
            200,
            'Asistente actualizado',
            $asistente->toArray()
        );
    }

    public function delete($id)
    {
        $result = $this->asistenteDao->delete($id);
        if ($result) {
            JsonResponse::send(
                200,
                'Asistente eliminado',
                null
            );
        } else {
            JsonResponse::send(
                404,
                'Asistente no encontrado',
                null
            );
        }
    }
}
