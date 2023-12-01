<?php

declare(strict_types=1);

/*
 * This file is part of Alengo\Bundle\AlengoFormBundle.
 *
 * (c) alengo
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Alengo\Bundle\AlengoFormBundle\Repository;

use Alengo\Bundle\AlengoFormBundle\Entity\FormData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FormData|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormData|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormData[] findAll()
 * @method FormData[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormDataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormData::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(FormData $formData): void
    {
        $this->getEntityManager()->persist($formData);
        $this->getEntityManager()->flush();
    }

    public function remove(int $id): void
    {
        $this->getEntityManager()->remove(
            $this->getEntityManager()->getReference(
                $this->getClassName(),
                $id,
            ),
        );
        $this->getEntityManager()->flush();
    }

    public function listFormData($datefrom = '', $dateto = '', $locale = '', $category = '', $webspaceKey = '', $receiverMail = '', $userMail = ''): array
    {
        $qb = $this->createQueryBuilder('f');

        if ($this->isValidDate($datefrom) && $this->isValidDate($dateto)) {
            $dateTimeFrom = new \DateTime($datefrom . ' 00:00:00');
            $dateTimeTo = new \DateTime($dateto . ' 23:59:59');
            $qb->andWhere('(f.created >= :datefrom AND f.created <= :dateto)');
            $qb->setParameter('datefrom', $dateTimeFrom->format('Y-m-d H:i:s'));
            $qb->setParameter('dateto', $dateTimeTo->format('Y-m-d H:i:s'));
        }

        if (!empty($locale)) {
            $qb->andWhere('f.locale = :locale');
            $qb->setParameter('locale', $locale);
        }

        if (!empty($category)) {
            $qb->andWhere('f.category = :category');
            $qb->setParameter('category', $category);
        }

        if (!empty($webspaceKey)) {
            $qb->andWhere('f.webspaceKey = :webspacekey');
            $qb->setParameter('webspacekey', $webspaceKey);
        }

        if (!empty($receiverMail)) {
            $qb->andWhere('f.receiverMail = :receivermail');
            $qb->setParameter('receivermail', $receiverMail);
        }

        if (!empty($userMail)) {
            $qb->andWhere('f.userMail = :usermail');
            $qb->setParameter('usermail', $userMail);
        }

        $qb->orderBy('f.created', 'DESC');

        return $qb->getQuery()->getResult();
    }

    private function isValidDate($date) {
        return (strtotime($date) !== false);
    }
}
