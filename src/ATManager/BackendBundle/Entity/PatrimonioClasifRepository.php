<?php

namespace ATManager\BackendBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PatrimonioClasifRepository extends EntityRepository
{
	public function findByName($nombre)
	{
	   $em = $this->getEntityManager();
	   $query = $em->createQuery('select pc from BackendBundle:PatrimonioClasif pc  where pc.nombre LIKE :nombre order by pc.nombre')
		->setParameter('nombre', '%'.$nombre.'%');
	   return $query->getResult(); 
	}
}
