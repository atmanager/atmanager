<?php

namespace ATManager\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Prioridad
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Prioridad
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
     * @ORM\Column(name="nombre", type="string", length=45, unique=true)
     * @Assert\NotBlank()
     */
    private $nombre;

    public function __construct(){
    }
    public function __toString(){
        return $this->getNombre();
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
     * @return Prioridad
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
