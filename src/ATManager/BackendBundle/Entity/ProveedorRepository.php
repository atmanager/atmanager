<?php

namespace ATManager\BackendBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ProveedorRepository extends EntityRepository
{
	public function findByName($nombre)
	{
	   $em = $this->getEntityManager();
	   $query = $em->createQuery('select pv from BackendBundle:Proveedor pv where pv.nombre LIKE :nombre order by pv.nombre')
		->setParameter('nombre', '%'.$nombre.'%');
	   return $query->getResult(); 
	}
}