<?php

namespace Skelgen\Reflection;

class ParentListRetriever {
    const CLASS_NAME = __CLASS__;

    /**
     * @param \ReflectionClass $reflectionClass
     * @return array|\ReflectionClass[]
     */
    public function getParentClassList( \ReflectionClass $reflectionClass ) {
        $parentClassList = array();
        while( false !== ( $parentClass = $reflectionClass->getParentClass() ) ) {
            $parentClassList[ ] = $parentClass;
            $reflectionClass = $parentClass;
        }

        return $parentClassList;
    }

}
