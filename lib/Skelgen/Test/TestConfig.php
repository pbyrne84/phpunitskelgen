<?php
namespace Skelgen\Test;

use Skelgen\File\ExistingFile;
use Skelgen\Reflection\ConstructorParameter;

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
     * @var ExistingFile
     */
    private $templateLocation;

    /**
     * @var array|\ReflectionMethod[]
     */
    private $reflectionMethodList = array();

    /**
     * @var array|ConstructorParameter[]
     */
    private $constructorParameterList = array();


    /**
     * @param ExistingFile $templateLocation
     * @param string       $testOutputFilePath
     * @param string       $className
     * @param string       $testNameSpace
     * @param string       $testClassName
     */
    function __construct( ExistingFile $templateLocation,
                          $testOutputFilePath,
                          $className,
                          $testNameSpace,
                          $testClassName ) {
        $this->templateLocation   = $templateLocation;
        $this->testOutputFilePath = $testOutputFilePath;
        $this->className          = $className;
        $this->testNameSpace      = $testNameSpace;
        $this->testClassName      = $testClassName;
    }


    /**
     * @param ExistingFile     $templateLocation
     * @param string           $testOutputFilePath
     * @param \ReflectionClass $reflectionClass
     *
     * @return TestConfig
     */
    public static function createFromReflectionClass( ExistingFile $templateLocation,
                                                      $testOutputFilePath,
                                                      \ReflectionClass $reflectionClass ) {
        return new TestConfig(
            $templateLocation,
            $testOutputFilePath,
            $reflectionClass->getShortName(),
            $reflectionClass->getNamespaceName(),
            $reflectionClass->getShortName() . 'Test'
        );
    }


    /**
     * @param array|\ReflectionMethod[] $reflectionMethods
     */
    public function addReflectionMethods( array  $reflectionMethods ) {
        foreach ( $reflectionMethods as $reflectionMethod ) {
            $this->addReflectionMethod( $reflectionMethod );
        }
    }


    /**
     * @param \ReflectionMethod $reflectionMethod
     */
    public function addReflectionMethod( \ReflectionMethod $reflectionMethod ) {
        $this->reflectionMethodList[ ] = $reflectionMethod;
    }


    /**
     * @param array|ConstructorParameter[] $constructorParameters
     */
    public function addConstructorParameters( array $constructorParameters ) {
        foreach ( $constructorParameters as $constructorParameter ) {
            $this->addConstructorParameter( $constructorParameter );
        }
    }


    /**
     * @param ConstructorParameter $constructorParameter
     */
    public function addConstructorParameter( ConstructorParameter $constructorParameter ) {
        $this->constructorParameterList[ ] = $constructorParameter;
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
     * @return ExistingFile
     */
    public function getTemplateLocation() {
        return $this->templateLocation;
    }


    /**
     * @return array|ConstructorParameter[]
     */
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
        return lcfirst( $this->getClassName() );
    }


    /**
     * @return string
     */
    public function getTestClassName() {
        return $this->testClassName;
    }
}