<?php
/**
 * Created by PhpStorm.
 * User: kelly
 * Date: 12/09/2018
 * Time: 10:27
 */

namespace Oberon\Quill\Render\Html\Parsers;

use Oberon\Quill\Render\Attribute;
use Oberon\Quill\Render\Html\Inline\Link;
use Oberon\Quill\Render\Html\Utils\InlineUtil;
use Oberon\Quill\Render\Interfaces\Parser;
use Oberon\Quill\Render\Interfaces\Renderer;

class LinkParser implements Parser
{

    /**
     * @param array $op
     * @param Renderer[] $renderers passed by reference, might be modified
     * @return boolean returns true if the op was fully handled, false otherwise
     */
    public function handleOp(array $op, array & $renderers)
    {
        if (!$this->checkRequirements($op)) {
            return false;
        }

        $link = new Link($op['attributes'][Attribute::LINK], $op['insert']);
        InlineUtil::addToParagraph($link, $renderers);

        return true;
    }

    private function checkRequirements($op)
    {
        return
            array_key_exists('attributes', $op)
            && is_array($op['attributes'])
            && is_string($op['insert'])
            && key_exists(Attribute::LINK, $op['attributes']);
    }
}