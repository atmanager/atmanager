<?php

namespace ATManager\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Sector
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="ATManager\BackendBundle\Entity\SectorRepository")
 * @UniqueEntity(
 *     fields={"nombre"},
 *     message="Ya existe el nombre en otro item"
 * )
 */
class Sector
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
     * @ORM\Column(name="nombre", type="string", length=80, unique=true,nullable=false)
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="internos", type="string", length=30,nullable=true)
     */
    private $internos;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=50,nullable=true)
     * @Assert\Email()
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="referente", type="string", length=45, nullable=false)
     * @Assert\NotBlank()
     */
    private $referente;

    /**
     * @ORM\ManyToOne(targetEntity="ATManager\BackendBundle\Entity\SectorTipo")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tipo;
    
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
     * @return Sector
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
     * Set internos
     *
     * @param string $internos
     * @return Sector
     */
    public function setInternos($internos)
    {
        $this->internos = $internos;

        return $this;
    }

    /**
     * Get internos
     *
     * @return string 
     */
    public function getInternos()
    {
        return $this->internos;
    }

    /**
     * Set mail
     *
     * @param string $mail
     * @return Sector
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set referente
     *
     * @param string $referente
     * @return Sector
     */
    public function setReferente($referente)
    {
        $this->referente = $referente;

        return $this;
    }

    /**
     * Get referente
     *
     * @return string 
     */
    public function getReferente()
    {
        return $this->referente;
    }

    /**
     * Set tipo
     *
     * @param \ATManager\BackendBundle\Entity\SectorTipo $tipo
     * @return Sector
     */
    public function setTipo(\ATManager\BackendBundle\Entity\SectorTipo $tipo=null)
    {
        $this->tipo = $tipo;

        return $this;
    }


    /**
     * Get tipo
     *
     * @return \ATManager\BackendBundle\Entity\SectorTipo 
     */
    public function getTipo()
    {
        return $this->tipo;
    }
}
