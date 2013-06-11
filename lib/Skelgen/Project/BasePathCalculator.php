<?php
namespace Skelgen\Project;

interface BasePathCalculator {

    /**
     * @param \SplFileInfo $classPath
     *
     * @return \Skelgen\File\ExistingDirectory - basePath
     */
    public function calculateBasePath( \SplFileInfo $classPath );
}
