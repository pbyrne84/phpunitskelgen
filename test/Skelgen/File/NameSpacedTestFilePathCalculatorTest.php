<?php
namespace Skelgen\File;

use Skelgen\InternalBaseTestCase;

class NameSpacedTestFilePathCalculatorTest extends InternalBaseTestCase {

    const CLASS_NAME = __CLASS__;

    /** @var ExistingDirectory */
    private $testBaseDir;

    /** @var NameSpacedTestFilePathCalculator */
    private $nameSpacedTestFilePathCalculator;


    protected function setUp() {
        $this->testBaseDir   = \mock( ExistingDirectory::CLASS_NAME );
        $this->nameSpacedTestFilePathCalculator = new NameSpacedTestFilePathCalculator(
            $this->testBaseDir
        );
    }


    public function test_calculate() {
        $testBasePath = '/the/path/that/is/the/root/of/the/tests';


        when( $this->testBaseDir->getNormalisedRealPath() )
                ->thenReturn( $testBasePath );

        $classToCreateTestFor = new \ReflectionClass( NameSpacedTestFilePathCalculator::CLASS_NAME );

        $this->assertEquals(
            '/the/path/that/is/the/root/of/the/tests/Skelgen/File/NameSpacedTestFilePathCalculatorTest.php',
            $this->nameSpacedTestFilePathCalculator->calculate( $classToCreateTestFor )
        );
    }

}
  
