<?php
namespace Skelgen\Renderer;

use Skelgen\Test\TestConfig;

interface TestCoderRenderer {

    /**
     * @param TestConfig $config
     * @return string
     */
    public function renderCode( TestConfig $config );
}
