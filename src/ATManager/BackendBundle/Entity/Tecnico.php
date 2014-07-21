<?php

namespace ATManager\BackendBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
// Assert = controles de validacion sobre los atributos de clases en vez
// de validar en el formulario
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="ATManager\BackendBundle\Entity\TecnicoRepository")
 * @ORM\Table
 * @ORM\HasLifecycleCallbacks()
 */
class Tecnico extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

      /**
     * @var String
     *
     * @ORM\Column(name="documento", type="string", length=12, unique=true)
     * @Assert\NotBlank()
     */
    private $documento;

   
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=60)
     * @Assert\NotBlank()
    */
    private $nombre;

    /**
     * @ORM\ManyToOne(targetEntity="ATManager\BackendBundle\Entity\Sector")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sector;

    
    /**
     * @var string
     *
     * @ORM\Column(name="movil", type="string", length=14, nullable=true)
     */
    private $movil;


     /**
     * @var datetime
     *
     * @ORM\Column(name="fechaUltimaActualizacion", type="datetime", nullable=true)
     */
    private $fechaUltimaActualizacion;


   
     /*
    mis metodos
    */

   public function __construct() {
        parent::__construct();
    
    }


    /*
    * @ORM\PreUpdate
    */
   public function preUpdate() {
        $this->fechaUltimaActualizacion = new \DateTime();
    
    }

    public function __toString(){
        return getNombre();
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
     * Set documento
     *
     * @param string $documento
     * @return Tecnico
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;

        return $this;
    }

    /**
     * Get documento
     *
     * @return string 
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Tecnico
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
     * Set movil
     *
     * @param string $movil
     * @return Tecnico
     */
    public function setMovil($movil)
    {
        $this->movil = $movil;

        return $this;
    }

    /**
     * Get movil
     *
     * @return string 
     */
    public function getMovil()
    {
        return $this->movil;
    }

    /**
     * Set sector
     *
     * @param \ATManager\BackendBundle\Entity\Sector $sector
     * @return Tecnico
     */
    public function setSector(\ATManager\BackendBundle\Entity\Sector $sector = null)
    {
        $this->sector = $sector;

        return $this;
    }

    /**
     * Get sector
     *
     * @return \ATManager\BackendBundle\Entity\Sector 
     */
    public function getSector()
    {
        return $this->sector;
    }

    

    /**
     * Set fechaUltimaActualizacion
     *
     * @param \DateTime $fechaUltimaActualizacion
     * @return Tecnico
     */
    public function setFechaUltimaActualizacion($fechaUltimaActualizacion)
    {
        $this->fechaUltimaActualizacion = $fechaUltimaActualizacion;

        return $this;
    }

    /**
     * Get fechaUltimaActualizacion
     *
     * @return \DateTime 
     */
    public function getFechaUltimaActualizacion()
    {
        return $this->fechaUltimaActualizacion;
    }
}
