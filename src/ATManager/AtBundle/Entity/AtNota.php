<?php

namespace ATManager\AtBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * AtNota
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ATManager\AtBundle\Entity\AtNotaRepository")
 */
class AtNota
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * 
     *   @ORM\ManyToOne(targetEntity="ATManager\FrontendBundle\Entity\At", inversedBy="notas") 
     *   @ORM\JoinColumn(name="at_id", referencedColumnName="id", nullable=false)
    */
    public $at;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=50)
     * @Assert\NotBlank
     */
    public $descripcion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    public $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     */
    public $path;

    /**
     * @var string
     *
     * @ORM\Column(name="comentario", type="text")
     */
    private $comentario;

     /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;


    



    public function __construct(){
     $this->fecha = new \DateTime();   
    }

      public function __toString(){
        return " ".$this->getDescripcion();
    }



     public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // la ruta absoluta del directorio donde se deben
        // guardar los archivos cargados
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // se deshace del __DIR__ para no meter la pata
        // al mostrar el documento/imagen cargada en la vista.
        return 'uploads/documents';
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return AtNota
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return AtNota
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
     * Set path
     *
     * @param string $path
     * @return AtNota
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set comentario
     *
     * @param string $comentario
     * @return AtNota
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
     * Set at
     *
     * @param \ATManager\FrontendBundle\Entity\At $at
     * @return AtNota
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
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
}
