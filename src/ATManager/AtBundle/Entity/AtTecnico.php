<?php

namespace ATManager\AtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
// DON'T forget this use statement!!!
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * AtTecnico
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ATManager\AtBundle\Entity\AtTecnicoRepository")
 * @UniqueEntity(
 *     fields={"at","tecnico"},
 *     message="Ya existe la relación At - Tecnico"
 * )
 * @ORM\Table(name="AtTecnico",uniqueConstraints={
 * @ORM\UniqueConstraint(name="at_tecnico_idx", columns={"at_id", "tecnico_id"})})
 */
class AtTecnico
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
     * @ORM\ManyToOne(targetEntity="ATManager\FrontendBundle\Entity\At") 
     * @ORM\JoinColumn(name="at_id", referencedColumnName="id", nullable=false)
     */
    private $at;

     /** 
     * @ORM\ManyToOne(targetEntity="ATManager\BackendBundle\Entity\Tecnico") 
     * @ORM\JoinColumn(name="tecnico_id", referencedColumnName="id", nullable=false)
     */
    private $tecnico;

     /** 
     * @ORM\ManyToOne(targetEntity="ATManager\BackendBundle\Entity\Rol") 
     * @ORM\JoinColumn(name="rol_id", referencedColumnName="id", nullable=false)
     */
    private $rol;


   

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
     * @return AtTecnico
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
     * Set tecnico
     *
     * @param \ATManager\BackendBundle\Entity\Tecnico $tecnico
     * @return AtTecnico
     */
    public function setTecnico(\ATManager\BackendBundle\Entity\Tecnico $tecnico)
    {
        $this->tecnico = $tecnico;

        return $this;
    }

    /**
     * Get tecnico
     *
     * @return \ATManager\BackendBundle\Entity\Tecnico 
     */
    public function getTecnico()
    {
        return $this->tecnico;
    }

    /**
     * Set rol
     *
     * @param \ATManager\BackendBundle\Entity\Rol $rol
     * @return AtTecnico
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
