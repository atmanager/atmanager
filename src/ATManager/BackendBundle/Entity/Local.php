<?php

namespace ATManager\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Local
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="ATManager\BackendBundle\Entity\LocalRepository")
 */
class Local
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
     * @ORM\Column(name="nombre", type="string", length=255 , nullable=false)
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="codigointerno", type="string", length=10, nullable=false, unique=true)
     * @Assert\NotBlank()
     */
    private $codigointerno;
    /**
     * @ORM\ManyToOne(targetEntity="ATManager\BackendBundle\Entity\AlaSector")
     * @ORM\JoinColumn(nullable=false)
     */	
    private $alasector;
	
    public function __construct(){
        
    }

    /*
    mis metodos
    */

    public function __toString(){
        return " ".$this->getCodigointerno()." ".$this->getNombre();
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
     * @return Local
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
     * Set codigointerno
     *
     * @param string $codigointerno
     * @return Local
     */
    public function setCodigointerno($codigointerno)
    {
        $this->codigointerno = $codigointerno;

        return $this;
    }

    /**
     * Get codigointerno
     *
     * @return string 
     */
    public function getCodigointerno()
    {
        return $this->codigointerno;
    }

    /**
     * Set alasector
     *
     * @param \ATManager\BackendBundle\Entity\AlaSector $alasector
     * @return Local
     */
    public function setAlasector(\ATManager\BackendBundle\Entity\AlaSector $alasector = null)
    {
        $this->alasector = $alasector;

        return $this;
    }

    /**
     * Get alasector
     *
     * @return \ATManager\BackendBundle\Entity\AlaSector 
     */
    public function getAlasector()
    {
        return $this->alasector;
    }
}
