<?php
namespace Skelgen\Reflection;

class CustomReflectionClass extends \ReflectionClass {
    const CLASS_NAME = __CLASS__;

    /** @var ParentListRetriever */
    private $parentListRetriever;


    /**
     * @param mixed $argument - same rules as the normal reflection constructor
     */
    public function __construct( $argument ) {
        parent::__construct( $argument );
        $this->parentListRetriever = new ParentListRetriever();
    }


    /**
     * Returns the list of parent reflection classes
     * @return array|\ReflectionClass[]
     */
    public function getParentClassList() {
        return $this->parentListRetriever->getParentClassList( $this );
    }
}
