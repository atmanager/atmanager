<?php

namespace ATManager\BackendBundle\Entity;

use Doctrine\ORM\EntityRepository;

class RepuestoRepository extends EntityRepository
{
	public function findByName($nombre)
	{
	   $em = $this->getEntityManager();
	   $query = $em->createQuery('select r from BackendBundle:Repuesto r where r.nombre LIKE :nombre order by r.nombre')
		->setParameter('nombre', '%'.$nombre.'%');
	   return $query->getResult(); 
	}
}
