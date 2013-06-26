<?php
namespace Skelgen\File;

use Skelgen\File\VCS\AddToVersionControlAction;
use Skelgen\InternalBaseTestCase;

class SubFolderGeneratorTest extends InternalBaseTestCase {

    const CLASS_NAME = __CLASS__;

    /** @var FileSystem */
    private $fileSystem;

    /** @var AddToVersionControlAction */
    private $addToVersionControlAction;

    /** @var SubFolderGenerator */
    private $subFolderGenerator;


    protected function setUp() {
        $this->fileSystem                = \mock( FileSystem::CLASS_NAME );
        $this->addToVersionControlAction = \mock( AddToVersionControlAction::INTERFACE_NAME_AddToVersionControlAction );
        $this->subFolderGenerator        = new SubFolderGenerator(
            $this->fileSystem,
            $this->addToVersionControlAction
        );
    }


    public function test_generateRequiredSubFolders_noFoldersExistAndAllAreCreated() {
        $newTestFilePath = '/dirA/dirB/NewTestFile.php';
        when( $this->fileSystem->isDir( '/' ) )
                ->thenReturn( true );

        $fullPathA = '/dirA/';
        when( $this->fileSystem->isDir( $fullPathA ) )
                ->thenReturn( false );

        $fullPathB = '/dirA/dirB/';
        when( $this->fileSystem->isDir( $fullPathB ) )
                ->thenReturn( false );

        $directoryA = mock( ExistingDirectory::CLASS_NAME );
        when( $this->fileSystem->getDirectory( $fullPathA ) )
                ->thenReturn( $directoryA );

        $directoryB = mock( ExistingDirectory::CLASS_NAME );
        when( $this->fileSystem->getDirectory( $fullPathB ) )
                ->thenReturn( $directoryB );

        $this->subFolderGenerator->generateRequiredSubFolders( $newTestFilePath );

        verify( $this->fileSystem )->mkDir( $fullPathA );
        verify( $this->fileSystem )->mkDir( $fullPathB );

        verify( $this->addToVersionControlAction )->addFolderToVersionControl( $directoryA );
        verify( $this->addToVersionControlAction )->addFolderToVersionControl( $directoryB );
    }


    public function test_generateRequiredSubFolders_AllFoldersExistAndAllAreCreated() {
        $newTestFilePath = '/dirA/dirB/NewTestFile.php';
        when( $this->fileSystem->isDir( '/' ) )
                ->thenReturn( true );

        $fullPathA = '/dirA/';
        when( $this->fileSystem->isDir( $fullPathA ) )
                ->thenReturn( true );

        $fullPathB = '/dirA/dirB/';
        when( $this->fileSystem->isDir( $fullPathB ) )
                ->thenReturn( true );

        $this->subFolderGenerator->generateRequiredSubFolders( $newTestFilePath );

        verify( $this->fileSystem, 0 )->mkDir( \anything() );
        $this->verifyNoInteractionsOn( $this->addToVersionControlAction );
    }
}
  
