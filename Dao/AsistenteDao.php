<?php

namespace Dao;

require_once 'Utils/DBConnection.php';
require_once 'Models/Asistente.php';

use Utils\DBConnection;
use Models\Asistente;

class AsistenteDao
{
    private $pdo;
    
    public function __construct()
    {
        $this->pdo = DBConnection::getInstance()->getConnection();   
    }

    public function index()
    {
        $sql = "SELECT * FROM Asistentes";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $resultados = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $asistentes = [];

        foreach ($resultados as $resultado) {
            $asistente = new Asistente(
                $resultado['id'],
                $resultado['nombre'],
                $resultado['apellido'],
                $resultado['email'],
                $resultado['telefono'],
                $resultado['fecha_nacimiento']
            );

            $asistentes[] = $asistente->toArray();
        }

        return $asistentes;
    }


    public function store(Asistente $asistente)
    {
        $sql = "INSERT INTO Asistentes (nombre, apellido, email, telefono, fecha_nacimiento) VALUES (:nombre, :apellido, :email, :telefono, :fecha_nacimiento)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nombre', $asistente->getNombre(), \PDO::PARAM_STR);
        $stmt->bindValue(':apellido', $asistente->getApellido(), \PDO::PARAM_STR);
        $stmt->bindValue(':email', $asistente->getEmail(), \PDO::PARAM_STR);
        $stmt->bindValue(':telefono', $asistente->getTelefono(), \PDO::PARAM_STR);
        $stmt->bindValue(':fecha_nacimiento', $asistente->getFechaNacimiento(), \PDO::PARAM_STR);
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function read($id)
    {
        $sql = "SELECT * FROM Asistentes WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($resultado) {
            return new Asistente(
                $resultado['id'],
                $resultado['nombre'],
                $resultado['apellido'],
                $resultado['email'],
                $resultado['telefono'],
                $resultado['fecha_nacimiento']
            );
        } else {
            return null;
        }
    }

    public function update(Asistente $asistente)
    {
        $sql = "UPDATE Asistentes SET nombre = :nombre, apellido = :apellido, email = :email, telefono = :telefono, fecha_nacimiento = :fecha_nacimiento WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $asistente->getId(), \PDO::PARAM_INT);
        $stmt->bindValue(':nombre', $asistente->getNombre(), \PDO::PARAM_STR);
        $stmt->bindValue(':apellido', $asistente->getApellido(), \PDO::PARAM_STR);
        $stmt->bindValue(':email', $asistente->getEmail(), \PDO::PARAM_STR);
        $stmt->bindValue(':telefono', $asistente->getTelefono(), \PDO::PARAM_STR);
        $stmt->bindValue(':fecha_nacimiento', $asistente->getFechaNacimiento(), \PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM Asistentes WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
