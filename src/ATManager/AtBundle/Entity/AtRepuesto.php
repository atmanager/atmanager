<?php

namespace ATManager\AtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
// DON'T forget this use statement!!!
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * AtRepuesto
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ATManager\AtBundle\Entity\AtRepuestoRepository")
 * @UniqueEntity(
 *     fields={"at","repuesto"},
 *     message="Ya existe la relación At - Repuesto"
 * )
 * @ORM\Table(name="AtRepuesto",uniqueConstraints={
 * @ORM\UniqueConstraint(name="at_repuesto_idx", columns={"at_id", "repuesto_id"})})
 */
class AtRepuesto
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="numfac", type="string", length=6)
     */
    private $numfac;

    /**
     * @var string
     *
     * @ORM\Column(name="cant", type="decimal")
     */
    private $cant;

    /**
     * @var string
     *
     * @ORM\Column(name="preciounit", type="decimal")
     */
    private $preciounit;

    /**
     * @var string
     *
     * @ORM\Column(name="comentario", type="text")
     */
    private $comentario;

    /**
     * 
     *   @ORM\ManyToOne(targetEntity="ATManager\BackendBundle\Entity\Proveedor") 
     *   @ORM\JoinColumn(name="proveedor_id", referencedColumnName="id", nullable=false)
    */
    private $proveedor;

    /**
     * 
     *   @ORM\ManyToOne(targetEntity="ATManager\BackendBundle\Entity\Repuesto") 
     *   @ORM\JoinColumn(name="repuesto_id", referencedColumnName="id", nullable=false)
    */
    private $repuesto;

    /**
     * 
     *   @ORM\ManyToOne(targetEntity="ATManager\FrontendBundle\Entity\At", inversedBy="repuestos") 
     *   @ORM\JoinColumn(name="at_id", referencedColumnName="id", nullable=false)
    */
    private $at;


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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return AtRepuesto
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
     * Set numfac
     *
     * @param string $numfac
     * @return AtRepuesto
     */
    public function setNumfac($numfac)
    {
        $this->numfac = $numfac;

        return $this;
    }

    /**
     * Get numfac
     *
     * @return string 
     */
    public function getNumfac()
    {
        return $this->numfac;
    }

    /**
     * Set cant
     *
     * @param string $cant
     * @return AtRepuesto
     */
    public function setCant($cant)
    {
        $this->cant = $cant;

        return $this;
    }

    /**
     * Get cant
     *
     * @return string 
     */
    public function getCant()
    {
        return $this->cant;
    }

    /**
     * Set preciounit
     *
     * @param string $preciounit
     * @return AtRepuesto
     */
    public function setPreciounit($preciounit)
    {
        $this->preciounit = $preciounit;

        return $this;
    }

    /**
     * Get preciounit
     *
     * @return string 
     */
    public function getPreciounit()
    {
        return $this->preciounit;
    }

    /**
     * Set comentario
     *
     * @param string $comentario
     * @return AtRepuesto
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
     * Set proveedor
     *
     * @param \ATManager\BackendBundle\Entity\Proveedor $proveedor
     * @return AtRepuesto
     */
    public function setProveedor(\ATManager\BackendBundle\Entity\Proveedor $proveedor)
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    /**
     * Get proveedor
     *
     * @return \ATManager\BackendBundle\Entity\Proveedor 
     */
    public function getProveedor()
    {
        return $this->proveedor;
    }

    /**
     * Set repuesto
     *
     * @param \ATManager\BackendBundle\Entity\Repuesto $repuesto
     * @return AtRepuesto
     */
    public function setRepuesto(\ATManager\BackendBundle\Entity\Repuesto $repuesto)
    {
        $this->repuesto = $repuesto;

        return $this;
    }

    /**
     * Get repuesto
     *
     * @return \ATManager\BackendBundle\Entity\Repuesto 
     */
    public function getRepuesto()
    {
        return $this->repuesto;
    }

    /**
     * Set at
     *
     * @param \ATManager\FrontendBundle\Entity\At $at
     * @return AtRepuesto
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
}
