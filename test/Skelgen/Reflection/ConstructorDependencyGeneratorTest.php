<?php
namespace Skelgen\Reflection;

use Skelgen\IDE\IdeFileOpener;
use Skelgen\InternalBaseTestCase;
use Skelgen\PhpStorm\PhpStormFileOpener;


class ConstructorDependencyGeneratorTest extends InternalBaseTestCase {

    const CLASS_NAME = __CLASS__;

    /** @var ConstructorDependencyGenerator */
    private $constructorDependencyGenerator;


    protected function setUp() {
        $this->constructorDependencyGenerator = new ConstructorDependencyGenerator();
    }


    public function test_createConstructorParameterList_emptyListForNotParameters() {
        $reflectionClass  = new \ReflectionClass( PhpStormFileOpener::CLASS_NAME );
        $actualParameters = $this->constructorDependencyGenerator->createConstructorParameterList( $reflectionClass );

        $this->assertEquals( array(), $actualParameters );
    }


    public function test_createConstructorParameterList_onlyTheConstructorWillBeScanned() {
        $reflectionClass = new \ReflectionClass( ConstructorDependencyGeneratorTestClass::CLASS_NAME );

        $expectedParameters = array(
            $this->createParameter( 'ideFileOpener' ),
            $this->createParameter( 'DOMDocument' ),
        );

        $actualParameters = $this->constructorDependencyGenerator->createConstructorParameterList( $reflectionClass );

        $this->assertEquals( $expectedParameters, $actualParameters );
    }


    /**
     * @param string $parameterVariableName
     *
     * @return ConstructorParameter
     */
    private function createParameter( $parameterVariableName ) {
        return new ConstructorParameter(
            new \ReflectionParameter(
                array( ConstructorDependencyGeneratorTestClass::CLASS_NAME, '__construct' ),
                $parameterVariableName
            )
        );
    }
}

class ConstructorDependencyGeneratorTestClass {
    const CLASS_NAME = __CLASS__;


    /**
     * @param IdeFileOpener $ideFileOpener
     * @param \DOMDocument  $DOMDocument
     */
    function __construct( IdeFileOpener $ideFileOpener, \DOMDocument $DOMDocument ) {
    }


    /**
     * @param \SimpleXMLElement $simpleXmlElement
     */
    public function testMethodThatWillBeIgnored( \SimpleXMLElement $simpleXmlElement ) {

    }
}
