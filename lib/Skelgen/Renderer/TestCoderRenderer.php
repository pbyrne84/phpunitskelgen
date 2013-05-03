<?php
namespace Skelgen\Renderer;

interface TestCoderRenderer {

    /**
     * @param \Skelgen\Test\TestConfig $config
     * @return string
     */
    public function renderCode( \Skelgen\Test\TestConfig $config );
}
