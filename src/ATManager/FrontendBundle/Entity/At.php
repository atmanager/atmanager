<?php

namespace ATManager\FrontendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * At
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ATManager\FrontendBundle\Entity\AtRepository")
 */
class At
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
     * @ORM\Column(name="numero", type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(value=0)
     */
    private $numero;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechasolicitud", type="datetime")
     */
    private $fechasolicitud;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechafin", type="datetime", nullable=true)
     */
    private $fechafin;

    /** 
     *   @ORM\ManyToOne(targetEntity="ATManager\PatrimonioBundle\Entity\Patrimonio") 
    */
    private $patrimonio;

    /** 
     *   @ORM\ManyToOne(targetEntity="ATManager\BackendBundle\Entity\Sector") 
     *   @ORM\JoinColumn(nullable=false)
     *   @Assert\NotNull()
    */
    private $sectorsolicita;

    /** 
     *   @ORM\ManyToOne(targetEntity="ATManager\BackendBundle\Entity\Sector") 
     *   @ORM\JoinColumn(nullable=false)
     *   @Assert\NotNull()
    */
    private $sectordestino;

    /**
     * @var string
     *
     * @ORM\Column(name="personasolicita", type="string", length=100)
     * @Assert\NotBlank()
     */
    private $personasolicita;

    /**
     * @var string
     *
     * @ORM\Column(name="ipsolicita", type="string", length=15, nullable=true)
     */
    private $ipsolicita;

    /**
     * @var string
     *
     * @ORM\Column(name="hostsolicita", type="string", length=100, nullable=true)
     */
    private $hostsolicita;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $descripcion;

    /** 
     *   @ORM\ManyToOne(targetEntity="ATManager\BackendBundle\Entity\Prioridad") 
    */
    private $prioridad;

    /** 
     *   @ORM\OneToMany(targetEntity="ATManager\AtBundle\Entity\AtHistorico", mappedBy="at") 
    */
    private $historicos;

  

     /**
     * Constructor
     */
    public function __construct()
    {
        $this->fechasolicitud= new \DateTime();
        $this->historicos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return At
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
     * Set fechasolicitud
     *
     * @param \DateTime $fechasolicitud
     * @return At
     */
    public function setFechasolicitud($fechasolicitud)
    {
        $this->fechasolicitud = $fechasolicitud;

        return $this;
    }

    /**
     * Get fechasolicitud
     *
     * @return \DateTime 
     */
    public function getFechasolicitud()
    {
        return $this->fechasolicitud;
    }

    /**
     * Set fechafin
     *
     * @param \DateTime $fechafin
     * @return At
     */
    public function setFechafin($fechafin)
    {
        $this->fechafin = $fechafin;

        return $this;
    }

    /**
     * Get fechafin
     *
     * @return \DateTime 
     */
    public function getFechafin()
    {
        return $this->fechafin;
    }

    /**
     * Set personasolicita
     *
     * @param string $personasolicita
     * @return At
     */
    public function setPersonasolicita($personasolicita)
    {
        $this->personasolicita = $personasolicita;

        return $this;
    }

    /**
     * Get personasolicita
     *
     * @return string 
     */
    public function getPersonasolicita()
    {
        return $this->personasolicita;
    }

    /**
     * Set ipsolicita
     *
     * @param string $ipsolicita
     * @return At
     */
    public function setIpsolicita($ipsolicita)
    {
        $this->ipsolicita = $ipsolicita;

        return $this;
    }

    /**
     * Get ipsolicita
     *
     * @return string 
     */
    public function getIpsolicita()
    {
        return $this->ipsolicita;
    }

    /**
     * Set hostsolicita
     *
     * @param string $hostsolicita
     * @return At
     */
    public function setHostsolicita($hostsolicita)
    {
        $this->hostsolicita = $hostsolicita;

        return $this;
    }

    /**
     * Get hostsolicita
     *
     * @return string 
     */
    public function getHostsolicita()
    {
        return $this->hostsolicita;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return At
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
     * Set patrimonio
     *
     * @param \ATManager\PatrimonioBundle\Entity\Patrimonio $patrimonio
     * @return At
     */
    public function setPatrimonio(\ATManager\PatrimonioBundle\Entity\Patrimonio $patrimonio = null)
    {
        $this->patrimonio = $patrimonio;

        return $this;
    }

    /**
     * Get patrimonio
     *
     * @return \ATManager\PatrimonioBundle\Entity\Patrimonio 
     */
    public function getPatrimonio()
    {
        return $this->patrimonio;
    }

    /**
     * Set sectorsolicita
     *
     * @param \ATManager\BackendBundle\Entity\Sector $sectorsolicita
     * @return At
     */
    public function setSectorsolicita(\ATManager\BackendBundle\Entity\Sector $sectorsolicita)
    {
        $this->sectorsolicita = $sectorsolicita;

        return $this;
    }

    /**
     * Get sectorsolicita
     *
     * @return \ATManager\BackendBundle\Entity\Sector 
     */
    public function getSectorsolicita()
    {
        return $this->sectorsolicita;
    }

    /**
     * Set sectordestino
     *
     * @param \ATManager\BackendBundle\Entity\Sector $sectordestino
     * @return At
     */
    public function setSectordestino(\ATManager\BackendBundle\Entity\Sector $sectordestino)
    {
        $this->sectordestino = $sectordestino;

        return $this;
    }

    /**
     * Get sectordestino
     *
     * @return \ATManager\BackendBundle\Entity\Sector 
     */
    public function getSectordestino()
    {
        return $this->sectordestino;
    }

    /**
     * Set prioridad
     *
     * @param \ATManager\BackendBundle\Entity\Prioridad $prioridad
     * @return At
     */
    public function setPrioridad(\ATManager\BackendBundle\Entity\Prioridad $prioridad = null)
    {
        $this->prioridad = $prioridad;

        return $this;
    }

    /**
     * Get prioridad
     *
     * @return \ATManager\BackendBundle\Entity\Prioridad 
     */
    public function getPrioridad()
    {
        return $this->prioridad;
    }

    /**
     * Add historicos
     *
     * @param \ATManager\AtBundle\Entity\AtHistorico $historicos
     * @return At
     */
    public function addHistorico(\ATManager\AtBundle\Entity\AtHistorico $historicos)
    {
        $this->historicos[] = $historicos;

        return $this;
    }

    /**
     * Remove historicos
     *
     * @param \ATManager\AtBundle\Entity\AtHistorico $historicos
     */
    public function removeHistorico(\ATManager\AtBundle\Entity\AtHistorico $historicos)
    {
        $this->historicos->removeElement($historicos);
    }

    /**
     * Get historicos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHistoricos()
    {
        return $this->historicos;
    }
  

}
