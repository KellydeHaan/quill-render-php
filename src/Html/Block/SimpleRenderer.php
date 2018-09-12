<?php
/**
 * Created by PhpStorm.
 * User: kelly
 * Date: 11/09/2018
 * Time: 15:00
 */

namespace Oberon\Quill\Render\Html\Block;


use Oberon\Quill\Render\Interfaces\Renderer;

class SimpleRenderer
{

    /**
     * @param Renderer[] $children
     * @param string|null $separator
     * @return string
     */
    public static function children(array $children, $separator = null)
    {
        $result = '';
        foreach ($children as $child) {
            if (!empty($result) && $separator !== null) {
                $result .= $separator;
            }
            $result .= $child->render();
        }

        return $result;
    }

    /**
     * @param string $tag
     * @param string $text
     * @return string
     */
    public static function tag($tag, $text)
    {
        return "<{$tag}>{$text}</{$tag}>";
    }

}