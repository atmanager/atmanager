<?php

namespace ATManager\BackendBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

// DON'T forget this use statement!!!
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Marca
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ATManager\BackendBundle\Entity\MarcaRepository")
 * @UniqueEntity(
 *     fields={"nombre"},
 *     message="Ya existe el nombre en otro items"
 * )
 */
class Marca
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
     * @ORM\Column(name="nombre", type="string", length=60, unique=true, nullable=false)
     * @Assert\NotBlank()
     */
    private $nombre;



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
     * @return Marca
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
