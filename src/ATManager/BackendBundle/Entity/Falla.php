<?php

namespace ATManager\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Falla
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="ATManager\BackendBundle\Entity\FallaRepository")
 * @UniqueEntity(
 *     fields={"nombre"},
 *     message="Ya existe el nombre en otro item"
 * )
 */
class Falla
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
     * @ORM\Column(name="nombre", type="string", length=60, unique=true)
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
     *  @ORM\ManyToMany(targetEntity="ATManager\BackendBundle\Entity\Sector")
     */
    private $sector;

    /**
     * @var boolean
     * 
     * @ORM\Column(name="estado", type="boolean",nullable=false)
     */
    private $estado;

    public function __construct(){
        $this->estado = true;  // produce que aparezca en el form inicializado
        $this->sector = new ArrayCollection();
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
     * @return Falla
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
     * Set descripamplia
     *
     * @param string $descripamplia
     * @return Falla
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
     * Set estado
     *
     * @param boolean $estado
     * @return Falla
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Add sector
     *
     * @param \ATManager\BackendBundle\Entity\Sector $sector
     * @return Falla
     */
    public function addSector(\ATManager\BackendBundle\Entity\Sector $sector)
    {
        $this->sector[] = $sector;

        return $this;
    }

    /**
     * Remove sector
     *
     * @param \ATManager\BackendBundle\Entity\Sector $sector
     */
    public function removeSector(\ATManager\BackendBundle\Entity\Sector $sector)
    {
        $this->sector->removeElement($sector);
    }

    /**
     * Get sector
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSector()
    {
        return $this->sector;
    }
}
