<?php

namespace ATManager\IndicadorBundle\Entity;

use Doctrine\ORM\EntityRepository;

class IndicadorRepository extends EntityRepository
{
    public function findByIndicador1($fechadesde,$fechahasta,$objpat){
    $em = $this->getEntityManager();		  	
	$query = $em->createQuery('select p.id as patNumero, p.descripcion as patNombre,
                a.id as atNumero, a.fechasolicitud as atFecha
                from FrontendBundle:At a
                inner join PatrimonioBundle:Patrimonio p with a.patrimonio = p
                where a.fechasolicitud between :fechadesde and :fechahasta
                and a.patrimonio =:patrimonio and a.patrimonio is not null')
            ->setParameter('fechadesde', $fechadesde)
            ->setParameter('fechahasta', $fechahasta)
            ->setParameter('patrimonio', $objpat);
        return $query->getResult();
    }
    public function findByIndicador2($fechadesde,$fechahasta){
        $em = $this->getEntityManager();		  	
	$query = $em->createQuery('select p.id as nropat,
                p.descripcion as descrippat,count(p.descripcion) as cantAtenciones 
                from FrontendBundle:At a inner join PatrimonioBundle:Patrimonio p with a.patrimonio=p
                where a.fechasolicitud between :fechadesde and :fechahasta 
                and a.patrimonio is not null
                group by p.id ,p.descripcion 
                having cantAtenciones>1
                order by cantAtenciones desc')
            ->setParameter('fechadesde', $fechadesde)
            ->setParameter('fechahasta', $fechahasta);
        return $query->getResult();
    }
    public function findByIndicador3($fechadesde,$fechahasta,$objsd){
        $em = $this->getEntityManager();		  	
	$query = $em->createQuery('select s.id as secDestino, s.nombre as nombreDestino, 
                count(s.nombre) as cantAtenciones
                from FrontendBundle:At a inner join BackendBundle:Sector s with a.sectordestino=s
                where a.fechasolicitud between :fechadesde and :fechahasta
                and a.sectordestino= :secdestino
                group by s.id, s.nombre
                order by cantAtenciones desc')
            ->setParameter('fechadesde', $fechadesde)
            ->setParameter('fechahasta', $fechahasta)
            ->setParameter('secdestino', $objsd);
        return $query->getResult();
    }
    

    public function findByIndicador4($fechadesde,$fechahasta,$objest,$objsec){
       
    $em = $this->getEntityManager();		  	
	$query = $em->createQuery('select s.id as secDestino, s.nombre as nomDestino, 
                ath.fecha as fechaFin, a.fechasolicitud as fechaInicio
                from FrontendBundle:At a 
                inner join AtBundle:AtHistorico ath with a=ath.at
                inner join BackendBundle:Sector s with a.sectordestino=s
                where a.fechasolicitud between :fechadesde and :fechahasta
                and ath.estadio= :estadio
                and s.id= :sector
                and a.fechafin is not null')
                ->setParameter('fechadesde', $fechadesde)
                ->setParameter('fechahasta', $fechahasta)
                ->setParameter('estadio', $objest)
                ->setParameter('sector', $objsec);
                return $query->getResult(); 
    
    }



    
    public function findByIndicador5($fechadesde,$fechahasta,$objss){
        $em = $this->getEntityManager();		  	
	$query = $em->createQuery('select s.id as secSolicita, s.nombre as nomSolicita,
                count(s.nombre) as cantidad
                from FrontendBundle:At a
                inner join BackendBundle:Sector s with a.sectorsolicita = s
                where a.fechasolicitud between :fechadesde and :fechahasta 
                and a.sectorsolicita = :secsolicitante
                group by s.id, s.nombre
                order by cantidad desc')
            ->setParameter('fechadesde', $fechadesde)
            ->setParameter('fechahasta', $fechahasta)
            ->setParameter('secsolicitante', $objss);    
        return $query->getResult();
    }
    public function findByIndicador6($fechadesde,$fechahasta,$objst){
        $em = $this->getEntityManager();		  	
	$query = $em->createQuery('select st.id as stNumero, st.nombre as stNombre, sum(ats.precio) as precio
               from AtBundle:AtServicioTercero ats 
                inner join BackendBundle:ServicioTercero st with ats.serviciotercero=st
                where ats.fecha between :fechadesde and :fechahasta
                and ats.serviciotercero = :sertercero
                group by st.id
                order by precio desc')
            ->setParameter('fechadesde', $fechadesde)
            ->setParameter('fechahasta', $fechahasta)
            ->setParameter('sertercero', $objst);
        return $query->getResult();
    }

    public function findByIndicador6bis($fechadesde,$fechahasta){
        $em = $this->getEntityManager();            
        $query = $em->createQuery('select st.id as stNumero, st.nombre as stNombre, sum(ats.precio) as precio
                from AtBundle:AtServicioTercero ats 
                inner join BackendBundle:ServicioTercero st with ats.serviciotercero=st
                where ats.fecha between :fechadesde and :fechahasta
                group by st.id
                order by precio desc')
            ->setParameter('fechadesde', $fechadesde)
            ->setParameter('fechahasta', $fechahasta);
            
        return $query->getResult();
    }

    public function findByIndicador7($fechadesde,$fechahasta){
        $em = $this->getEntityManager();		  	
	$query = $em->createQuery('select f.id as numFalla, f.nombre as nomFalla, count(f.nombre) as cantidad
                from AtBundle:AtFalla af
                inner join FrontendBundle:At a with af.at=a
                inner join BackendBundle:Falla f with af.falla=f
                where a.fechasolicitud between :fechadesde and :fechahasta
                group by f.id,f.nombre
                order by cantidad desc')
            ->setParameter('fechadesde', $fechadesde)
            ->setParameter('fechahasta', $fechahasta);
        return $query->getResult();
    }
    public function findByIndicador8($fechadesde,$fechahasta){
        $em = $this->getEntityManager();		  	
	$query = $em->createQuery('select t.id as numTecnico, t.nombre as nomTecnico,
                s.nombre as nomSector, count(t.nombre) as cantidad
                from AtBundle:AtTecnico att
                inner join FrontendBundle:At a with att.at=a
                inner join BackendBundle:Tecnico t with att.tecnico=t
                inner join BackendBundle:Sector s with t.sector=s
                where a.fechasolicitud between :fechadesde and :fechahasta
                group by t.id,t.nombre,s.nombre
                order by cantidad desc')
            ->setParameter('fechadesde', $fechadesde)
            ->setParameter('fechahasta', $fechahasta);
        return $query->getResult();
    }
    public function findByIndicador9($fechadesde,$fechahasta,$objrep){
        $em = $this->getEntityManager();		  	
	$query = $em->createQuery('select r.id as repNumero, r.nombre as repNombre,
                sum(ar.cant) as cantidad, sum(ar.preciounit * ar.cant) as total
                from AtBundle:AtRepuesto ar
                inner join BackendBundle:Repuesto r with ar.repuesto=r
                where ar.fecha between :fechadesde and :fechahasta
                and ar.repuesto = :repuesto
                group by r.id, r.nombre
                order by total desc')
            ->setParameter('fechadesde', $fechadesde)
            ->setParameter('fechahasta', $fechahasta)
            ->setParameter('repuesto', $objrep);
        return $query->getResult();
    }
    public function findByIndicador9bis($fechadesde,$fechahasta){
        $em = $this->getEntityManager();            
    $query = $em->createQuery('select r.id as repNumero, r.nombre as repNombre,
                sum(ar.cant) as cantidad, sum(ar.preciounit * ar.cant) as total
                from AtBundle:AtRepuesto ar
                inner join BackendBundle:Repuesto r with ar.repuesto=r
                where ar.fecha between :fechadesde and :fechahasta
                group by r.id, r.nombre
                order by total desc')
            ->setParameter('fechadesde', $fechadesde)
            ->setParameter('fechahasta', $fechahasta);         
        return $query->getResult();
    }
    public function findByIndicador10($fechadesde,$fechahasta){
        $em = $this->getEntityManager();		  	
	$query = $em->createQuery('select f.nombre as falla, p.id as idPat, p.descripcion as patrimonio, count(f.nombre) as cantidad
                from AtBundle:AtFalla af
                inner join FrontendBundle:At a with af.at=a
                inner join BackendBundle:Falla f with af.falla=f
                inner join PatrimonioBundle:Patrimonio p with a.patrimonio=p
                where a.fechasolicitud between :fechadesde and :fechahasta
                group by f.nombre, p.id, p.descripcion
                order by cantidad desc')
            ->setParameter('fechadesde', $fechadesde)
            ->setParameter('fechahasta', $fechahasta);
        return $query->getResult();  
    }
}
