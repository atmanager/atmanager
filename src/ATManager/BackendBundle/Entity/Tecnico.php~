<?php

namespace ATManager\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tecnico
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Tecnico
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
     * @ORM\Column(name="cedula", type="string", length=12)
     */
    private $cedula;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=60)
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=60)
     */
    private $nombre;

    /**
     * @ORM\ManyToOne(targetEntity="ATManager\BackendBundle\Entity\Sector")
     */
    private $sector;

    /**
     * @ORM\ManyToOne(targetEntity="ATManager\BackendBundle\Entity\Perfil")
     */
    private $perfil;

    /**
     * @var string
     *
     * @ORM\Column(name="movil", type="string", length=14)
     */
    private $movil;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=100)
     */
    private $correo;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=50)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64)
     */
    private $password;

    /**
     * @var boolean
     *
     * @ORM\Column(name="habilita", type="boolean")
     */
    private $habilita;

    public function __construct(){
        $this->habilita = true;  // produce que aparezca en el form inicializado
    }

    /*
    mis metodos
    */

    public function __toString(){
        return getApellido()." ".$this->getNombre();
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
     * Set cedula
     *
     * @param string $cedula
     * @return Tecnico
     */
    public function setCedula($cedula)
    {
        $this->cedula = $cedula;

        return $this;
    }

    /**
     * Get cedula
     *
     * @return string 
     */
    public function getCedula()
    {
        return $this->cedula;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     * @return Tecnico
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Tecnico
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

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
     * Set movil
     *
     * @param string $movil
     * @return Tecnico
     */
    public function setMovil($movil)
    {
        $this->movil = $movil;

        return $this;
    }

    /**
     * Get movil
     *
     * @return string 
     */
    public function getMovil()
    {
        return $this->movil;
    }

    /**
     * Set correo
     *
     * @param string $correo
     * @return Tecnico
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string 
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return Tecnico
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Tecnico
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set habilita
     *
     * @param boolean $habilita
     * @return Tecnico
     */
    public function setHabilita($habilita)
    {
        $this->habilita = $habilita;

        return $this;
    }

    /**
     * Get habilita
     *
     * @return boolean 
     */
    public function getHabilita()
    {
        return $this->habilita;
    }

    /**
     * Set sector
     *
     * @param \ATManager\BackendBundle\Entity\Sector $sector
     * @return Tecnico
     */
    public function setSector(\ATManager\BackendBundle\Entity\Sector $sector = null)
    {
        $this->sector = $sector;

        return $this;
    }

    /**
     * Get sector
     *
     * @return \ATManager\BackendBundle\Entity\Sector 
     */
    public function getSector()
    {
        return $this->sector;
    }

    /**
     * Set perfil
     *
     * @param \ATManager\BackendBundle\Entity\Perfil $perfil
     * @return Tecnico
     */
    public function setPerfil(\ATManager\BackendBundle\Entity\Perfil $perfil = null)
    {
        $this->perfil = $perfil;

        return $this;
    }

    /**
     * Get perfil
     *
     * @return \ATManager\BackendBundle\Entity\Perfil 
     */
    public function getPerfil()
    {
        return $this->perfil;
    }
}
