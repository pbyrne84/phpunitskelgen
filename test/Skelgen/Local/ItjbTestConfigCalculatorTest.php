<?php
namespace Skelgen\Local;

use Skelgen\Reflection\CustomReflectionClass;

$paths = array(
    'J:\inetpub\wwwroot\dev.itjb4.local\ITJB1\PHP\includes\Bart\mvc',
    'J:\inetpub\wwwroot\dev.itjb4.local\ITJB1\PHP',
    'J:\inetpub\wwwroot\dev.itjb4.local\ITJB1\PHP\\includes',
    'J:\inetpub\wwwroot\dev.itjb4.local\ITJB1\PHP\includes\servers'
);

set_include_path( get_include_path() . ';' . implode( PATH_SEPARATOR, $paths ) );


require_once 'J:\inetpub\wwwroot\dev.itjb4.local\ITJB1\PHP\ITJB\JBE\JbeSearchParametersTaskDataMapper.php';
require_once 'J:\inetpub\wwwroot\dev.itjb4.local\ITJB1\PHP\ITJB\Task\DetectDeviceTask.php';
require_once 'J:\inetpub\wwwroot\dev.itjb4.local\ITJB1\PHP\modules\JE\ITJB\Solr\Server\ConfigurationServer.php';


class ItjbTestConfigCalculatorTest extends \Skelgen\TestCase\BaseTestCase {
    const CLASS_NAME = __CLASS__;

    /**
     * @var ItjbTestConfigCalculator
     */
    private $itjbTestConfigCalculator;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $basePathCalculator;


    protected function setUp() {
        $this->basePathCalculator = $this->getFullMock( ItjbBasePathCalculator::CLASS_NAME );
        $this->itjbTestConfigCalculator = new ItjbTestConfigCalculator( $this->basePathCalculator );

    }


    public function test_calculateConfig_default() {
        $this->basePathCalculator
                ->expects( $this->once() )
                ->method( 'calculateBasePath' )
                ->with( new \Skelgen\File\ExistingFile( 'J:\inetpub\wwwroot\dev.itjb4.local\ITJB1\PHP\ITJB\JBE\JbeSearchParametersTaskDataMapper.php' ) )
                ->will( $this->returnValue( new \Skelgen\File\ExistingDirectory( __DIR__ ) ) );

        $renderClass = $this->itjbTestConfigCalculator->calculateConfig(  new CustomReflectionClass( 'ITJB\JBE\JbeSearchParametersTaskDataMapper' ) );
        $this->assertNull( $renderClass);
    }


    public function test_calculateConfig_controller() {
        $this->basePathCalculator
                ->expects( $this->once() )
                ->method( 'calculateBasePath' )
                ->with( new \Skelgen\File\ExistingFile( 'J:\inetpub\wwwroot\dev.itjb4.local\ITJB1\PHP\ITJB\Controller\CvAnywhere\CvaLinkedInCvController.php' ) )
                ->will( $this->returnValue( new \Skelgen\File\ExistingDirectory( __DIR__ ) ) );

        $renderClass = $this->itjbTestConfigCalculator->calculateConfig(  new CustomReflectionClass( 'ITJB\Controller\CvAnywhere\CvaLinkedInCvController' ) );
        $this->assertEquals( array(), (array)$renderClass);
    }



    public function test_calculateConfig_task() {
        $this->basePathCalculator
                ->expects( $this->once() )
                ->method( 'calculateBasePath' )
                ->with( new \Skelgen\File\ExistingFile( 'J:\inetpub\wwwroot\dev.itjb4.local\ITJB1\PHP\ITJB\Task\DetectDeviceTask.php' ) )
                ->will( $this->returnValue( new \Skelgen\File\ExistingDirectory( __DIR__ ) ) );

        $renderClass = $this->itjbTestConfigCalculator->calculateConfig(  new CustomReflectionClass( 'ITJB\Task\DetectDeviceTask' ) );

        var_dump( $renderClass );
        $this->assertEquals( array(), (array)$renderClass);
    }

}
