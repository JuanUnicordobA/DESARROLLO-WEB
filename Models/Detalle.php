<?php

namespace Models;

require_once 'Models/Evento.php';
require_once 'Models/Asistente.php';
require_once 'Models/Inscripcion.php';

use Models\Evento;
use Models\Asistente;
use Models\Inscripcion;

class Detalle
{
    private $id;
    private $eventoId;
    private $asistenteId;
    private $inscripcionId;
    private $tipoEntrada;
    private $codigoPromocional;
    private ?Evento $evento = null;
    private ?Asistente $asistente = null;
    private ?Inscripcion $inscripcion = null;

    public function __construct($id, $eventoId, $asistenteId, $inscripcionId, $tipoEntrada, $codigoPromocional)
    {
        $this->id = $id;
        $this->eventoId = $eventoId;
        $this->asistenteId = $asistenteId;
        $this->inscripcionId = $inscripcionId;
        $this->tipoEntrada = $tipoEntrada;
        $this->codigoPromocional = $codigoPromocional;

    }

    public function getId()
    {
        return $this->id;
    }

    public function getEventoId()
    {
        return $this->eventoId;
    }

    public function getAsistenteId()
    {
        return $this->asistenteId;
    }

    public function getInscripcionId()
    {
        return $this->inscripcionId;
    }

    public function getTipoEntrada()
    {
        return $this->tipoEntrada;
    }

    public function getCodigoPromocional()
    {
        return $this->codigoPromocional;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setEventoId($eventoId)
    {
        $this->eventoId = $eventoId;
    }

    public function setAsistenteId($asistenteId)
    {
        $this->asistenteId = $asistenteId;
    }

    public function setInscripcionId($inscripcionId)
    {
        $this->inscripcionId = $inscripcionId;
    }

    public function setTipoEntrada($tipoEntrada)
    {
        $this->tipoEntrada = $tipoEntrada;
    }

    public function setCodigoPromocional($codigoPromocional)
    {
        $this->codigoPromocional = $codigoPromocional;
    }

    /**
     * Get the value of evento
     */ 
    public function getEvento()
    {
        return $this->evento;
    }

    /**
     * Set the value of evento
     *
     * @return  self
     */ 
    public function setEvento($evento)
    {
        $this->evento = $evento;

        return $this;
    }

    /**
     * Get the value of asistente
     */ 
    public function getAsistente()
    {
        return $this->asistente;
    }

    /**
     * Set the value of asistente
     *
     * @return  self
     */ 
    public function setAsistente($asistente)
    {
        $this->asistente = $asistente;

        return $this;
    }

    /**
     * Get the value of inscripcion
     */ 
    public function getInscripcion()
    {
        return $this->inscripcion;
    }

    /**
     * Set the value of inscripcion
     *
     * @return  self
     */ 
    public function setInscripcion($inscripcion)
    {
        $this->inscripcion = $inscripcion;

        return $this;
    }


    
    public function toArray()
    {
        $data = [
            'id' => $this->id,
            'eventoId' => $this->eventoId,
            'asistenteId' => $this->asistenteId,
            'inscripcionId' => $this->inscripcionId,
            'tipoEntrada' => $this->tipoEntrada,
            'codigoPromocional' => $this->codigoPromocional
        ];
        
        if($this->evento != null){
            $data['evento'] = $this->evento->toArray();
        }

        if($this->asistente != null){
            $data['asistente'] = $this->asistente->toArray();
        }

        if($this->inscripcion != null){
            $data['inscripcion'] = $this->inscripcion->toArray();
        }


        return $data;
        
    }   
}
