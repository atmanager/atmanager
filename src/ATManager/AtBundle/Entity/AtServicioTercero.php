<?php

namespace ATManager\AtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
// DON'T forget this use statement!!!
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * AtServicioTercero
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ATManager\AtBundle\Entity\AtServicioTerceroRepository")
 * @UniqueEntity(
 *     fields={"at","serviciotercero"},
 *     message="Ya existe la relación At - Servicio Tercero"
 * )
 * @ORM\Table(name="AtServicioTercero",uniqueConstraints={
 * @ORM\UniqueConstraint(name="at_serviciotercero_idx", columns={"at_id", "serviciotercero_id"})})
 */
class AtServicioTercero
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
     * @ORM\Column(name="comentario", type="text",nullable=true)
     */
    private $comentario;
    /**
     * @var decimal
     *
     * @ORM\Column(name="precio", type="decimal", precision=8, scale=2, nullable=true)
     * @Assert\GreaterThanOrEqual(value=0)
     * @Assert\NotBlank()
     */
    private $precio;
    /**
     * @var string
     *
     * @ORM\Column(name="contacto", type="string", length=50)
     * @Assert\NotBlank()
     */
    private $contacto;
     /**
     * 
     *   @ORM\ManyToOne(targetEntity="ATManager\BackendBundle\Entity\ServicioTercero") 
     *   @ORM\JoinColumn(name="serviciotercero_id", referencedColumnName="id", nullable=false)
     */
    private $serviciotercero;
    /**
     * 
     *   @ORM\ManyToOne(targetEntity="ATManager\BackendBundle\Entity\Proveedor") 
     *   @ORM\JoinColumn(name="proveedor_id", referencedColumnName="id", nullable=false)
    */
    private $proveedor;
     /**
     * 
     *   @ORM\ManyToOne(targetEntity="ATManager\FrontendBundle\Entity\At", inversedBy="servicios") 
     *   @ORM\JoinColumn(name="at_id", referencedColumnName="id", nullable=false)
    */
    private $at;
  
    public function __construct(){ 
        $this->fecha = new \DateTime(); 
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
     * @return AtServicioTercero
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
     * @return AtServicioTercero
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
     * Set precio
     *
     * @param string $precio
     * @return AtServicioTercero
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
     * Set contacto
     *
     * @param string $contacto
     * @return AtServicioTercero
     */
    public function setContacto($contacto)
    {
        $this->contacto = $contacto;

        return $this;
    }

    /**
     * Get contacto
     *
     * @return string 
     */
    public function getContacto()
    {
        return $this->contacto;
    }

    /**
     * Set serviciotercero
     *
     * @param \ATManager\BackendBundle\Entity\ServicioTercero $serviciotercero
     * @return AtServicioTercero
     */
    public function setServiciotercero(\ATManager\BackendBundle\Entity\ServicioTercero $serviciotercero)
    {
        $this->serviciotercero = $serviciotercero;

        return $this;
    }

    /**
     * Get serviciotercero
     *
     * @return \ATManager\BackendBundle\Entity\ServicioTercero 
     */
    public function getServiciotercero()
    {
        return $this->serviciotercero;
    }

    /**
     * Set proveedor
     *
     * @param \ATManager\BackendBundle\Entity\Proveedor $proveedor
     * @return AtServicioTercero
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
     * Set at
     *
     * @param \ATManager\FrontendBundle\Entity\At $at
     * @return AtServicioTercero
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
