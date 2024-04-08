<?php

namespace Dao;

require_once 'Utils/DBConnection.php';
require_once 'Models/Inscripcion.php';

use Utils\DBConnection;
use Models\Inscripcion;

class InscripcionDao
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = DBConnection::getInstance()->getConnection();
    }

    public function index()
    {
        $sql = "SELECT * FROM Inscripciones";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $resultados = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $inscripciones = [];

        foreach ($resultados as $resultado) {
            $inscripcion = new Inscripcion(
                $resultado['id'],
                $resultado['rol'],
                $resultado['costo'],
                $resultado['estado_pago'],
                $resultado['fecha_inscripcion'],
                $resultado['fecha_vencimiento']
            );

            $inscripciones[] = $inscripcion->toArray();
        }

        return $inscripciones;
    }

    public function store(Inscripcion $inscripcion)
    {
        $sql = "INSERT INTO Inscripciones (rol, costo, estado_pago, fecha_inscripcion, fecha_vencimiento) VALUES (:rol, :costo, :estado_pago, :fecha_inscripcion, :fecha_vencimiento)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':rol', $inscripcion->getRol(), \PDO::PARAM_STR);
        $stmt->bindValue(':costo', $inscripcion->getCosto(), \PDO::PARAM_INT);
        $stmt->bindValue(':estado_pago', $inscripcion->getEstadoPago(), \PDO::PARAM_STR);
        $stmt->bindValue(':fecha_inscripcion', $inscripcion->getFechaInscripcion(), \PDO::PARAM_STR);
        $stmt->bindValue(':fecha_vencimiento', $inscripcion->getFechaVencimiento(), \PDO::PARAM_STR);
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function read($id)
    {
        $sql = "SELECT * FROM Inscripciones WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($resultado) {
            return new Inscripcion(
                $resultado['id'],
                $resultado['rol'],
                $resultado['costo'],
                $resultado['estado_pago'],
                $resultado['fecha_inscripcion'],
                $resultado['fecha_vencimiento']
            );
        } else {
            return null;
        }
    }

    public function update(Inscripcion $inscripcion)
    {
        $sql = "UPDATE Inscripciones SET rol = :rol, costo = :costo, estado_pago = :estado_pago, fecha_inscripcion = :fecha_inscripcion, fecha_vencimiento = :fecha_vencimiento WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $inscripcion->getId(), \PDO::PARAM_INT);
        $stmt->bindValue(':rol', $inscripcion->getRol(), \PDO::PARAM_STR);
        $stmt->bindValue(':costo', $inscripcion->getCosto(), \PDO::PARAM_INT);
        $stmt->bindValue(':estado_pago', $inscripcion->getEstadoPago(), \PDO::PARAM_STR);
        $stmt->bindValue(':fecha_inscripcion', $inscripcion->getFechaInscripcion(), \PDO::PARAM_STR);
        $stmt->bindValue(':fecha_vencimiento', $inscripcion->getFechaVencimiento(), \PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM Inscripciones WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
