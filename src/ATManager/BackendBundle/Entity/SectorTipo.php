<?php

namespace ATManager\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * SectorTipo
 *
 * @ORM\Table()
 * @ORM\Entity
 * @UniqueEntity(
 *     fields={"descripcion"},
 *     message="Ya existe la descripción en otro item"
 * )
 */
class SectorTipo
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
     * @ORM\Column(name="descripcion", type="string", length=45, unique=true)
     * @Assert\NotBlank()
     */
    private $descripcion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="origen", type="boolean")
     */
    private $origen;

    /**
     * @var boolean
     *
     * @ORM\Column(name="destino", type="boolean")
     */
    private $destino;


    public function __construct(){
        
    }

    /*
    mis metodos
    */

    public function __toString(){
        return " ".$this->getDescripcion();
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return SectorTipo
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = strtoupper($descripcion);

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set origen
     *
     * @param boolean $origen
     * @return SectorTipo
     */
    public function setOrigen($origen)
    {
        $this->origen = $origen;

        return $this;
    }

    /**
     * Get origen
     *
     * @return boolean 
     */
    public function getOrigen()
    {
        return $this->origen;
    }

    /**
     * Set destino
     *
     * @param boolean $destino
     * @return SectorTipo
     */
    public function setDestino($destino)
    {
        $this->destino = $destino;

        return $this;
    }

    /**
     * Get destino
     *
     * @return boolean 
     */
    public function getDestino()
    {
        return $this->destino;
    }
}
