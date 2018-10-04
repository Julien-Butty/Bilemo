<?php

namespace App\Repository;


class UserRepository extends AbstractRepository
{

    public function search($client, $term, $order = 'asc', $limit = 20, $offset = 0)
    {
        $qb = $this
            ->createQueryBuilder('a')
            ->select('a')
            ->orderBy('a.id', $order)
            ->andWhere('a.client = :client')
            ->setParameter('client', $client);

        if ($term) {
            $qb
                ->where('a.lastName LIKE ?1
                    OR a.firstName LIKE ?1
                    OR a.mail LIKE ?1
                    OR a.address LIKE ?1
                    OR a.phone LIKE ?1
                ')
                ->setParameter(1, '%' . $term . '%');
        }
        $qb->getQuery()->useResultCache(true);

        return $this->paginate($qb, $limit, $offset);
    }
}
