<?php
namespace Skelgen\Renderer;

use Skelgen\Test\TestConfig;

class XslTransformTestCodeRenderer implements TestCoderRenderer {
    /**
     * @var \DOMDocument
     */
    private $document;


    function __construct() {

    }


    /**
     * @param TestConfig $config
     *
     * @return string
     */
    public function renderCode( TestConfig $config ) {
        $this->document = new \DOMDocument();
        $this->convertToXml( $config );
        $code = $this->transForm( $config );

        return str_replace( array( '&lt;', '&gt;' ), array( '<', '>' ), $code );
    }


    /**
     * @param TestConfig $config
     */
    private function convertToXml( TestConfig $config ) {
        $rootNode = $this->document->createElement( "xml" );
        $rootNode->appendChild( $this->createTextElement( "class_name", $config->getClassName() ) );
        $rootNode->appendChild( $this->createTextElement( "class_instance_name", $config->getClassInstanceName() ) );
        $rootNode->appendChild( $this->createTextElement( "test_class_name", $config->getTestClassName() ) );
        $rootNode->appendChild( $this->createTextElement( "namespace", $config->getTestNameSpace() ) );
        $rootNode->appendChild( $this->createConstructorInjectionNode( $config ) );

        $this->document->appendChild( $rootNode );
    }


    /**
     * @param string $name
     * @param string $text
     *
     * @return \DOMElement
     */
    private function createTextElement( $name, $text ) {
        $element = $this->document->createElement( $name );
        $element->appendChild( $this->document->createTextNode( $text ) );

        return $element;
    }


    /**
     * @param TestConfig $config
     *
     * @return \DOMElement
     */
    private function createConstructorInjectionNode( TestConfig $config ) {
        $constructorElement = $this->document->createElement( "constructor_injections" );
        foreach ( $config->getConstructorParameterList() as $parameter ) {
            $injectionElement = $this->document->createElement( "injection" );
            $injectionElement->setAttribute( "has_hint", (int)$parameter->hasTypeHint() );
            $injectionElement->appendChild( $this->createTextElement( "name", $parameter->getParameterName() ) );

            if ( $parameter->hasTypeHint() ) {
                $injectionElement->appendChild( $this->createTextElement( "type_hint", $parameter->getTypeHintClassName() ) );
            }

            $constructorElement->appendChild( $injectionElement );
        }

        return $constructorElement;
    }


    /**
     * @param TestConfig $config
     *
     * @return string
     */
    private function transForm( TestConfig $config ) {
        $domXslTransformer = new DomXslTransformer();
        return $domXslTransformer->transformDomDocument( $config->getTemplateLocation(), $this->document );
    }

}
