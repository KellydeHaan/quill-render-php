<?php
/**
 * Created by PhpStorm.
 * User: kelly
 * Date: 11/09/2018
 * Time: 14:58
 */

namespace Oberon\Quill\Render\Html\Block;

use Oberon\Quill\Render\Html\Utils\HtmlTags;
use Oberon\Quill\Render\Interfaces\Renderer;

class ListItem implements Renderer
{

    private $children;

    /**
     * ListItem constructor.
     * @param $children
     */
    public function __construct($children)
    {
        $this->children = $children;
    }

    /**
     * Render and return the string for the insert ready for the
     * renderer
     *
     * @return string
     */
    public function render()
    {
        return SimpleRenderer::tag(HtmlTags::HTML_TAG_LIST_ITEM, SimpleRenderer::children($this->children)).PHP_EOL;
    }
}