<?php

namespace ATManager\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ServicioTercero
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="ATManager\BackendBundle\Entity\ServicioTerceroRepository")
 */
class ServicioTercero
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
     * @ORM\Column(name="nombre", type="string", length=80, unique=true, nullable=false)
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripamplia", type="text", nullable=true)
     */
    private $descripamplia;

    /**
     * @var string
     *
     * @ORM\Column(name="comentario", type="text", nullable=true)
     */
    private $comentario;


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
     * @return ServicioTercero
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
     * Set descripamplia
     *
     * @param string $descripamplia
     * @return ServicioTercero
     */
    public function setDescripamplia($descripamplia)
    {
        $this->descripamplia = $descripamplia;

        return $this;
    }

    /**
     * Get descripamplia
     *
     * @return string 
     */
    public function getDescripamplia()
    {
        return $this->descripamplia;
    }

    /**
     * Set comentario
     *
     * @param string $comentario
     * @return ServicioTercero
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
}
