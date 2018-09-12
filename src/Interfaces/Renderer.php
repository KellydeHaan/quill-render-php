<?php
/**
 * Created by PhpStorm.
 * User: kelly
 * Date: 08/09/2018
 * Time: 02:04
 */

namespace Oberon\Quill\Render\Interfaces;

interface Renderer
{

    /**
     * Render a part of the content
     *
     * @return string
     */
    public function render();

}