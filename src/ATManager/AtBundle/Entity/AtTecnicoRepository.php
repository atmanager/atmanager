<?php

namespace ATManager\AtBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AtTecnicoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AtTecnicoRepository extends EntityRepository
{
    public function FindBySector($sector){
        $em = $this->getEntityManager();		  	
	    $query = $em->createQuery('SELECT t.id as idtecnico, t.nombre as tecnico, count(t.nombre) as cantidad 
        FROM BackendBundle:Tecnico t
        left join AtBundle:AtTecnico att  with t.id=att.tecnico
            where t.sector= :sector and t.enabled= :enabled
            group by t.nombre')	
            ->setParameter('sector', $sector)
            ->setParameter('enabled',true);
    	return $query->getResult();
    }
    
    public function FindBySectorAyudante($sector,$at)
    {
        //$tec = 3;
        $em = $this->getEntityManager();   
        $query = $em->createQuery('SELECT t FROM BackendBundle:Tecnico t
         WHERE t.sector= :sector and t.id NOT IN 
         (SELECT IDENTITY(att.tecnico) FROM AtBundle:AtTecnico att where att.at= :at)')
         ->setParameter('sector', $sector)
         ->setParameter('at', $at) ; 
         return $query->getResult();

                
    }
}
