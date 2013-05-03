<?php
namespace Skelgen\Local;

use Skelgen\File\ExistingDirectory;
use Skelgen\Reflection\ConstructorParameter;
use Skelgen\Reflection\CustomReflectionClass;
use Skelgen\Test\TestConfig;
use Skelgen\Test\TestConfigRenderer;


class StandardTestConfigCalculator implements TestConfigRenderer {
    const CLASS_NAME = __CLASS__;

    const PATH_STANDARD_TEMPLATE        = 'J:\inetpub\wwwroot\PhpUnitBootStrap\JePhpUnitBootStrap\Skelgen\Template\GenerationFiles\generic\StandardTestTemplate.xsl';
    const PATH_STANDARD_SERVER_TEMPLATE = 'J:\inetpub\wwwroot\PhpUnitBootStrap\JePhpUnitBootStrap\Skelgen\Template\GenerationFiles\generic\StandardServerTestTemplate.xsl';
    const PATH_STANDARD_ARRAY_OBJECT    = 'J:\inetpub\wwwroot\PhpUnitBootStrap\JePhpUnitBootStrap\Skelgen\Template\GenerationFiles\generic\StandardTypeSafeArrayObjectTest.xsl';


    /**
     * @var \Skelgen\Project\BasePathCalculator
     */
    private $basePathCalculator;


    function __construct( \Skelgen\Project\BasePathCalculator $basePathCalculator ) {
        $this->basePathCalculator = $basePathCalculator;
    }


    /**
     * @param \Skelgen\Reflection\CustomReflectionClass $reflectionClass
     * @throws \RuntimeException
     * @return TestConfig
     */
    public function calculateConfig( CustomReflectionClass $reflectionClass ) {
        if( !$reflectionClass->getNamespaceName() ) {
            throw new \RuntimeException( 'Non name spaced classes are not supported' );
        }

        $basePath            = $this->basePathCalculator->calculateBasePath(
            new \Skelgen\File\ExistingFile( $reflectionClass->getFileName() )
        );

        foreach( $reflectionClass->getParentClassList() as $parentClass ) {
            switch( $parentClass->getName() ) {
                case "Server" :
                    return $this->createGenericDetailsForServer( $reflectionClass, $basePath );

                case 'JE\Collection\TypeSafeArrayObject' :
                    return $this->createTypeSafeArrayObject( $reflectionClass, $basePath );
            }
        }

        return $this->createDefault( $reflectionClass, $basePath );
    }


    /**
     * @param \ReflectionClass                $reflectionClass
     * @param \Skelgen\File\ExistingDirectory $basePath
     * @return \Skelgen\Test\TestConfig
     */
    private function createGenericDetailsForServer( \ReflectionClass $reflectionClass, ExistingDirectory $basePath ) {
        $testConfig = new TestConfig(
                new \Skelgen\File\ExistingFile( self::PATH_STANDARD_SERVER_TEMPLATE )
              , $basePath->getRealPath() . '/moomoo'
               , $reflectionClass->getShortName()
              , $reflectionClass->getNamespaceName()
              , $reflectionClass->getShortName() . 'Test'
          );

          return $this->appendPublicReflectedMethods( $testConfig, $reflectionClass );
    }


    /**
     * @param \ReflectionClass                $reflectionClass
     * @param \Skelgen\File\ExistingDirectory $basePath
     * @return \Skelgen\Test\TestConfig
     */
    private function createTypeSafeArrayObject( \ReflectionClass  $reflectionClass, ExistingDirectory $basePath ) {
        $testConfig = new TestConfig(
              new \Skelgen\File\ExistingFile( self::PATH_STANDARD_ARRAY_OBJECT )
              , $basePath->getRealPath() . '/moomoo'
              , $reflectionClass->getShortName()
              , $reflectionClass->getNamespaceName()
              , $reflectionClass->getShortName() . 'Test'
          );

        $testConfig = $this->appendPublicReflectedMethods( $testConfig, $reflectionClass );
        $testConfig = $this->appendConstructorInjections( $testConfig, $reflectionClass);
        return $testConfig;
    }


    /**
     * @param \ReflectionClass                $reflectionClass
     * @param \Skelgen\File\ExistingDirectory $basePath
     * @return TestConfig
     */
    private function createDefault( \ReflectionClass $reflectionClass, ExistingDirectory $basePath ) {
        $testConfig = new TestConfig(
            new \Skelgen\File\ExistingFile( self::PATH_STANDARD_TEMPLATE )
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
         * @param \Skelgen\Test\TestConfig $testConfig
         * @param \ReflectionClass         $reflectionClass
         * @return \Skelgen\Test\TestConfig
         */
    private function appendConstructorInjections( TestConfig $testConfig, \ReflectionClass $reflectionClass  ) {
        $testConfig->addConstructorParameters( $this->createConstructorParameterList( $reflectionClass ));
        return $testConfig;
    }


    /**
     * TODO refactor out
     * @param \ReflectionClass $reflectedClass
     * @return array
     */
    private function createConstructorParameterList( \ReflectionClass $reflectedClass ) {
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
