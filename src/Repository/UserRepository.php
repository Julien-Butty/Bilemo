<?php

namespace App\Repository;



class UserRepository extends AbstractRepository
{

    public function search($term, $order = 'asc', $limit = 20, $offset = 0)
    {
        $qb = $this
            ->createQueryBuilder('a')
            ->select('a')
            ->orderBy('a.id', $order);

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

        return $this->paginate($qb, $limit, $offset);
    }
}
