<?php

namespace ATManager\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Estadio
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Estadio
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, unique=true, nullable=false)
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="comentario", type="text",nullable=true)
     */
    private $comentario;

    /**
     * @ORM\ManyToOne(targetEntity="ATManager\BackendBundle\Entity\EstadioClasif")
     * @ORM\JoinColumn(nullable=false)
     */
    private $clasificacion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean",nullable=false)
     */
    private $estado;

     public function __construct(){
        
    }

    /*
    mis metodos
    */

    public function __toString(){
        return " ".$this->getNombre();
    }


    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Estadio
     */
    public function setNombre($nombre)
    {
        $this->nombre = strtoupper($nombre);

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set comentario
     *
     * @param string $comentario
     * @return Estadio
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get comentario
     *
     * @return string 
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     * @return Estadio
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set clasificacion
     *
     * @param \ATManager\BackendBundle\Entity\EstadioClasif $clasificacion
     * @return Estadio
     */
    public function setClasificacion(\ATManager\BackendBundle\Entity\EstadioClasif $clasificacion = null)
    {
        $this->clasificacion = $clasificacion;

        return $this;
    }

    /**
     * Get clasificacion
     *
     * @return \ATManager\BackendBundle\Entity\EstadioClasif 
     */
    public function getClasificacion()
    {
        return $this->clasificacion;
    }
}
