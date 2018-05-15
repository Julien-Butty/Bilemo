<?php

namespace App\Repository;

use App\Entity\Phone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;


class PhoneRepository extends AbstractRepository
{
    public function search($term, $order= 'asc', $limit=20, $offset = 0)
    {
        $qb = $this
            ->createQueryBuilder('a')
            ->select('a')
            ->orderBy('a.brand')
            ;

        if ($term) {
            $qb
                ->where('a.brand LIKE ?1')
                ->setParameter(1, '%'.$term.'%')
                ;
        }

        return $this->paginate($qb, $limit, $offset);
    }
}
