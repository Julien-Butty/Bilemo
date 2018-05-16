<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 15/05/2018
 * Time: 06:25
 */

namespace App\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

abstract class AbstractRepository extends EntityRepository
{
    protected function paginate(QueryBuilder $qb, int $limit = 20, int $offset = 0)
    {
        if (!($limit >= 0 && $offset >= 0)) {
            throw new \LogicException('$limit & $offset must be greater than 0. limit = ' . $limit . ' offset = ' . $offset);
            //Greater est >= 0 et au cas où ce n'est PAS le cas l'erreur est déclenchée.
        }

        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));
        $currentPage = ceil(($offset + 1) / $limit);
        // => $currentPage = ceil($offset + 1) / $limit On obtient que un float, le ceil doit être global pour avoir un int
        $pager->setCurrentPage($currentPage);
        $pager->setMaxPerPage($limit);

        return $pager;
    }
}