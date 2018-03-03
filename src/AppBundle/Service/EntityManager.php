<?php
/**
 * Created by PhpStorm.
 * User: jeremie
 * Date: 02/03/18
 * Time: 19:02
 */

namespace AppBundle\Service;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\EntityManager as Manager;
/**
 * Class EntityManager
 * @package AppBundle\Service
 */
class EntityManager
{
    /**
     * @var Manager
     */
    private $em;

    /**
     * EntityManager constructor.
     *
     * @param Manager $entityManager
     */
    public function __construct(Manager $entityManager){
        $this->em = $entityManager;
    }

    /**
     * @param null $object
     */
    public function flush($object = null){
        try{
            $this->em->flush($object);
        }catch(OptimisticLockException $e){

        }
    }

    /**
     * @param $repository
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository($repository){
        return $this->em->getRepository($repository);
    }

    /**
     * @param null $object
     */
    public function persist($object = null){
        $this->em->persist($object);
    }
}