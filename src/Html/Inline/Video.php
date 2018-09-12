<?php

namespace Oberon\Quill\Render\Html\Inline;

use Oberon\Quill\Render\Interfaces\Renderer;

/**
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright Dean Blackborough
 * @license https://github.com/deanblackborough/php-quill-renderer/blob/master/LICENSE
 */
class Video implements Renderer
{
    private $insert;

    /**
     * Set the initial properties for the delta
     *
     * @param string $insert
     * @param array $attributes
     */
    public function __construct($insert)
    {

        $this->insert = $insert;

    }

    /**
     * Render the HTML for the specific Delta type
     *
     * @return string
     */
    public function render()
    {
        $insert = htmlspecialchars($this->insert, ENT_COMPAT, 'UTF-8');

        return '<iframe class="ql-video" frameborder="0" allowfullscreen="true" src="'.$insert.'"></iframe>';
    }
}
