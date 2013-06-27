# phpunitskelgen - a skeleton generator for generating unit tests.
One of the main issues with TDD is the manual effort that must be repeated at the start of each new test case. This in
turn can lead to classes growing large due to the hassle of create a new test case when sprouting a class. This makes it almost as easy to create
a new class for new functionality than it to try and lump it into another class( Inline Class is quite a rare refactoring as class tend to always
go from thin to fat due to the effort, reduce effort then more experimentation in TDD can be allowed in the current time restraints ). Just create a class
in a namespace with a type hinted contructor and call the external tool.


## Features:
1. All customisable implementation is injected via constructor so IDE features, subfolder creation, adding to Version Control, use of namespaces on legacy code,
code construction etc. can be overriden

2. Analyses constructor parameters to generate mocks from.

3. Current internal configuration relies on Phockito/PhpUnit for mocking but this can be ovveriden for any test framework/mocking framework. Originally this
was used internally but refactored out to make generic and generated PhpUnit mocks.

4. External tool configuration is farely generic but the implemented mask to calculate class name is namespaced specific. This did use to hook in to PhpStorm
very nicely but they removed the PHP skelgen feature for a java only one.

5. Internal templating method uses XSLT but this can be overriden and all it is doing is rendered a list of calculated

6. Custom base test case on the inheritance of the class to be tested is also very easy to implement as it all relies on
two levels of chaining.
a:) Matching to a project
b:) Matching to a base test case for that project

The amount of work required depends on the organisation differential in the projects this is applied to.


## External tool configuration( for PhpStorm ):
Program: path to php exectuable
Tool: "path to skelgen/phpstorm-phpunit-skelgen-mask.php" "$FilePath$"


## Internal boot loading
```php

//The boot loader is in a class purely because this is a branched action so I can use one external
//tool to manage this project which is totally seperate from other projects wihout polluting the
//global address space.
class SkelgenBoot {
    const CLASS_NAME = __CLASS__;

    public function bootAndRun() {
        //Wrapper for reading the arguments from $_SERVER
        $initialisationArgumentReader = new InitialisationArgumentReader();
        $initialisationConfig         = $initialisationArgumentReader->readInitialisation();

        //ArrayObject that has project list implemented
        $internalProjectConfigList    = new InternalSkelgenConfigList();

        //Scans the project list matching the source file to the project
        $skelgenConfig                = $internalProjectConfigList->matchProjectFileToConfig( $initialisationConfig->getSourceFile() );

        if ( $skelgenConfig == null ) {
            throw new RuntimeException( "'" . $initialisationConfig->getSourceFile() . '" cannot be mapped to skelgen config' );
        }

        //Run your project autoloader with include path setup etc, should append to any current
        //include path setup and autoloader
        if ( $skelgenConfig->hasAutoLoader() ) {
            require_once $skelgenConfig->getAutoLoaderPath( $initialisationConfig->getSourceFile() );
        }

        require_once $initialisationConfig->getSourceFile();

        $JESkelgenRunner = new InternalSkelgenRunner();
        $JESkelgenRunner->runSkelgen( $initialisationConfig, $skelgenConfig );
    }
}
```

## Internal configiguration
All classes in the LocalSkelgenTestGeneration can be used as a reference, they are all subject to change as they are not
considered published interfaces. They are best copied and pasted then hacked to need in your own implementation

1. InternalBasePathCalculator - relies on regexes to get the root path for your project from the passed class absolute location. There is commonly one of these
and it is used to handle project paths that vary between different machines so one configuration of this tool can be mapped on a network centrally managed.

2. InternalSkelgenBoot - discussed above

3. InternalSklgeenConfig - implementation of SkelgenConfig that is used for internal generation, usually one of these is configured for each project.

```php

class InternalSkelgenConfig implements SkelgenConfig {

    //This is just auto generated in the code template I use for everything class to allow when
    //creating mocks to use imports and have safe refactoring. Behaves the same as ::class in 5.5
    const CLASS_NAME = __CLASS__;

    //Regex to calculate base project path.
    const PROJECT_REGEX = '~(.*/phpunitskelgen/)~i';


    /**
     * Uses the above regex to verify if this is the correct one when spinnnig through possible
     * configurations in a loop.
     * @inheritdoc
     */
    public function isProject( VerifiedFileSystemResource $verifiedFileSystemResource ) {
        return preg_match( self::PROJECT_REGEX, $verifiedFileSystemResource->getNormalisedRealPath()  );
    }


    /**
     * Top level method that does all the calculation needed to generate the test class :-#
     * 1. Sets project name for any future reference/debugging
     * 2. Calculates the absolute test file output path, this implementation assumes namespacing
     *    and Test.php suffixing
     * 3. Verifies the test class is locatable on the file system and creates the base path using
     *    the InternalBasePathCalculator
     * 4. Sets the project regex for any further calculations.
     * 5. Sets the possible TestConfigRenders for the project, each renderer can handle grouping
     *    of possible templates and are usually matched via inheritance analysys.
     *
     * @inheritdoc
     */
    public function createProjectConfig( \ReflectionClass $classToTest ) {
        $projectConfig = new GenericProjectConfig(
            $this->getProjectName(),
            $this->getTestOutputFilePath( $classToTest ),
            $this->getBaseFolder( new ExistingFile( $classToTest->getFileName() ) ),
            self::PROJECT_REGEX
        );

        $projectConfig->setTestConfigRenderers( $this->getTestConfigRenderers( $projectConfig ) );

        return $projectConfig;
    }


    /**
     * @inheritdoc
     */
    public function getProjectName() {
        return 'Skelgen';
    }


    /**
     * This implementation assumes there is a test folder in the root of the project where the
     * test classes will start from. The complexity from this really comes down to the
     * organisation of a project and whether multiple test roots are involved.
     *
     * @param \ReflectionClass $classToTest
     *
     * @return string
     */
    private function getTestOutputFilePath( \ReflectionClass $classToTest ) {
        $baseProjectFolder = $this
                ->getBaseFolder( new ExistingFile( $classToTest->getFileName() ) )
                ->getRealPath();

        $baseTestPath           = new ExistingDirectory( $baseProjectFolder . '/test/' );
        $testFilePathCalculator = new NameSpacedTestFilePathCalculator( $baseTestPath );

        return $testFilePathCalculator->calculate( $classToTest );
    }


    /**
     * @param VerifiedFileSystemResource $testFileLocation
     *
     * @return \Skelgen\File\ExistingDirectory
     */
    private function getBaseFolder( VerifiedFileSystemResource $testFileLocation ) {
        $internalBasePathCalculator = new InternalBasePathCalculator( self::PROJECT_REGEX );

        return $internalBasePathCalculator->calculateBasePath( $testFileLocation );
    }


    /**
     * Returns the list of TestConfigRenderes applicable to a project. In this case as this project
     * is isolated there is only one but usually in the list would a render/s that handle shareable
     * config rendering such as configurations for framework controllers etc.
     *
     * @param \Skelgen\Project\GenericProjectConfig $projectConfig
     *
     * @return array|\Skelgen\Test\TestConfigRenderer[]
     */
    private function getTestConfigRenderers( GenericProjectConfig $projectConfig ) {
        return array(
            new InternalTestConfigRenderer( $projectConfig )
        );
    }


    /**
     * No autoloader path requried to for this but usually calculation would be implemented to
     * include the projects autoloader /include path setup. All include paths for autloading the
     * skelgen classes are determined and set as absolute starting points so they are safe from
     * any current working dir manipulations that may be required to get your own autoloaders
     * working.
     *
     * @inheritdoc
     */
    public function getAutoLoaderPath( VerifiedFileSystemResource $testFileLocation ) {
        return null;
    }


    /**
     * The autoloader is always included for this project whenever the sckelgen is run in the
     * external command setup
     * @inheritdoc
     */
    public function hasAutoLoader() {
        return false;
    }
}

```