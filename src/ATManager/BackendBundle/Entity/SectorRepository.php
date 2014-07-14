<?php

namespace ATManager\BackendBundle\Entity;

use Doctrine\ORM\EntityRepository;

class SectorRepository extends EntityRepository
{
	public function findByName($nombre)
	{
	   $em = $this->getEntityManager();
	   $query = $em->createQuery('select s from BackendBundle:Sector s where s.nombre LIKE :nombre order by s.nombre')
		->setParameter('nombre', '%'.$nombre.'%');
	   return $query->getResult(); 
	}
}
