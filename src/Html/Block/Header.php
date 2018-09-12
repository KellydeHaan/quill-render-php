<?php

namespace Oberon\Quill\Render\Html\Block;

use Oberon\Quill\Render\Html\Utils\HtmlTags;
use Oberon\Quill\Render\Interfaces\Renderer;

/**
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright Dean Blackborough
 * @license https://github.com/deanblackborough/php-quill-renderer/blob/master/LICENSE
 */
class Header implements Renderer
{

    /**
     * @var Renderer[]
     */
    private $children;

    /**
     * @var string
     */
    private $tag;

    /**
     * Set the initial properties for the delta
     *
     * @param Renderer[] $children
     * @param array $attributes
     */
    public function __construct($children, array $attributes = [])
    {
        $this->children = $children;
        $this->tag = HtmlTags::HTML_TAG_HEADER.$attributes['header'];
    }

    /**
     * Render the HTML for the specific Delta type
     *
     * @return string
     */
    public function render()
    {
        $text = SimpleRenderer::children($this->children);

        return "<{$this->tag}>$text</{$this->tag}>".PHP_EOL;
    }
}
