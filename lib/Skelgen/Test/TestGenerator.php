<?php
namespace Skelgen\Test;

use Skelgen\Reflection\CustomReflectionClass;
use Skelgen\Renderer\TestCoderRenderer;

class TestGenerator {
    const CLASS_NAME = __CLASS__;

    private $testCoderRenderer;

    /**
     * @var array|TestConfigRenderer[]
     */
    private $testConfigRendererList;


    /**
     * @param array|TestConfigRenderer[] $testConfigRendererList
     * @param TestCoderRenderer          $testCoderRenderer
     */
    function __construct( array $testConfigRendererList, TestCoderRenderer $testCoderRenderer ) {
        $this->testConfigRendererList = $testConfigRendererList;
        $this->testCoderRenderer      = $testCoderRenderer;
    }


    /**
     * @param CustomReflectionClass $reflectionClass
     *
     * @throws TestConfigRendererNotFoundException
     */
    public function renderTestCode( CustomReflectionClass $reflectionClass ) {
        foreach ( $this->testConfigRendererList as $testConfigRenderer ) {
            $testConfig = $testConfigRenderer->calculateConfig( $reflectionClass );
            if ( !is_null( $testConfig ) ) {
                $code = $this->testCoderRenderer->renderCode( $testConfig );
                file_put_contents( $testConfig->getTestOutputFilePath(), $code );

                return;

            }
        }

        throw new TestConfigRendererNotFoundException( "Cannot found renderer for " . $reflectionClass->getFileName() );

    }

}
