<?php
namespace Skelgen\Reflection;

class CustomReflectionClass extends \ReflectionClass{
    const CLASS_NAME = __CLASS__;

    /** @var ParentListRetriever */
    private $parentListRetriever;


    /**
     * @param mixed $argument
     */
    public function __construct( $argument ) {
        parent::__construct( $argument );
        $this->parentListRetriever = new ParentListRetriever();
    }


    /**
     * @return array|\ReflectionClass[]
     */
    public function getParentClassList() {
        return $this->parentListRetriever->getParentClassList( $this );
    }
}
