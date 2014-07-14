<?php

namespace ATManager\BackendBundle\Entity;

use Doctrine\ORM\EntityRepository;

class TecnicoRepository extends EntityRepository{

    /**
     * Devuelve solo los usuarios con rol ROLE_ADMIN o ROLE_SUPER_ADMIN
     */
    public function findByRolesAdmin() {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('u')
         ->from('BackendBundle:Tecnico', 'u')
         ->orderBy('u.id', 'ASC')
        ;
        $users = $qb->getQuery()->getResult();
        $usersAux = array();
        $roles = array('ROLE_ADMIN', 'ROLE_TECNICO');
        foreach($users as $user){
            foreach($user->getRoles() as $role){
                if(in_array($role, $roles)){
                    $usersAux[] = $user;
                }
            }
        }
        return $usersAux;
    }

    /**
     * Devuelve solo los usuarios con rol ROLE_USER
     */
    public function findByRoleUser() {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('u')
         ->from('backendBundle:Tecnico', 'u')
         ->orderBy('u.id', 'ASC')
        ;
        $users = $qb->getQuery()->getResult();
        $usersAux = array();
        $roles = array('ROLE_TECNICO');
        foreach($users as $user){
            foreach($user->getRoles() as $role){
                if(in_array($role, $roles)){
                    $usersAux[] = $user;
                }
            }
        }
        return $usersAux;
    }
    public function findByOrden($nombre) {
        $em = $this->getEntityManager();
        $query= $em->createQuery('select t from BackendBundle:Tecnico t where t.nombre like :nombre order by t.enabled desc,t.nombre')
            ->setParameter('nombre','%'.$nombre.'%');
        return $query->getResult();                   
    }
}