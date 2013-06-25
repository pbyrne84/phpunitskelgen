<?php

namespace Skelgen;

use PHPUnit_Framework_TestCase;

abstract class InternalBaseTestCase extends PHPUnit_Framework_TestCase {
    const CLASS_NAME = __CLASS__;


    /**
     * @var ExtendedPhockito
     */
    public $phockito;


    public function __construct( $name = null, array $data = array(), $dataName = '' ) {
        parent::__construct( $name, $data, $dataName );
        $this->phockito = new ExtendedPhockito();

    }

    /**
     * @param $mock
     *
     * @throws \PHPUnit_Framework_AssertionFailedError on failure
     */
    protected function verifyNoInteractionsOn( $mock ) {
        $mockInteractions = $this->phockito->getClassInteractions( $mock );
        if ( count( $mockInteractions ) == 0 ) {
            return;
        }

        $assertionMessage = 'Expected no interaction on "' . $mockInteractions[ 0 ]->getClass() .
                '" object but actually received the following method calls:' . "\n\n";

        foreach ( $mockInteractions as $mockInteraction ) {
            $assertionMessage .= "call: " . $mockInteraction->getClass() . '->' . $mockInteraction->getMethod() . " (\n" .
                    "" . var_export( $mockInteraction->getArgs(), true ) . ")\n\n";
        }

        throw new \PHPUnit_Framework_AssertionFailedError( $assertionMessage );
    }
}
