<?php


namespace App\Service;

/**
 * Class CircularReferenceHandler
 * @package App\Service
 *
 * Prevents serializer from looping
 */
class CircularReferenceHandler
{
    public function __invoke($object)
    {
        return $object->getID();
    }
}