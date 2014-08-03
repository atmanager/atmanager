<?php

namespace ATManager\FrontendBundle\Entity;

use Doctrine\ORM\EntityRepository;

class AtRepository extends EntityRepository
{
	public function findByFiltroAt($numero, $personasolicita, $sectorsolicita)
	{
		$em = $this->getEntityManager();
		$query = $em->createQuery('select a from FrontendBundle:At a where a.id = :id and a.personasolicita LIKE :personasolicita and a.sectorsolicita = :sectorsolicita');
		$query->setParameter('id',$numero);
		$query->setParameter('personasolicita','%'.$personasolicita.'%');
		$query->setParameter('sectorsolicita',$sectorsolicita);
		$query->setMaxResults(50);
		return $query->getResult();
	}	
}
