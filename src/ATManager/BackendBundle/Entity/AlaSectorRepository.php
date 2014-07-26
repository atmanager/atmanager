<?php

namespace ATManager\BackendBundle\Entity;

use Doctrine\ORM\EntityRepository;

class AlaSectorRepository extends EntityRepository
{
	public function findByName($nombre)
	{
	   $em = $this->getEntityManager();
	   $query = $em->createQuery('select al from BackendBundle:AlaSector al where al.nombre LIKE :nombre order by al.codigointerno')
		->setParameter('nombre', '%'.$nombre.'%');
	   return $query->getResult(); 
	}
}
