<?php

namespace Skelgen\Reflection;


class ConstructorDependencyGenerator {
    const CLASS_NAME = __CLASS__;


    /**
     * @param \ReflectionClass $reflectedClass
     *
     * @return array|ConstructorParameter[]
     */
    public function createConstructorParameterList( \ReflectionClass $reflectedClass ) {
        $constructorParameterList = array();
        /** @var \ReflectionMethod $method */
        foreach( $reflectedClass->getMethods() as $method ) {
            if( $method->isConstructor() ) {
                /** @var \ReflectionParameter $parameter */
                foreach( $method->getParameters() as $parameter ) {
                    $constructorParameterList[ ] = new ConstructorParameter( $parameter );
                }
            }
        }

        return $constructorParameterList;
    }
}
