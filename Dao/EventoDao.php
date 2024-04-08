<?php

namespace Dao;

require_once 'Utils/DBConnection.php';
require_once 'Models/Detalle.php';
require_once 'Models/Evento.php';   

use Utils\DBConnection;
use Models\Evento;
use Models\Detalle;

class EventoDao
{
    private $pdo;
    
    public function __construct()
    {
        $this->pdo = DBConnection::getInstance()->getConnection();   
    }

    public function index()
    {
        $sql = "SELECT * FROM Eventos";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $resultados = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $eventos = [];

        foreach ($resultados as $resultado) {
            $evento = new Evento(
                $resultado['id'],
                $resultado['nombre'],
                $resultado['fecha'],
                $resultado['lugar'],
                $resultado['tipo'],
                $resultado['duracion']
            );

            $eventos[] = $evento->toArray();
        }

        return $eventos;
    }


    public function store(Evento $evento)
    {
        $sql = "INSERT INTO Eventos (nombre, fecha, lugar, tipo, duracion) VALUES (:nombre, :fecha, :lugar, :tipo, :duracion)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nombre', $evento->getNombre(), \PDO::PARAM_STR);
        $stmt->bindValue(':fecha', $evento->getFecha(), \PDO::PARAM_STR);
        $stmt->bindValue(':lugar', $evento->getLugar(), \PDO::PARAM_STR);
        $stmt->bindValue(':tipo', $evento->getTipo(), \PDO::PARAM_STR);
        $stmt->bindValue(':duracion', $evento->getDuracion(), \PDO::PARAM_INT);
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function read($id)
    {
        $sql = "
            SELECT e.*, d.id as detalle_id, d.evento_id, d.asistente_id, d.inscripcion_id, d.tipo_entrada, d.codigo_promocional 
            FROM Eventos e 
            LEFT JOIN Detalles d ON e.id = d.evento_id 
            WHERE e.id = :id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    
        if ($resultado) {
            // Crear objeto Evento
            $evento = new Evento(
                $resultado[0]['id'],
                $resultado[0]['nombre'],
                $resultado[0]['fecha'],
                $resultado[0]['lugar'],
                $resultado[0]['tipo'],
                $resultado[0]['duracion']
            );
    
            
            $detalles = [];
            foreach ($resultado as $row) {
                $detalle = new Detalle(
                    $row['detalle_id'],
                    $row['evento_id'],
                    $row['asistente_id'],
                    $row['inscripcion_id'],
                    $row['tipo_entrada'],
                    $row['codigo_promocional']
                );

                $detalles[][] = $detalle;
            }
    
            // Agregar los detalles al evento
            $evento->setDetalles($detalles);
    
            return $evento;
        } else {
            return null;
        }
    }
    

    public function update(Evento $evento)
    {
        $sql = "UPDATE Eventos SET nombre = :nombre, fecha = :fecha, lugar = :lugar, tipo = :tipo, duracion = :duracion WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $evento->getId(), \PDO::PARAM_INT);
        $stmt->bindValue(':nombre', $evento->getNombre(), \PDO::PARAM_STR);
        $stmt->bindValue(':fecha', $evento->getFecha(), \PDO::PARAM_STR);
        $stmt->bindValue(':lugar', $evento->getLugar(), \PDO::PARAM_STR);
        $stmt->bindValue(':tipo', $evento->getTipo(), \PDO::PARAM_STR);
        $stmt->bindValue(':duracion', $evento->getDuracion(), \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM Eventos WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }


}

