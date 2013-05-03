<?php
namespace Skelgen\Renderer;

class XslTransformTestCodeRendererTest extends \PHPUnit_Framework_TestCase {
    const CLASS_NAME = __CLASS__;


    public function test_moo() {
        $xslTransformTestCodeRenderer = new XslTransformTestCodeRenderer();

        $reflectionClass = new \ReflectionClass( $this );

        $templateLocation = new \Skelgen\File\ExistingFile( 'J:\inetpub\wwwroot\Skelgen\test\Skelgen\Renderer\resource\test_generate.xsl' );
        $config = new \Skelgen\Test\TestConfig(
              $templateLocation
            ,  'J:\inetpub\wwwroot\Skelgen\test\Skelgen\Renderer\resource\test_output.php'
            , $reflectionClass->getShortName()
            , $reflectionClass->getNamespaceName()
            , $reflectionClass->getShortName() . 'Test' );


        $config->addConstructorParameter($this->createConstructorParameter( 'DOMElement', 'appendChild' ) );
        $config->addConstructorParameter($this->createConstructorParameter( 'DOMDocument', 'adoptNode' ) );
        $config->addConstructorParameter($this->createConstructorParameter( 'DOMDocument', 'createAttribute' ) );

        echo $xslTransformTestCodeRenderer->renderCode( $config );
    }


    /**
     * @param $className
     * @param $method
     * @return \Skelgen\Reflection\ConstructorParameter
     */
    private function createConstructorParameter( $className, $method ) {
        return new \Skelgen\Reflection\ConstructorParameter( new \ReflectionParameter( array( $className, $method ), 0 ) );
    }
}
