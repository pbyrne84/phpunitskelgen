<?php
namespace Skelgen\Test;

class TestGenerator {
    const CLASS_NAME = __CLASS__;
    private $testCoderRenderer;
    /**
     * @var array|TestConfigRenderer[]
     */
    private $testConfigRendererList;


    /**
     * @param array|TestConfigRenderer[]          $testConfigRendererList
     * @param \Skelgen\Renderer\TestCoderRenderer $testCoderRenderer
     */
    function __construct( array $testConfigRendererList, \Skelgen\Renderer\TestCoderRenderer $testCoderRenderer ) {
        $this->testConfigRendererList = $testConfigRendererList;
        $this->testCoderRenderer = $testCoderRenderer;
    }


    /**
     * @param \Skelgen\Reflection\CustomReflectionClass $reflectionClass
     * @throws TestConfigRendererNotFoundException
     */
    public function renderTestCode( \Skelgen\Reflection\CustomReflectionClass $reflectionClass ) {
        foreach( $this->testConfigRendererList as $testConfigRenderer ) {
            $testConfig = $testConfigRenderer->calculateConfig( $reflectionClass );
            if( !is_null( $testConfig ) ) {
                $code = $this->testCoderRenderer->renderCode( $testConfig );
                file_put_contents( $testConfig->getTestOutputFilePath(), $code );

                return;

            }
        }

        throw new TestConfigRendererNotFoundException("Cannot found renderer for " . $reflectionClass->getFileName());

    }

}
