<?php

namespace ATManager\BackendBundle\Entity;

use Doctrine\ORM\EntityRepository;

class LocalRepository extends EntityRepository
{
	public function findByName($nombre)
	{
	   $em = $this->getEntityManager();
	   $query = $em->createQuery('select l from BackendBundle:Local l where l.nombre LIKE :nombre order by l.codigointerno')
		->setParameter('nombre', '%'.$nombre.'%');
	   return $query->getResult(); 
	}
}
