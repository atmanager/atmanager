<?php

namespace ATManager\BackendBundle\Entity;

use Doctrine\ORM\EntityRepository;

class MarcaRepository extends EntityRepository
{
	public function findByName($nombre)
	{
	   $em = $this->getEntityManager();
	   $query = $em->createQuery('select m from BackendBundle:Marca m where m.nombre LIKE :nombre order by m.nombre')
		->setParameter('nombre', '%'.$nombre.'%');
	   return $query->getResult(); 
	}
}
