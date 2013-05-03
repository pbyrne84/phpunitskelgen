<?php
namespace Skelgen\TestCase;

class BaseTestCase extends \PHPUnit_Framework_TestCase {
    const CLASS_NAME = __CLASS__;


    /**
     * @param string $sClassName
     * @throws \Exception
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    public function getFullMock( $sClassName ) {
        if( !class_exists( $sClassName, true ) && !interface_exists( $sClassName, true ) ) {
            throw new \Exception( $sClassName . ' is not included' );
        }
        return $this->getMock( $sClassName, array(), array(), '', false );
    }


    /**
     * @param $xml
     * @return \DOMDocument
     */
    protected function createPhpUnitComparableDomDocument( $xml ) {
        $oDomDocument                     = new \DOMDocument();
        $oDomDocument->preserveWhiteSpace = false;
        $oDomDocument->formatOutput       = true;
        $oDomDocument->loadXML( $xml );
        return $oDomDocument;
    }


    protected function returnTrue() {
        return $this->returnValue( true );
    }


    protected function returnFalse() {
        return $this->returnValue( false );
    }

}
