<?php
namespace Skelgen\Local;


use Skelgen\Test\TestConfig;

class ItjbTestConfigCalculator implements \Skelgen\Test\TestConfigRenderer {
    const CLASS_NAME = __CLASS__;

    const PATH_CONTROLLER_TEMPLATE = 'J:\inetpub\wwwroot\PhpUnitBootStrap\JePhpUnitBootStrap\Skelgen\Template\GenerationFiles\itjb\ItjbControllerTestTemplate.xsl';
    const PATH_TASK_TEMPLATE       = 'J:\inetpub\wwwroot\PhpUnitBootStrap\JePhpUnitBootStrap\Skelgen\Template\GenerationFiles\itjb\ItjbTaskTestTemplate.xsl';

    private $basePathCalculator;


    function __construct( \Skelgen\Project\BasePathCalculator $basePathCalculator ) {
        $this->basePathCalculator = $basePathCalculator;
    }


    /**
     * @param \Skelgen\Reflection\CustomReflectionClass $reflectionClass
     * @throws \RuntimeException if not names paced class
     * @return TestConfig|null
     */
    public function calculateConfig( \Skelgen\Reflection\CustomReflectionClass $reflectionClass ) {
        if( !$reflectionClass->getNamespaceName() ) {
            throw new \RuntimeException( 'Non name spaced classes are not supported' );
        }

        $classFilePath       = new \Skelgen\File\ExistingFile( $reflectionClass->getFileName() );
        $basePath            = $this->basePathCalculator->calculateBasePath( $classFilePath );
        foreach( $reflectionClass->getParentClassList() as $parentClass ) {
            switch( $parentClass->getName() ) {
                case "Task" :
                    return $this->createDetailsForTask( $reflectionClass, $basePath );

                case "ITJB\\Bart\\Mvc\\PageController" :
                    return $this->createGenericDetailsForController( $reflectionClass, $basePath );
            }
        }

        return null;
    }


    /**
     * @param \ReflectionClass                $reflectionClass
     * @param \Skelgen\File\ExistingDirectory $basePath
     * @return \Skelgen\Test\TestConfig
     */
    private function createDetailsForTask( \ReflectionClass $reflectionClass, \Skelgen\File\ExistingDirectory $basePath ) {
        $testConfig = new TestConfig(
            new \Skelgen\File\ExistingFile( self::PATH_TASK_TEMPLATE )
            , $basePath->getRealPath() . '/moomoo'
            , $reflectionClass->getShortName()
            , $reflectionClass->getNamespaceName()
            , $reflectionClass->getShortName() . 'Test'
        );

        return $this->appendPublicReflectedMethods( $testConfig, $reflectionClass );
    }


    /**
     * @param \Skelgen\Test\TestConfig $testConfig
     * @param \ReflectionClass         $reflectionClass
     * @return \Skelgen\Test\TestConfig
     */
    private function appendPublicReflectedMethods( TestConfig $testConfig, \ReflectionClass $reflectionClass ) {
        $reflectionMethods = $reflectionClass->getMethods( \ReflectionMethod::IS_PUBLIC );
        $testConfig->addReflectionMethods( $reflectionMethods );
        return $testConfig;
    }


    /**
     * @param \ReflectionClass                $reflectionClass
     * @param \Skelgen\File\ExistingDirectory $basePath
     * @return \Skelgen\Test\TestConfig
     */
    private function createGenericDetailsForController( \ReflectionClass $reflectionClass, \Skelgen\File\ExistingDirectory $basePath ) {
        $testConfig = new TestConfig(
              new \Skelgen\File\ExistingFile( self::PATH_TASK_TEMPLATE )
            , $basePath->getRealPath() . '/moomoo'
            , $reflectionClass->getShortName()
            , $reflectionClass->getNamespaceName()
            , $reflectionClass->getShortName() . 'Test'
        );

        return $this->appendPublicReflectedMethods( $testConfig, $reflectionClass );
    }

}
