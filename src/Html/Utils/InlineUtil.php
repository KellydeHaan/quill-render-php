<?php
/**
 * Created by PhpStorm.
 * User: kelly
 * Date: 11/09/2018
 * Time: 16:58
 */

namespace Oberon\Quill\Render\Html\Utils;

use Oberon\Quill\Render\Html\Block\Paragraph;
use Oberon\Quill\Render\Interfaces\Renderer;

/**
 * Class InlineUtil
 * @package Oberon\Quill\Render\Html\Block
 */
class InlineUtil
{

    /**
     * @param Renderer $child
     * @param Renderer[] $renderables
     */
    public static function addToParagraph(Renderer $child, array &$renderables)
    {
        $parent = count($renderables) > 0 ? $renderables[count($renderables) - 1] : null;
        if ($parent != null && $parent instanceof Paragraph) {
            $parent->addChild($child);
        } else {
            $parent = new Paragraph();
            $parent->addChild($child);
            $renderables[] = $parent;
        }
    }
}