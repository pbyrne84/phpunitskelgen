<?php

namespace Skelgen\Reflection;


class ConstructorDependencyGenerator {
    const CLASS_NAME = __CLASS__;


    /**
     * Creates a list of constructor parameters to be used in the test generation
     *
     * @param \ReflectionClass $reflectedClass
     *
     * @return array|ConstructorParameter[]
     */
    public function createConstructorParameterList( \ReflectionClass $reflectedClass ) {
        $constructorParameterList = array();
        /** @var \ReflectionMethod $method */
        foreach ( $reflectedClass->getMethods() as $method ) {
            if ( $method->isConstructor() ) {
                /** @var \ReflectionParameter $parameter */
                foreach ( $method->getParameters() as $parameter ) {
                    $constructorParameterList[ ] = new ConstructorParameter( $parameter );
                }
            }
        }

        return $constructorParameterList;
    }
}
