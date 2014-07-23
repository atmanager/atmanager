<?php

namespace ATManager\PatrimonioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
// Assert = controles de validacion sobre los atributos de clases en vez
// de validar en el formulario
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Patrimonio
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ATManager\PatrimonioBundle\Entity\PatrimonioRepository")
 */
class Patrimonio
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
     * @ORM\Column(name="numero", type="integer", unique=true, nullable=true)
     */
    private $numero;

    /**
     * @var integer
     *
     * @ORM\Column(name="alasector", type="integer", nullable=true)
     */
    private $alasector;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="responsable", type="string", length=60, nullable=true)
     */
    private $responsable;

    /**
     * @var string
     *
     * @ORM\Column(name="modelo", type="string", length=100, nullable=true)
     */
    private $modelo;

    /**
     * @var string
     *
     * @ORM\Column(name="serial", type="string", length=50, nullable=true)
     */
    private $serial;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="text", nullable=true)
     */
    private $observacion;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaAlta", type="datetime", nullable=true)
     */
    private $fechaAlta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaBaja", type="date", nullable=true)
     */
    private $fechaBaja;

    /**
     * @var boolean
     *
     * @ORM\Column(name="habilita", type="boolean", options={"default":1})
     */
    private $habilita;

     /**
     * @var decimal
     *
     * @ORM\Column(name="precio", type="decimal", precision=8, scale=2, nullable=true)
     * @Assert\GreaterThanOrEqual(value=0)
     */
    private $precio;

    
    /** @ORM\ManyToOne(targetEntity="ATManager\BackendBundle\Entity\PatrimonioClasif") 
    
    */
    private $clasificacion;

    /** @ORM\ManyToOne(targetEntity="ATManager\BackendBundle\Entity\Local") 
     *@ORM\OrderBy({"nombre" = "ASC" })
    */
    private $local;

    /** @ORM\ManyToOne(targetEntity="ATManager\BackendBundle\Entity\Marca") */
    private $marca;


    // To Do relación a la entidad at, para conocer en cuantas AT abiertas esta el patrimonio...



    public function __construct(){
        $this->fechaAlta= new \DateTime();
        $this->habilita = true;  // produce que aparezca en el form inicializado
    }

    /*
    mis metodos
    */

    public function __toString(){
        return " ".$this->getDescripcion()." ".$this->getNumero();
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
     * Set numero
     *
     * @param integer $numero
     * @return Patrimonio
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set sector
     *
     * @param string $sector
     * @return Patrimonio
     */
    public function setSector($sector)
    {
        $this->sector = $sector;

        return $this;
    }

    /**
     * Get sector
     *
     * @return string 
     */
    public function getSector()
    {
        return $this->sector;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Patrimonio
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

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
     * Set fechaAlta
     *
     * @param \DateTime $fechaAlta
     * @return Patrimonio
     */
    public function setFechaAlta($fechaAlta)
    {
        $this->fechaAlta = $fechaAlta;

        return $this;
    }

    /**
     * Get fechaAlta
     *
     * @return \DateTime 
     */
    public function getFechaAlta()
    {
        return $this->fechaAlta;
    }

    /**
     * Set precio
     *
     * @param string $precio
     * @return Patrimonio
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return string 
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set responsable
     *
     * @param string $responsable
     * @return Patrimonio
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return string 
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * Set modelo
     *
     * @param string $modelo
     * @return Patrimonio
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo
     *
     * @return string 
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set serial
     *
     * @param string $serial
     * @return Patrimonio
     */
    public function setSerial($serial)
    {
        $this->serial = $serial;

        return $this;
    }

    /**
     * Get serial
     *
     * @return string 
     */
    public function getSerial()
    {
        return $this->serial;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return Patrimonio
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string 
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Set fechaBaja
     *
     * @param \DateTime $fechaBaja
     * @return Patrimonio
     */
    public function setFechaBaja($fechaBaja)
    {
        $this->fechaBaja = $fechaBaja;

        return $this;
    }

    /**
     * Get fechaBaja
     *
     * @return \DateTime 
     */
    public function getFechaBaja()
    {
        return $this->fechaBaja;
    }

    /**
     * Set clasificacion
     *
     * @param \ATManager\BackendBundle\Entity\PatrimonioClasif $clasificacion
     * @return Patrimonio
     */
    public function setClasificacion(\ATManager\BackendBundle\Entity\PatrimonioClasif $clasificacion = null)
    {
        $this->clasificacion = $clasificacion;

        return $this;
    }

    /**
     * Get clasificacion
     *
     * @return \ATManager\BackendBundle\Entity\PatrimonioClasif 
     */
    public function getClasificacion()
    {
        return $this->clasificacion;
    }

    /**
     * Set local
     *
     * @param \ATManager\BackendBundle\Entity\Local $local
     * @return Patrimonio
     */
    public function setLocal(\ATManager\BackendBundle\Entity\Local $local = null)
    {
        $this->local = $local;

        return $this;
    }

    /**
     * Get local
     *
     * @return \ATManager\BackendBundle\Entity\Local 
     */
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * Set marca
     *
     * @param \ATManager\BackendBundle\Entity\Marca $marca
     * @return Patrimonio
     */
    public function setMarca(\ATManager\BackendBundle\Entity\Marca $marca = null)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return \ATManager\BackendBundle\Entity\Marca 
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set alasector
     *
     * @param integer $alasector
     * @return Patrimonio
     */
    public function setAlasector($alasector)
    {
        $this->alasector = $alasector;

        return $this;
    }

    /**
     * Get alasector
     *
     * @return integer 
     */
    public function getAlasector()
    {
        return $this->alasector;
    }

    /**
     * Set habilita
     *
     * @param boolean $habilita
     * @return Patrimonio
     */
    public function setHabilita($habilita)
    {
        $this->habilita = $habilita;

        return $this;
    }

    /**
     * Get habilita
     *
     * @return boolean
     */
    public function getHabilita()
    {
        return $this->habilita;
    }
}
