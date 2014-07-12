<?php

namespace ATManager\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * EstadioClasif
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class EstadioClasif
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
     * @ORM\Column(name="nombre", type="string", length=100, unique=true)
     * @Assert\NotBlank())
     */
    private $nombre;

    /**
     * @var boolean
     *
     * @ORM\Column(name="inicia_at", type="boolean", nullable=true)
     */
    private $iniciaAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="finaliza_at", type="boolean", nullable=true)
     */
    private $finalizaAt;

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
     * @return EstadioClasif
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

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
     * Set iniciaAt
     *
     * @param boolean $iniciaAt
     * @return EstadioClasif
     */
    public function setIniciaAt($iniciaAt)
    {
        $this->iniciaAt = $iniciaAt;

        return $this;
    }

    /**
     * Get iniciaAt
     *
     * @return boolean 
     */
    public function getIniciaAt()
    {
        return $this->iniciaAt;
    }

    /**
     * Set finalizaAt
     *
     * @param boolean $finalizaAt
     * @return EstadioClasif
     */
    public function setFinalizaAt($finalizaAt)
    {
        $this->finalizaAt = $finalizaAt;

        return $this;
    }

    /**
     * Get finalizaAt
     *
     * @return boolean 
     */
    public function getFinalizaAt()
    {
        return $this->finalizaAt;
    }
}
