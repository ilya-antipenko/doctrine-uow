<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\AuditLog;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;

class AuditLoggerListener
{
    private $changedEntities = [];
    private $internalFlushInProgress = false;

    public function onFlush(OnFlushEventArgs $event)
    {
        if ($this->internalFlushInProgress) {
            return;
        }

        $uow = $event->getEntityManager()->getUnitOfWork();
        $this->changedEntities = array_merge(
            $uow->getScheduledEntityInsertions(),
            $uow->getScheduledEntityUpdates(),
            $uow->getScheduledEntityDeletions()
        );
    }

    public function postFlush(PostFlushEventArgs $event)
    {
        if ($this->internalFlushInProgress || !$this->changedEntities) {
            return;
        }

        $em = $event->getEntityManager();

        foreach ($this->changedEntities as $entity) {
            $entityClass = \get_class($entity);
            $entityId = $em->getUnitOfWork()->getSingleIdentifierValue($entity);

            $audit = new AuditLog();
            $audit->setMessage(sprintf('Entity %s has been changed. ID: %s', $entityClass, $entityId));

            $em->persist($audit);
        }

        $this->changedEntities = [];
        $this->internalFlushInProgress = true;
        $em->flush();
        $this->internalFlushInProgress = false;
    }
}
