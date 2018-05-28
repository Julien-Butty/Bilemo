<?php

namespace App\Repository;



class PhoneRepository extends AbstractRepository
{
    public function search($term, $order= 'asc', $limit = 20, $offset = 0)
    {
        $qb = $this
            ->createQueryBuilder('a')
            ->select('a')
            ->orderBy('a.id', $order)
        ;

        if ($term) {
            $qb
                ->where(('a.brand LIKE ?1
                    OR a.model LIKE ?1
                    OR a.plateform LIKE ?1
                    OR a.color LIKE ?1
                    OR a.weight LIKE ?1
                    OR a.dimensions LIKE ?1
                    OR a.sim LIKE ?1
                    OR a.displaySize LIKE ?1
                    OR a.memory LIKE ?1
                    OR a.camera LIKE ?1')
                )
                ->setParameter(1, '%'.$term.'%')
            ;
        }

        return $this->paginate($qb,$limit,$offset);
    }
}
