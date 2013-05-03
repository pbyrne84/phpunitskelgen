<?php
namespace Skelgen\Reflection;

class ConstructorParameter {

    const CLASS_NAME = __CLASS__;

    /**
     * @var \ReflectionParameter
     */
    private $reflectionParameter;


    /**
     * @param \ReflectionParameter $reflectionParameter
     */
    function __construct( \ReflectionParameter $reflectionParameter ) {
        $this->reflectionParameter = $reflectionParameter;
    }


    /**
     * @return bool
     */
    public function hasTypeHint(){
        return $this->reflectionParameter->getClass() !== null;
    }


    /**
     * @return string
     * @throws \UnexpectedValueException
     */
    public function getTypeHintClassName(){
        if( !$this->hasTypeHint() ){
           throw new \UnexpectedValueException( $this->reflectionParameter->getName() . ' does not implement a type hint');
        }

        return $this->reflectionParameter->getClass()->getName();
    }


    /**
     * @return string
     */
    public function getParameterName(){
        return $this->reflectionParameter->getName();
    }

}
