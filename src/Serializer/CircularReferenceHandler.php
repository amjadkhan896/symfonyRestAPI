<?php

namespace App\Serializer;

class CircularReferenceHandler{

    public function __invoke($object)
    {
        // TODO: Implement __invoke() method.
        return $object->getId();
    }
}
?>