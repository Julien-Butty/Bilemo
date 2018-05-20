<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 20/05/2018
 * Time: 21:19
 */

namespace App\Normalizer;


interface NormalizerInterface
{
    public function normalize(\Exception $exception);

    public function supports(\Exception $exception);

}