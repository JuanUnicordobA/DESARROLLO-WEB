<?php

namespace Models;

class Evento
{
    private $id;
    private $nombre;
    private $fecha;
    private $lugar;
    private $tipo;
    private $duracion;
    private array $detalles;

    public function __construct($id, $nombre, $fecha, $lugar, $tipo, $duracion)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->fecha = $fecha;
        $this->lugar = $lugar;
        $this->tipo = $tipo;
        $this->duracion = $duracion;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getLugar()
    {
        return $this->lugar;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function getDuracion()
    {
        return $this->duracion;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function setLugar($lugar)
    {
        $this->lugar = $lugar;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function setDuracion($duracion)
    {
        $this->duracion = $duracion;
    }

    public function setDetalles($detalle)
    {
        $this->detalles = $detalle;
    }

    public function getDetalles()
    {
        return $this->detalles;
    }

    public function toArray()
    {
        $data = [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'fecha' => $this->fecha,
            'lugar' => $this->lugar,
            'tipo' => $this->tipo,
            'duracion' => $this->duracion,
        ];

        if (empty($this->detalles)) {
            return $data;
        }

        foreach ($this->detalles as $detalle) {
            foreach ($detalle as $obj) {
                $data['detalles'][] = $obj->toArray();
            }
        }


        return $data;
    }
}
