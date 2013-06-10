<?php
namespace Skelgen\Test;

class TestConfig {
    const CLASS_NAME = __CLASS__;

    /**
     * @var string
     */
    private $testOutputFilePath,
            $testNameSpace,
            $testClassName,
            $className;

    /**
     * @var \Skelgen\File\ExistingFile
     */
    private $templateLocation;

    /**
     * @var array|\ReflectionMethod[]
     */
    private $reflectionMethodList = array();

    /**
     * @var array|\Skelgen\Reflection\ConstructorParameter[]
     */
    private $constructorParameterList = array();


    /**
     * @param \Skelgen\File\ExistingFile $templateLocation
     * @param string                     $testOutputFilePath
     * @param string                     $className
     * @param string                     $testNameSpace
     * @param string                     $testClassName
     */
    function __construct( \Skelgen\File\ExistingFile $templateLocation, $testOutputFilePath, $className, $testNameSpace, $testClassName ) {
        $this->templateLocation   = $templateLocation;
        $this->testOutputFilePath = $testOutputFilePath;
        $this->className            = $className;
        $this->testNameSpace      = $testNameSpace;
        $this->testClassName       = $testClassName;
    }


    public static function createFromReflectionClass( \Skelgen\File\ExistingFile $templateLocation, $testOutputFilePath, \ReflectionClass $reflectionClass ) {
        return new TestConfig(
              $templateLocation
            , $testOutputFilePath
            , $reflectionClass->getShortName()
            , $reflectionClass->getNamespaceName()
            , $reflectionClass->getShortName() . 'Test'
        );
    }

    /**
     * @param \ReflectionMethod $reflectionMethod
     */
    public function addReflectionMethod( \ReflectionMethod $reflectionMethod ) {
        $this->reflectionMethodList[] =  $reflectionMethod;
    }


    /**
     * @param array $reflectionMethods
     * @internal param array|\ReflectionMethod $reflectionMethod
     */
    public function addReflectionMethods( array  $reflectionMethods ) {
        foreach( $reflectionMethods as $reflectionMethod ) {
            $this->addReflectionMethod( $reflectionMethod );
        }
    }


    /**
     * @param \Skelgen\Reflection\ConstructorParameter $constructorParameter
     */
    public function addConstructorParameter( \Skelgen\Reflection\ConstructorParameter $constructorParameter ) {
        $this->constructorParameterList[ ] = $constructorParameter;
    }


    /**
     * @param array|\Skelgen\Reflection\ConstructorParameter[]  $constructorParameters
     */
    public function addConstructorParameters( array $constructorParameters ) {
        foreach( $constructorParameters as $constructorParameter ) {
            $this->addConstructorParameter( $constructorParameter );
        }
    }


    /**
     * @return string
     */
    public function getTestClassName() {
        return $this->testClassName;
    }


    /**
     * @return string
     */
    public function getTestNameSpace() {
        return $this->testNameSpace;
    }


    /**
     * @return string
     */
    public function getTestOutputFilePath() {
        return $this->testOutputFilePath;
    }


    /**
     * @return \Skelgen\File\ExistingFile
     */
    public function getTemplateLocation() {
        return $this->templateLocation;
    }


    public function getConstructorParameterList() {
        return $this->constructorParameterList;
    }


    /**
     * @return string
     */
    public function getClassName() {
        return $this->className;
    }


    /**
     * @return string
     */
    public function getClassInstanceName() {
        return lcfirst( $this->getTestClassName() );
    }
}