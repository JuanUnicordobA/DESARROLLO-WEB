<?php

namespace Dao;

require_once 'Utils/DBConnection.php';
require_once 'Models/Detalle.php';
require_once 'Models/Evento.php';
require_once 'Models/Asistente.php';
require_once 'Models/Inscripcion.php';


use Utils\DBConnection;

use Models\Asistente;
use Models\Detalle;
use Models\Evento;
use Models\Inscripcion;


class DetalleDao
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = DBConnection::getInstance()->getConnection();
    }

    public function index()
    {
        $sql = "SELECT * FROM Detalles";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $resultados = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $detalles = [];

        foreach ($resultados as $resultado) {
            $detalle = new Detalle(
                $resultado['id'],
                $resultado['evento_id'],
                $resultado['asistente_id'],
                $resultado['inscripcion_id'],
                $resultado['tipo_entrada'],
                $resultado['codigo_promocional']
            );

            $detalles[] = $detalle->toArray();
        }

        return $detalles;
    }


    public function store(Detalle $detalle)
    {
        $sql = "INSERT INTO Detalles (evento_id, asistente_id, inscripcion_id, tipo_entrada, codigo_promocional) 
                VALUES (:evento_id, :asistente_id, :inscripcion_id, :tipo_entrada, :codigo_promocional)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':evento_id', $detalle->getEventoId(), \PDO::PARAM_INT);
        $stmt->bindValue(':asistente_id', $detalle->getAsistenteId(), \PDO::PARAM_INT);
        $stmt->bindValue(':inscripcion_id', $detalle->getInscripcionId(), \PDO::PARAM_INT);
        $stmt->bindValue(':tipo_entrada', $detalle->getTipoEntrada(), \PDO::PARAM_STR);
        $stmt->bindValue(':codigo_promocional', $detalle->getCodigoPromocional(), \PDO::PARAM_STR);
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function read($id)
    {
        $sql = "SELECT 
                d.id AS detalle_id, 
                d.evento_id AS detalle_evento_id, 
                d.asistente_id AS detalle_asistente_id, 
                d.inscripcion_id AS detalle_inscripcion_id,
                d.tipo_entrada AS detalle_tipo_entrada,
                d.codigo_promocional AS detalle_codigo_promocional,
                e.id AS evento_id,
                e.nombre AS evento_nombre,
                e.fecha AS evento_fecha,
                e.lugar AS evento_lugar,
                e.tipo AS evento_tipo,
                e.duracion AS evento_duracion,
                a.id AS asistente_id,
                a.nombre AS asistente_nombre,
                a.apellido AS asistente_apellido,
                a.email AS asistente_email,
                a.telefono AS asistente_telefono,
                a.fecha_nacimiento AS asistente_fecha_nacimiento,
                i.id AS inscripcion_id,
                i.rol AS inscripcion_rol,
                i.costo AS inscripcion_costo,
                i.estado_pago AS inscripcion_estado_pago,
                i.fecha_inscripcion AS inscripcion_fecha_inscripcion,
                i.fecha_vencimiento AS inscripcion_fecha_vencimiento
            FROM 
                Detalles d
            INNER JOIN 
                Eventos e ON d.evento_id = e.id
            INNER JOIN 
                Asistentes a ON d.asistente_id = a.id
            INNER JOIN 
                Inscripciones i ON d.inscripcion_id = i.id
            WHERE 
                d.id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($resultado) {

            $evento = new Evento(
                $resultado['evento_id'],
                $resultado['evento_nombre'],
                $resultado['evento_fecha'],
                $resultado['evento_lugar'],
                $resultado['evento_tipo'],
                $resultado['evento_duracion']
            );

            $asistente = new Asistente(
                $resultado['asistente_id'],
                $resultado['asistente_nombre'],
                $resultado['asistente_apellido'],
                $resultado['asistente_email'],
                $resultado['asistente_telefono'],
                $resultado['asistente_fecha_nacimiento']
            );

            $inscripcion = new Inscripcion(
                $resultado['inscripcion_id'],
                $resultado['inscripcion_rol'],
                $resultado['inscripcion_costo'],
                $resultado['inscripcion_estado_pago'],
                $resultado['inscripcion_fecha_inscripcion'],
                $resultado['inscripcion_fecha_vencimiento']
            );
            
            // Crea un objeto Detalle con los datos obtenidos
            $detalle = new Detalle(
                $resultado['detalle_id'],
                $evento->getId(),
                $asistente->getId(),
                $inscripcion->getId(),
                $resultado['detalle_tipo_entrada'],
                $resultado['detalle_codigo_promocional']
            );

            $detalle->setEvento($evento);
            $detalle->setInscripcion($inscripcion);
            $detalle->setAsistente($asistente);

            return $detalle;
        } else {
            return null;
        }
    }


    public function update(Detalle $detalle)
    {
        $sql = "UPDATE Detalles SET evento_id = :evento_id, asistente_id = :asistente_id, 
                inscripcion_id = :inscripcion_id, tipo_entrada = :tipo_entrada, 
                codigo_promocional = :codigo_promocional WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $detalle->getId(), \PDO::PARAM_INT);
        $stmt->bindValue(':evento_id', $detalle->getEventoId(), \PDO::PARAM_INT);
        $stmt->bindValue(':asistente_id', $detalle->getAsistenteId(), \PDO::PARAM_INT);
        $stmt->bindValue(':inscripcion_id', $detalle->getInscripcionId(), \PDO::PARAM_INT);
        $stmt->bindValue(':tipo_entrada', $detalle->getTipoEntrada(), \PDO::PARAM_STR);
        $stmt->bindValue(':codigo_promocional', $detalle->getCodigoPromocional(), \PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM Detalles WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
