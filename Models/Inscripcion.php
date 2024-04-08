<?php

namespace Models;

class Inscripcion
{
    private $id;
    private $rol;
    private $costo;
    private $estadoPago;
    private $fechaInscripcion;
    private $fechaVencimiento;

    public function __construct($id, $rol, $costo, $estadoPago, $fechaInscripcion, $fechaVencimiento)
    {
        $this->id = $id;
        $this->rol = $rol;
        $this->costo = $costo;
        $this->estadoPago = $estadoPago;
        $this->fechaInscripcion = $fechaInscripcion;
        $this->fechaVencimiento = $fechaVencimiento;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function getCosto()
    {
        return $this->costo;
    }

    public function getEstadoPago()
    {
        return $this->estadoPago;
    }

    public function getFechaInscripcion()
    {
        return $this->fechaInscripcion;
    }

    public function getFechaVencimiento()
    {
        return $this->fechaVencimiento;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setRol($rol)
    {
        $this->rol = $rol;
    }

    public function setCosto($costo)
    {
        $this->costo = $costo;
    }

    public function setEstadoPago($estadoPago)
    {
        $this->estadoPago = $estadoPago;
    }

    public function setFechaInscripcion($fechaInscripcion)
    {
        $this->fechaInscripcion = $fechaInscripcion;
    }

    public function setFechaVencimiento($fechaVencimiento)
    {
        $this->fechaVencimiento = $fechaVencimiento;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'rol' => $this->rol,
            'costo' => $this->costo,
            'estado_pago' => $this->estadoPago,
            'fecha_inscripcion' => $this->fechaInscripcion,
            'fecha_vencimiento' => $this->fechaVencimiento
        ];
    }
}
