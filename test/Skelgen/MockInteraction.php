<?php

namespace Skelgen;


class MockInteraction {
    const CLASS_NAME = __CLASS__;
    /**
     * @var string
     */
    private $class;
    /**
     * @var string
     */
    private $method;
    /**
     * @var array
     */
    private $args;


    /**
     * @param string $class
     * @param string $method
     * @param array  $args
     */
    function __construct( $class, $method, array $args ) {
        $this->class = $class;
        $this->method = $method;
        $this->args = $args;
    }


    /**
     * @return array
     */
    public function getArgs() {
        return $this->args;
    }


    /**
     * @return string
     */
    public function getClass() {
        return $this->class;
    }


    /**
     * @return string
     */
    public function getMethod() {
        return $this->method;
    }


}
