<?php

namespace ATManager\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * AlaSector
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ATManager\BackendBundle\Entity\AlaSectorRepository")
 * @UniqueEntity(
 *     fields={"codigointerno"},
 *     message="Ya existe el nombre en otro items"
 * )
 * @UniqueEntity(
 *     fields={"nombre"},
 *     message="Ya existe el nombre en otro items"
 * )
 */
class AlaSector
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
     * @ORM\Column(name="codigointerno", type="integer", nullable=false, unique=true)
     * @Assert\NotBlank()
     * @Assert\Type(type="numeric") 
    */
    private $codigointerno;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=80, nullable=false, unique=true)
     * @Assert\NotBlank()
     */
    private $nombre;

    public function __construct(){   
    }

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
     * Set codigointerno
     *
     * @param integer $codigointerno
     * @return AlaSector
     */
    public function setCodigointerno($codigointerno)
    {
        $this->codigointerno = $codigointerno;

        return $this;
    }

    /**
     * Get codigointerno
     *
     * @return integer 
     */
    public function getCodigointerno()
    {
        return $this->codigointerno;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return AlaSector
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
}
