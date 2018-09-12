<?php
/**
 * Created by PhpStorm.
 * User: kelly
 * Date: 06/09/2018
 * Time: 17:40
 */

namespace Oberon\Quill\Render\Html\Parsers;

use Oberon\Quill\Render\Attribute;
use Oberon\Quill\Render\Html\Block\Header;
use Oberon\Quill\Render\Html\Block\MutableBlock;
use Oberon\Quill\Render\Html\Inline\Text;
use Oberon\Quill\Render\Interfaces\Parser;
use Oberon\Quill\Render\Interfaces\Renderer;

class HeaderParser implements Parser
{

    /**
     * @param array $op
     * @param Renderer[] $renderers
     * @return bool
     */
    public function handleOp(array $op, array &$renderers)
    {
        if ($this->checkRequirements($op) === false) {
            return false;
        }

        $replace = array_pop($renderers);
        if ($replace === null) {
            return false;
        }
        $children = $replace instanceof MutableBlock ? $replace->getChildren() : [new Text($replace->render())];
        $renderers[] = new Header($children, $op['attributes']);

        return true;
    }

    private function checkRequirements(array $op)
    {
        return array_key_exists('attributes', $op) === true
            && is_array($op['attributes']) === true
            && count($op['attributes']) === 1
            && key_exists(Attribute::HEADER, $op['attributes'])
            && in_array($op['attributes'][Attribute::HEADER], array(1, 2, 3, 4, 5, 6, 7)) === true;
    }
}