<?php
namespace Skelgen\Renderer;

class XslTransformTestCodeRenderer implements TestCoderRenderer {
    /**
     * @var \DOMDocument
     */
    private $document;


    /**
     *
     */
    function __construct() {

    }


    /**
     * @param \Skelgen\Test\TestConfig $config
     *
     * @return string
     */
    public function renderCode( \Skelgen\Test\TestConfig $config ) {
        $this->document = new \DOMDocument();
        $this->convertToXml( $config );
        $code = $this->transForm( $config );

        return str_replace( array( '&lt;', '&gt;' ), array( '<', '>' ), $code );
    }


    /**
     * @param \Skelgen\Test\TestConfig $config
     */
    private function convertToXml( \Skelgen\Test\TestConfig $config ) {
        $rootNode = $this->document->createElement( "xml" );
        $rootNode->appendChild( $this->createText( "class_name", $config->getClassName() ) );
        $rootNode->appendChild( $this->createText( "class_instance_name", $config->getClassInstanceName() ) );
        $rootNode->appendChild( $this->createText( "test_class_name", $config->getTestClassName() ) );
        $rootNode->appendChild( $this->createText( "namespace", $config->getTestNameSpace() ) );
        $rootNode->appendChild( $this->createConstructorInjectionNode( $config ) );

        $this->document->appendChild( $rootNode );
    }


    /**
     * @param $name
     * @param $text
     *
     * @return \DOMElement
     */
    private function createText( $name, $text ) {
        $element = $this->document->createElement( $name );
        $element->appendChild( $this->document->createTextNode( $text ) );

        return $element;
    }


    /**
     * @param \Skelgen\Test\TestConfig $config
     *
     * @return \DOMElement
     */
    private function createConstructorInjectionNode( \Skelgen\Test\TestConfig $config ) {
        $constructorElement = $this->document->createElement( "constructor_injections" );
        foreach ( $config->getConstructorParameterList() as $parameter ) {
            $injectionElement = $this->document->createElement( "injection" );
            $injectionElement->setAttribute( "has_hint", (int)$parameter->hasTypeHint() );
            $injectionElement->appendChild( $this->createText( "name", $parameter->getParameterName() ) );

            if ( $parameter->hasTypeHint() ) {
                $injectionElement->appendChild( $this->createText( "type_hint", $parameter->getTypeHintClassName() ) );
            }

            $constructorElement->appendChild( $injectionElement );
        }

        return $constructorElement;
    }


    /**
     * @param \Skelgen\Test\TestConfig $config
     *
     * @return string
     */
    private function transForm( \Skelgen\Test\TestConfig $config ) {
        $domXslTransformer = new DomXslTransformer();
        echo $this->document->saveXML();

        return $domXslTransformer->transformDomDocument( $config->getTemplateLocation(), $this->document );
    }

}
