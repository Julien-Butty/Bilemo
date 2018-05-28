<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 28/05/2018
 * Time: 14:18
 */

namespace App\Handler;


use Symfony\Component\Validator\ConstraintViolationList;

class AbstractHandler
{
    public function validate(ConstraintViolationList $validationErrors)
    {
        if (count($validationErrors)) {
            return $this->view($validationErrors, Response::HTTP_BAD_REQUEST);
        }
    }
}