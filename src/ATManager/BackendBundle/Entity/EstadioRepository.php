<?php

namespace ATManager\BackendBundle\Entity;

use Doctrine\ORM\EntityRepository;

class EstadioRepository extends EntityRepository
{
	public function findOneEstadioFinaliza()
	{
	   $em = $this->getEntityManager();
	   $query = $em->createQuery('Select e From BackendBundle:Estadio e
	   	INNER JOIN BackendBundle:EstadioClasif ec WITH e.clasificacion=ec.id
	   	WHERE ec.finalizaAt=true');
	   return $query->getOneOrNullResult(); 
	}
}