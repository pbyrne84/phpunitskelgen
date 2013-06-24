<?php
namespace Skelgen\Renderer;

use Skelgen\Test\TestConfig;

interface TestCoderRenderer {

    /**
     * Renders the test code for the config
     *
     * @param TestConfig $config
     * @return string
     */
    public function renderCode( TestConfig $config );
}
