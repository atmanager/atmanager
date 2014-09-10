<?php

namespace ATManager\IndicadorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Indicador
 * 
 * @ORM\Entity(repositoryClass="ATManager\IndicadorBundle\Entity\IndicadorRepository") 
 */
class Indicador
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
     * @var array
     */
    private $datos;
    
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
     * Set datos
     *
     * @param array $datos
     * @return Indicador
     */
    public function setDatos($datos)
    {
        $this->datos = $datos;

        return $this;
    }
    /**
     * Get datos
     *
     * @return array 
     */
    public function getDatos()
    {
        return $this->datos;
    }
    
    public function __construct(){
        $this->datos= array();
    }
}
