<?php

namespace ATManager\AtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AtHistorico
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ATManager\AtBundle\Entity\AtHistoricoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class AtHistorico
{
    /**
     *  
     * @ORM\ManyToOne(targetEntity="ATManager\BackendBundle\Entity\Estadio")
     * @ORM\Id 
     */
    private $estadio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="comentario", type="text", nullable=false)
     */
    private $comentario;

    public function __construct(){
     $this->fecha = new \DateTime();   
    }

    /*
    * @ORM\PrePersist
    */
   public function prePersist() {
        
    
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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return AtHistorico
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set comentario
     *
     * @param string $comentario
     * @return AtHistorico
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
     * Set at
     *
     * @param \ATManager\FrontendBundle\Entity\At $at
     * @return AtHistorico
     */
    public function setAt(\ATManager\FrontendBundle\Entity\At $at = null)
    {
        $this->at = $at;

        return $this;
    }

    /**
     * Get at
     *
     * @return \ATManager\FrontendBundle\Entity\At 
     */
    public function getAt()
    {
        return $this->at;
    }

    /**
     * Set estadio
     *
     * @param \ATManager\BackendBundle\Entity\Estadio $estadio
     * @return AtHistorico
     */
    public function setEstadio(\ATManager\BackendBundle\Entity\Estadio $estadio = null)
    {
        $this->estadio = $estadio;

        return $this;
    }

    /**
     * Get estadio
     *
     * @return \ATManager\BackendBundle\Entity\Estadio 
     */
    public function getEstadio()
    {
        return $this->estadio;
    }
}
