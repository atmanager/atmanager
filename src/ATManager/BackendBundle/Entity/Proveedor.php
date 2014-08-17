<?php

namespace ATManager\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Proveedor
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="ATManager\BackendBundle\Entity\ProveedorRepository")
 * @UniqueEntity(
 *     fields={"cuit"},
 *     message="Ya existe el cuit en otro item"
 * )
 */
class Proveedor
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
     * @var integer
     *
     * @ORM\Column(name="cuit", type="bigint", nullable=false, unique=true)
     * @Assert\NotBlank()
     * @Assert\Type(type="numeric")
     */
    private $cuit;
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=80, nullable=false)
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="calle", type="string", length=80, nullable=true)
     */
    private $calle;

    /**
     * @var string
     *
     * @ORM\Column(name="puerta", type="string", length=25, nullable=true)
     */
    private $puerta;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=25, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=50, nullable=true)
     * @Assert\Email() 
     */
    private $correo;

    /**
     * @var text
     *
     * @ORM\Column(name="comentario", type="text", length=50, nullable=true)
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
     * Set cuit
     *
     * @param string $cuit
     * @return Proveedor
     */
    public function setCuit($cuit)
    {
        $this->cuit = $cuit;

        return $this;
    }

    /**
     * Get cuit
     *
     * @return string 
     */
    public function getCuit()
    {
        return $this->cuit;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Proveedor
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
     * Set calle
     *
     * @param string $calle
     * @return Proveedor
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get calle
     *
     * @return string 
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set puerta
     *
     * @param string $puerta
     * @return Proveedor
     */
    public function setPuerta($puerta)
    {
        $this->puerta = $puerta;

        return $this;
    }

    /**
     * Get puerta
     *
     * @return string 
     */
    public function getPuerta()
    {
        return $this->puerta;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Proveedor
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set correo
     *
     * @param string $correo
     * @return Proveedor
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string 
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set comentario
     *
     * @param string $comentario
     * @return Proveedor
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
