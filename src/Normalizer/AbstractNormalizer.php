<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 20/05/2018
 * Time: 21:22
 */

namespace App\Normalizer;


abstract class AbstractNormalizer implements NormalizerInterface
{
    protected $exceptionTypes;

    public function __construct(array $exceptionTypes)
    {
        $this->exceptionTypes = $exceptionTypes;
    }

    public function supports(\Exception $exception)
    {
        return in_array(get_class($exception), $this->exceptionTypes);
    }

}