<?php

namespace Skelgen;


class ExtendedPhockito extends \Phockito{
    const CLASS_NAME = __CLASS__;


    /**
     * @param $mock
     *
     * @return array|MockInteraction[]
     */
    public function getClassInteractions( $mock ) {
        $originalClassName = get_parent_class( $mock );
        $mockInteractionList = array();
        foreach ( self::$_call_list as $call ) {
            if ( $call['class'] == $originalClassName && $call['instance'] == $mock->__phockito_instanceid ) {
                $mockInteractionList[ ] = new MockInteraction( $call[ 'class' ], $call[ 'method' ], $call[ 'args' ] );
            }
        }

        return array_reverse( $mockInteractionList );
    }
}
