<?php
/**
 * Created by PhpStorm.
 * User: kelly
 * Date: 08/09/2018
 * Time: 02:01
 */

namespace Oberon\Quill\Render\Html\Inline;

use Oberon\Quill\Render\Interfaces\Renderer;

class Tag implements Renderer
{

    private $tags;

    private $attributes;

    private $content;

    /**
     * Tag constructor.
     * @param array $tags
     * @param $content
     */
    public function __construct(array $tags, array $attributes, $content)
    {
        $this->tags = $tags;
        $this->attributes = $attributes;
        $this->content = $content;
    }

    /**
     * Render and return the string for the insert ready for the
     * renderer
     *
     * @return string
     */
    public function render()
    {
        $attrs = '';
        foreach ($this->attributes as $attr => $value) {
            $attrs .= " {$attr}=\"{$value}\"";
        }

        $tags = $this->tags;

        if (empty($tags)) {
            $tags[] = 'span';
        }

        $first = array_shift($tags);
        $content = "<{$first}{$attrs}>{$this->content}</{$first}>";
        foreach ($tags as $tag) {
            $content = "<{$tag}>{$content}</{$tag}>";
        }

        return $content;
    }
}