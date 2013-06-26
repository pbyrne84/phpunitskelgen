<?php
namespace Skelgen\File;

use JESkelgen\Calculator\OutputDetailsFactoryParameters;
use Skelgen\InternalBaseTestCase;

class NameSpacedTestFilePathCalculatorTest extends InternalBaseTestCase {

    const CLASS_NAME = __CLASS__;

    /** @var OutputDetailsFactoryParameters */
    private $outputDetailsFactoryParameters;

    /** @var NameSpacedTestFilePathCalculator */
    private $nameSpacedTestFilePathCalculator;


    protected function setUp() {
        $this->outputDetailsFactoryParameters   = \mock( OutputDetailsFactoryParameters::CLASS_NAME );
        $this->nameSpacedTestFilePathCalculator = new NameSpacedTestFilePathCalculator(
            $this->outputDetailsFactoryParameters
        );
    }


    public function test_calculate() {
        $testBasePath = '/the/path/that/is/the/root/of/the/tests';

        when( $this->outputDetailsFactoryParameters->getBaseTestPath() )
                ->thenReturn( $testBasePath );

        $classToCreateTestFor = new \ReflectionClass( NameSpacedTestFilePathCalculator::CLASS_NAME );

        $this->assertEquals(
            '/the/path/that/is/the/root/of/the/tests/Skelgen/File/NameSpacedTestFilePathCalculatorTest.php',
            $this->nameSpacedTestFilePathCalculator->calculate( $classToCreateTestFor )
        );
    }

}
  
