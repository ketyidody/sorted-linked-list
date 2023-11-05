<?php

namespace App\EventListener;

use App\Entity\StringList;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(event: Events::postPersist, priority: 500, connection: 'default')]
class StringListOrderer
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function postPersist(PostPersistEventArgs $event): void
    {
        $entity = $event->getObject();
        $entities = $this->getEntitiesByFirstLetter(substr($entity->getName(), 0, 1));

        if (empty($entities)) {
            $entities = $this->getAllEntities();
        }

        [$prev, $next] = $this->getPrevNextEntitiesByName($entities, $entity);

        if ($prev !== null) {
            $prev->setNext($entity);
            $this->entityManager->persist($prev);
            // need to flush here so that there is no constraint violation with duplicate entities
            $this->entityManager->flush();
        }

        if ($next !== null) {
            $next->setPrevious($entity);
            $this->entityManager->persist($next);
            // need to flush here so that there is no constraint violation with duplicate entities
            $this->entityManager->flush();
        }

        $entity->setPrevious($prev);
        $entity->setNext($next);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    // to lower the amount of data transferred from the database first I search for entities that start with the same letter
    protected function getEntitiesByFirstLetter(string $letter): ?array
    {
        return $this->entityManager->getRepository(StringList::class)
            ->createQueryBuilder('e')
            ->where('e.name LIKE :letter')
            ->setParameter('letter', $letter . '%')
            ->orderBy('e.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    protected function getAllEntities()
    {
        return $this->entityManager->getRepository(StringList::class)->findAll();
    }

    protected function getPrevNextEntitiesByName(?array $entities, StringList $entity)
    {
        $prev = null;
        $next = null;

        /**
         * StringList $compareEntity
         */
        foreach ($entities as $compareEntity) {
            if ($compareEntity->getId() === $entity->getId()) {
                continue;
            }

            $cmp = strcasecmp($compareEntity->getName(),$entity->getName());
            dump($entity->getId(), $compareEntity->getId(), $cmp);
            if ($cmp > 0) {
                $next = $compareEntity;
                break;
            }

            $prev = $compareEntity;
        }

        if ($prev === null && $next === null) {
            return [$prev, $next];
        }

        if ($prev === null) {
            $prev = $next?->getPrevious();
        }

        return [$prev, $next];
    }
}