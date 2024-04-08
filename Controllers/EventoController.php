<?php

namespace Controller;

require_once 'Utils/JsonResponse.php';
require_once 'Models/Evento.php';
require_once 'Dao/EventoDao.php';

use Dao\EventoDao;
use Models\Evento;
use Utils\JsonResponse;

class EventoController
{
    private $eventoDao;

    public function __construct()
    {
        $this->eventoDao = new EventoDao();
    }

    public function index()
    {
        $eventos = $this->eventoDao->index();

        jsonResponse::send(
            200,
            'lista de eventos',
            $eventos
        );
    }

    public function store()
    {
        $requestData = json_decode(file_get_contents('php://input'), true);

        $nombre = $requestData['nombre'];
        $fecha = $requestData['fecha'];
        $lugar = $requestData['lugar'];
        $tipo = $requestData['tipo'];
        $duracion = $requestData['duracion'];

        $evento = new Evento(null, $nombre, $fecha, $lugar, $tipo, $duracion);

        $evento->setId($this->eventoDao->store($evento));

        JsonResponse::send(
            201,
            'evento creado',
            $evento->toArray()
        );
    }

    public function read($id)
    {
        $evento = $this->eventoDao->read($id);

        if(!$evento){
            JsonResponse::send(
                404,
                'evento no encontrado',
                null
            );
            return;
        }

        JsonResponse::send(
            200,
            'evento encontrado',
            $evento->toArray()
        );
        
    }

    public function update($id)
    {
        
        $requestData = json_decode(file_get_contents('php://input'), true);

        $nombre = $requestData['nombre'];
        $fecha = $requestData['fecha'];
        $lugar = $requestData['lugar'];
        $tipo = $requestData['tipo'];
        $duracion = $requestData['duracion'];

        $evento = new Evento($id, $nombre, $fecha, $lugar, $tipo, $duracion);

        $result = $this->eventoDao->update($evento);

       JsonResponse::send(
            200,
            'evento actualizado',
            $evento->toArray()
       );
    }

    public function delete($id)
    {
        $result = $this->eventoDao->delete($id);
        if ($result) {
            JsonResponse::send(
                200,
                'evento eliminado',
                null
            );
        } else {
            JsonResponse::send(
                404,
                'evento no encontrado',
                null
            );
        }   
    }
}
