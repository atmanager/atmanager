<?php

namespace ATManager\AtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
// DON'T forget this use statement!!!
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * AtFalla
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ATManager\AtBundle\Entity\AtFallaRepository")
 * @UniqueEntity(
 *     fields={"at","falla"},
 *     message="Ya existe la relación At - Falla"
 * )
 * @ORM\Table(name="AtFalla",uniqueConstraints={
 * @ORM\UniqueConstraint(name="at_falla_idx", columns={"at_id", "falla_id"})})
 */
class AtFalla
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
     * 
     *   @ORM\ManyToOne(targetEntity="ATManager\FrontendBundle\Entity\At", inversedBy="fallas") 
     *   @ORM\JoinColumn(name="at_id", referencedColumnName="id", nullable=false)
    */
    private $at;

    /**
     * 
     *   @ORM\ManyToOne(targetEntity="ATManager\BackendBundle\Entity\Falla") 
     *   @ORM\JoinColumn(name="falla_id", referencedColumnName="id", nullable=false)
    */
    private $falla;


     /** 
     * @ORM\ManyToOne(targetEntity="ATManager\BackendBundle\Entity\Rol") 
     * @ORM\JoinColumn(name="rol_id", referencedColumnName="id", nullable=false)
     */
    private $rol;


    public function __construct(){
      
    }

    public function __toString(){
        return " ".$this->getId();
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
     * Set at
     *
     * @param \ATManager\FrontendBundle\Entity\At $at
     * @return AtFalla
     */
    public function setAt(\ATManager\FrontendBundle\Entity\At $at)
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
     * Set falla
     *
     * @param \ATManager\BackendBundle\Entity\Falla $falla
     * @return AtFalla
     */
    public function setFalla(\ATManager\BackendBundle\Entity\Falla $falla)
    {
        $this->falla = $falla;

        return $this;
    }

    /**
     * Get falla
     *
     * @return \ATManager\BackendBundle\Entity\Falla 
     */
    public function getFalla()
    {
        return $this->falla;
    }

    /**
     * Set rol
     *
     * @param \ATManager\BackendBundle\Entity\Rol $rol
     * @return AtFalla
     */
    public function setRol(\ATManager\BackendBundle\Entity\Rol $rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return \ATManager\BackendBundle\Entity\Rol 
     */
    public function getRol()
    {
        return $this->rol;
    }
}
